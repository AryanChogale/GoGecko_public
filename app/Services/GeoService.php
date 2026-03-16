<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoService
{
    /**
     * Geocode a city + state to lat/lng using Nominatim.
     * Returns ['lat' => float, 'lng' => float] or null on failure.
     */
    public function geocode(string $city, string $state): ?array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'GoGecko/1.0',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'city'           => $city,
                'state'          => $state,
                'country'        => 'India',
                'format'         => 'json',
                'limit'          => 1,
                'addressdetails' => 0,
            ]);

            $results = $response->json();

            if (empty($results)) {
                return null;
            }

            return [
                'lat' => (float) $results[0]['lat'],
                'lng' => (float) $results[0]['lon'],
            ];
        } catch (\Throwable $e) {
            Log::error('Nominatim geocoding failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get city autocomplete suggestions from Nominatim.
     * Returns array of ['name' => string, 'lat' => float, 'lng' => float]
     */
    public function autocomplete(string $query, string $state): array
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'GoGecko/1.0 (gogecko@example.com)',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q'              => $query . ', ' . $state . ', India',
                'format'         => 'json',
                'limit'          => 5,
                'addressdetails' => 1,
            ]);

            $results = $response->json();

            if (empty($results)) {
                return [];
            }

            $suggestions = [];
            foreach ($results as $result) {
                // Only return cities, towns, villages — skip roads, buildings etc.
                if (!in_array($result['type'], ['city', 'town', 'village', 'suburb', 'municipality', 'administrative'])) {
                    continue;
                }

                $name = $result['address']['city']
                    ?? $result['address']['town']
                    ?? $result['address']['village']
                    ?? $result['address']['suburb']
                    ?? $result['name'];

                $suggestions[] = [
                    'name' => $name,
                    'lat'  => (float) $result['lat'],
                    'lng'  => (float) $result['lon'],
                ];
            }

            // Deduplicate by name
            $seen = [];
            $unique = [];
            foreach ($suggestions as $s) {
                if (!in_array($s['name'], $seen)) {
                    $seen[] = $s['name'];
                    $unique[] = $s;
                }
            }

            return $unique;
        } catch (\Throwable $e) {
            Log::error('Nominatim autocomplete failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Calculate distance between two lat/lng points using Haversine formula.
     * Returns distance in kilometers.
     */
    public function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Find the closest branch to a given lat/lng from a collection of branches.
     * Branches must have latitude and longitude set.
     */
    public function closestBranch(\Illuminate\Support\Collection $branches, float $lat, float $lng): ?\App\Models\Branch
    {
        $closest = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($branches as $branch) {
            if ($branch->latitude === null || $branch->longitude === null) {
                continue;
            }

            $distance = $this->haversine($lat, $lng, $branch->latitude, $branch->longitude);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closest = $branch;
            }
        }

        return $closest;
    }
}

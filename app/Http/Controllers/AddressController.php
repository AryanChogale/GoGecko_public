<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'state'    => ['required', 'string', 'max:255'],
            'city'     => ['required', 'string', 'max:255'],
            'address'  => ['required', 'string', 'max:500'],
            'pin'      => ['required', 'string', 'max:10'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'phone'    => ['required', 'string', 'max:20'],
            'whatsapp' => ['required', 'string', 'max:20'],
        ]);

        $coords = app(\App\Services\GeoService::class)->geocode($validated['city'], $validated['state']);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $user->addresses()->create(array_merge($validated, [
            'latitude'  => $coords['lat'] ?? null,
            'longitude' => $coords['lng'] ?? null,
        ]));

        return back()->with('address_success', 'Address saved.');
    }

    public function destroy(Address $address): RedirectResponse
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();

        return back()->with('address_success', 'Address removed.');
    }
}

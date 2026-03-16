<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Services\GeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::with('user')->latest()->paginate(10);

        return view('admin.branches.index', compact('branches'));
    }

    public function create(): View
    {
        return view('admin.branches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'city'     => ['required', 'string', 'max:255'],
            'address'  => ['nullable', 'string'],
            'phone'    => ['nullable', 'string', 'max:50'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'branch',
        ]);

        // Geocode the branch city
        $coords = null;
        if (!empty($validated['city'])) {
            $coords = app(GeoService::class)->geocode($validated['city'], $validated['name']);
        }

        $branch = Branch::create([
            'user_id'   => $user->id,
            'name'      => $validated['name'],
            'city'      => $validated['city'] ?? null,
            'address'   => $validated['address'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'email'     => $validated['email'],
            'latitude'  => $coords['lat'] ?? null,
            'longitude' => $coords['lng'] ?? null,
        ]);

        $user->update(['branch_id' => $branch->id]);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch): View
    {
        $branch->load('user');

        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $user = $branch->user;

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'city'     => ['nullable', 'string', 'max:255'],
            'address'  => ['nullable', 'string'],
            'phone'    => ['nullable', 'string', 'max:50'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user?->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Re-geocode if city or state changed
        $coords = null;
        if (!empty($validated['city'])) {
            $cityChanged  = $validated['city'] !== $branch->city;
            $stateChanged = $validated['name'] !== $branch->name;

            if ($cityChanged || $stateChanged || $branch->latitude === null) {
                $coords = app(GeoService::class)->geocode($validated['city'], $validated['name']);
            }
        }

        $branch->update([
            'name'      => $validated['name'],
            'city'      => $validated['city'] ?? null,
            'address'   => $validated['address'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'email'     => $validated['email'],
            'latitude'  => $coords['lat'] ?? $branch->latitude,
            'longitude' => $coords['lng'] ?? $branch->longitude,
        ]);

        if ($user) {
            $user->update([
                'name'  => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (!empty($validated['password'])) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }
        }

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function byState(Request $request)
    {
        $branches = Branch::where('name', $request->state)
            ->get(['id', 'city', 'latitude', 'longitude']);

        return response()->json($branches);
    }

    public function cityAutocomplete(Request $request)
    {
        $query = $request->get('q', '');
        $state = $request->get('state', '');

        if (strlen($query) < 2 || empty($state)) {
            return response()->json([]);
        }

        $suggestions = app(GeoService::class)->autocomplete($query, $state);

        return response()->json($suggestions);
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->user?->delete();
        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}

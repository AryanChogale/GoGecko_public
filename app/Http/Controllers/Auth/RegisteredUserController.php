<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\GeoService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Branch;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $states = [
            'Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam',
            'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu',
            'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir',
            'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Lakshadweep', 'Madhya Pradesh',
            'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha',
            'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana',
            'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal',
        ];

        return view('auth.register', compact('states'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'state'    => ['required', 'string'],
            'city'     => ['required', 'string'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'state'    => $request->state,
            'city'     => $request->city,
        ]);

        // Geocode and assign nearest branch
        $branchId = null;
        $lat      = null;
        $lng      = null;

        $coords = app(GeoService::class)->geocode($request->city, $request->state);

        if ($coords) {
            $lat = $coords['lat'];
            $lng = $coords['lng'];

            $branches = Branch::where('name', $request->state)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            if ($branches->isNotEmpty()) {
                $closest  = app(GeoService::class)->closestBranch($branches, $lat, $lng);
                $branchId = $closest?->id;
            }
        }

        DB::table('customer_profiles')->insert([
            'user_id'            => $user->id,
            'selected_branch_id' => $branchId,
            'lat'                => $lat,
            'lng'                => $lng,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
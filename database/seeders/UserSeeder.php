<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed an admin user and one branch per Indian state/UT with hardcoded coordinates.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'branch_id' => null,
            ]
        );

        $branches = [
            ['state' => 'Andaman and Nicobar Islands', 'city' => 'Port Blair', 'lat' => 11.6234, 'lng' => 92.7265],
            ['state' => 'Andhra Pradesh', 'city' => 'Visakhapatnam', 'lat' => 17.6868, 'lng' => 83.2185],
            ['state' => 'Arunachal Pradesh', 'city' => 'Itanagar', 'lat' => 27.0844, 'lng' => 93.6053],
            ['state' => 'Assam', 'city' => 'Guwahati', 'lat' => 26.1445, 'lng' => 91.7362],
            ['state' => 'Bihar', 'city' => 'Patna', 'lat' => 25.5941, 'lng' => 85.1376],
            ['state' => 'Chandigarh', 'city' => 'Chandigarh', 'lat' => 30.7333, 'lng' => 76.7794],
            ['state' => 'Chhattisgarh', 'city' => 'Raipur', 'lat' => 21.2514, 'lng' => 81.6296],
            ['state' => 'Dadra and Nagar Haveli and Daman and Diu', 'city' => 'Daman', 'lat' => 20.3974, 'lng' => 72.8328],
            ['state' => 'Delhi', 'city' => 'New Delhi', 'lat' => 28.6139, 'lng' => 77.2090],
            ['state' => 'Goa', 'city' => 'Panaji', 'lat' => 15.4909, 'lng' => 73.8278],
            ['state' => 'Gujarat', 'city' => 'Ahmedabad', 'lat' => 23.0225, 'lng' => 72.5714],
            ['state' => 'Haryana', 'city' => 'Gurugram', 'lat' => 28.4595, 'lng' => 77.0266],
            ['state' => 'Himachal Pradesh', 'city' => 'Shimla', 'lat' => 31.1048, 'lng' => 77.1734],
            ['state' => 'Jammu and Kashmir', 'city' => 'Srinagar', 'lat' => 34.0837, 'lng' => 74.7973],
            ['state' => 'Jharkhand', 'city' => 'Ranchi', 'lat' => 23.3441, 'lng' => 85.3096],
            ['state' => 'Karnataka', 'city' => 'Bengaluru', 'lat' => 12.9716, 'lng' => 77.5946],
            ['state' => 'Kerala', 'city' => 'Kochi', 'lat' => 9.9312, 'lng' => 76.2673],
            ['state' => 'Ladakh', 'city' => 'Leh', 'lat' => 34.1526, 'lng' => 77.5771],
            ['state' => 'Lakshadweep', 'city' => 'Kavaratti', 'lat' => 10.5667, 'lng' => 72.6417],
            ['state' => 'Madhya Pradesh', 'city' => 'Bhopal', 'lat' => 23.2599, 'lng' => 77.4126],
            ['state' => 'Maharashtra', 'city' => 'Mumbai', 'lat' => 19.0760, 'lng' => 72.8777],
            ['state' => 'Manipur', 'city' => 'Imphal', 'lat' => 24.8170, 'lng' => 93.9368],
            ['state' => 'Meghalaya', 'city' => 'Shillong', 'lat' => 25.5788, 'lng' => 91.8933],
            ['state' => 'Mizoram', 'city' => 'Aizawl', 'lat' => 23.7271, 'lng' => 92.7176],
            ['state' => 'Nagaland', 'city' => 'Kohima', 'lat' => 25.6751, 'lng' => 94.1086],
            ['state' => 'Odisha', 'city' => 'Bhubaneswar', 'lat' => 20.2961, 'lng' => 85.8245],
            ['state' => 'Puducherry', 'city' => 'Puducherry', 'lat' => 11.9416, 'lng' => 79.8083],
            ['state' => 'Punjab', 'city' => 'Ludhiana', 'lat' => 30.9000, 'lng' => 75.8573],
            ['state' => 'Rajasthan', 'city' => 'Jaipur', 'lat' => 26.9124, 'lng' => 75.7873],
            ['state' => 'Sikkim', 'city' => 'Gangtok', 'lat' => 27.3389, 'lng' => 88.6065],
            ['state' => 'Tamil Nadu', 'city' => 'Chennai', 'lat' => 13.0827, 'lng' => 80.2707],
            ['state' => 'Telangana', 'city' => 'Hyderabad', 'lat' => 17.3850, 'lng' => 78.4867],
            ['state' => 'Tripura', 'city' => 'Agartala', 'lat' => 23.8315, 'lng' => 91.2868],
            ['state' => 'Uttar Pradesh', 'city' => 'Lucknow', 'lat' => 26.8467, 'lng' => 80.9462],
            ['state' => 'Uttarakhand', 'city' => 'Dehradun', 'lat' => 30.3165, 'lng' => 78.0322],
            ['state' => 'West Bengal', 'city' => 'Kolkata', 'lat' => 22.5726, 'lng' => 88.3639],
        ];

        foreach ($branches as $branchData) {
            $emailSlug = strtolower(str_replace(' ', '', $branchData['city']));
            $branchEmail = "{$emailSlug}@gmail.com";

            $user = User::updateOrCreate(
                ['email' => $branchEmail],
                [
                    'name' => $branchData['state'] . ' Branch',
                    'password' => Hash::make('password'),
                    'role' => 'branch',
                ]
            );

            $branch = Branch::updateOrCreate(
                ['email' => $branchEmail],
                [
                    'user_id' => $user->id,
                    'name' => $branchData['state'],
                    'city' => $branchData['city'],
                    'address' => $branchData['city'] . ', ' . $branchData['state'] . ', India',
                    'phone' => null,
                    'latitude' => $branchData['lat'],
                    'longitude' => $branchData['lng'],
                ]
            );

            if ($user->branch_id !== $branch->id) {
                $user->update(['branch_id' => $branch->id]);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = 
        [
            [
                'name'       => 'Aleppo',
                'cities'     => ['Azaz', 'Al-Bab', 'Manbij', 'Jarabulus']
            ],
            [
                'name'       => 'Homs',
                'cities'     => ['Tadmur', 'Al-Qusayr', 'Al-Rastan', 'Talbiseh']
            ],
            [
                'name'       => 'Damascus',
                'cities'     => ['Dummar', 'Al-Shagour', 'Mazzeh', 'Qanawat']
            ]
        ];
        foreach ($data as $item) {
            $governorate = Governorate::create([
                'name' => $item['name'],
            ]);

            foreach ($item['cities'] as $city) {
                City::create([
                    'governorate_id' => $governorate->id,
                    'name' => $city,
                ]);
            }
        }
    }
}

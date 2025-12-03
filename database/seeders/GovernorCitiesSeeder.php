<?php

namespace Database\Seeders;

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
    }
}

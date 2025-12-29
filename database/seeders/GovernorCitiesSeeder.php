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
                'name'       => 'Damascus',
                'cities'     => ['Dummar', 'Al-Shagour', 'Mazzeh', 'Qanawat','Barzeh']
            ],
            [
                'name'      =>  'Rif Dimashq',
                'cities'    =>  ['Douma','Darayya','Qudsaya','Al-Tall','Zabadani','Yabroud','Qatana','Al-Kiswah','Harasta']
            ],
            [
                'name'       => 'Aleppo',
                'cities'     => ['Azaz', 'Al-Bab', 'Manbij', 'Jarabulus']
            ],
            [
                'name'       => 'Homs',
                'cities'     => ['Tadmur', 'Al-Qusayr', 'Al-Rastan', 'Talbiseh']
            ],
            [
                'name'      =>  'Hama',
                'cities'    =>  ['Hama','Salamiyah','Masyaf','Kafr Zita']
            ],
            [
                'name'      =>  'Idlib',
                'cities'    =>  ['Maarrat al-Numan','Ariha','Saraqib','Jisr al-Shughur']
            ],
            [
                'name'      =>  'Latakia',
                'cities'    =>  ['Jableh','Al-Qardaha','Al-Haffah','Al-sheik Daher']
            ],
            [
                'name'      =>  'Tartus',
                'cities'    =>  ['Baniyas','Safita','Sheikh Badr','Duraykish','Bosaira']
            ],
            [
                'name'      =>  'Al-Hasakah',
                'cities'    =>  ['Qamishli','Ras al-Ayn','Al-Malikiyah']
            ],
            [
                'name'      =>  'Raqqa',
                'cities'    =>  ['Tabqa','Tell Abyad']
            ],
            [
                'name'      =>  'Deir ez-Zor',
                'cities'    =>  ['Al-Mayadin','Al-Bukamal']
            ],
            [
                'name'      =>  'Daraa',
                'cities'    =>  ['Nawa','Jasim','Tafas']
            ],
            [
                'name'      =>  'As-Suwayda',
                'cities'    =>  ['Shahba','Salkhad']
            ],
            [
                'name'      =>  'Quneitra',
                'cities'    =>  ['Quneitra','Khan Arnabah']
            ],
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

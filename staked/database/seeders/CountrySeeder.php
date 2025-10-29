<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AFG'],
            ['name' => 'Albania', 'code' => 'ALB'],
            ['name' => 'Algeria', 'code' => 'DZA'],
            ['name' => 'Andorra', 'code' => 'AND'],
            ['name' => 'Angola', 'code' => 'AGO'],
            ['name' => 'Argentina', 'code' => 'ARG'],
            ['name' => 'Armenia', 'code' => 'ARM'],
            ['name' => 'Australia', 'code' => 'AUS'],
            ['name' => 'Austria', 'code' => 'AUT'],
            ['name' => 'Azerbaijan', 'code' => 'AZE'],
            // ... include all ISO 3166 countries
            ['name' => 'Kenya', 'code' => 'KEN'],
            ['name' => 'Tanzania', 'code' => 'TZA'],
            ['name' => 'Uganda', 'code' => 'UGA'],
            ['name' => 'Nigeria', 'code' => 'NGA'],
            ['name' => 'England', 'code' => 'ENG'],
            ['name' => 'United States', 'code' => 'USA'],
            ['name' => 'South Africa', 'code' => 'ZAF'],
            // ...
            ['name' => 'Zimbabwe', 'code' => 'ZWE'],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate($country);
        }
    }
}

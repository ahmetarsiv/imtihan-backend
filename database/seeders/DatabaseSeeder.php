<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Database\Factories\CityFactory;
use Database\Factories\StateFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(1)->create();
        Country::factory([
            'id' => 1,
            'name' => 'Türkiye',
            'code' => 'TR',
        ])->create();
        City::factory([
            'id' => 1,
            'name' => 'İstanbul',
            'plate_code' => '34',
            'country_id' => 1,
        ])->create();
        State::factory([
            'id' => 1,
            'name' => 'Beşiktaş',
            'city_id' => 1,
        ])->create();
    }
}

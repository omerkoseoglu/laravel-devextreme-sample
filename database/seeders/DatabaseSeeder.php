<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $countriesPath = storage_path('countries.json');
        $statesPath = storage_path('states.json');
        $citiesPath = storage_path('cities.json');
        $countries = json_decode(File::get($countriesPath), true);
        $states = json_decode(File::get($statesPath), true);
        $cities = json_decode(File::get($citiesPath), true);

        $countries = collect($countries['countries'])->transform(function ($value, $key) {
           return [
               'id' => $value['id'],
               'short_name' => $value['sortname'],
               'name' => $value['name'],
               'phone_code' => $value['phoneCode']
           ];
        })->all();

        Country::insert($countries);

        collect($states['states'])->chunk(1000)->each(function ($value, $key) {
            State::insert($value->toArray());
        });

        collect($cities['cities'])->chunk(1)->each(function ($value, $key) {
            City::insert($value->toArray());
        });

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

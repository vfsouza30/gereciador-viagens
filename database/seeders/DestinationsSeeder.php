<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DestinationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [];
        
        $states = Http::get('https://brasilapi.com.br/api/ibge/uf/v1')->json();

        foreach ($states as $state) {

            $municipalities = Http::get("https://brasilapi.com.br/api/ibge/municipios/v1/{$state['sigla']}")->json();

            if (empty($municipalities)) continue;            
            
            $sampleCities = collect($municipalities);
            $sampleCities = $sampleCities->count() > 3
                ? $sampleCities->random(3)
                : $sampleCities;

            foreach ($sampleCities as $city) {
                $destinations[] = [
                    'city'    => $city['nome'],
                    'state'   => $state['sigla'],
                    'airport' => null,
                ];
            }
        }
        
        $airports = Http::get('https://brasilapi.com.br/api/cptec/v1/airports')->json();
        $airports = collect($airports);

        if ($airports->isNotEmpty()) {
            foreach ($destinations as $key => $dest) {
                $airport = $airports->random();
                $destinations[$key]['airport'] = $airport['codigo'] ?? null;
            }
        }

        $destinations = array_slice($destinations, 0, 100);

        if (!empty($destinations)) {
            DB::table('destinations')->insert($destinations);
        }
    }
}

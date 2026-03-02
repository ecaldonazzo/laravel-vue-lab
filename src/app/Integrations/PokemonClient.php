<?php

namespace App\Integrations;

use Illuminate\Support\Facades\Http;

class PokemonClient
{
    private const BASE_URL = 'https://pokeapi.co/api/v2';

    public function getPokemonWithNameOrId(int|string $nameOrId): array
    {
        $data = Http::get(self::BASE_URL . "/pokemon/{$nameOrId}")
            ->throw()
            ->json();

        return $data;
    }
}

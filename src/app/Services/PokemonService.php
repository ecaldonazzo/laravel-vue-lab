<?php

namespace App\Services;

use App\DTOs\PokemonAttackResultDto;
use App\DTOs\PokemonDTO;
use App\Integrations\PokemonClient;

class PokemonService
{
    public function __construct(
        protected PokemonClient $client
    ) {}

    public function getRandomPokemon(): PokemonDTO
    {
        $pokemonId = rand(1, 151);
        return PokemonDTO::fromArray($this->client->getPokemonWithNameOrId($pokemonId));
    }

    public function getPokemon(string $name): PokemonDTO
    {
        return PokemonDTO::fromArray($this->client->getPokemonWithNameOrId($name));
    }

    public function calculateAttack(PokemonDTO $attacker, PokemonDTO $defender): PokemonAttackResultDto
    {
        $damage = max(1, (int)(($attacker->attack / $defender->defense) * rand(15, 30)));
        $isCritical = rand(1, 16) === 1;

        if ($isCritical) {
            $damage = (int)($damage * 1.5);
        }

        return new PokemonAttackResultDto(
            damage: $damage,
            isCritical: $isCritical,
        );
    }
}

<?php

namespace App\DTOs;

class PokemonDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $imagePokemon,
        public readonly array  $types,
        public readonly int    $hp,
        public readonly int    $attack,
        public readonly int    $defense,
        public readonly int    $speed,
    ) {}

    public static function fromArray(array $data): self
    {
        $stats = collect($data['stats']);

        return new self(
            id:      $data['id'],
            name:    $data['name'],
            imagePokemon:   $data['sprites']['other']['official-artwork']['front_default'],
            types:   collect($data['types'])->pluck('type.name')->toArray(),
            hp:      $stats->firstWhere('stat.name', 'hp')['base_stat'],
            attack:  $stats->firstWhere('stat.name', 'attack')['base_stat'],
            defense: $stats->firstWhere('stat.name', 'defense')['base_stat'],
            speed:   $stats->firstWhere('stat.name', 'speed')['base_stat'],
        );
    }
}

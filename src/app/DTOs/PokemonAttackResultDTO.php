<?php

namespace App\DTOs;

class PokemonAttackResultDTO
{
    public function __construct(
        public readonly int  $damage,
        public readonly bool $isCritical,
    ) {}
}

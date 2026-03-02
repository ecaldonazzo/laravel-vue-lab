<?php

namespace App\DTOs;

class PokemonAttackResultDto
{
    public function __construct(
        public readonly int  $damage,
        public readonly bool $isCritical,
    ) {}
}

<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function __construct(
        protected PokemonService $service
    ) {}

    public function show(string $name): JsonResponse
    {
        $pokemon = $this->service->getPokemon($name);
        return response()->json($pokemon);
    }

    public function random(): JsonResponse
    {
        $pokemon = $this->service->getRandomPokemon();
        return response()->json($pokemon);
    }

    public function attack(Request $request): JsonResponse
    {
        $attacker = $this->service->getPokemon($request->input('attacker'));
        $defender = $this->service->getPokemon($request->input('defender'));

        $result = $this->service->calculateAttack($attacker, $defender);

        return response()->json([
            'damage'     => $result->damage,
            'isCritical' => $result->isCritical,
        ]);
    }
}

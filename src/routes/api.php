<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Integrations\PokemonClient;
use App\Http\Controllers\PokemonController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('pokemon')->group(function () {
    Route::get('/random', [PokemonController::class, 'random']);
    Route::get('/{name}', [PokemonController::class, 'show']);

});

Route::post('/battle/attack', [PokemonController::class, 'attack']);
Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'send']);

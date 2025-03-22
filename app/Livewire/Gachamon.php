<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Livewire\Component;

class Gachamon extends Component
{
    public int $totalPokemons = 0;

    public int $currency = 1000;

    public int $gachaCost = 100;

    public array $gachaResult = [];

    public array $gachaHistory = [];

    public function render(): View
    {
        return view('livewire.gachamon');
    }

    public function mount(): void
    {
        $response = Cache::remember('total_pokemon', now()->addMonth(), function () {
            return Http::get('https://pokeapi.co/api/v2/pokemon')->json();
        });
        $this->totalPokemons = $response['count'];
    }

    public function gacha(): void
    {
        // Ensure the user has enough currency to perform the gacha
        if ($this->currency < $this->gachaCost) {
            // Optionally log or notify the user about insufficient currency
            return;
        }

        $pokemon = null;
        while ($pokemon === null) {
            $pokemon = $this->getRandomPokemon();
        }

        // Deduct the gacha cost from the user's currency
        $this->currency -= $this->gachaCost;
        // Store the gacha result
        $this->gachaResult = $pokemon;

        // Add the gacha result to the history, get only last 3 results
        $this->gachaHistory[] = $pokemon;
        $this->gachaHistory = array_slice($this->gachaHistory, -3);
    }

    public function getRandomPokemon(): ?array
    {
        // Generate a random Pokémon ID
        $randomPokemonId = rand(1, $this->totalPokemons);

        // Define the cache key based on the Pokémon ID
        $cacheKey = 'pokemon-'.$randomPokemonId;

        // Use Cache::remember to fetch the Pokémon data
        $gachaResult = Cache::remember($cacheKey, now()->addMonth(), function () use ($randomPokemonId) {
            // Fetch Pokémon data from the API
            $response = Http::get('https://pokeapi.co/api/v2/pokemon/'.$randomPokemonId);

            // Validate the HTTP status code
            if ($response->status() !== 200) {
                return null;
            }

            // Decode the JSON response
            $responseData = $response->json();

            // Fetch species data from the API
            $speciesResponse = Http::get('https://pokeapi.co/api/v2/pokemon-species/'.$randomPokemonId);
            if ($speciesResponse->status() !== 200) {
                return null;
            }

            // Combine Pokémon data and species data
            $responseData['species'] = $speciesResponse->json();

            return $responseData;
        });

        // If the cache returns null, return null
        if (is_null($gachaResult)) {
            return null;
        }

        // Dispatch the gacha-result event
        $this->dispatch('gacha-result', ...$gachaResult);

        return $gachaResult;
    }
}

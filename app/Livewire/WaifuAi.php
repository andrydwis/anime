<?php

namespace App\Livewire;

use Livewire\Component;
use OpenAI;

class WaifuAi extends Component
{
    public string $message = '';

    public array $messages = [];

    public function render()
    {
        return view('livewire.waifu-ai');
    }

    public function mount(): void
    {
        $this->messages = [
            [
                'role' => 'assistant',
                'content' => 'Halooo, Aku Midori. Aku waifu AI kamu, apa ada yang bisa aku bantu? Mau rekomendasi anime atau manga? atau... Aku? 🥰',
            ],
        ];
    }

    public function ask(): void
    {
        $this->validate([
            'message' => ['required', 'string'],
        ]);

        $client = OpenAI::factory()
            ->withApiKey(config('openai.api_key'))
            ->withBaseUri(config('openai.base_uri'))
            ->make();

        $this->messages[] = [
            'role' => 'user',
            'content' => $this->message,
        ];

        $chat = $client->chat()->create([
            'model' => 'gemma2-9b-it',
            'messages' => $this->messages,
        ]);

        $response = $chat->choices[0]->message->content;

        $this->messages[] = [
            'role' => 'assistant',
            'content' => $response,
        ];

        $this->message = '';
    }

    public function clear(): void
    {
        $this->messages = [];

        $this->mount();
    }
}

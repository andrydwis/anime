<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use OpenAI;

class WaifuAi extends Component
{
    public string $message = '';

    public array $messages = [];

    public array $messageRecommendations = [];

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

        // Now, ask the AI to generate follow-up questions based on its last response
        $followUpPrompt = 'Berdasarkan jawaban terakhir Anda, buat beberapa pertanyaan lanjutan yang mungkin ditanyakan oleh pengguna. Format HARUS dalam array JSON {"pertanyaan1", "pertanyaan2", "pertanyaan3"} TANPA PENGANTAR, hanya array tersebut.';

        $followUpMessages = $this->messages;
        $followUpMessages[] = [
            'role' => 'user',
            'content' => $followUpPrompt,
        ];

        $followUpChat = $client->chat()->create([
            'model' => 'gemma2-9b-it',
            'messages' => $followUpMessages,
        ]);

        $followUpResponse = $followUpChat->choices[0]->message->content;

        try {
            // Attempt to decode the JSON response
            $this->messageRecommendations = json_decode($followUpResponse, true) ?? [];

            // Check if json_decode returned null, which indicates an error
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to decode JSON: '.json_last_error_msg());
            }
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, set a default value, etc.)
            error_log('Error decoding JSON: '.$e->getMessage().$followUpResponse);
            $this->messageRecommendations = []; // Set to an empty array or handle as needed
        }

        $this->message = '';
    }

    public function clear(): void
    {
        $this->messages = [];
        $this->messageRecommendations = [];

        $this->mount();
    }
}

<?php

namespace App\Services;

use App\Clients\OpenRouterClient;

class OpenRouterService
{
    public function generateSaaSIdea( string $idea, ?string $notes, string $model, ?float $temperature ): array
    {
        $prompt = 'Idea: ' . $idea;

        if ( ! empty( $notes ) ) {
            $prompt .= PHP_EOL . 'Notes: ' . $notes;
        }

        return app( OpenRouterClient::class )->generateArrayWithSchema( $prompt, $model, $temperature );
    }
}

<?php

namespace App\Services;

use App\Agents\SaasGeneratorAgent;
use Laravel\Ai\Responses\StructuredAgentResponse;

class SaasGeneratorService
{
    public function generateSaaSIdea( string $idea, ?string $notes, string $model, ?float $temperature = null ): array
    {
        $prompt = 'Idea: ' . $idea;

        if ( ! empty( $notes ) ) {
            $prompt .= PHP_EOL . 'Notes: ' . $notes;
        }

        /** @var StructuredAgentResponse $response */
        $response = new SaasGeneratorAgent( $temperature )->prompt( $prompt, provider: 'openrouter', model: $model );

        return $response->structured;
    }
}

<?php

namespace App\Clients;

use App\Agents\SaasGeneratorAgent;
use Laravel\Ai\Responses\StructuredAgentResponse;

class OpenRouterClient
{
    public function generateArrayWithSchema( string $prompt, string $model, ?float $temperature = null ): array
    {
        /** @var StructuredAgentResponse $response */
        $response = ( new SaasGeneratorAgent( $temperature ) )->prompt( $prompt, provider: 'openrouter', model: $model );

        return $response->structured;
    }
}

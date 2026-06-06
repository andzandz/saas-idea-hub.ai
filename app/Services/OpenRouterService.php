<?php

namespace App\Services;

use App\Clients\OpenRouterClient;
use GuzzleHttp\Exception\GuzzleException;

class OpenRouterService
{
    /**
     * @throws \ReflectionException
     * @throws GuzzleException
     */
    public function generateSaaSIdea( string $idea, ?string $notes, string $model, ?float $temperature ): array
    {
        $prompt = 'You are a SaaS (Software as a Service) Generator. Generate a startup name, summary (max 250 characters),'
            . ' price tiers, fake testimonials and investor pitch (max 500 characters) for:'
            . PHP_EOL . 'Idea: ' . $idea;

        if ( ! empty( $notes ) ) {
            $prompt .= PHP_EOL . 'Notes: ' . $notes;
        }

        return app( OpenRouterClient::class )->generateArrayWithSchema(
            $prompt,
            $model,
            config( 'saas-generator.json_schema' ),
            $temperature
        );
    }
}

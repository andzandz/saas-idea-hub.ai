<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use MoeMizrak\LaravelOpenrouter\DTO\ChatData;
use MoeMizrak\LaravelOpenrouter\DTO\MessageData;
use MoeMizrak\LaravelOpenrouter\DTO\ResponseFormatData;
use MoeMizrak\LaravelOpenrouter\Facades\LaravelOpenRouter;
use MoeMizrak\LaravelOpenrouter\Types\RoleType;

class OpenRouterService
{
    /**
     * @throws \ReflectionException
     * @throws GuzzleException
     */
    public function generateSaaSIdea( string $idea, ?string $notes, string $model ): array
    {
        $chat_response = LaravelOpenRouter::chatRequest(
            new ChatData(
                messages: [
                    new MessageData(
                        content: 'Generate a SaaS startup idea for: ' . $idea,
                        role: RoleType::USER,
                    ),
                ],
                model: $model,
                response_format: new ResponseFormatData(
                    'json_schema',
                    config( 'saas-generator.json_schema' )
                )
            )
        );

        return json_decode(
            $chat_response->choices[0]['message']['content'],
            true
        );
    }
}

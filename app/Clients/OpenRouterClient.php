<?php

namespace App\Clients;

use GuzzleHttp\Exception\GuzzleException;
use MoeMizrak\LaravelOpenrouter\DTO\ChatData;
use MoeMizrak\LaravelOpenrouter\DTO\MessageData;
use MoeMizrak\LaravelOpenrouter\DTO\ResponseFormatData;
use MoeMizrak\LaravelOpenrouter\Facades\LaravelOpenRouter;
use MoeMizrak\LaravelOpenrouter\Types\RoleType;

class OpenRouterClient
{
    /**
     * @throws \ReflectionException
     * @throws GuzzleException
     */
    public function generateArrayWithSchema( string $prompt, string $model, array $json_schema, ?float $temperature = null ): array
    {
        $chat_response = LaravelOpenRouter::chatRequest(
            new ChatData(
                messages: [
                    new MessageData(
                        content: $prompt,
                        role: RoleType::USER,
                    ),
                ],
                model: $model,
                response_format: new ResponseFormatData( 'json_schema', $json_schema ),
                temperature: $temperature
            )
        );

        return json_decode(
            $chat_response->choices[0]['message']['content'],
            true
        );
    }
}

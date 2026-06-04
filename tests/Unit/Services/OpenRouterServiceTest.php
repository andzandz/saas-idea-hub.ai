<?php

namespace Tests\Unit\Services;

use App\Services\OpenRouterService;
use Mockery;
use MoeMizrak\LaravelOpenrouter\DTO\ChatData;
use MoeMizrak\LaravelOpenrouter\DTO\ResponseData;
use MoeMizrak\LaravelOpenrouter\Facades\LaravelOpenRouter;
use MoeMizrak\LaravelOpenrouter\Types\RoleType;
use Tests\TestCase;

class OpenRouterServiceTest extends TestCase
{
    public function test_open_router_service_sends_the_expected_prompt_and_parameters_and_returns_correctly(): void
    {
        $captured = null;

        // Generic mock — no subclassing of the final class
        $mock = Mockery::mock();
        $mock->shouldReceive( 'chatRequest' )
            ->once()
            ->andReturnUsing( function ( ChatData $chatData ) use ( &$captured ) {
                $captured = $chatData;

                return new ResponseData(
                    id: 'gen-test',
                    model: 'openai/gpt-5.4-mini',
                    object: 'chat.completion',
                    created: now()->timestamp,
                    choices: [
                        /** An array works fine here */
                        ['message' => ['role' => 'assistant', 'content' => '{"idea":"example"}']],
                    ],
                    usage: null,
                );
            } );

        // Point the facade at our mock
        LaravelOpenRouter::swap( $mock );

        $response = ( new OpenRouterService )->generateSaaSIdea(
            idea: 'Uber for ducks',
            notes: null,
            model: 'openai/gpt-5.4-mini'
        );

        // --- message / prompt ---
        $this->assertNotNull( $captured, 'chatRequest was never called' );
        $this->assertCount( 1, $captured->messages );

        $message = $captured->messages[0];
        $this->assertSame( RoleType::USER, $message->role );
        $this->assertSame(
            'Generate a SaaS startup idea for: Uber for ducks',
            $message->content,
        );

        // --- top-level params ---
        $this->assertSame( 'openai/gpt-5.4-mini', $captured->model );

        // --- nested response_format ---
        $this->assertNotNull( $captured->response_format );
        $this->assertSame( 'json_schema', $captured->response_format->type );

        $this->assertEquals( config( 'saas-generator.json_schema' ), $captured->response_format->json_schema );

        $this->assertEquals( ['idea' => 'example'], $response );
    }
}

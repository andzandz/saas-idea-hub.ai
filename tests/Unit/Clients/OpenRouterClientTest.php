<?php

namespace Tests\Unit\Clients;

use App\Clients\OpenRouterClient;
use Mockery;
use MoeMizrak\LaravelOpenrouter\DTO\ResponseData;
use MoeMizrak\LaravelOpenrouter\Facades\LaravelOpenRouter;
use MoeMizrak\LaravelOpenrouter\Types\RoleType;
use Tests\TestCase;

class OpenRouterClientTest extends TestCase
{
    public function test_open_router_client_sends_the_expected_prompt_and_parameters_and_returns_correctly_without_temperature(): void
    {
        $mock = Mockery::mock();
        $mock->shouldReceive( 'chatRequest' )
            ->once()
            ->with( Mockery::capture( $captured_chat_data ) )
            ->andReturn(
                new ResponseData(
                    id: 'gen-test',
                    model: 'openai/gpt-5.4-mini',
                    object: 'chat.completion',
                    created: now()->timestamp,
                    choices: [
                        ['message' => ['role' => 'assistant', 'content' => '{"output foo":"output bar"}']],
                    ],
                    usage: null,
                )
            );

        LaravelOpenRouter::swap( $mock );

        $response = ( new OpenRouterClient )->generateArrayWithSchema(
            prompt: 'Example prompt',
            model: 'openai/gpt-5.4-mini',
            json_schema: [
                'schema foo' => 'schema bar',
            ],
        );

        // --- message / prompt ---
        $this->assertNotNull( $captured_chat_data, 'chatRequest was never called' );
        $this->assertCount( 1, $captured_chat_data->messages );

        $message = $captured_chat_data->messages[0];
        $this->assertSame( RoleType::USER, $message->role );
        $this->assertSame(
            'Example prompt',
            $message->content,
        );

        $this->assertSame( 'openai/gpt-5.4-mini', $captured_chat_data->model );

        $this->assertNotNull( $captured_chat_data->response_format );
        $this->assertSame( 'json_schema', $captured_chat_data->response_format->type );

        $this->assertEquals( ['schema foo' => 'schema bar'], $captured_chat_data->response_format->json_schema );

        $this->assertEquals( ['output foo' => 'output bar'], $response );
    }

    public function test_open_router_client_sends_the_expected_prompt_and_parameters_and_returns_correctly_when_temperature_specified(): void
    {
        $mock = Mockery::mock();
        $mock->shouldReceive( 'chatRequest' )
            ->once()
            ->with( Mockery::capture( $captured_chat_data ) )
            ->andReturn(
                new ResponseData(
                    id: 'gen-test',
                    model: 'openai/gpt-5.4-mini',
                    object: 'chat.completion',
                    created: now()->timestamp,
                    choices: [
                        ['message' => ['role' => 'assistant', 'content' => '{"output foo":"output bar"}']],
                    ],
                    usage: null,
                )
            );

        LaravelOpenRouter::swap( $mock );

        $response = ( new OpenRouterClient )->generateArrayWithSchema(
            prompt: 'Example prompt',
            model: 'openai/gpt-5.4-mini',
            json_schema: [
                'schema foo' => 'schema bar',
            ],
            temperature: 1.3,
        );

        // --- message / prompt ---
        $this->assertNotNull( $captured_chat_data, 'chatRequest was never called' );
        $this->assertCount( 1, $captured_chat_data->messages );

        $message = $captured_chat_data->messages[0];
        $this->assertSame( RoleType::USER, $message->role );
        $this->assertSame(
            'Example prompt',
            $message->content,
        );

        $this->assertSame( 'openai/gpt-5.4-mini', $captured_chat_data->model );
        $this->assertNotNull( $captured_chat_data->response_format );
        $this->assertSame( 'json_schema', $captured_chat_data->response_format->type );
        $this->assertSame( 1.3, $captured_chat_data->temperature );

        $this->assertEquals( ['schema foo' => 'schema bar'], $captured_chat_data->response_format->json_schema );

        $this->assertEquals( ['output foo' => 'output bar'], $response );
    }
}

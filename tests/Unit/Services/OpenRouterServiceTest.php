<?php

namespace Tests\Unit\Services;

use App\Clients\OpenRouterClient;
use App\Services\OpenRouterService;
use Mockery;
use Tests\TestCase;

class OpenRouterServiceTest extends TestCase
{
    public function test_open_router_service_calls_the_client_with_the_correct_parameters_and_returns_correctly_when_no_notes_or_temperature(): void
    {
        $this->mock( OpenRouterClient::class )
            ->shouldReceive( 'generateArrayWithSchema' )
            ->with(
                Mockery::capture( $captured_prompt ),
                Mockery::capture( $captured_model ),
                Mockery::capture( $captured_temperature ),
            )
            ->andReturn( [
                'example' => 'output',
            ] );

        $service = new OpenRouterService;
        $result = $service->generateSaaSIdea( 'Netflix for professionals', null, 'openai/example-model', null );

        $this->assertEquals( 'Idea: Netflix for professionals', $captured_prompt );
        $this->assertEquals( 'openai/example-model', $captured_model );
        $this->assertNull( $captured_temperature );

        $this->assertEquals( [
            'example' => 'output',
        ], $result );
    }

    public function test_open_router_service_calls_the_client_with_the_correct_parameters_and_returns_correctly_when_notes_and_temperature_specified(): void
    {
        $this->mock( OpenRouterClient::class )
            ->shouldReceive( 'generateArrayWithSchema' )
            ->with(
                Mockery::capture( $captured_prompt ),
                Mockery::capture( $captured_model ),
                Mockery::capture( $captured_temperature ),
            )
            ->andReturn( [
                'example' => 'output',
            ] );

        $service = new OpenRouterService;
        $result = $service->generateSaaSIdea( 'Netflix for professionals', 'example notes', 'openai/example-model', 1.2 );

        $this->assertEquals(
            'Idea: Netflix for professionals' . PHP_EOL . 'Notes: example notes',
            $captured_prompt
        );
        $this->assertEquals( 'openai/example-model', $captured_model );
        $this->assertSame( 1.2, $captured_temperature );

        $this->assertEquals( [
            'example' => 'output',
        ], $result );
    }
}

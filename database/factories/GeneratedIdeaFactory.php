<?php

namespace Database\Factories;

use App\Models\GeneratedIdea;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GeneratedIdea>
 */
class GeneratedIdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'startup_name' => 'Example Startup Name',
            'summary' => 'Example Summary',
            'investor_pitch' => 'Example Investor Pitch',
            'model' => 'openai/example-model',
            'public' => true,
        ];
    }

    public function userId( int $user_id ): self
    {
        return $this->state( function ( array $attributes ) use ( $user_id ) {
            return [
                'user_id' => $user_id,
            ];
        } );
    }

    public function public( bool $public ): self
    {
        return $this->state( function ( array $attributes ) use ( $public ) {
            return [
                'public' => $public,
            ];
        } );
    }

    public function startupName( string $startup_name ): self
    {
        return $this->state( function ( array $attributes ) use ( $startup_name ) {
            return [
                'startup_name' => $startup_name,
            ];
        } );
    }

    public function summary( string $summary ): self
    {
        return $this->state( function ( array $attributes ) use ( $summary ) {
            return [
                'summary' => $summary,
            ];
        } );
    }

    public function investorPitch( string $investor_pitch ): self
    {
        return $this->state( function ( array $attributes ) use ( $investor_pitch ) {
            return [
                'investor_pitch' => $investor_pitch,
            ];
        } );
    }

    public function model( string $model ): self
    {
        return $this->state( function ( array $attributes ) use ( $model ) {
            return [
                'model' => $model,
            ];
        } );
    }
}

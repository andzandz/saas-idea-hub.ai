<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create( 'generated_ideas', callback: function ( Blueprint $table ) {
            $table->id();
            $table->timestamps();
            $table->foreignId( 'user_id' )->constrained()->cascadeOnDelete();
            $table->string( 'startup_name' );
            $table->text( 'summary' );
            $table->text( 'investor_pitch' );
            $table->string( 'model' );
            $table->boolean( 'public' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'generated_ideas' );
    }
};

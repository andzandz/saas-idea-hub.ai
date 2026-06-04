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
        Schema::create( 'generated_idea_testimonials', function ( Blueprint $table ) {
            $table->id();
            $table->timestamps();
            $table->foreignId( 'generated_idea_id' )->constrained()->cascadeOnDelete();
            $table->text( 'comment' );
            $table->text( 'author' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'generated_idea_testimonials' );
    }
};

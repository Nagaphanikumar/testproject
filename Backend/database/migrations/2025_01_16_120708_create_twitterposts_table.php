<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('twitterposts', function (Blueprint $table) {
            $table->id(); 
            $table->text('text')->nullable(); 
            $table->json('images')->nullable(); 
            $table->json('urls')->nullable(); 
            $table->timestamp('post_created')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitterposts');
    }
};

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
        // Schema::create('facebook_postsf', function (Blueprint $table) {
        //     $table->id();
        //     $table->text('full_picture')->nullable();
        //     $table->text('permalink_url')->unique();
        //     $table->text('message')->nullable();
        //     $table->timestamp('post_created')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_posts');
    }
};

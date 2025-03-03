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
        Schema::table('facebook', function (Blueprint $table) {
            Schema::table('facebook_posts', function (Blueprint $table) {
                $table->text('videos')->nullable();
            });
    
            // Adding nullable 'text' column to the 'twitter' table
            Schema::table('twitterposts', function (Blueprint $table) {
                $table->text('videos')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facebook', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::create('facebookfeeds', function (Blueprint $table) {
            $table->id();
            $table->string('page_id');
            $table->string('access_token');
            $table->timestamps();  
        });
        
        DB::table('facebookfeeds')->insert([
            'page_id' => '123456789',
            'access_token' => 'exampleaccesstoken123',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebookfeeds');
    }
};

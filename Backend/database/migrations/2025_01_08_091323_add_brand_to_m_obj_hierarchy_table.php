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
        Schema::table('m_obj_hierarchy', function (Blueprint $table) {
            $table->biginteger('brand')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_obj_hierarchy', function (Blueprint $table) {
            $table->dropColumn('brand');
        });
    }
};

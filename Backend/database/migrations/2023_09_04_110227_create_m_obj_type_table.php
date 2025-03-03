<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMObjTypeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('m_obj_type', function (Blueprint $table) {
            $table->bigIncrements('obj_type_id');
            $table->string('obj_type_name', 50);
            $table->string('obj_type_desc', 150)->nullable();
            $table->string('created_by', 50);
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('m_obj_type');
    }
}

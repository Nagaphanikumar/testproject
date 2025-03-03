<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMObjHierarchyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('m_obj_hierarchy', function (Blueprint $table) {
            $table->id('obj_hierarchy_id');
            $table->bigInteger('obj_id');
            $table->bigInteger('parent_obj_id');
            $table->integer('display_order')->nullable();
            $table->boolean('displayable')->nullable();
            $table->boolean('displayed')->nullable();
            $table->string('display_name', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('route_path', 250)->nullable();
            $table->string('image_name', 250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('m_obj_hierarchy');
    }
};

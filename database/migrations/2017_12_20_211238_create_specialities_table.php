<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('specialities');
        Schema::dropIfExists('company_speciality');
        Schema::dropIfExists('speciality_project');

        Schema::create('specialities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('speciality_name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('company_speciality', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('speciality_id')->unsigned();
        });

        Schema::create('project_speciality', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('speciality_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialities');
        Schema::dropIfExists('company_speciality');
        Schema::dropIfExists('speciality_project');
    }
}

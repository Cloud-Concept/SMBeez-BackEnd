<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('industries');
        Schema::dropIfExists('industry_project');
        Schema::create('industries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('industry_name');
            $table->string('slug');
            $table->string('industry_img_url');
            $table->timestamps();
        });

        Schema::create('industry_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('industry_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industries');
        Schema::dropIfExists('company_industry');
        Schema::dropIfExists('industry_project');
    }
}

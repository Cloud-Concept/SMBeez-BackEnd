<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('projects');
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_title');
            $table->string('slug');
            $table->text('project_description');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('city');
            $table->string('budget');
            $table->string('status');
            $table->date('close_date');
            $table->string('status_on_close')->nullable();
            $table->string('supportive_docs')->nullable();
            $table->integer('is_promoted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
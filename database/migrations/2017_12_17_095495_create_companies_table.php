<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('companies');
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('slug')->unique();
            $table->integer('user_id');
            $table->integer('industry_id');
            $table->text('company_description');
            $table->string('company_tagline')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone');
            $table->string('linkedin_url')->nullable();
            $table->string('city');
            $table->string('company_size');
            $table->string('year_founded')->nullable();
            $table->string('company_type')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('reg_date')->nullable();
            $table->string('reg_doc')->nullable();
            $table->string('location')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('status')->nullable();
            $table->integer('is_verified')->nullable();
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
        Schema::dropIfExists('companies');
    }
}

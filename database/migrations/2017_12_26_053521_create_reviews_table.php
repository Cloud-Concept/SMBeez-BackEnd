<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::dropIfExists('reviews');
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('reviewer_relation');
            $table->integer('is_hired');
            $table->integer('completness')->nullable();
            $table->string('why_not')->nullable();
            $table->text('why_not_msg')->nullable();
            $table->text('feedback')->nullable();
            $table->integer('quality')->default('0')->nullable();
            $table->integer('cost')->default('0')->nullable();
            $table->integer('time')->default('0')->nullable();
            $table->integer('procurement')->default('0')->nullable();
            $table->integer('expectations')->default('0')->nullable();
            $table->integer('payments')->default('0')->nullable();
            $table->integer('business_repeat')->default('0')->nullable();
            $table->integer('overall_rate')->default('0')->nullable();
            $table->string('review_privacy');
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
        Schema::dropIfExists('reviews');
    }
}

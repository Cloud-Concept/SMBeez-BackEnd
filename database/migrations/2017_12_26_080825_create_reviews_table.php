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
            $table->text('feedback');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->integer('overall_rate');
            $table->integer('selection_process_rate');
            $table->integer('money_value_rate');
            $table->integer('delivery_quality_rate');
            $table->string('reviewer_relation');
            $table->integer('question');
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

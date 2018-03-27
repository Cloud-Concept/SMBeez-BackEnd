<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelevanceScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function($table) {
            $table->integer('relevance_score')->nullable()->after('is_promoted');
        });

        Schema::table('projects', function($table) {
            $table->integer('relevance_score')->nullable()->after('is_promoted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function($table) {
            $table->dropColumn('relevance_score');
        });

        Schema::table('projects', function($table) {
            $table->dropColumn('relevance_score');
        });
    }
}

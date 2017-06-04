<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeletedAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function ($table) {
            $table->softDeletes();
        });
        Schema::table('images_posts', function ($table) {
            $table->softDeletes();
        });
        Schema::table('posts', function ($table) {
            $table->softDeletes();
        });
        Schema::table('social_providers', function ($table) {
            $table->softDeletes();
        });
        Schema::table('users', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

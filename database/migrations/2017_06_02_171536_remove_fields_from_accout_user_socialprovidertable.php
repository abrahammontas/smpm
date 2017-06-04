<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromAccoutUserSocialprovidertable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            $table->dropColumn('password');
            $table->integer('social_provider_id')->unsigned();
            $table->foreign('social_provider_id')->references('id')->on('social_providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('provider');
            $table->string('provider_id');
            $table->string('password');
            $table->foreign('user_id')->references('id')->on('users');
            $table->dropColumn('social_provider_id');
        });
    }
}

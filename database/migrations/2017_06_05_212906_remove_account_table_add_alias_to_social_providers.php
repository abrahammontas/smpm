<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAccountTableAddAliasToSocialProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('accounts');

        Schema::table('social_providers', function (Blueprint $table) {
            $table->string('alias')->after('token');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->integer('social_provider_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('social_provider_id')->references('id')->on('social_providers');
            $table->softDeletes();
        });

        Schema::table('social_providers', function (Blueprint $table) {
            $table->dropColumn('alias');
        });
    }
}

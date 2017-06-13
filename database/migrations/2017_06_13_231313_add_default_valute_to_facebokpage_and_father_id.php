<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultValuteToFacebokpageAndFatherId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_providers', function (Blueprint $table) {
            $table->boolean('facebook_page')->default(0)->change();            
            $table->integer('father_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_providers', function (Blueprint $table) {
            $table->dropColumn('facebook_page');
            $table->dropColumn('father_id');
        });
    }
}

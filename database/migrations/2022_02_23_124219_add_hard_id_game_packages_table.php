<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHardIdGamePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_packages', function (Blueprint $table) {
            $table->unsignedInteger('hard_id')->comment('ハードID')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_packages', function (Blueprint $table) {
            $table->dropColumn('hard_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnGamePackageShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->renameColumn('is_adult', 'rated_r');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->renameColumn('is_adult', 'rated_r');
        });
    }
}

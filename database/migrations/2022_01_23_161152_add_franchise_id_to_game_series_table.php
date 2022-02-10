<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFranchiseIdToGameSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_series', function (Blueprint $table) {
            $table->unsignedBigInteger('franchise_id')->default(1)->comment('フランチャイズID')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_series', function (Blueprint $table) {
            $table->dropColumn('franchise_id');
        });
    }
}

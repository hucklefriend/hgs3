<?php
/**
 * ゲームソフトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexGameSoftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->index('phonetic_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->dropIndex('phonetic_order');
        });
    }
}

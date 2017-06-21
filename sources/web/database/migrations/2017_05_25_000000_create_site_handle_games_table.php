<?php
/**
 * サイトで扱っているゲームの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteHandleGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_handle_games', function (Blueprint $table) {
            $table->unsignedInteger('site_id')->comment('サイトID');
            $table->unsignedInteger('game_id')->comment('ゲームソフトID');
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
        Schema::dropIfExists('site_handle_games');
    }
}

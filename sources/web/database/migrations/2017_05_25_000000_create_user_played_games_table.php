<?php
/**
 * 遊んだゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPlayedGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_played_games', function (Blueprint $table) {
            $table->increments('id')->comment('遊んだゲームID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('game_id')->index()->comment('ゲームID');
            $table->text('comment')->nullable()->comment('コメント');
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
        Schema::dropIfExists('user_played_games');
    }
}

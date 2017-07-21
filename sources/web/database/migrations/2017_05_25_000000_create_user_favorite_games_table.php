<?php
/**
 * お気に入りゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavoriteGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorite_games', function (Blueprint $table) {
            $table->increments('id')->comment('お気に入りゲームID');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('game_id')->index()->comment('ゲームID');
            $table->unsignedInteger('rank')->nullable()->comment('順位');
            $table->timestamps();
            $table->unique(['user_id', 'game_id']);
            $table->index(['user_id', 'rank']);
            $table->index(['game_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorite_games');
    }
}

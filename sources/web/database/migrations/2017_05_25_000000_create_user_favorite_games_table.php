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
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('package_id')->comment('パッケージID');
            $table->unsignedTinyInteger('open_type')->default(0)->comment('公開範囲');
            $table->timestamps();
            $table->primary(['user_id', 'package_id']);
            $table->index(['package_id', 'created_at']);
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

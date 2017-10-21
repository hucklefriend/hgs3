<?php
/**
 * お気に入りゲームソフトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavoriteSoftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorite_softs', function (Blueprint $table) {
            $table->increments('id')->comment('お気に入りゲームID');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->index()->comment('ゲームソフトID');
            $table->unsignedInteger('rank')->nullable()->comment('順位');
            $table->timestamps();
            $table->unique(['user_id', 'soft_id']);
            $table->index(['user_id', 'rank']);
            $table->index(['soft_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorite_softs');
    }
}

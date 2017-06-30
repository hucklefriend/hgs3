<?php
/**
 * 仮登録ゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_comments', function (Blueprint $table) {
            $table->increments('id')->comment('コメントID');
            $table->unsignedInteger('game_id')->index()->comment('ゲームID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedTinyInteger('type')->default(0)->comment('コメント種別');
            $table->text('comment')->comment('コメント');
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
        Schema::dropIfExists('game_comments');
    }
}

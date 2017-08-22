<?php
/**
 * 追加リクエストへのコメントテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameRequestCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_request_comments', function (Blueprint $table) {
            $table->increments('id')->comment('コメントID');
            $table->unsignedInteger('game_request_id')->index()->comment('ゲーム追加要望ID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
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
        Schema::dropIfExists('game_request_comments');
    }
}

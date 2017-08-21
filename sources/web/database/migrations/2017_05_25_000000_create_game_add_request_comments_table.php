<?php
/**
 * 仮登録ゲームへのコメントテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAddRequestCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_add_request_comments', function (Blueprint $table) {
            $table->increments('id')->comment('コメントID');
            $table->unsignedInteger('parent_id')->index()->comment('仮登録ID');
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
        Schema::dropIfExists('game_add_request_comments');
    }
}

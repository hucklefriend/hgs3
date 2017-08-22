<?php
/**
 * ゲーム追加要望テーブル
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_requests', function (Blueprint $table) {
            $table->increments('id')->comment('ゲーム追加要望ID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->string('name', 200)->nullable()->comment('名称');
            $table->string('url', 200)->nullable()->comment('公式サイトURL');
            $table->text('platforms')->nullable()->comment('プラットフォームリスト');
            $table->text('other')->nullable()->comment('いろいろ');
            $table->unsignedTinyInteger('status')->default(0)->comment('対応状況');
            $table->unsignedSmallInteger('comment_num')->default(0)->comment('コメント数');
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
        Schema::dropIfExists('game_requests');
    }
}

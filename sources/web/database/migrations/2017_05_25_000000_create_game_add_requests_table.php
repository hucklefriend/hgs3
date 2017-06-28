<?php
/**
 * 仮登録ゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameAddRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_add_requests', function (Blueprint $table) {
            $table->increments('id')->comment('仮登録ID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->string('name', 200)->comment('名称');
            $table->text('platforms')->nullable()->comment('プラットフォームリスト');
            $table->text('other')->nullable()->comment('いろいろ');
            $table->unsignedTinyInteger('status')->default(0)->comment('対応状況');
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
        Schema::dropIfExists('game_add_requests');
    }
}

<?php
/**
 * 仮登録ゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameUpdateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_update_requests', function (Blueprint $table) {
            $table->increments('id')->comment('仮登録ID');
            $table->increments('parent_id')->nullable()->index()->comment('親の仮登録ID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->index()->comment('ソフトID');
            $table->unsignedInteger('package_id')->nullable()->comment('パッケージID');
            $table->text('comment')->nullable()->comment('コメント');
            $table->unsignedTinyInteger('status')->default(0)->comment('対応状況');
            $table->text('admin_comment')->nullable()->comment('管理者コメント');
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
        Schema::dropIfExists('game_update_requests');
    }
}

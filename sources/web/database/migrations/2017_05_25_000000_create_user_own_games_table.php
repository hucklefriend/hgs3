<?php
/**
 * 所持ゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOwnGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_own_games', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('package_id')->index()->comment('パッケージID');
            $table->string('buy_date', 100)->comment('買った日');
            $table->string('clear_date', 100)->comment('クリアした日');
            $table->text('comment')->comment('コメント');
            $table->timestamps();
            $table->primary(['user_id', 'package_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_own_games');
    }
}

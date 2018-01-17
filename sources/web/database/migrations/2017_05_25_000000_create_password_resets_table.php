<?php
/**
 * パスワード設定テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary()->comment('ユーザーID');
            $table->string('token', 50)->unique()->comment('パスワード再発行時のトークン');
            $table->dateTime('limit_at')->comment('パスワード再発行時の有効期限');
            $table->unsignedTinyInteger('ignore')->default(0)->comment('無視フラグ');
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
        Schema::dropIfExists('password_resets');
    }
}

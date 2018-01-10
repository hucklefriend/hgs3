<?php
/**
 * メールアドレス変更テーブル
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserChangeEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_emails', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary()->comment('ユーザーID');
            $table->string('email', 200)->unique()->comment('メールアドレス');
            $table->string('token', 50)->nullable()->comment('パスワード再発行時のトークン');
            $table->dateTime('limit_date')->nullable()->comment('パスワード再発行時の有効期限');
            $table->string('password', 100)->comment('パスワード');
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
        Schema::dropIfExists('user_emails');
    }
}

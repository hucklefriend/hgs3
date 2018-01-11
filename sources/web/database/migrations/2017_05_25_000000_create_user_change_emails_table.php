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
        Schema::create('user_change_emails', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->primary()->comment('ユーザーID');
            $table->string('email', 200)->unique()->comment('メールアドレス');
            $table->string('token', 50)->nullable()->comment('メールアドレス変更時のトークン');
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
        Schema::dropIfExists('user_change_emails');
    }
}

<?php
/**
 * ユーザーテーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('ユーザーID');
            $table->string('name', 200)->index()->comment('ユーザー名');
            $table->unsignedSmallInteger('role')->default(1)->comment('ロール');
            $table->unsignedTinyInteger('adult')->default(0)->comment('18歳以上');
            $table->unsignedInteger('point')->default(0)->comment('ポイント');
            $table->dateTime('last_login_date')->nullable()->comment('最終ログイン日時');
            $table->dateTime('sign_up_date')->nullable()->comment('登録日時');
            $table->tinyInteger('hgs12_user')->default(0)->comment('旧HGSユーザーフラグ');
            $table->string('email', 200)->nullable()->comment('メールアドレス');
            $table->string('password', 200)->nullable()->comment('パスワード');
            $table->string('remember_token', 200)->nullable()->comment('再アクセストークン');
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
        Schema::dropIfExists('users');
    }
}
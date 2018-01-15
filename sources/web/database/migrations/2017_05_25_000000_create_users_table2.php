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
            $table->string('show_id', 100)->unique()->comment('表示用ID');
            $table->string('name', 200)->index()->comment('ユーザー名');
            $table->unsignedSmallInteger('role')->default(1)->comment('ロール');
            $table->unsignedTinyInteger('adult')->default(0)->comment('18歳以上');
            $table->text('profile')->default('')->comment('自己紹介');
            $table->unsignedInteger('point')->default(0)->comment('ポイント');
            $table->dateTime('last_login_at')->nullable()->comment('最終ログイン日時');
            $table->dateTime('sign_up_at')->nullable()->comment('登録日時');
            $table->tinyInteger('hgs12_user')->default(0)->comment('旧HGSユーザーフラグ');
            $table->string('email', 200)->nullable()->comment('メールアドレス');
            $table->string('password', 200)->nullable()->comment('パスワード');
            $table->string('remember_token', 200)->nullable()->comment('再アクセストークン');
            $table->unsignedTinyInteger('icon_upload_flag')->default(0)->comment('アイコンアップロード済みフラグ');
            $table->string('icon_file_name', 30)->nullable()->comment('アイコンファイル名');
            $table->unsignedTinyInteger('footprint')->default(1)->comment('サイトへの足跡を残すフラグ');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE `used_show_ids` CHANGE `show_id` `show_id` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL  COMMENT "表示用ID"');
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

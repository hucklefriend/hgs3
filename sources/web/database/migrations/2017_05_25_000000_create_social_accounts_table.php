<?php
/**
 * ソーシャルアカウントテーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->increments('id')->comment('ソーシャルアカウントID');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->string('social_user_id', 256)->index()->comment('ソーシャルサイト側のユーザーID');
            $table->string('token', 256)->nullable()->comment('アクセストークン');
            $table->string('token_secret', 256)->nullable()->comment('シークレットアクセストークン');
            $table->unsignedSmallInteger('social_site_id')->comment('ソーシャルサイトの種別');
            $table->timestamps();
            $table->unique(['user_id', 'social_site_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('social_accounts');
    }
}

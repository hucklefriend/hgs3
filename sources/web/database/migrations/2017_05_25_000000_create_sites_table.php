<?php
/**
 * サイトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id')->comment('サイトID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->string('name', 100)->comment('サイト名');
            $table->string('url', 200)->comment('URL');
            $table->string('banner_url', 200)->nullable()->comment('バナーURL');
            $table->text('presentation')->comment('紹介文');
            $table->unsignedTinyInteger('rate')->comment('対象年齢');
            $table->unsignedTinyInteger('gender')->comment('対象性別');
            $table->unsignedSmallInteger('main_contents_id')->comment('メインコンテンツ');
            $table->unsignedTinyInteger('open_type')->comment('公開範囲');
            $table->unsignedInteger('in_count')->default(0)->comment('INカウント');
            $table->unsignedInteger('out_count')->default(0)->comment('OUTカウント');
            $table->unsignedInteger('good_num')->default(0)->comment('いいね数');
            $table->unsignedInteger('max_good_num')->default(0)->comment('最高いいね数');
            $table->unsignedInteger('bad_num')->default(0)->comment('BAD数');
            $table->unsignedBigInteger('registered_timestamp')->comment('登録日時タイムスタンプ');
            $table->unsignedBigInteger('updated_timestamp')->comment('最終更新タイムスタンプ');
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
        Schema::dropIfExists('sites');
    }
}

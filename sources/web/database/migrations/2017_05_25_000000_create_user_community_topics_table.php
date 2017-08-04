<?php
/**
 * ユーザーコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommunityTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_community_topics', function (Blueprint $table) {
            $table->increments('id')->comment('ユーザーコミュニティトピックスID');
            $table->unsignedInteger('user_community_id')->comment('ユーザーコミュニティID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->text('title')->comment('タイトル');
            $table->text('comment')->comment('本文');
            $table->dateTime('wrote_date')->comment('書き込み日時');
            $table->dateTime('response_date')->comment('一番最新のレスがあった日時');
            $table->unsignedInteger('response_num')->comment('レス数');
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
        Schema::dropIfExists('user_community_topics');
    }
}

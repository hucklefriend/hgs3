<?php
/**
 * ユーザーコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommunityTopicResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_community_topic_responses', function (Blueprint $table) {
            $table->increments('id')->comment('ユーザーコミュニティトピックスレスID');
            $table->unsignedInteger('user_community_topics_id')->comment('ユーザーコミュニティトピックスID');
            $table->unsignedInteger('user_community_topics_response_id')->nullable()->comment('ユーザーコミュニティトピックスID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->text('comment')->comment('本文');
            $table->dateTime('wrote_date')->comment('書き込み日時');
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
        Schema::dropIfExists('user_community_topic_responses');
    }
}

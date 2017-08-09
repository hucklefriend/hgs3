<?php
/**
 * ゲームコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameCommunityTopicResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_community_topic_responses', function (Blueprint $table) {
            $table->increments('id')->comment('ゲームコミュニティトピックスレスID');
            $table->unsignedInteger('game_community_topic_id')->index()->comment('ゲームコミュニティトピックスID');
            $table->unsignedInteger('game_community_topic_response_id')->nullable()->comment('レスID');
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
        Schema::dropIfExists('game_community_topic_responses');
    }
}

<?php
/**
 * ゲームコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameCommunityMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_community_members', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->comment('ゲームソフトID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->dateTime('join_date')->comment('参加日時');
            $table->timestamps();
            $table->primary(['soft_id', 'user_id']);
            $table->index(['soft_id', 'join_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_community_members');
    }
}

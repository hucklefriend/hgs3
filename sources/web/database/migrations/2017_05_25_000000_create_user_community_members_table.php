<?php
/**
 * ユーザーコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommunityMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_community_members', function (Blueprint $table) {
            $table->unsignedInteger('user_community_id')->comment('ユーザーコミュニティID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->dateTime('join_date')->comment('参加日時');
            $table->timestamps();
            $table->primary(['user_community_id', 'user_id']);
            $table->index(['user_community_id', 'join_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_community_members');
    }
}

<?php
/**
 * ユーザーコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_communities', function (Blueprint $table) {
            $table->increments('id')->comment('ユーザーコミュニティID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID(作成者)');
            $table->unsignedTinyInteger('access')->default(\Hgs3\Constants\UserCommunity\Access::OPEN)->comment('アクセス区分');
            $table->string('name', 100)->comment('コミュニティ名');
            $table->text('profile')->comment('コミュニティ紹介文');
            $table->unsignedInteger('user_num')->comment('ユーザー数');
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
        Schema::dropIfExists('user_communities');
    }
}

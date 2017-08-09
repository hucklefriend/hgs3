<?php
/**
 * ゲームコミュニティテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_communities', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary()->comment('ゲームコミュニティID(=ゲームソフトID)');
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
        Schema::dropIfExists('game_communities');
    }
}

<?php
/**
 * レビュー下書きテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_drafts', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('game_id')->comment('ゲームソフトID');
            $table->text('package_id')->nullable()->comment('パッケージID');
            $table->unsignedSmallInteger('play_time')->comment('プレイ時間');
            $table->string('title', 50)->comment('一言');
            $table->unsignedTinyInteger('point')->comment('ポイント');
            $table->unsignedTinyInteger('fear')->comment('怖さ');
            $table->unsignedTinyInteger('story')->comment('シナリオ');
            $table->unsignedTinyInteger('volume')->comment('ボリューム');
            $table->unsignedTinyInteger('difficulty')->comment('難易度');
            $table->unsignedTinyInteger('graphic')->comment('グラフィック');
            $table->unsignedTinyInteger('sound')->comment('サウンド');
            $table->unsignedTinyInteger('crowded')->comment('やりこみ');
            $table->unsignedTinyInteger('controllability')->comment('操作性');
            $table->unsignedTinyInteger('recommend')->comment('オススメ度');
            $table->text('thoughts')->comment('感想');
            $table->text('recommendatory')->comment('オススメ');
            $table->timestamps();
            $table->primary(['user_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}

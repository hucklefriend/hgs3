<?php
/**
 * レビューテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id')->comment('レビューID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('game_id')->index()->comment('ゲームソフトID');
            $table->unsignedInteger('package_id')->comment('パッケージID');
            $table->string('title', 100)->comment('一言');
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
            $table->text('progress')->comment('ゲームの進行状態');
            $table->text('text')->comment('レビュー本文');
            $table->unsignedTinyInteger('is_spoiler')->default(0)->comment('ネタバレ有無');
            $table->integer('sort_order')->default(0)->comment('ソート順');
            $table->unsignedInteger('good_num')->default(0)->comment('いいね数');
            $table->unsignedInteger('latest_good_num')->default(0)->comment('直近のいいね数');
            $table->unsignedInteger('max_good_num')->default(0)->comment('いいね数');
            $table->dateTime('post_date')->comment('投稿日時');
            $table->unsignedInteger('update_num')->default(0)->comment('更新回数');
            $table->unsignedTinyInteger('status')->default(0)->comment('表示ステータス');
            $table->timestamps();
            $table->index(['game_id', 'status']);
            $table->index(['user_id', 'status']);
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

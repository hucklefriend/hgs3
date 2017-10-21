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
            $table->unsignedInteger('soft_id')->comment('ゲームソフトID');
            $table->unsignedInteger('package_id')->comment('パッケージID');
            $table->string('title', 0)->comment('一言');
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
            $table->timestamps();
            $table->primary(['user_id', 'package_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_drafts');
    }
}

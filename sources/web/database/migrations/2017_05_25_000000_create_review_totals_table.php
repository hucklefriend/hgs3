<?php
/**
 * レビューテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_totals', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->primary()->comment('ゲームソフトID');
            $table->unsignedInteger('review_num')->comment('レビュー数');
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
        Schema::dropIfExists('review_totals');
    }
}

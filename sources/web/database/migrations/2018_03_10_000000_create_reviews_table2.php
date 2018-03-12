<?php
/**
 * レビューのタグテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reviews');
        Schema::create('review', function (Blueprint $table) {
            $table->increments('id')->comment('レビューID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->index()->comment('ゲームソフトID');
            $table->text('package_id')->comment('パッケージIDリスト');
            $table->text('progress')->comment('ゲームの進行状態');
            $table->text('good')->comment('良い点');
            $table->text('bad')->comment('悪い点');
            $table->text('general_comment')->comment('総評');
            $table->unsignedTinyInteger('is_spoiler')->default(0)->comment('ネタバレ有無');
            $table->integer('sort_order')->default(0)->comment('ソート順');
            $table->unsignedInteger('good_num')->default(0)->comment('いいね数');
            $table->unsignedInteger('latest_good_num')->default(0)->comment('直近のいいね数');
            $table->unsignedInteger('max_good_num')->default(0)->comment('いいね数');
            $table->dateTime('post_at')->comment('投稿日時');
            $table->unsignedInteger('update_num')->default(0)->comment('更新回数');
            $table->unsignedTinyInteger('status')->default(0)->comment('表示ステータス');
            $table->timestamps();
            $table->index(['soft_id', 'status']);
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

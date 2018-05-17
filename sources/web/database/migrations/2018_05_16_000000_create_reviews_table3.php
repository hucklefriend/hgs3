<?php
/**
 * レビューテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reviews');

        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id')->comment('レビューID');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->comment('ゲームソフトID');
            $table->text('package_id')->comment('パッケージID');
            $table->unsignedTinyInteger('fear')->comment('怖さ');
            $table->text('fear_comment')->nullable()->comment('怖さコメント');
            $table->text('url')->nullable()->comment('URL');
            $table->unsignedInteger('enable_url')->default(0)->comment('URLが有効か');
            $table->text('progress')->nullable()->comment('ゲームの進行状態');
            $table->unsignedTinyInteger('good_tag_num')->comment('良いタグ数');
            $table->unsignedTinyInteger('very_good_tag_num')->comment('特に良いタグ数');
            $table->text('good_comment')->nullable()->comment('良い点');
            $table->unsignedTinyInteger('bad_tag_num')->comment('悪いタグ数');
            $table->unsignedTinyInteger('very_bad_tag_num')->comment('特に悪いタグ数');
            $table->text('bad_comment')->nullable()->comment('悪い点');
            $table->text('general_comment')->nullable()->comment('総合評価');
            $table->unsignedTinyInteger('is_spoiler')->default(0)->comment('ネタバレ有無');
            $table->integer('point')->comment('ポイント');
            $table->integer('sort_order')->default(0)->comment('ソート順');
            $table->unsignedInteger('good_num')->default(0)->comment('いいね数');
            $table->unsignedInteger('latest_good_num')->default(0)->comment('直近のいいね数');
            $table->unsignedInteger('max_good_num')->default(0)->comment('いいね数');
            $table->dateTime('post_at')->comment('投稿日時');
            $table->unsignedInteger('update_num')->default(0)->comment('更新回数');
            $table->unsignedTinyInteger('status')->default(0)->comment('表示ステータス');
            $table->timestamps();
            $table->unique(['soft_id', 'user_id']);
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

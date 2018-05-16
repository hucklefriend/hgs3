<?php
/**
 * レビュー集計テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTotalsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('review_totals');

        Schema::create('review_totals', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->primary()->comment('ゲームソフトID');
            $table->unsignedTinyInteger('fear')->comment('怖さ');
            $table->unsignedTinyInteger('good_tag_num')->comment('良いタグ数');
            $table->unsignedTinyInteger('very_good_tag_num')->comment('特に良いタグ数');
            $table->text('good_comment')->nullable()->comment('良い点');
            $table->unsignedTinyInteger('bad_tag_num')->comment('悪いタグ数');
            $table->unsignedTinyInteger('very_bad_tag_num')->comment('特に悪いタグ数');
            $table->text('bad_comment')->nullable()->comment('悪い点');
            $table->text('general_comment')->nullable()->comment('総合評価');
            $table->unsignedInteger('point')->comment('ポイント');
            $table->unsignedInteger('review_num')->comment('レビュー数');
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

<?php
/**
 * レビュー印象履歴テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewImpressionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('review_good_histories');

        Schema::create('review_impression_histories', function (Blueprint $table) {
            $table->unsignedInteger('review_id')->comment('レビューID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->tinyInteger('fmfm_or_n')->comment('どっちにしたか');
            $table->timestamps();
            $table->primary(['review_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_impression_histories');
    }
}

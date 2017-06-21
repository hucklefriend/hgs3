<?php
/**
 * レビューいいね履歴テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewGoodHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_good_histories', function (Blueprint $table) {
            $table->unsignedInteger('review_id')->comment('レビューID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->dateTime('good_date')->comment('いいねした日時');
            $table->unsignedTinyInteger('anonymous')->default(0)->comment('匿名フラグ');
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
        Schema::dropIfExists('review_good_histories');
    }
}

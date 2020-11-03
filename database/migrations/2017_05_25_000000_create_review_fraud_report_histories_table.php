<?php
/**
 * 不正レビュー履歴テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewFraudReportHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_fraud_report_histories', function (Blueprint $table) {
            $table->increments('id')->comment('不正レビュー報告履歴ID');
            $table->unsignedTinyInteger('status')->comment('対応状況');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('ユーザーID');
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
        Schema::dropIfExists('review_fraud_report_histories');
    }
}

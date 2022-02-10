<?php
/**
 * 不正レビューテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewFraudReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_fraud_reports', function (Blueprint $table) {
            $table->increments('id')->comment('不正レビュー報告ID');
            $table->unsignedInteger('review_id')->index()->comment('レビューID');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('ユーザーID');
            $table->unsignedInteger('types')->default(0)->comment('種類');
            $table->text('comment')->comment('コメント');
            $table->unsignedTinyInteger('status')->index()->comment('対応状況');
            $table->unsignedTinyInteger('stop_comment')->comment('コメント停止フラグ');
            $table->string('ip_address', 64)->nullable()->comment('IPアドレス');
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
        Schema::dropIfExists('review_fraud_reports');
    }
}

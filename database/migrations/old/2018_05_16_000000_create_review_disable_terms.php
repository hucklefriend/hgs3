<?php
/**
 * レビュー無効期間テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewDisableTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_disable_terms', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->comment('ソフトID');
            $table->date('start_date')->comment('無効化開始日時');
            $table->timestamps();
            $table->primary(['user_id', 'soft_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_disable_terms');
    }
}

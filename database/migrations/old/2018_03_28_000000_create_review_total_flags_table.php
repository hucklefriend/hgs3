<?php
/**
 * レビュー集計管理テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTotalFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_total_flags', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->primary()->comment('ゲームソフトID');
            $table->unsignedTinyInteger('total_flag')->default(0)->index()->comment('集計実行フラグ');
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
        Schema::dropIfExists('review_total_flags');
    }
}

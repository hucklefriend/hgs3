<?php
/**
 * レビュー怖さランキングテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewFearRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_fear_rankings', function (Blueprint $table) {
            $table->unsignedInteger('rank')->comment('順位');
            $table->unsignedInteger('soft_id')->primary()->comment('ゲームID');
            $table->smallInteger('fear')->comment('怖さ');
            $table->tinyInteger('fear_face')->comment('顔');
            $table->timestamps();
            $table->unique(['rank', 'soft_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_fear_rankings');
    }
}

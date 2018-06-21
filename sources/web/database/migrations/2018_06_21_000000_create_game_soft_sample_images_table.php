<?php
/**
 * ゲームのサンプルイメージテーブル
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSoftSampleImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_soft_sample_images', function (Blueprint $table) {
            $table->increments('id')->comment('ID');
            $table->unsignedInteger('no')->comment('画像番号');
            $table->unsignedInteger('soft_id')->comment('ゲームID');
            $table->unsignedInteger('shop_id')->comment('ショップID');
            $table->text('small_image_url')->nullable()->comment('小イメージURL');
            $table->text('large_image_url')->nullable()->comment('大イメージURL');
            $table->timestamps();
            $table->index(['soft_id', 'no']);
            $table->index(['soft_id', 'shop_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_soft_sample_images');
    }
}

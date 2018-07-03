<?php
/**
 * ゲームのサンプルイメージテーブル
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSoftSampleImagesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('game_soft_sample_images');
        Schema::create('game_soft_sample_images', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->comment('ゲームID');
            $table->unsignedInteger('no')->comment('画像番号');
            $table->unsignedInteger('package_id')->default(0)->index()->comment('パッケージID');
            $table->unsignedInteger('shop_id')->comment('ショップID');
            $table->text('small_image_url')->nullable()->comment('小イメージURL');
            $table->text('large_image_url')->nullable()->comment('大イメージURL');
            $table->timestamps();
            $table->primary(['soft_id', 'no']);
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

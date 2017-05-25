<?php
/**
 * ゲームパッケージテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->index();
            $table->integer('platform_id')->index();
            $table->integer('company_id');
            $table->string('name', 200);
            $table->text('url');
            $table->string('release_date', 100);
            $table->integer('release_int');
            $table->string('asin', 200)->nullable();
            $table->text('small_image_url')->nullable();
            $table->text('medium_image_url')->nullable();
            $table->text('large_image_url')->nullable();
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
        Schema::dropIfExists('game_packages');
    }
}

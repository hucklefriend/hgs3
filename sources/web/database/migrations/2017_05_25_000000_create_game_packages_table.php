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
            $table->increments('id')->comment('ゲームパッケージID');
            $table->unsignedInteger('game_id')->comment('ゲームソフトID');
            $table->unsignedInteger('platform_id')->index()->comment('プラットフォームID');
            $table->unsignedInteger('company_id')->comment('ゲーム会社ID');
            $table->string('name', 200)->comment('パッケージ名称');
            $table->text('url')->comment('公式サイトURL');
            $table->string('release_date', 100)->comment('発売日');
            $table->unsignedInteger('release_int')->comment('発売日（ソート用の数値）');
            $table->string('asin', 200)->nullable()->comment('ASIN');
            $table->text('small_image_url')->nullable()->comment('amazonの小画像URL');
            $table->unsignedInteger('small_image_width')->nullable()->comment('小画像の幅');
            $table->unsignedInteger('small_image_height')->nullable()->comment('小画像の高さ');
            $table->text('medium_image_url')->nullable()->comment('amazonの中画像URL');
            $table->unsignedInteger('medium_image_width')->nullable()->comment('中画像の幅');
            $table->unsignedInteger('medium_image_height')->nullable()->comment('中画像の高さ');
            $table->text('large_image_url')->nullable()->comment('amazonの大画像URL');
            $table->unsignedInteger('large_image_width')->nullable()->comment('大画像の幅');
            $table->unsignedInteger('large_image_height')->nullable()->comment('大画像の高さ');
            $table->timestamps();
            $table->index(['game_id', 'release_int']);
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

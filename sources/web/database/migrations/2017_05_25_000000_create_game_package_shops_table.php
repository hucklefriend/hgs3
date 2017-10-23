<?php
/**
 * ゲームパッケージショップテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePackageShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_package_shops', function (Blueprint $table) {
            $table->unsignedInteger('package_id')->comment('ゲームパッケージID');
            $table->unsignedInteger('shop_id')->index()->comment('ショップID');
            $table->text('shop_url')->nullable()->comment('ショップ販売ページのURL');
            $table->string('param1', 200)->nullable()->comment('パラメーター1');
            // ※いまのところ2以上はなさそうなのでparamは1のみ、必要になったら追加する
            $table->timestamps();
            $table->primary(['package_id', 'shop_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_package_shops');
    }
}

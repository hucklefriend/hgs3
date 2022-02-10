<?php
/**
 * ゲームショップデータテーブルにカラム追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGameShopParam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->text('small_image_url')->nullable()->comment('小画像URL')->after('shop_url');
            $table->text('medium_image_url')->nullable()->comment('中画像URL')->after('small_image_url');
            $table->text('large_image_url')->nullable()->comment('大画像URL')->after('medium_image_url');
            $table->string('param2', 200)->nullable()->comment('パラメーター2')->after('param1');
            $table->string('param3', 200)->nullable()->comment('パラメーター3')->after('param2');
            $table->string('param4', 200)->nullable()->comment('パラメーター4')->after('param3');
            $table->string('param5', 200)->nullable()->comment('パラメーター5')->after('param4');
            $table->string('param6', 200)->nullable()->comment('パラメーター6')->after('param5');
            $table->string('param7', 200)->nullable()->comment('パラメーター7')->after('param6');
            $table->string('param8', 200)->nullable()->comment('パラメーター8')->after('param7');
            $table->string('param9', 200)->nullable()->comment('パラメーター9')->after('param8');
            $table->string('param10', 200)->nullable()->comment('パラメーター10')->after('param9');
            $table->unsignedBigInteger('updated_timestamp')->default(0)->index()->comment('データ更新日時')->after('param10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

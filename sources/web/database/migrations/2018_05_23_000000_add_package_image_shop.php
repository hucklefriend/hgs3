<?php
/**
 * パッケージに画像を取得した元のショップIDを入れる
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageImageShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_packages', function (Blueprint $table) {
            $table->unsignedInteger('shop_id')->nullable()->comment('画像のショップID')->after('is_adult');
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

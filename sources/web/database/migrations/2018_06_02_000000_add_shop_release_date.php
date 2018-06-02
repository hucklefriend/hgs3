<?php
/**
 * ショップに発売日を追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Hgs3\Constants\User\Setting\OpenTimelineFlag;

class AddShopReleaseDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->unsignedBigInteger('release_int')->default(0)->comment('発売日(数値)')->after('large_image_url');
            $table->index(['shop_id', 'release_int']);
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

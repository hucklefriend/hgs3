<?php
/**
 * 公式サイトがアダルトサイトか
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGameOfficialSiteIsAdult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_official_sites', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_adult')->default(0)->after('priority')->comment('アダルトサイトフラグ');
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

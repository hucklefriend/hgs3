<?php
/**
 * ゲームソフトテーブルに列を追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGameSoftColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->text('introduction')->default('')->comment('説明文')->after('original_package_id');
            $table->text('introduction_from')->default('')->comment('説明文引用元')->after('introduction');
        });

        //$sql = "ALTER TABLE `game_softs` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'ゲームソフトID'";
        //\Illuminate\Support\Facades\DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_softs');
    }
}

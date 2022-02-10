<?php
/**
 * マスター系のテーブルからAutoIncrementを削除
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIdMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "ALTER TABLE `game_companies` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'ゲーム会社ID';";
        \Illuminate\Support\Facades\DB::statement($sql);
        $sql = "ALTER TABLE `game_packages` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'ゲームパッケージID';";
        \Illuminate\Support\Facades\DB::statement($sql);
        $sql = "ALTER TABLE `game_platforms` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'プラットフォームID';";
        \Illuminate\Support\Facades\DB::statement($sql);
        $sql = "ALTER TABLE `game_platforms` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'プラットフォームID';";
        \Illuminate\Support\Facades\DB::statement($sql);
        $sql = "ALTER TABLE `game_series` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'シリーズID';";
        \Illuminate\Support\Facades\DB::statement($sql);
        $sql = "ALTER TABLE `game_softs` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL COMMENT 'ゲームソフトID';";
        \Illuminate\Support\Facades\DB::statement($sql);
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

<?php
/**
 * プロフィール公開フラグ
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserOpenFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "ALTER TABLE `users` CHANGE `open_timeline_flag` `open_profile_flag` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' COMMENT 'タイムライン公開フラグ'";
        DB::statement($sql);

        DB::update("UPDATE users SET open_profile_flag = 1");
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

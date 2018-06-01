<?php
/**
 * タイムライン公開フラグ
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Hgs3\Constants\User\Setting\OpenTimelineFlag;

class AddOpenTimelineFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('open_timeline_flag')->default(OpenTimelineFlag::NO)->comment('タイムライン公開フラグ')->after('footprint');
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

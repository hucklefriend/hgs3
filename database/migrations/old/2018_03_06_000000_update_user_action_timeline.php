<?php
/**
 * ユーザー行動タイムライン
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserActionTimeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $db = \Hgs3\Models\MongoDB\Collection::getInstance()->getDatabase();

        $db->dropCollection('user_action_timeline');

        $db->user_action_timeline->createIndex([
            'user_id' => 1,
            'time'    => -1,
        ]);
        $db->user_action_timeline->createIndex([
            'user_only' => 1,
            'user_id'   => 1,
            'time'      => -1,
        ]);
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

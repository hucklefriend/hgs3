<?php
/**
 * ゲームソフトリスト
 */


use Illuminate\Database\Migrations\Migration;

class CreateGameSoftListCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $db = \Hgs3\Models\MongoDB\Collection::getInstance()->getDatabase();
        $db->dropCollection('game_soft_list');
        $db->createCollection('game_soft_list');
        $db->game_soft_list->createIndex(['sort' => 1]);
        $db->game_soft_list->createIndex(['series_id' => 1, 'order_in_series' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $db = \Hgs3\Models\MongoDB\Collection::getInstance()->getDatabase();
        $db->dropCollection('game_soft_list');
    }
}

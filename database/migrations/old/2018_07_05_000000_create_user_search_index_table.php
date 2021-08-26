<?php
/**
 * ユーザー
 */


use Illuminate\Database\Migrations\Migration;

class CreateUserSearchIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $db = \Hgs3\Models\MongoDB\Collection::getInstance()->getDatabase();
        $db->dropCollection('user_search_index');
        $db->createCollection('user_search_index');
        $db->user_search_index->createIndex(['id' => 1]);
        $db->user_search_index->createIndex(['open_profile_flag' => 1, 'attribute' => 1, 'time' => -1]);
        $db->user_search_index->createIndex(['open_profile_flag' => 1, 'sns' => 1, 'time' => -1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $db = \Hgs3\Models\MongoDB\Collection::getInstance()->getDatabase();
        $db->dropCollection('user_search_index');
    }
}

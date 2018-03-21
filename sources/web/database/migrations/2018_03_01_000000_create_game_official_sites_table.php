<?php
/**
 * 公式サイトテーブルを作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameOfficialSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_official_sites', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->comment('ソフトID');
            $table->string('title', 100)->comment('タイトル');
            $table->string('url', 256)->comment('URL');
            $table->unsignedTinyInteger('priority')->comment('優先度');
            $table->primary(['soft_id', 'url']);
            $table->index(['soft_id', 'priority']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_official_sites');
    }
}

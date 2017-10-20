<?php
/**
 * ゲームソフトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSoftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_softs', function (Blueprint $table) {
            $table->increments('id')->comment('ゲームソフトID');
            $table->string('name', 200)->comment('名称');
            $table->string('phonetic', 200)->comment('よみがな');
            $table->unsignedTinyInteger('phonetic_type')->comment('よみがな区分');
            $table->unsignedInteger('phonetic_order')->default(0)->comment('よみがなでの表示順');
            $table->string('genre', 200)->comment('ジャンル');
            $table->unsignedInteger('series_id')->nullable()->index()->comment('シリーズID');
            $table->unsignedInteger('order_in_series')->nullable()->comment('シリーズ内での表示順');
            $table->unsignedInteger('original_package_id')->nullable()->comment('原点のパッケージID');
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
        Schema::dropIfExists('game_softs');
    }
}

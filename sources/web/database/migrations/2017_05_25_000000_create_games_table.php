<?php
/**
 * ゲームソフトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id')->comment('ゲームソフトID');
            $table->string('name', 200)->comment('名称');
            $table->string('phonetic', 200)->comment('名称のよみがな');
            $table->unsignedInteger('company_id')->comment('ゲーム会社ID');
            $table->unsignedInteger('series_id')->nullable()->index()->comment('シリーズID');
            $table->unsignedInteger('order_in_series')->nullable()->comment('シリーズ内での表示順');
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
        Schema::dropIfExists('games');
    }
}

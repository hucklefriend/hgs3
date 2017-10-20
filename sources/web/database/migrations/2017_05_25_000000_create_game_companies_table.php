<?php
/**
 * 会社テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_companies', function (Blueprint $table) {
            $table->increments('id')->comment('ゲーム会社ID');
            $table->string('name', 200)->comment('ゲーム会社名');
            $table->string('acronym', 30)->comment('略称');
            $table->string('phonetic', 200)->comment('ゲーム会社名のよみがな');
            $table->text('url')->nullable()->comment('サイトのURL');
            $table->text('wikipedia')->nullable()->comment('WikipediaのURL');
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
        Schema::dropIfExists('game_companies');
    }
}

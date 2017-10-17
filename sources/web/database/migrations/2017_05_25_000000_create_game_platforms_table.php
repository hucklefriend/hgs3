<?php
/**
 * プラットフォームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_platforms', function (Blueprint $table) {
            $table->increments('id')->comment('プラットフォームID');
            $table->unsignedInteger('company_id')->nullable()->index()->comment('ゲーム会社ID');
            $table->string('name', 200)->comment('プラットフォーム名');
            $table->string('acronym', 30)->comment('略称');
            $table->unsignedInteger('sort_order')->index()->comment('表示順');
            $table->string('url', 500)->nullable()->comment('公式サイトURL');
            $table->string('wikipedia', 500)->nullable()->comment('Wikipedia URL');
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
        Schema::dropIfExists('game_platforms');
    }
}

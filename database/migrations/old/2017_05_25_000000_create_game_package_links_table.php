<?php
/**
 * ゲームとパッケージの紐づけテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePackageLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_package_links', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->comment('ゲームソフトID');
            $table->unsignedInteger('package_id')->comment('パッケージID');
            $table->unsignedBigInteger('sort_order')->comment('表示順');
            $table->timestamps();
            $table->primary(['soft_id', 'package_id']);
            $table->index(['soft_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_package_links');
    }
}

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
            $table->unsignedInteger('game_id')->comment('ID');
            $table->unsignedInteger('package_id')->comment('ゲーム会社ID');
            $table->timestamps();
            $table->index(['game_id', 'package_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_packages');
    }
}

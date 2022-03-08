<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePackageGameSoftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_package_game_soft', function (Blueprint $table) {
            $table->unsignedBigInteger('game_soft_id');
            $table->unsignedBigInteger('game_package_id');
            $table->primary(['game_soft_id','game_package_id']);
            $table->index(['game_package_id']);
            $table->foreign('game_soft_id')->references('id')->on('game_softs')->onDelete('cascade');
            $table->foreign('game_package_id')->references('id')->on('game_packages')->onDelete('cascade');

            $table->timestamps();
        });

        /**
         *
         * INSERT IGNORE INTO game_package_game_soft(game_soft_id, game_package_id, created_at, updated_at)
        SELECT soft_id, package_id, created_at, updated_at
        FROM game_soft_package
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_package_game_soft');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameHardGamePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_hard_game_package', function (Blueprint $table) {
            $table->unsignedBigInteger('game_hard_id');
            $table->unsignedBigInteger('game_package_id');
            $table->primary(['game_hard_id','game_package_id']);
            $table->index(['game_package_id']);
            $table->foreign('game_hard_id')->references('id')->on('game_hards')->onDelete('cascade');
            $table->foreign('game_package_id')->references('id')->on('game_packages')->onDelete('cascade');
            $table->timestamps();
        });

        $sql =<<< SQL
INSERT IGNORE INTO game_hard_game_package(game_hard_id, game_package_id, created_at, updated_at)
SELECT hard_id, id, NOW(), NOW()
FROM game_packages
WHERE hard_id IS NOT NULL
SQL;

        DB::statement($sql);

        Schema::dropColumns('game_packages', ['hard_id']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_hard_game_package');
    }
}

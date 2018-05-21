<?php
/**
 * ゲームショップデータテーブルにカラム追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewsFmfm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->string('param2', 200)->nullable()->comment('パラメーター2');
            $table->string('param3', 200)->nullable()->comment('パラメーター3');
            $table->string('param4', 200)->nullable()->comment('パラメーター4');
            $table->string('param5', 200)->nullable()->comment('パラメーター5');
            $table->string('param6', 200)->nullable()->comment('パラメーター6');
            $table->string('param7', 200)->nullable()->comment('パラメーター7');
            $table->string('param8', 200)->nullable()->comment('パラメーター8');
            $table->string('param9', 200)->nullable()->comment('パラメーター9');
            $table->string('param10', 200)->nullable()->comment('パラメーター10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

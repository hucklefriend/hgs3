<?php
/**
 * 攻略日記テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diaries', function (Blueprint $table) {
            $table->increments('id')->comment('攻略日記ID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('package_id')->index()->comment('パッケージID');
            $table->date('play_date')->comment('遊んだ日');
            $table->text('text')->comment('内容');
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
        Schema::dropIfExists('diaries');
    }
}

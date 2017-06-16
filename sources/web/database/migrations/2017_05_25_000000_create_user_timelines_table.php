<?php
/**
 * タイムラインテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_timelines', function (Blueprint $table) {
            $table->increments('id')->comment('タイムラインテーブル');
            $table->unsignedBigInteger('sort')->index()->comment('ソート順');
            $table->dateTime('action_date')->index()->comment('日時');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->text('text')->comment('表示テキスト');
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
        Schema::dropIfExists('user_timelines');
    }
}

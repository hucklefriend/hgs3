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
            $table->increments('id');
            $table->unsignedBigInteger('sort')->index();
            $table->dateTime('action_date')->index();
            $table->unsignedInteger('user_id')->index();
            $table->text('text');
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

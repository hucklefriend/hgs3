<?php
/**
 * 新着情報テーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_information', function (Blueprint $table) {
            $table->increments('id')->comment('新着情報ID');
            $table->unsignedInteger('text_type')->comment('テキスト種類');
            $table->unsignedInteger('param1')->default(0)->comment('パラメーター1');
            $table->unsignedInteger('param2')->default(0)->comment('パラメーター2');
            $table->unsignedInteger('param3')->default(0)->comment('パラメーター3');
            $table->unsignedInteger('param4')->default(0)->comment('パラメーター4');
            $table->unsignedInteger('param5')->default(0)->comment('パラメーター5');
            $table->dateTime('date_time')->comment('日時');
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
        Schema::dropIfExists('new_information');
    }
}

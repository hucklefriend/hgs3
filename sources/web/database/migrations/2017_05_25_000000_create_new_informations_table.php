<?php
/**
 * 新着情報テーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_informations', function (Blueprint $table) {
            $table->increments('id')->comment('新着情報ID');
            $table->unsignedInteger('text_type')->comment('テキスト種類');
            $table->unsignedInteger('user_id')->default(0)->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->default(0)->comment('ゲームソフトID');
            $table->unsignedInteger('site_id')->default(0)->comment('サイトID');
            $table->unsignedInteger('review_id')->default(0)->comment('レビューID');
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
        Schema::dropIfExists('new_informations');
    }
}

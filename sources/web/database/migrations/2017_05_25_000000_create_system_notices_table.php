<?php
/**
 * お知らせテーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_notices', function (Blueprint $table) {
            $table->increments('id')->primary()->comment('ID');
            $table->string('title', 200)->comment('タイトル');
            $table->text('message')->comment('内容');
            $table->unsignedTinyInteger('type')->comment('種別');
            $table->dateTime('open_at')->comment('公開日時');
            $table->dateTime('close_at')->default('2100-12-31 23:59:59')->comment('公開終了日時');
            $table->timestamps();
            $table->index(['open_at', 'close_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_notices');
    }
}

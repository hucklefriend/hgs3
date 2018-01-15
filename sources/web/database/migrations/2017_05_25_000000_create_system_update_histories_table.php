<?php
/**
 * システム更新履歴テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_update_histories', function (Blueprint $table) {
            $table->increments('id')->comment('システム更新ID');
            $table->string('title', 200)->comment('タイトル');
            $table->datetime('updated_at')->comment('更新日時');
            $table->text('detail')->comment('詳細');
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
        Schema::dropIfExists('system_update_histories');
    }
}

<?php
/**
 * サイト更新履歴テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_update_histories', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('サイト更新ID');
            $table->unsignedInteger('site_id')->index()->comment('サイトID');
            $table->text('detail')->comment('詳細');
            $table->timestamps();

            $table->index(['site_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_update_histories');
    }
}

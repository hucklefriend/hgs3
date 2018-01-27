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
            $table->unsignedInteger('site_id')->comment('サイトID');
            $table->date('site_updated_at')->comment('サイトの更新日時');
            $table->text('detail')->comment('詳細');
            $table->timestamps();

            $table->unique(['site_id', 'site_updated_at']);
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

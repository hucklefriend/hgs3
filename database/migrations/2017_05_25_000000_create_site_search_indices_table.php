<?php
/**
 * サイトで扱っているゲームの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSearchIndicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_search_indices', function (Blueprint $table) {
            $table->unsignedInteger('site_id')->comment('サイトID');
            $table->unsignedInteger('soft_id')->comment('ゲームソフトID');
            $table->unsignedTinyInteger('open_type')->comment('公開範囲');
            $table->unsignedTinyInteger('main_contents_id')->comment('メインコンテンツ');
            $table->unsignedTinyInteger('gender')->comment('対象性別');
            $table->unsignedTinyInteger('rate')->comment('年齢');
            $table->unsignedBigInteger('updated_timestamp')->comment('更新日時タイムスタンプ');
            $table->timestamps();

            $table->primary(['site_id', 'soft_id']);
            $table->index(['open_type', 'soft_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_search_indices');
    }
}

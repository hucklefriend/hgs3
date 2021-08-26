<?php
/**
 * 新着サイト関連のシステムテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_systems', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary()->comment('ID');
            $table->dateTime('ranking_collect_at')->comment('ランキング集計日時');
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
        Schema::dropIfExists('site_systems');
    }
}

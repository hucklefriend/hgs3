<?php
/**
 * 更新サイトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteUpdateArrivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_update_arrivals', function (Blueprint $table) {
            $table->unsignedInteger('site_id')->primary()->comment('サイトID');
            $table->unsignedBigInteger('updated_timestamp')->index()->comment('更新日時タイムスタンプ');
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
        Schema::dropIfExists('site_update_arrivals');
    }
}

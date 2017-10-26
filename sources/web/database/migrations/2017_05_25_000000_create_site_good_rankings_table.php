<?php
/**
 * いいねランキングテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteGoodRankingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_good_rankings', function (Blueprint $table) {
            $table->unsignedInteger('rank')->comment('順位');
            $table->unsignedInteger('site_id')->primary()->comment('サイトID');
            $table->unsignedInteger('good_num')->comment('いいね数');
            $table->timestamps();
            $table->unique(['rank', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_good_rankings');
    }
}

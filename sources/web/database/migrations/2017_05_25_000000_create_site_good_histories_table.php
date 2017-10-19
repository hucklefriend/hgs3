<?php
/**
 * サイトいいね履歴テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteGoodHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_good_histories', function (Blueprint $table) {
            $table->unsignedInteger('site_id')->comment('サイトID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->dateTime('good_date')->comment('いいねした日時');
            $table->timestamps();
            $table->primary(['site_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}

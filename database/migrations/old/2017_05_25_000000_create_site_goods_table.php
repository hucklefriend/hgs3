<?php
/**
 * サイトいいねログの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_goods', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('site_id')->comment('サイトID');
            $table->timestamps();
            $table->primary(['user_id', 'site_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_goods');
    }
}

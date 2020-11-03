<?php
/**
 * お気に入りサイトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavoriteSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorite_sites', function (Blueprint $table) {
            $table->increments('id')->comment('お気に入りサイトID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('site_id')->index()->comment('サイトID');
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
        Schema::dropIfExists('user_favorite_sites');
    }
}

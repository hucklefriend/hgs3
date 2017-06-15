<?php
/**
 * サイトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('name', 100);
            $table->string('url', 200);
            $table->string('banner_url', 200);
            $table->text('presentation');
            $table->unsignedTinyInteger('rate');
            $table->unsignedTinyInteger('gender');
            $table->unsignedSmallInteger('main_contents_id');
            $table->unsignedTinyInteger('open_type');
            $table->unsignedInteger('in_count');
            $table->unsignedInteger('out_count');
            $table->unsignedInteger('bad_count');
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
        Schema::dropIfExists('sites');
    }
}

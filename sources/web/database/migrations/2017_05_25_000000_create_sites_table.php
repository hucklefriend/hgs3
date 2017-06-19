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
            $table->increments('id')->comment('');
            $table->unsignedInteger('user_id')->index()->comment('');
            $table->string('name', 100)->comment('');
            $table->string('url', 200)->comment('');
            $table->string('banner_url', 200)->comment('');
            $table->text('presentation')->comment('');
            $table->unsignedTinyInteger('rate')->comment('');
            $table->unsignedTinyInteger('gender')->comment('');
            $table->unsignedSmallInteger('main_contents_id')->comment('');
            $table->unsignedTinyInteger('open_type')->comment('');
            $table->unsignedInteger('in_count')->comment('');
            $table->unsignedInteger('out_count')->comment('');
            $table->unsignedInteger('bad_count')->comment('');
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

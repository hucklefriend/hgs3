<?php
/**
 * 仮登録ゲームテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameProvisionalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_provisional_registrations', function (Blueprint $table) {
            $table->increments('id')->comment('仮登録ID');
            $table->integer('user_id')->index()->comment('ユーザーID');
            $table->string('name', 200)->comment('名称');
            $table->string('release_date', 100)->comment('発売日');
            $table->integer('company_id')->comment('ゲーム会社');
            $table->integer('series_id');
            $table->text('platform_list');
            $table->text('other');
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
        Schema::dropIfExists('game_provisional_registrations');
    }
}

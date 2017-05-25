<?php
/**
 * ユーザー仮登録テーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProvisionalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_provisional_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 200)->unique();
            $table->string('token', 50);
            $table->dateTime('limit_date');
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
        Schema::dropIfExists('user_provisional_registrations');
    }
}

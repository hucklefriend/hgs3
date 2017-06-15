<?php
/**
 * ユーザーテーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200)->index();
            $table->unsignedSmallInteger('role')->default(1);
            $table->unsignedTinyInteger('adult')->default(0);
            $table->unsignedInteger('point')->default(0);
            $table->dateTime('last_login_date')->nullable();
            $table->dateTime('sign_up_date')->nullable();
            $table->tinyInteger('hgs12_user')->default(0);
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
        Schema::dropIfExists('users');
    }
}

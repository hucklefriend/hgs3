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
            $table->string('email', 200)->comment('メールアドレス');
            $table->string('token', 50)->comment('トークン');
            $table->dateTime('limit_date')->index()->comment('有効期限');
            $table->timestamps();
            $table->primary('email');
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

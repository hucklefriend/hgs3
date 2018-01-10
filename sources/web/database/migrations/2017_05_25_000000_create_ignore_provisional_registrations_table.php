<?php
/**
 * 仮登録を無視するメールアドレスのテーブル
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgnoreProvisionalRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ignore_provisional_registrations', function (Blueprint $table) {
            $table->string('email_hash', 200)->primary()->comment('メールアドレスのハッシュ');
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
        Schema::dropIfExists('ignore_provisional_registrations');
    }
}

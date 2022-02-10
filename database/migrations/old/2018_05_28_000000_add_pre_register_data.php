<?php
/**
 * 仮登録メール情報にユーザーデータを入れる
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreRegisterData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_provisional_registrations', function (Blueprint $table) {
            $table->text('user_data')->nullable()->comment('ユーザー情報')->after('limit_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

<?php
/**
 * お知らせにトップページ表示期間を入れる
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoticeTopShowDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_notices', function (Blueprint $table) {
            $table->dateTime('top_start_at')->nullable()->comment('トップページ表示開始日')->after('close_at');
            $table->dateTime('top_end_at')->nullable()->comment('トップページ表示終了日')->after('close_at');

            $table->index(['top_start_at', 'top_end_at']);
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

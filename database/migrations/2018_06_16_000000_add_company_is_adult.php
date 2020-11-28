<?php
/**
 * 会社のURLがアダルトサイトか
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIsAdult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_companies', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_adult_url')->default(0)->after('wikipedia')->comment('アダルトサイトフラグ');
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

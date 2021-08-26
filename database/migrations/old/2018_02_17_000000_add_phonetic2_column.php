<?php
/**
 * Hgs2のサイトID列を追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhonetic2Column extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->string('phonetic2')->default('')->comment('よみがな2(ソート用)')->after('phonetic');
        });

        $sql = 'UPDATE game_softs SET phonetic2 = phonetic';
        \Illuminate\Support\Facades\DB::update($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->dropColumn('phonetic2');
        });
    }
}

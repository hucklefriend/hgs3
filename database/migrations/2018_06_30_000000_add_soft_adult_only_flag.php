<?php
/**
 * ソフトがアダルトオンリーかのフラグを用意
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftAdultOnlyFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->unsignedTinyInteger('adult_only_flag')->default(0)->after('first_release_int')->comment('アダルトオンリーか');
            $table->index(['adult_only_flag']);
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

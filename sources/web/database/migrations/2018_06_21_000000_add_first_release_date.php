<?php
/**
 * 最初の発売日
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstReleaseDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->unsignedInteger('first_release_int')->default(0)->index()->after('introduction_from_adult')->comment('最初の発売日');
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

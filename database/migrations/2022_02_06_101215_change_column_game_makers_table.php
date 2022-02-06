<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnGameMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_makers', function (Blueprint $table) {
            $table->dropColumn('wikipedia');
            $table->renameColumn('is_adult_url', 'url_rated_r');
            $table->unsignedSmallInteger('kind')->default(\Hgs3\Enums\Game\Maker\Kind::None->value)->comment('属性')->after('phonetic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_makers', function (Blueprint $table) {
            $table->text('wikipedia')->nullable()->comment('WikipediaのURL');
            $table->renameColumn('url_rated_r', 'is_adult_url');
            $table->dropColumn('kind');
        });
    }
}

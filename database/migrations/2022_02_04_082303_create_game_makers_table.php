<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('game_companies', 'game_makers');

        Schema::table('game_platforms', function (Blueprint $table) {
            $table->renameColumn('company_id', 'maker_id');
        });

        Schema::table('game_packages', function (Blueprint $table) {
            $table->renameColumn('company_id', 'maker_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('game_makers', 'game_companies');
        Schema::table('game_platforms', function (Blueprint $table) {
            $table->renameColumn('maker_id', 'company_id');
        });
        Schema::table('game_packages', function (Blueprint $table) {
            $table->renameColumn('maker_id', 'company_id');
        });
    }
}

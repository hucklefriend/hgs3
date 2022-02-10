<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsIsAdultToRatedR extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_official_sites', function (Blueprint $table) {
            $table->renameColumn('is_adult', 'rated_r');
        });
        Schema::table('game_packages', function (Blueprint $table) {
            $table->renameColumn('is_adult', 'rated_r');
        });
        Schema::table('game_softs', function (Blueprint $table) {
            $table->renameColumn('introduction_from_adult', 'introduction_from_rated_r');
            $table->renameColumn('adult_only_flag', 'r18_only_flag');
        });
        Schema::table('game_platforms', function (Blueprint $table) {
            $table->unsignedTinyInteger('rated_r')->after('acronym')->default(\Hgs3\Enums\RatedR::None->value)->comment('R指定');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_official_sites', function (Blueprint $table) {
            $table->renameColumn('rated_r', 'is_adult');
        });
        Schema::table('game_packages', function (Blueprint $table) {
            $table->renameColumn('rated_r', 'is_adult');
        });
        Schema::table('game_softs', function (Blueprint $table) {
            $table->renameColumn('introduction_from_rated_r', 'introduction_from_adult');
            $table->renameColumn('r18_only_flag', 'adult_only_flag');
        });
        Schema::table('game_platforms', function (Blueprint $table) {
            $table->dropColumn('rated_r');
        });
    }
}

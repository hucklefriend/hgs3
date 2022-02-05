<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPkGamePackageShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->dropPrimary();
        });

        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->id()->first();
            $table->unsignedBigInteger('package_id')->change();
            $table->unsignedBigInteger('shop_id')->change();
            $table->unique(['package_id', 'shop_id'], 'package_shop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('game_package_shops', function (Blueprint $table) {
            $table->dropUnique('package_shop');
            $table->unsignedInteger('package_id')->change();
            $table->unsignedInteger('shop_id')->change();
            $table->primary(['package_id', 'shop_id']);
        });
    }
}

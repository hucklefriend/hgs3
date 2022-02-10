<?php
/**
 * パッケージに略称列を追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackageAcronymColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_packages', function (Blueprint $table) {
            $table->string('acronym', 30)->nullable()->comment('略称')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_packages', function (Blueprint $table) {
            $table->dropColumn('acronym');
        });
    }
}

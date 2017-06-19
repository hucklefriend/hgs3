<?php
/**
 * 日別アクセステーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteDailyAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_daily_accesses', function (Blueprint $table) {
            $table->integer('site_id')->comment('');
            $table->integer('user_id')->comment('');
            $table->integer('date')->comment('');
            $table->integer('in_count')->comment('');
            $table->integer('out_count')->comment('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_daily_accesses');
    }
}

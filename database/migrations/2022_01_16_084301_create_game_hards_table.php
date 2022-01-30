<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameHardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_hards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->comment('名称');
            $table->string('phonetic', 200)->comment('よみがな');
            $table->string('acronym', 10)->comment('略称');
            $table->integer('sort_order')->default(99999999)->comment('表示順');
            $table->unsignedBigInteger('maker_id')->nullable()->comment('メーカーID');
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
        Schema::dropIfExists('game_hards');
    }
}

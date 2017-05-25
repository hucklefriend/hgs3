<?php
/**
 * レビューテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('game_id')->index();
            $table->unsignedInteger('package_id')->index();
            $table->unsignedTinyInteger('fear');
            $table->unsignedTinyInteger('story');
            $table->unsignedTinyInteger('game');
            $table->unsignedTinyInteger('sound');
            $table->unsignedTinyInteger('game');
            $table->unsignedTinyInteger('game');
            $table->unsignedTinyInteger('recommend');
            $table->text('thoughts');
            $table->text('recommendatory');
            $table->integer('sort_order');
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
        Schema::dropIfExists('reviews');
    }
}

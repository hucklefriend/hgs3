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
            $table->increments('id')->comment('');
            $table->unsignedInteger('user_id')->index()->comment('');
            $table->unsignedInteger('game_id')->index()->comment('');
            $table->unsignedInteger('package_id')->index()->comment('');
            $table->unsignedSmallInteger('play_time')->comment('');
            $table->unsignedTinyInteger('fear')->comment('');
            $table->unsignedTinyInteger('story')->comment('');
            $table->unsignedTinyInteger('volume')->comment('');
            $table->unsignedTinyInteger('difficulty')->comment('');
            $table->unsignedTinyInteger('sound')->comment('');
            $table->unsignedTinyInteger('crowded')->comment('');
            $table->unsignedTinyInteger('controllability')->comment('');
            $table->unsignedTinyInteger('recommend')->comment('');
            $table->text('thoughts')->comment('');
            $table->text('recommendatory')->comment('');
            $table->integer('sort_order')->comment('');
            $table->unsignedInteger('like_num')->comment('');
            $table->dateTime('post_date')->comment('');
            $table->unsignedInteger('update_num')->comment('');
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

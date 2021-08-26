<?php
/**
 * レビュータグテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTagsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_tags', function (Blueprint $table) {
            $table->unsignedInteger('review_id')->comment('レビューID');
            $table->unsignedInteger('tag')->comment('タグ');
            $table->tinyInteger('point')->comment('ポイント');
            $table->timestamps();

            $table->primary(['review_id', 'tag', 'point']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_tags');
    }
}

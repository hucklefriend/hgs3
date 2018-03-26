<?php
/**
 * レビュー下書きタグテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewDraftTagsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_draft_tags', function (Blueprint $table) {
            $table->unsignedInteger('soft_id')->comment('ゲームID');
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('tag')->comment('タグ');
            $table->tinyInteger('point')->comment('ポイント');
            $table->timestamps();

            $table->primary(['soft_id', 'user_id', 'tag']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_draft_tags');
    }
}

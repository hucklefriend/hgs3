<?php
/**
 * 不正レビューコメントテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjusticeReviewCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injustice_review_comments', function (Blueprint $table) {
            $table->increments('id')->comment('不正レビュー報告コメントID');
            $table->unsignedInteger('injustice_review_id')->index()->comment('不正レビュー報告ID');
            $table->unsignedInteger('user_id')->nullable()->index()->comment('ユーザーID');
            $table->text('comment')->comment('コメント');
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
        Schema::dropIfExists('injustice_review_comments');
    }
}

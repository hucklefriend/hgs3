<?php
/**
 * レビュー下書きテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewDraftsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('review_drafts');

        Schema::create('review_drafts', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('soft_id')->comment('ゲームソフトID');
            $table->text('package_id')->comment('パッケージID');
            $table->unsignedTinyInteger('fear')->comment('怖さ');
            $table->text('url')->nullable()->comment('URL');
            $table->text('progress')->nullable()->comment('ゲームの進行状態');
            $table->text('good_comment')->nullable()->comment('良い点');
            $table->text('bad_comment')->nullable()->comment('悪い点');
            $table->text('general_comment')->nullable()->comment('総合評価');
            $table->unsignedTinyInteger('is_spoiler')->default(0)->comment('ネタバレ有無');
            $table->timestamps();
            $table->primary(['soft_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_drafts');
    }
}

<?php
/**
 * レビューテーブルの評価項目を修正
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewsFmfm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedInteger('fmfm_num')->default(0)->comment('ふむふむ')->after('post_at');
            $table->unsignedInteger('n_num')->default(0)->comment('んー…')->after('fmfm_num');

            $table->dropColumn(['good_num', 'latest_good_num', 'max_good_num', 'update_num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

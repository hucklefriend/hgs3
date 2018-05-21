<?php
/**
 * レビューテーブルの作成
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
            $table->unsignedInteger('max_fmfm_num')->default(0)->comment('最高ふむふむ数')->after('fmfm_num');
            $table->unsignedInteger('n_num')->default(0)->comment('んー…')->after('max_fmfm_num');
            $table->unsignedInteger('max_n_num')->default(0)->comment('最高んー…数')->after('n_num');

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

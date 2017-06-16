<?php
/**
 * フォローテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follows', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedSmallInteger('category')->default(0)->comment('フォローカテゴリ');
            $table->unsignedInteger('follow_user_id')->comment('フォロー対象ユーザーID');
            $table->timestamps();
            $table->primary(['user_id', 'category', 'follow_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follows');
    }
}

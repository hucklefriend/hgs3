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
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('follow_user_id');
            $table->unsignedTinyInteger('notice')->default(1);
            $table->unsignedTinyInteger('open_flag')->default(1);
            $table->primary(['user_id', 'follow_user_id']);
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
        Schema::dropIfExists('user_follows');
    }
}

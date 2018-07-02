<?php
/**
 * レビューテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id')->comment('メッセージID');
            $table->unsignedInteger('from_user_id')->index()->comment('ユーザーID');
            $table->unsignedInteger('to_user_id')->index()->comment('ユーザーID');
            $table->text('message')->comment('メッセージ');
            $table->unsignedTinyInteger('is_read')->default(0)->comment('既読フラグ');
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
        Schema::dropIfExists('messages');
    }
}

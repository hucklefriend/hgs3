<?php
/**
 * 攻略日記テーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiaryCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_comments', function (Blueprint $table) {
            $table->increments('id')->comment('攻略日記コメントID');
            $table->unsignedInteger('diary_id')->index()->comment('日記ID');
            $table->unsignedInteger('user_id')->index()->comment('ユーザーID');
            $table->text('text')->comment('内容');
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
        Schema::dropIfExists('diary_comments');
    }
}

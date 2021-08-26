<?php
/**
 * 使用済みユーザーIDテーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsedShowIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('used_show_ids', function (Blueprint $table) {
            $table->string('show_id', 100)->unique()->comment('表示用ID');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE `used_show_ids` CHANGE `show_id` `show_id` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL  COMMENT "表示用ID"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

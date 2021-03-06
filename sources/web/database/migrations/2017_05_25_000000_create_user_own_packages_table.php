<?php
/**
 * 所持パッケージテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOwnPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_own_packages', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ユーザーID');
            $table->unsignedInteger('package_id')->index()->comment('パッケージID');
            $table->string('buy_at', 100)->comment('買った日');
            $table->string('clear_at', 100)->comment('クリアした日');
            $table->text('comment')->comment('コメント');
            $table->timestamps();
            $table->primary(['user_id', 'package_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_own_packages');
    }
}

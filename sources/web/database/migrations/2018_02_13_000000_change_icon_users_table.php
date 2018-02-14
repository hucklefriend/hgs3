<?php
/**
 * ユーザーテーブルの作成
 */


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIconUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'icon_border_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('icon_border_type')->default(0)->comment('アイコンのボーダー種別');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'icon_border_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('icon_border_type');
            });
        }
    }
}

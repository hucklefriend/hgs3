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
        if (!Schema::hasColumn('users', 'icon_round_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedTinyInteger('icon_round_type')
                    ->default(\Hgs3\Constants\IconRoundType::NONE)
                    ->comment('アイコンの丸み種別')
                    ->after('icon_file_name');
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
        if (Schema::hasColumn('users', 'icon_round_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('icon_round_type');
            });
        }
    }
}

<?php
/**
 * メッセージにレス元のIDを表示
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessageResId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedInteger('res_id')->nullable()->after('id')->comment('レス元のメッセージID');
            $table->dropIndex(['to_user_id']);
            $table->index(['to_user_id', 'is_read']);
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

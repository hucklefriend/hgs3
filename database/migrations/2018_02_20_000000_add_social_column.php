<?php
/**
 * Hgs2のサイトID列を追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->unsignedTinyInteger('open_flag')->default(0)->comment('公開フラグ')->after('social_site_id');
            $table->string('nickname', 250)->nullable()->comment('ソーシャルサイトのニックネーム')->after('social_site_id');
            $table->string('name', 250)->nullable()->comment('ソーシャルサイトの名前')->after('social_site_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->dropColumn('open_flag');
            $table->dropColumn('nickname');
            $table->dropColumn('name');
        });
    }
}

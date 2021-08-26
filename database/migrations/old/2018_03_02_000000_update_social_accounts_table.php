<?php
/**
 * ソーシャルアカウントテーブルを修正
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_accounts', function (Blueprint $table) {
            $table->text('token')->nullable()->change();
            $table->text('token_secret')->nullable()->change();
            $table->text('url')->nullable()->comment('プロフィールURL');
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

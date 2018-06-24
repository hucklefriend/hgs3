<?php
/**
 * サイトの更新履歴の最終設定を
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteLatestUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->date('latest_update_history_date')->nullable()->after('open_type')->comment('直近の更新履歴日時');
            $table->text('latest_update_history')->default('')->after('latest_update_history_date')->comment('直近の更新履歴');
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

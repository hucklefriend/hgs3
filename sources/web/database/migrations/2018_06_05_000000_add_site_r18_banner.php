<?php
/**
 * R-18バナーを追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteR18Banner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->unsignedTinyInteger('list_banner_upload_flag_r18')->nullable()->comment('一覧用バナーアップロードフラグ(R-18)');
            $table->string('list_banner_url_r18', 200)->nullable()->comment('一覧用バナーURL(R-18)');
            $table->unsignedTinyInteger('detail_banner_upload_flag_r18')->nullable()->comment('詳細用バナーアップロードフラグ(R-18)');
            $table->string('detail_banner_url_r18', 200)->nullable()->comment('詳細用バナーURL(R-18)');
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

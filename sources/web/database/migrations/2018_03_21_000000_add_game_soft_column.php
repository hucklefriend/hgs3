<?php
/**
 * ゲームソフトテーブルに列を追加
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGameSoftColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_softs', function (Blueprint $table) {
            $table->text('introduction')->default('')->comment('説明文')->after('original_package_id');
            $table->text('introduction_url')->default('')->comment('説明文引用元URL')->after('introduction');
            $table->text('introduction_csite_title')->default('')->comment('説明文引用元のcsite表示のタイトル')->after('introduction_url');
            $table->text('introduction_site_name')->default('')->comment('説明文引用元のサイト名')->after('introduction_csite_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_softs');
    }
}

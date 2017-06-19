<?php
/**
 * お気に入りサイトテーブルの作成
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFavoriteSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favorite_sites', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('');
            $table->unsignedInteger('package_id')->comment('');
            $table->unsignedTinyInteger('open_type')->default(0)->comment('');
            $table->timestamps();
            $table->primary(['user_id', 'package_id']);
            $table->index(['package_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_favorite_sites');
    }
}

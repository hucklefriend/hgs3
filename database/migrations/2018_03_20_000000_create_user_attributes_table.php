<?php
/**
 * ユーザー属性
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attributes', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->comment('ソフトID');
            $table->unsignedTinyInteger('attribute')->comment('属性');
            $table->timestamps();
            $table->primary(['user_id', 'attribute']);
            $table->index(['attribute', 'user_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_attributes');
    }
}

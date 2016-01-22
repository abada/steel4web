<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObraUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obra_user', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('obra_id')->unsigned();
            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');           

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obra_user', function (Blueprint $table)
        {
            $table->dropForeign('obra_user_obra_id_foreign');
            $table->dropForeign('obra_user_user_id_foreign');
        });
        Schema::drop('obra_user');
    }
}

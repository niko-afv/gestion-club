<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActualizarTablaUsers3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('member_id')->unsigned()->nullable();
            $table->text('avatar')->after('password')->nullable();
            $table->longText('resume')->after('password')->nullable();
            $table->foreign('member_id')->references('id')->on('miembros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('resume');
            $table->dropForeign('users_member_id_miembros');
            $table->dropColumn('member_id');
        });
    }
}

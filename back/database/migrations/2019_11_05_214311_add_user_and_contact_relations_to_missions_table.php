<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserAndContactRelationsToMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->nullable()->after('address_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->integer('contact_id')->unsigned()->nullable()->after('user_id');
            $table->foreign('contact_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropForeign('missions_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropForeign('missions_contact_id_foreign');
            $table->dropColumn('contact_id');
        });
    }
}

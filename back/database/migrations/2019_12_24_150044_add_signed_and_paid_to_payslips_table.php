<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignedAndPaidToPayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->boolean('signed')->default(false)->after('user_id');
            $table->boolean('paid')->default(false)->after('signed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn(['signed', 'paid']);
        });
    }
}

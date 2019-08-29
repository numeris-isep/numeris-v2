<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSocialContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_contributions', function (Blueprint $table) {
            $table->decimal('student_rate', 10, 4)->change();
            $table->decimal('employer_rate', 10, 4)->change();
            $table->decimal('base', 10, 4)->change();
        });

        Schema::table('social_contributions', function (Blueprint $table) {
            $table->renameColumn('base', 'base_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_contributions', function (Blueprint $table) {
            $table->renameColumn('base_rate', 'base');
        });

        Schema::table('social_contributions', function (Blueprint $table) {
            $table->decimal('student_rate', 10, 2)->change();
            $table->decimal('employer_rate', 10, 2)->change();
            $table->decimal('base', 10, 2)->change();
        });
    }
}

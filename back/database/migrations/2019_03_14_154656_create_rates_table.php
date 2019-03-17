<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('convention_id')->unsigned()->nullable();
            $table->foreign('convention_id')->references('id')->on('conventions')->onDelete('set null');

            $table->string('name');
            $table->boolean('is_flat');
            $table->decimal('hours', 10, 1)->nullable();
            $table->decimal('for_student', 10, 2);
            $table->decimal('for_staff', 10, 2);
            $table->decimal('for_client', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
}

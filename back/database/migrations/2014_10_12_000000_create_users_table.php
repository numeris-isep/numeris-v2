<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('activated')->default(false);
            $table->boolean('tou_accepted')->default(false);
            $table->string('subscription_paid_at')->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->string('username')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('student_number')->nullable();
            $table->string('promotion')->nullable();
            $table->string('phone')->nullable();

            $table->string('nationality')->nullable();

            $table->dateTime('birth_date')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('social_insurance_number')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

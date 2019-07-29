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
            $table->timestamp('subscription_paid_at')->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('promotion');
            $table->timestamp('birth_date')->nullable();

            $table->string('phone')->nullable();
            $table->string('nationality')->nullable();
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

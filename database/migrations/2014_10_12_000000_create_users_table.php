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
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('status')->default(10)->unsigned();
            $table->boolean('is_confirmed')->default(false);
            $table->boolean('is_subscribed')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->integer('subscription_plan')->default(0);
            $table->string('affiliate_code')->unique();
            $table->string('confirmation_token', 25)->nullable();
            $table->string('password');
            $table->rememberToken();
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

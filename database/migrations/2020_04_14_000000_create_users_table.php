<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('salutation', 45)->nullable()->default(null);
            $table->date('birthday')->nullable()->default(null);
            $table->tinyInteger('gender')->nullable()->default(null);
            $table->tinyInteger('active')->default(0);
            $table->rememberToken();
            $table->nullableTimestamps();

            $table->unique(["email"], 'unique_users');

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

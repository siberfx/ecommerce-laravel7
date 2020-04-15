<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->string('name', 100)->nullable()->default(null);
            $table->string('address1', 255)->nullable()->default(null);
            $table->string('address2', 255)->nullable()->default(null);
            $table->string('county', 255)->nullable()->default(null);
            $table->string('city', 255)->nullable()->default(null);
            $table->string('postal_code', 50)->nullable()->default(null);
            $table->string('phone', 50)->nullable()->default(null);
            $table->string('mobile_phone', 50)->nullable()->default(null);
            $table->mediumText('comment')->nullable()->default(null);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}

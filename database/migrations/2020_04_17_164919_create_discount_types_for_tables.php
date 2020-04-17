<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTypesForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('specific_price_discount_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->nullableTimestamps();
        });

        Schema::create('cart_rule_discount_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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

        Schema::dropIfExists('specific_price_discount_types');
        Schema::dropIfExists('cart_rule_discount_types');
    }
}

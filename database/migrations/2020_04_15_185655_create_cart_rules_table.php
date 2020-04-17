<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 100);
            $table->unsignedSmallInteger('priority');
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->boolean('status')->default(0);
            $table->boolean('highlight')->default(0);
            $table->bigInteger('minimum_amount')->nullable()->default(0);
            $table->boolean('free_delivery')->default(0);
            $table->bigInteger('total_available')->nullable();
            $table->bigInteger('total_available_each_user')->nullable();
            $table->string('promo_label', 255)->nullable();
            $table->string('promo_text', 1000)->nullable();
            $table->bigInteger('multiply_gift')->nullable()->default(1);
            $table->bigInteger('min_nr_products')->nullable()->default(0);
            $table->bigInteger('discount_type');
            $table->decimal('reduction_amount', 13, 2)->nullable()->default(0);
            $table->bigInteger('reduction_currency_id')->unsigned()->nullable();
            $table->bigInteger('minimum_amount_currency_id')->unsigned()->nullable();
            $table->bigInteger('gift_product_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();

            // Foreign keys
            $table->foreign('customer_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('gift_product_id')
                ->references('id')->on('products')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('reduction_currency_id')
                ->references('id')->on('currencies')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('minimum_amount_currency_id')
                ->references('id')->on('currencies')
                ->onDelete('no action')
                ->onUpdate('no action');

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
        Schema::dropIfExists('cart_rules');
    }
}

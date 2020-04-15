<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('carrier_id');
            $table->unsignedBigInteger('shipping_address_id')->nullable()->default(null);
            $table->unsignedBigInteger('billing_address_id')->nullable()->default(null);
            $table->unsignedBigInteger('billing_company_id')->nullable()->default(null);
            $table->unsignedBigInteger('currency_id');
            $table->mediumText('comment')->nullable()->default(null);
            $table->string('shipping_no', 50)->nullable()->default(null);
            $table->string('invoice_no', 50)->nullable()->default(null);
            $table->dateTime('invoice_date')->nullable()->default(null);
            $table->dateTime('delivery_date')->nullable()->default(null);
            $table->decimal('total_discount', 13, 2)->nullable()->default(null);
            $table->decimal('total_discount_tax', 13, 2)->nullable()->default(null);
            $table->decimal('total_shipping', 13, 2)->nullable()->default(null);
            $table->decimal('total_shipping_tax', 13, 2)->nullable()->default(null);
            $table->decimal('total', 13, 2)->nullable()->default(null);
            $table->decimal('total_tax', 13, 2)->nullable()->default(null);
            $table->timestamps();


            $table->foreign('carrier_id')
                ->references('id')->on('carriers')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('currency_id')
                ->references('id')->on('currencies')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('status_id')
                ->references('id')->on('order_statuses')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

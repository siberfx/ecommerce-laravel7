<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specific_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('reduction', 13, 2)->nullable()->default(0);
            $table->enum('discount_type', ['Amount', 'Percent']);
            $table->dateTime('start_date');
            $table->dateTime('expiration_date');
            $table->unsignedBigInteger('product_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specific_prices');
    }
}

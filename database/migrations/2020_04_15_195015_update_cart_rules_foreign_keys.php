<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCartRulesForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('cart_rules_customers', function (Blueprint $table) {

            $table->foreign('cart_rule_id')
                ->references('id')->on('cart_rules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('customer_id')
                ->references('id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('cart_rules_categories', function (Blueprint $table) {

            $table->foreign('cart_rule_id')
                ->references('id')->on('cart_rules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('cart_rules_products', function (Blueprint $table) {

            $table->foreign('cart_rule_id')
                ->references('id')->on('cart_rules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('no action')
                ->onUpdate('no action');
        });


        Schema::table('cart_rules_product_groups', function (Blueprint $table) {

            $table->foreign('cart_rule_id')
                ->references('id')->on('cart_rules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('product_group_id')
                ->references('id')->on('product_groups')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('cart_rules_combinations', function (Blueprint $table) {

            $table->foreign('cart_rule_id_1')
                ->references('id')->on('cart_rules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('cart_rule_id_2')
                ->references('id')->on('cart_rules')
                ->onDelete('no action')
                ->onUpdate('no action');
        });


        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use App\Models\CartRuleDiscountType;
use Illuminate\Database\Seeder;

class CartRuleDiscountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Percent - order'],
            ['name' => 'Percent - selected products'],
            ['name' => 'Percent - cheapest product'],
            ['name' => 'Percent - most expensive product'],
            ['name' => 'Amount - order'],

        ];

        if (CartRuleDiscountType::count() == 0 ) {
            foreach ($data as $single) {
                CartRuleDiscountType::create($single);
            }
        }
    }
}

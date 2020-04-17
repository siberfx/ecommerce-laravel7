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
            'Percent - order',
            'Percent - selected products',
            'Percent - cheapest product',
            'Percent - most expensive product', 'Amount - order'

        ];

        if (CartRuleDiscountType::count() == 0 ) {
            foreach ($data as $single) {
                CartRuleDiscountType::create($single);
            }
        }
    }
}

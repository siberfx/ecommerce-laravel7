<?php

use App\Models\SpecificPriceDiscountType;
use Illuminate\Database\Seeder;

class SpecificPriceDiscountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =  [
            'Amount',
            'Percent'
        ];

        if (SpecificPriceDiscountType::count() == 0 ) {
            foreach ($data as $single) {
                SpecificPriceDiscountType::create($single);
            }
        }
    }
}

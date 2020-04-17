<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SpecificPriceDiscountType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecificPriceDiscountType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SpecificPriceDiscountType extends Model
{

    protected $table = 'specific_price_discount_types';

    protected $guarded = [];
}

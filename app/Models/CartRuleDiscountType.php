<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CartRuleDiscountType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CartRuleDiscountType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CartRuleDiscountType extends Model
{
    protected $table = 'cart_rule_discount_types';

    protected $guarded = [];
}

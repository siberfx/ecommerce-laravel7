<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\SpecificPrice
 *
 * @property int $id
 * @property float|null $reduction
 * @property string $discount_type
 * @property string $start_date
 * @property string $expiration_date
 * @property int|null $product_id
 * @property-read Product $product
 * @method static Builder|SpecificPrice newModelQuery()
 * @method static Builder|SpecificPrice newQuery()
 * @method static Builder|SpecificPrice query()
 * @method static Builder|SpecificPrice whereDiscountType($value)
 * @method static Builder|SpecificPrice whereExpirationDate($value)
 * @method static Builder|SpecificPrice whereId($value)
 * @method static Builder|SpecificPrice whereProductId($value)
 * @method static Builder|SpecificPrice whereReduction($value)
 * @method static Builder|SpecificPrice whereStartDate($value)
 * @mixin Eloquent
 */
class SpecificPrice extends Model
{
    use CrudTrait;

    protected $table = 'specific_prices';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'reduction',
        'start_date',
        'expiration_date',
        'product_id',
        'currency_id',
        'discount_type'
    ];

    /**
     * @return mixed|string
     */
    public function getReduction()
    {
        $reduction = $this->reduction;

        if(isset($reduction)){
            if($this->discount_type=='Percent') {
                return $reduction . ' %';
            }
            return $reduction;
        }
        return '-';
    }

    /**
     * @return string
     */
    public function getOldPrice()
    {
        $product = Product::find($this->product_id);
        if(isset($product)) {
            return number_format($product->price . $product->currency, 2);
        }
        return '-';
    }

    /**
     * @return string
     */
    public function getReducedPrice()
    {
        $product = Product::find($this->product_id);

        if(isset($product)) {
            $oldPrice = $product->price;
            if($this->discount_type == 'Percent'){
                return number_format($oldPrice - $this->reduction/100 * $oldPrice, 2);
            }
            if($this->discount_type == 'Amount'){
                return number_format($oldPrice - $this->reduction, 2);
            }
            return number_format($product->price, 2);
        }
        return '-';
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        $product = Product::find($this->product_id);
        if(isset($product)) {
            return $product->name;
        }
        return "-";
    }

    /**
     * @return HasOne
     */
    public function product() {
        return $this->hasOne(Product::class);
    }

}

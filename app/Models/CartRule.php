<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\CartRule
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $priority
 * @property string $start_date
 * @property string $expiration_date
 * @property int $status
 * @property int $highlight
 * @property int|null $minimum_amount
 * @property int $free_delivery
 * @property int|null $total_available
 * @property int|null $total_available_each_user
 * @property string|null $promo_label
 * @property string|null $promo_text
 * @property int|null $multiply_gift
 * @property int|null $min_nr_products
 * @property string $discount_type
 * @property float|null $reduction_amount
 * @property int|null $reduction_currency_id
 * @property int|null $minimum_amount_currency_id
 * @property int|null $gift_product_id
 * @property int|null $customer_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|CartRule[] $compatibleCartRules
 * @property-read int|null $compatible_cart_rules_count
 * @property-read User $customer
 * @property-read Collection|User[] $customers
 * @property-read int|null $customers_count
 * @property-read Product $gift
 * @property-read Currency $minimumAmountCurrency
 * @property-read Collection|ProductGroup[] $productGroups
 * @property-read int|null $product_groups_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read Currency $reductionCurrency
 * @method static Builder|CartRule newModelQuery()
 * @method static Builder|CartRule newQuery()
 * @method static Builder|CartRule query()
 * @method static Builder|CartRule whereCode($value)
 * @method static Builder|CartRule whereCreatedAt($value)
 * @method static Builder|CartRule whereCustomerId($value)
 * @method static Builder|CartRule whereDiscountType($value)
 * @method static Builder|CartRule whereExpirationDate($value)
 * @method static Builder|CartRule whereFreeDelivery($value)
 * @method static Builder|CartRule whereGiftProductId($value)
 * @method static Builder|CartRule whereHighlight($value)
 * @method static Builder|CartRule whereId($value)
 * @method static Builder|CartRule whereMinNrProducts($value)
 * @method static Builder|CartRule whereMinimumAmount($value)
 * @method static Builder|CartRule whereMinimumAmountCurrencyId($value)
 * @method static Builder|CartRule whereMultiplyGift($value)
 * @method static Builder|CartRule whereName($value)
 * @method static Builder|CartRule wherePriority($value)
 * @method static Builder|CartRule wherePromoLabel($value)
 * @method static Builder|CartRule wherePromoText($value)
 * @method static Builder|CartRule whereReductionAmount($value)
 * @method static Builder|CartRule whereReductionCurrencyId($value)
 * @method static Builder|CartRule whereStartDate($value)
 * @method static Builder|CartRule whereStatus($value)
 * @method static Builder|CartRule whereTotalAvailable($value)
 * @method static Builder|CartRule whereTotalAvailableEachUser($value)
 * @method static Builder|CartRule whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CartRule extends Model
{
    use CrudTrait;

    protected $table = 'cart_rules';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'code',
        'priority',
        'start_date',
        'expiration_date',
        'status',
        'highlight',
        'minimum_amount',
        'total_available',
        'total_available_each_user',
        'promo_label',
        'promo_text',
        'multiply_gift',
        'min_nr_products',
        'discount_type',
        'reduction_amount',
        'reduction_currency_id',
        'minimum_amount_currency_id',
        'gift_product_id',
        'customer_id',
        'free_delivery',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->compatibleCartRules()->detach();
            $model->products()->detach();
            $model->categories()->detach();
            $model->productGroups()->detach();
            $model->customers()->detach();
        });

    }

    /**
     * @return HasOne
     */
    public function customer()
    {
        return $this->hasOne(User::class);
    }

    /**
     * @return HasOne
     */
    public function gift()
    {
        return $this->hasOne(Product::class);
    }

    /**
     * @return HasOne
     */
    public function reductionCurrency()
    {
        return $this->hasOne(Currency::class);
    }

    /**
     * @return HasOne
     */
    public function minimumAmountCurrency()
    {
        return $this->hasOne(Currency::class);
    }

    /**
     * @return BelongsToMany
     */
    public function compatibleCartRules()
    {
        return $this->belongsToMany(CartRule::class, 'cart_rules_combinations', 'cart_rule_id_1', 'cart_rule_id_2');
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_rules_products', 'cart_rule_id', 'product_id');
    }

    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cart_rules_categories', 'cart_rule_id', 'category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function productGroups()
    {
        return $this->belongsToMany(ProductGroup::class, 'cart_rules_product_groups', 'cart_rule_id', 'product_group_id');
    }

    /**
     * @return BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(User::class, 'cart_rules_customers', 'cart_rule_id', 'customer_id');
    }

}

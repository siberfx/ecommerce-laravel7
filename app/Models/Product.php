<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Storage;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $group_id
 * @property int $attribute_set_id
 * @property string|null $name
 * @property string|null $description
 * @property int $tax_id
 * @property float|null $price
 * @property string $sku
 * @property int|null $stock
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @property-read Collection|CartRule[] $cartRules
 * @property-read int|null $cart_rules_count
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read ProductGroup $group
 * @property-read Collection|ProductImage[] $images
 * @property-read int|null $images_count
 * @property-read SpecificPrice $specificPrice
 * @property-read Tax $tax
 * @method static Builder|Product active()
 * @method static Builder|Product loadCloneRelations()
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereActive($value)
 * @method static Builder|Product whereAttributeSetId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereGroupId($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereStock($value)
 * @method static Builder|Product whereTaxId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends Model
{
    use CrudTrait;

    protected $table = 'products';

    protected $fillable = [
    	'group_id',
    	'attribute_set_id',
    	'name',
    	'description',
    	'price',
    	'tax_id',
    	'sku',
    	'stock',
    	'active',
    	'created_at',
    	'updated_at'
	];


	protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->categories()->detach();
            $model->attributes()->detach();

            // Delete product images
            $disk = 'products';

            foreach ($model->images as $image) {
                // Delete image from disk
                if (Storage::disk($disk)->has($image->name)) {
                    Storage::disk($disk)->delete($image->name);
                }

                // Delete image from db
                $image->delete();
            }
        });
    }


    /**
     * @return BelongsToMany
     */
	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

    /**
     * @return BelongsToMany
     */
	public function attributes()
	{
		return $this->belongsToMany(Attribute::class, 'attribute_product_value', 'product_id', 'attribute_id')->withPivot('value');
	}

    /**
     * @return HasOne
     */
	public function tax()
	{
		return $this->hasOne(Tax::class);
	}

    /**
     * @return HasMany
     */
	public function images()
	{
		return $this->hasMany(ProductImage::class)->orderBy('order', 'ASC');
	}

    /**
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    /**
     * @return BelongsToMany
     */
    public function cartRules()
    {
        return $this->belongsToMany(CartRule::class);
    }

    /**
     * @return BelongsTo
     */
    public function specificPrice()
    {
        return $this->belongsTo(SpecificPrice::class);
    }

    /**
     * @param $query
     */
    public function scopeLoadCloneRelations($query)
    {
        $query->with('categories', 'attributes', 'images');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}

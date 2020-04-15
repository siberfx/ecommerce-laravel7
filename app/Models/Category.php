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

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $name
 * @property string|null $slug
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property-read Collection|CartRule[] $cartRules
 * @property-read int|null $cart_rules_count
 * @property-read Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereDepth($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereLft($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereRgt($value)
 * @method static Builder|Category whereSlug($value)
 * @mixin Eloquent
 */
class Category extends Model
{
    use CrudTrait;

    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
    	'parent_id',
    	'name',
    	'slug',
    	'lft',
    	'rgt',
    	'depth'
	];

    /**
     * @return BelongsTo
     */
	public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    /**
     * @return BelongsToMany
     */
    public function cartRules()
    {
        return $this->belongsToMany('App\Models\CartRule');
    }

}

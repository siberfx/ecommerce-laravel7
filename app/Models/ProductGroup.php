<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductGroup
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|CartRule[] $cartRules
 * @property-read int|null $cart_rules_count
 * @method static Builder|ProductGroup newModelQuery()
 * @method static Builder|ProductGroup newQuery()
 * @method static Builder|ProductGroup query()
 * @method static Builder|ProductGroup whereCreatedAt($value)
 * @method static Builder|ProductGroup whereId($value)
 * @method static Builder|ProductGroup whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductGroup extends Model
{
    use CrudTrait;

    protected $table = 'product_groups';

    /**
     * @return BelongsToMany
     */
    public function cartRules()
    {
        return $this->belongsToMany(CartRule::class);
    }

}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\AttributeSet
 *
 * @property int $id
 * @property string|null $name
 * @property-read Collection|Attribute[] $attributes
 * @property-read int|null $attributes_count
 * @method static Builder|AttributeSet newModelQuery()
 * @method static Builder|AttributeSet newQuery()
 * @method static Builder|AttributeSet query()
 * @method static Builder|AttributeSet whereId($value)
 * @method static Builder|AttributeSet whereName($value)
 * @mixin Eloquent
 */
class AttributeSet extends Model
{
    use CrudTrait;

    protected $table = 'attribute_sets';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

	protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->attributes()->detach();
        });
    }

    /**
     * @return BelongsToMany
     */
	public function attributes() {
    	return $this->belongsToMany(Attribute::class, 'attribute_attribute_set', 'attribute_set_id', 'attribute_id');
	}

}

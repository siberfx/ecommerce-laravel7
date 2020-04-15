<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Attribute
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $name
 * @property-read Collection|AttributeSet[] $sets
 * @property-read int|null $sets_count
 * @property-read Collection|AttributeValue[] $values
 * @property-read int|null $values_count
 * @method static Builder|Attribute newModelQuery()
 * @method static Builder|Attribute newQuery()
 * @method static Builder|Attribute query()
 * @method static Builder|Attribute whereId($value)
 * @method static Builder|Attribute whereName($value)
 * @method static Builder|Attribute whereType($value)
 * @mixin Eloquent
 */
class Attribute extends Model
{
    use CrudTrait;

    protected $table = 'attributes';

    public $timestamps = false;

    protected $fillable = [
    	'type',
	 	'name'
 	];


	protected static function boot()
    {
        parent::boot();

    	static::deleting(function($model) {
	        if (count($model->sets) == 0) {
    	        $model->values()->delete();
    		} else {
    			return $model;
    		}
        });
    }

    /**
     * @return HasMany
     */
	public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    /**
     * @return BelongsToMany
     */
    public function sets()
    {
    	return $this->belongsToMany(AttributeSet::class, 'attribute_attribute_set', 'attribute_id', 'attribute_set_id');
    }


}

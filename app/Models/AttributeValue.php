<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * App\Models\AttributeValue
 *
 * @property int $id
 * @property int $attribute_id
 * @property string|null $value
 * @method static Builder|AttributeValue newModelQuery()
 * @method static Builder|AttributeValue newQuery()
 * @method static Builder|AttributeValue query()
 * @method static Builder|AttributeValue whereAttributeId($value)
 * @method static Builder|AttributeValue whereId($value)
 * @method static Builder|AttributeValue whereValue($value)
 * @mixin Eloquent
 */
class AttributeValue extends Model
{
    use CrudTrait;

    protected $table = 'attribute_values';

    public $timestamps = false;

    protected $fillable = [
    	'attribute_id',
    	'value'
	];

}

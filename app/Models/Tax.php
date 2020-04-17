<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Tax
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $value
 * @method static Builder|Tax newModelQuery()
 * @method static Builder|Tax newQuery()
 * @method static Builder|Tax query()
 * @method static Builder|Tax whereId($value)
 * @method static Builder|Tax whereName($value)
 * @method static Builder|Tax whereValue($value)
 * @mixin Eloquent
 */
class Tax extends Model
{
    use CrudTrait;

    protected $table = 'taxes';

    public $timestamps = false;

    protected $fillable = [
    	'name',
    	'value'
	];

    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}

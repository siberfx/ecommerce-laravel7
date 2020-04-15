<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string|null $code
 * @property string|null $name
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @mixin Eloquent
 */
class Country extends Model
{
    use CrudTrait;

    protected $table = 'countries';

    public $timestamps = false;

    protected $fillable = [
    	'code',
    	'name'
	];

}

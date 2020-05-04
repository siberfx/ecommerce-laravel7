<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $iso
 * @property string|null $value
 * @property int $default
 * @property-read SpecificPrice $specificPrice
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereDefault($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency whereIso($value)
 * @method static Builder|Currency whereName($value)
 * @method static Builder|Currency whereValue($value)
 * @mixin Eloquent
 */
class Currency extends Model
{
    use CrudTrait;

    protected $table = 'currencies';

    public $timestamps = false;

    protected $fillable = [
    	'iso',
    	'name',
    	'value',
    	'default'
	];

    /**
     * @return string
     */
    public static function getDefaultCurrencyName() {
        $default_currency = Currency::where('default', 1)->first();

        if(isset($default_currency)){
            $default_currency_name = $default_currency->name;
        } else {
            $default_currency_name = '-';
        }

        return $default_currency_name;
    }

    /**
     * @return |null
     */
    public static function getDefaultCurrencyId() {
        $default_currency = Currency::where('default', 1)->first();

        if(isset($default_currency)){
            $default_currency_id = $default_currency->id;
        } else {
            $default_currency_id = NULL;
        }

        return $default_currency_id;
    }


}

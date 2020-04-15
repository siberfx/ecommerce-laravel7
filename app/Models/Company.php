<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $county
 * @property string|null $city
 * @property string|null $tin Tax Identification Number
 * @property string|null $trn Trade Registry Number
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereAddress1($value)
 * @method static Builder|Company whereAddress2($value)
 * @method static Builder|Company whereCity($value)
 * @method static Builder|Company whereCounty($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereTin($value)
 * @method static Builder|Company whereTrn($value)
 * @method static Builder|Company whereUserId($value)
 * @mixin Eloquent
 */
class Company extends Model
{
    use CrudTrait;

    protected $table = 'companies';

    public $timestamps = false;

    protected $fillable = [
    	'user_id',
    	'name',
    	'address1',
    	'address2',
    	'county',
    	'city',
    	'tin',
    	'trn'
	];

}

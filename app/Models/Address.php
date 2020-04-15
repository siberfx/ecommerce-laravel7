<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property int $country_id
 * @property string|null $name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $county
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $mobile_phone
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Country $country
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @method static Builder|Address whereAddress1($value)
 * @method static Builder|Address whereAddress2($value)
 * @method static Builder|Address whereCity($value)
 * @method static Builder|Address whereComment($value)
 * @method static Builder|Address whereCountryId($value)
 * @method static Builder|Address whereCounty($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereMobilePhone($value)
 * @method static Builder|Address whereName($value)
 * @method static Builder|Address wherePhone($value)
 * @method static Builder|Address wherePostalCode($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereUserId($value)
 * @mixin Eloquent
 */
class Address extends Model
{
    use CrudTrait;

    protected $table = 'addresses';

    protected $fillable = [
    	'user_id',
    	'country_id',
    	'name',
    	'address1',
    	'address2',
    	'county',
    	'city',
    	'postal_code',
    	'phone',
    	'mobile_phone',
    	'comment'
	];

    /**
     * @return HasOne
     */
	public function country()
	{
		return $this->hasOne(Country::class, 'id', 'country_id');
	}

}

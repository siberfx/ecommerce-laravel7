<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\OrderStatusHistory
 *
 * @property int $id
 * @property int $order_id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read OrderStatus $status
 * @method static Builder|OrderStatusHistory newModelQuery()
 * @method static Builder|OrderStatusHistory newQuery()
 * @method static Builder|OrderStatusHistory query()
 * @method static Builder|OrderStatusHistory whereCreatedAt($value)
 * @method static Builder|OrderStatusHistory whereId($value)
 * @method static Builder|OrderStatusHistory whereOrderId($value)
 * @method static Builder|OrderStatusHistory whereStatusId($value)
 * @method static Builder|OrderStatusHistory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class OrderStatusHistory extends Model
{
    use CrudTrait;

    protected $table = 'order_status_history';

    protected $fillable = [
    	'order_id',
    	'status_id'
	];

    /**
     * @return HasOne
     */
	public function status()
	{
		return $this->hasOne(OrderStatus::class, 'id', 'status_id');
	}

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y H:i:s');
    }
}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * App\Models\OrderStatus
 *
 * @property int $id
 * @property string|null $name
 * @property int $notification
 * @method static Builder|OrderStatus newModelQuery()
 * @method static Builder|OrderStatus newQuery()
 * @method static Builder|OrderStatus query()
 * @method static Builder|OrderStatus whereId($value)
 * @method static Builder|OrderStatus whereName($value)
 * @method static Builder|OrderStatus whereNotification($value)
 * @mixin Eloquent
 */
class OrderStatus extends Model
{
    use CrudTrait;

    protected $table = 'order_statuses';

    public $timestamps = false;

    protected $fillable = ['name'];

}

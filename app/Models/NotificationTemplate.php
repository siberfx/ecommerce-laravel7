<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * App\Models\NotificationTemplate
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $model
 * @property string|null $body
 * @method static Builder|NotificationTemplate newModelQuery()
 * @method static Builder|NotificationTemplate newQuery()
 * @method static Builder|NotificationTemplate query()
 * @method static Builder|NotificationTemplate whereBody($value)
 * @method static Builder|NotificationTemplate whereId($value)
 * @method static Builder|NotificationTemplate whereModel($value)
 * @method static Builder|NotificationTemplate whereName($value)
 * @method static Builder|NotificationTemplate whereSlug($value)
 * @mixin Eloquent
 */
class NotificationTemplate extends Model
{
    use CrudTrait;

    protected $table = 'notification_templates';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'model',
        'body'
    ];

}

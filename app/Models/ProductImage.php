<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property int $order
 * @method static Builder|ProductImage newModelQuery()
 * @method static Builder|ProductImage newQuery()
 * @method static Builder|ProductImage query()
 * @method static Builder|ProductImage whereId($value)
 * @method static Builder|ProductImage whereName($value)
 * @method static Builder|ProductImage whereOrder($value)
 * @method static Builder|ProductImage whereProductId($value)
 * @mixin Eloquent
 */
class ProductImage extends Model
{
    use CrudTrait;

    protected $table = 'product_images';

    public $timestamps = false;

    protected $fillable = [
    	'product_id',
    	'name',
    	'order'
	];

    /**
     * @param $name
     * @return string
     */
    public function getNameAttribute($name) {
        return substr($this->product_id, 0, 1) . DIRECTORY_SEPARATOR . $this->product_id . DIRECTORY_SEPARATOR . $name;
    }

}

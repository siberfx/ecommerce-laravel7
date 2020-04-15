<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * App\Models\Carrier
 *
 * @property int $id
 * @property string|null $name
 * @property float $price
 * @property string|null $delivery_text
 * @property string|null $logo
 * @method static Builder|Carrier newModelQuery()
 * @method static Builder|Carrier newQuery()
 * @method static Builder|Carrier query()
 * @method static Builder|Carrier whereDeliveryText($value)
 * @method static Builder|Carrier whereId($value)
 * @method static Builder|Carrier whereLogo($value)
 * @method static Builder|Carrier whereName($value)
 * @method static Builder|Carrier wherePrice($value)
 * @mixin Eloquent
 */
class Carrier extends Model
{
    use CrudTrait;

    protected $table = 'carriers';

    public $timestamps = false;

    protected $fillable = [
    	'name',
    	'price',
    	'delivery_text',
    	'logo'
	];

 	public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            Storage::disk('carriers')->delete($obj->logo);
        });
    }

    /**
     * @param $value
     */
	public function setLogoAttribute($value)
    {
        $attribute_name = "logo";
        $disk = "carriers";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            Storage::disk($disk)->delete($this->logo);

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            Storage::disk($disk)->put($filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $filename;
        }
    }

}

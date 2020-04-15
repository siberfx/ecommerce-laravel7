<?php

namespace App\Models;

use App\Mail\NotificationTemplateMail;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Mail;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property int $carrier_id
 * @property int|null $shipping_address_id
 * @property int|null $billing_address_id
 * @property int|null $billing_company_id
 * @property int $currency_id
 * @property string|null $comment
 * @property string|null $shipping_no
 * @property string|null $invoice_no
 * @property string|null $invoice_date
 * @property string|null $delivery_date
 * @property float|null $total_discount
 * @property float|null $total_discount_tax
 * @property float|null $total_shipping
 * @property float|null $total_shipping_tax
 * @property float|null $total
 * @property float|null $total_tax
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Address $billingAddress
 * @property-read Company $billingCompanyInfo
 * @property-read Carrier $carrier
 * @property-read Currency $currency
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read Address $shippingAddress
 * @property-read OrderStatus $status
 * @property-read Collection|OrderStatusHistory[] $statusHistory
 * @property-read int|null $status_history_count
 * @property-read User $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereBillingAddressId($value)
 * @method static Builder|Order whereBillingCompanyId($value)
 * @method static Builder|Order whereCarrierId($value)
 * @method static Builder|Order whereComment($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCurrencyId($value)
 * @method static Builder|Order whereDeliveryDate($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereInvoiceDate($value)
 * @method static Builder|Order whereInvoiceNo($value)
 * @method static Builder|Order whereShippingAddressId($value)
 * @method static Builder|Order whereShippingNo($value)
 * @method static Builder|Order whereStatusId($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereTotalDiscount($value)
 * @method static Builder|Order whereTotalDiscountTax($value)
 * @method static Builder|Order whereTotalShipping($value)
 * @method static Builder|Order whereTotalShippingTax($value)
 * @method static Builder|Order whereTotalTax($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{

    use CrudTrait;

    protected $table = 'orders';

    protected $fillable = [
        'status_id',
        'comment',
        'invoice_date',
        'delivery_date',
        'shipping_address',
        'billing_address',
        'total_discount',
        'total_discount_tax',
        'total_shipping',
        'total_shipping_tax',
        'total',
        'total_tax'
    ];

    public $notificationVars = [
        'userSalutation',
        'userName',
        'userEmail',
        'carrier',
        'total',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS VARIABLES
    |--------------------------------------------------------------------------
    */
    public function notificationVariables()
    {
        return [
            'userSalutation' => $this->user->salutation,
            'userName'       => $this->user->name,
            'userEmail'      => $this->user->email,
            'total'          => $this->total(),
            'carrier'        => $this->carrier()->first()->name,
            'status'         => $this->status->name
        ];
    }


    protected static function boot()
    {
        parent::boot();

        static::updating(function($order) {
            // Send notification when order status was changed
            $oldStatus = $order->getOriginal();
            if ($order->status_id != $oldStatus['status_id'] && $order->status->notification != 0) {
                // example of usage: (be sure that a notification template mail with the slug "example-slug" exists in db)
                return Mail::to($order->user->email)->send(new NotificationTemplateMail($order, "order-status-changed"));
            }
        });
    }

    /**
     * @return mixed
     */
    public function total()
    {
        return decimalFormat($this->products->sum( function ($product) {
                return $product->pivot->price_with_tax * $product->pivot->quantity;
            }, 0) + $this->carrier->price);
    }

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }

    /**
     * @return HasMany
     */
    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'DESC');
    }

    /**
     * @return HasOne
     */
    public function carrier()
    {
        return $this->hasOne(Carrier::class, 'id', 'carrier_id');
    }

    /**
     * @return HasOne
     */
    public function shippingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'shipping_address_id');
    }

    /**
     * @return HasOne
     */
    public function billingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'billing_address_id');
    }

    /**
     * @return HasOne
     */
    public function billingCompanyInfo()
    {
        return $this->hasOne(Company::class, 'id', 'billing_company_id');
    }

    /**
     * @return HasOne
     */
    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }

    /**
     * @return BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['name', 'sku', 'price', 'price_with_tax',  'quantity']);
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

<?php

namespace App\Observers;

use App\Mail\NotificationTemplateMail;
use App\Models\Order;
use Mail;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the order "updated" event.
     *
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        $oldStatus = $order->getOriginal();
        if ($order->status_id != $oldStatus['status_id'] && $order->status->notification != 0) {
            // example of usage: (be sure that a notification template mail with the slug "example-slug" exists in db)
            return Mail::to($order->user->email)->send(new NotificationTemplateMail($order, "order-status-changed"));
        }
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param Order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param Order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}

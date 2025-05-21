<?php

namespace App\Services;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function sendOrderConfirmationEmail(Order $order)
    {
        Mail::to($order->shipping_email)->send(new OrderConfirmation($order));
    }
}

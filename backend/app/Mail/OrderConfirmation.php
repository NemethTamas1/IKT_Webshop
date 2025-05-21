<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $shipping_email;
    public $shipping_name;
    public $shipping_phone;
    public $shipping_country;
    public $shipping_city;
    public $shipping_zip;
    public $shipping_street_name;
    public $shipping_street_type;
    public $shipping_street_number;
    public $shipping_floor;
    public $orderstatus;
    public $totalamount;
    public $totalquantity;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->shipping_email = $order->shipping_email;
        $this->shipping_name = $order->shipping_name;
        $this->shipping_phone = $order->shipping_phone;
        $this->shipping_country = $order->shipping_country;
        $this->shipping_city = $order->shipping_city;
        $this->shipping_zip = $order->shipping_zip;
        $this->shipping_street_name = $order->shipping_street_name;
        $this->shipping_street_type = $order->shipping_street_type;
        $this->shipping_street_number = $order->shipping_street_number;
        $this->shipping_floor = $order->shipping_floor;
        $this->orderstatus = $order->orderstatus;
        $this->totalamount = $order->totalamount;
        $this->totalquantity = $order->totalquantity;
    }

    public function build()
    {
        $htmlContent = view('mail.order-confirmation', [ //ez a template, nem ez a fájl!
            'order' => $this->order, // Ez hiányzott - adjuk át az egész order objektumot
            "shipping_email" => $this->shipping_email,
            "shipping_name" => $this->shipping_name,
            "shipping_phone" => $this->shipping_phone,
            "shipping_country" => $this->shipping_country,
            "shipping_city" => $this->shipping_city,
            "shipping_zip" => $this->shipping_zip,
            "shipping_street_name" => $this->shipping_street_name,
            "shipping_street_type" => $this->shipping_street_type,
            "shipping_street_number" => $this->shipping_street_number,
            "shipping_floor" => $this->shipping_floor,
            "orderstatus" => $this->orderstatus,
            "totalamount" => $this->totalamount,
            "totalquantity" => $this->totalquantity,
        ])->render();
        return $this->subject('Sikeres rendelés leadás - BuzzShop')->html((string)$htmlContent);
    }
    public function attachments(): array
    {
        return [];
    }
}

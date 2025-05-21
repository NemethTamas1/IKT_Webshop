<?php

namespace Database\Seeders;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $quantity = 5;
        $orders = Order::factory()->count($quantity)->create();

        foreach ($orders as $order) {
            $email = $order->shipping_email ?? 'test@example.com';
            Mail::to($email)->send(new OrderConfirmation($order));
        }
        $this->command->info("A rendelések szinkronizációja sikeresen megtörtént!");
        $this->command->info("A rendelésekhez tartozó {$quantity} db tájékoztató e-mail sikeresen elküldve.");
    }
}

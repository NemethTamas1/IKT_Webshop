<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::factory()->count(5)->create();
        // A factory-ben egyszerü, szimpla order-öket gyártok csak le!!! Nincs valid összekötésük!

        $this->command->info("A rendelések szinkronizációja sikeresen megtörtént!");
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            // Ebbe mennek szépen bele, hogy XY multivitaminból rendelt 1-et, fehérjéből 2-t stb. Minden egyes "tétel rész" egy rekord lesz.
            // Az order_id fogja "egybe" majd őket, hogy pontosan melyik rendeléshez tartozik.
            // Mivel a User lesz, aki leadja a rendelést, ezért létrejön majd az:
            //
            // Orders táblában a rendeléshez a rekord 
            // |>> Abból generálódik az Order Items (amikor létrejön az Order. Observer erre nagyon jó pl.) 
            // |>> Arra meg majd reagál a Product Variants (tétel csökkentést idéz elő, szintén observerrel működhet.)
            // |--->>> Magyarán ha jó az elméletem, egymásba építjük az Observereket a végén és automatán generálja majd a:
            // # Készlet Frissítését
            // # Rendelési rekordot
            // # Rendelés részletezőt
            // # Rendelési ellenszámláját.
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->unsignedTinyInteger('ordered_quantity'); // 0-tól 255-ig. Ennél kisebb "lekötést" nem tudtam adni.
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('total_amount');
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

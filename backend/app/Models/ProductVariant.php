<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "product_id",
        "quantity",
        "unit",
        "flavour",
        "stock",
        "available",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
}

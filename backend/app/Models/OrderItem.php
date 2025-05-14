<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
  use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        "order_id",
        "product_variant_id",
        "ordered_quantity",
        "unit_price",
        "total_amount",
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
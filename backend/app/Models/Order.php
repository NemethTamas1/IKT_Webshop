<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = [
        "user_id",
        "shipping_email",
        "shipping_name",
        "shipping_phone",
        "shipping_country",
        "shipping_city",
        "shipping_zip",
        "shipping_street_name",
        "shipping_street_type",
        "shipping_street_number",
        "orderstatus",
        "totalamount",
        "totalquantity",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function oreditems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

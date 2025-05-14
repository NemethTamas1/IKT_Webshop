<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'product_variants';

    protected $fillable = [
        "product_id",
        "quantity",
        "unit",
        "flavour",
        "stock",
        "price",
        "available",
        "image_path",
        "created_at",
        "updated_at",
        "deleted_at",
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

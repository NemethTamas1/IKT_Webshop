<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['id', 'category_id', 'description', 'quantity', 'flavour', 'price', 'created_at', 'updated_at', 'deleted_at'];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function brands(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}

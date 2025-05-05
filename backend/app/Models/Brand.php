<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['id', 'name', 'description', 'created_at', 'updated_at', 'deleted_at'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->withPivot('name', 'description')
            ->withTimestamps();
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

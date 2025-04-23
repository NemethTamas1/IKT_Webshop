<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['id', 'name', 'slug','logo_path', 'description', 'created_at', 'updated_at', 'deleted_at'];

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->withPivot('name', 'description')
            ->withTimestamps();
    }
}

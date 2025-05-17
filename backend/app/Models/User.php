<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        "role",
        "username",
        "name",
        "password",
        "email",
        "phone",
        "country",
        "city",
        "zip",
        "street_name",
        "street_type",
        "street_number",
        "floor",
        "email_verified_at",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $hidden = [
        // 'password', Kezdetben azért lássuk, hogy működik-e.
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

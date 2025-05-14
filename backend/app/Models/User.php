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
        'email',
        'username',
        'password',
        'shipping_country',
        'shipping_city',
        'shipping_zip',
        'shipping_street',
        'shipping_street_number',
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

<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    public function sitterProfile(): HasOne
    {
        return $this->hasOne(SitterProfile::class);
    }
    public function ownerBookings(): HasMany
{
    return $this->hasMany(Booking::class, 'owner_id');
}

public function sitterBookings(): HasMany
{
    return $this->hasMany(Booking::class, 'sitter_id');
}

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
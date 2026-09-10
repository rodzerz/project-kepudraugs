<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'owner_id',
        'sitter_id',
        'pet_type',
        'booking_date',
        'start_time',
        'end_time',
        'message',
        'status',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function sitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}


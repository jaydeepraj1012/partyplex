<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'venue_id',
        'start_time',
        'end_time',
        'guest_count',
        'total_amount',
        'status',
        'special_requests',
        'booking_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that made the booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the venue that was booked
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Get the payment for the booking
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the review for the booking
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the messages for the booking
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Generate a unique booking code
     */
    public static function generateBookingCode(): string
    {
        return 'BK-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
    }
}

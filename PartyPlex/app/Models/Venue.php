<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Venue extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'venue_type_id',
        'name',
        'description',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'latitude',
        'longitude',
        'capacity',
        'price_per_hour',
        'price_per_day',
        'images',
        'featured_image',
        'availability',
        'rules',
        'is_approved',
        'is_featured',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
        'availability' => 'array',
        'rules' => 'array',
        'is_approved' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array<int, string>
     */
    public $translatable = [
        'name',
        'description',
        'rules',
    ];

    /**
     * Get the user that owns the venue
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the venue type
     */
    public function venueType(): BelongsTo
    {
        return $this->belongsTo(VenueType::class);
    }

    /**
     * Get the amenities for the venue
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }

    /**
     * Get the bookings for the venue
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the venue
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Calculate the average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}

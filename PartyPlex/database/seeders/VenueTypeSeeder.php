<?php

namespace Database\Seeders;

use App\Models\VenueType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venueTypes = [
            [
                'name' => 'Farmhouse',
                'description' => 'Spacious farmhouses with outdoor spaces, perfect for large gatherings and events.',
                'icon' => 'fa-house',
            ],
            [
                'name' => 'Banquet Hall',
                'description' => 'Elegant banquet halls for weddings, corporate events, and formal gatherings.',
                'icon' => 'fa-champagne-glasses',
            ],
            [
                'name' => 'Party Hall',
                'description' => 'Versatile party halls suitable for birthdays, anniversaries, and casual celebrations.',
                'icon' => 'fa-cake-candles',
            ],
            [
                'name' => 'Rooftop Venue',
                'description' => 'Scenic rooftop venues offering panoramic views, ideal for cocktail parties and social events.',
                'icon' => 'fa-building',
            ],
            [
                'name' => 'Garden Venue',
                'description' => 'Beautiful garden venues for outdoor events and ceremonies surrounded by nature.',
                'icon' => 'fa-tree',
            ],
            [
                'name' => 'Conference Center',
                'description' => 'Professional conference centers equipped with modern amenities for business meetings and seminars.',
                'icon' => 'fa-briefcase',
            ],
            [
                'name' => 'Beach Venue',
                'description' => 'Stunning beachfront venues for destination weddings and beach parties.',
                'icon' => 'fa-umbrella-beach',
            ],
        ];

        foreach ($venueTypes as $venueType) {
            VenueType::create($venueType);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            [
                'name' => 'Wi-Fi',
                'icon' => 'fa-wifi',
                'description' => 'High-speed wireless internet access',
            ],
            [
                'name' => 'Parking',
                'icon' => 'fa-car',
                'description' => 'On-site parking facilities',
            ],
            [
                'name' => 'Air Conditioning',
                'icon' => 'fa-snowflake',
                'description' => 'Climate control system',
            ],
            [
                'name' => 'Catering',
                'icon' => 'fa-utensils',
                'description' => 'Food and beverage services',
            ],
            [
                'name' => 'Sound System',
                'icon' => 'fa-music',
                'description' => 'Professional audio equipment',
            ],
            [
                'name' => 'Projector',
                'icon' => 'fa-film',
                'description' => 'Projection equipment for presentations',
            ],
            [
                'name' => 'Stage',
                'icon' => 'fa-person-booth',
                'description' => 'Elevated platform for performances',
            ],
            [
                'name' => 'Dance Floor',
                'icon' => 'fa-compact-disc',
                'description' => 'Dedicated area for dancing',
            ],
            [
                'name' => 'Bar',
                'icon' => 'fa-martini-glass',
                'description' => 'Bar service available',
            ],
            [
                'name' => 'Swimming Pool',
                'icon' => 'fa-person-swimming',
                'description' => 'Swimming pool access',
            ],
            [
                'name' => 'Wheelchair Access',
                'icon' => 'fa-wheelchair',
                'description' => 'Accessible facilities for disabled guests',
            ],
            [
                'name' => 'Security',
                'icon' => 'fa-shield',
                'description' => 'Security personnel and systems',
            ],
            [
                'name' => 'Smoking Area',
                'icon' => 'fa-smoking',
                'description' => 'Designated smoking area',
            ],
            [
                'name' => 'Decoration Services',
                'icon' => 'fa-wand-magic-sparkles',
                'description' => 'Event decoration services',
            ],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}

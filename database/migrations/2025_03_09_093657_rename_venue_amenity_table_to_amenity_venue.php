<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('venue_amenity', 'amenity_venue');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('amenity_venue', 'venue_amenity');
    }
};

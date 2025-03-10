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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_type_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('zip_code');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->integer('capacity');
            $table->decimal('price_per_hour', 10, 2);
            $table->decimal('price_per_day', 10, 2)->nullable();
            $table->json('images')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('availability')->nullable();
            $table->json('rules')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};

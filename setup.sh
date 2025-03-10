#!/bin/bash

# PartyPlex Setup Script

echo "Setting up PartyPlex application..."

# Copy environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
    php artisan key:generate
    echo "Environment file created and application key set."
else
    echo "Environment file already exists."
fi

# Install dependencies
echo "Installing PHP dependencies..."
composer install

echo "Installing JavaScript dependencies..."
npm install

# Database setup
echo "Setting up database..."

# Create SQLite database if using SQLite
if grep -q "DB_CONNECTION=sqlite" .env; then
    touch database/database.sqlite
    echo "SQLite database created."
fi

# Run migrations and seeders
echo "Running migrations and seeders..."
php artisan migrate:fresh --seed

# Create storage link
echo "Creating storage link..."
php artisan storage:link

# Build assets
echo "Building frontend assets..."
npm run build

echo "Setup complete! You can now run 'php artisan serve' to start the application." 
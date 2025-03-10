# PartyPlex: Venue Discovery and Booking Platform

PartyPlex is a comprehensive venue-finding website that helps users discover nearby farmhouses, banquet halls, and party venues. The platform offers a seamless experience for both venue owners and customers, with features designed to make the venue booking process efficient and enjoyable.

## Features

### For Customers
- **Location-based Search**: Find venues near you with advanced filtering options
- **Detailed Venue Profiles**: View high-quality images, amenities, pricing, and availability
- **Booking System**: Book venues for specific dates and times
- **Reviews and Ratings**: Read and write reviews for venues
- **Real-time Chat**: Communicate directly with venue owners
- **Secure Payments**: Pay for bookings using multiple payment methods
- **Notifications**: Receive updates about your bookings and messages

### For Venue Owners
- **Venue Management**: Add and manage venue listings with detailed information
- **Booking Management**: Accept, reject, or modify booking requests
- **Calendar Integration**: Manage venue availability
- **Analytics Dashboard**: Track performance and booking statistics
- **Payment Processing**: Receive payments securely
- **Customer Communication**: Chat with potential and current customers

### For Administrators
- **User Management**: Manage users, roles, and permissions
- **Content Moderation**: Review and approve venues and reviews
- **System Configuration**: Configure system settings and parameters
- **Reports and Analytics**: Access comprehensive reports on platform usage

## Technical Features
- **Google Maps Integration**: For location-based search and venue mapping
- **Multi-language Support**: Localized content for global users
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Real-time Notifications**: Using Pusher for instant updates
- **Secure Payment Processing**: Integration with Stripe
- **Role-based Access Control**: Using Spatie Permissions
- **Image Optimization**: Using Intervention Image

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL
- Laravel requirements

### Setup Instructions
1. Clone the repository:
   ```
   git clone https://github.com/yourusername/partyplex.git
   cd partyplex
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Create and configure the environment file:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=partyplex
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Configure Stripe and Pusher in the `.env` file:
   ```
   STRIPE_KEY=your_stripe_key
   STRIPE_SECRET=your_stripe_secret
   
   PUSHER_APP_ID=your_pusher_app_id
   PUSHER_APP_KEY=your_pusher_key
   PUSHER_APP_SECRET=your_pusher_secret
   PUSHER_APP_CLUSTER=your_pusher_cluster
   ```

7. Run migrations and seeders:
   ```
   php artisan migrate --seed
   ```

8. Build assets:
   ```
   npm run build
   ```

9. Start the development server:
   ```
   php artisan serve
   ```

10. Access the application at `http://localhost:8000`

### Default Users
- **Super Admin**: admin@partyplex.com / password
- Regular users and venue owners are created by the seeder

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements
- Laravel Framework
- Spatie Permissions
- Laravel Cashier
- Intervention Image
- Pusher
- And all other open-source packages used in this project

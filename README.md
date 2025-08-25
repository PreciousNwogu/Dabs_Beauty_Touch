# Dab's Beauty Touch

Professional hair braiding and beauty services booking system.

## About

Dab's Beauty Touch is a modern web application for booking hair braiding appointments and beauty services. Our platform provides an easy-to-use interface for customers to schedule appointments and for administrators to manage bookings.

## Features

- **Online Appointment Booking**: Easy-to-use booking system with calendar integration
- **Service Selection**: Choose from various braiding styles and beauty services
- **Admin Dashboard**: Comprehensive management system for appointments
- **Email Notifications**: Automated confirmation and reminder emails
- **Responsive Design**: Works perfectly on desktop and mobile devices
- **Secure**: Built with Laravel's security features

## Services Offered

- Box Braids
- Knotless Braids
- Twist Styles
- Wig Installation
- Hair Styling
- And more...

## Contact

**Phone**: (+1)343-245-8848  
**Email**: infor@dabsbeautytouch

## Technology

Built with Laravel and modern web technologies for a reliable and secure booking experience.

---

© 2025 Dab's Beauty Touch. All rights reserved.

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: React 19 + TypeScript
- **Database**: PostgreSQL (Production) / SQLite (Development)
- **Build Tool**: Vite
- **Styling**: Bootstrap 5

## 🌐 Deployment on Render

### Quick Deploy

1. **Fork/Clone this repository**
2. **Connect to Render**: Go to [render.com](https://render.com) and connect your GitHub repo
3. **Use the render.yaml**: Render will automatically detect the configuration
4. **Add Environment Variables**:
   ```
   APP_KEY=base64:YOUR_KEY_HERE  # Generate with: php artisan key:generate --show
   APP_URL=https://your-app-name.onrender.com
   ```

### Manual Setup

1. **Create Web Service** on Render:
   - Runtime: PHP
   - Build Command: `./render-build.sh`
   - Start Command: `./render-start.sh`

2. **Add PostgreSQL Database**:
   - Render will provide `DATABASE_URL` automatically

3. **Environment Variables**:
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_NAME="Dab's Beauty Touch"
   APP_KEY=base64:YOUR_GENERATED_KEY
   APP_URL=https://your-app-name.onrender.com
   DB_CONNECTION=pgsql
   LOG_LEVEL=error
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   ```

---

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

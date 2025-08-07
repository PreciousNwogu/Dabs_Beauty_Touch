# Dab's Beauty Touch - Laravel + React Application

A professional hair braiding booking system built with Laravel 12 and React 19.

## 🚀 Features

- **Appointment Booking System**: Complete booking management with calendar integration
- **File Upload**: Sample picture uploads for consultations  
- **Admin Dashboard**: Manage appointments and services
- **Responsive Design**: Mobile-first design with Bootstrap
- **Real-time Availability**: Calendar showing available time slots

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

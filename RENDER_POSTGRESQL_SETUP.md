# PostgreSQL Environment Variables for Render

## Add these to your Render Web Service Environment Variables:

### Database Configuration
```
DB_CONNECTION=pgsql
DATABASE_URL=[This will be auto-provided by Render when you connect the services]
```

### Alternative Manual Configuration (if DATABASE_URL doesn't work)
```
DB_HOST=[PostgreSQL service internal hostname from Render]
DB_PORT=5432
DB_DATABASE=dabs_beauty_touch
DB_USERNAME=[username from PostgreSQL service]
DB_PASSWORD=[password from PostgreSQL service]
```

### Complete Environment Variables List for Production:
```
APP_NAME="Dab's Beauty Touch"
APP_ENV=production
APP_DEBUG=false
APP_KEY=[YOUR_APP_KEY_FROM_LOCAL_ENV]
APP_URL=https://dabs-beauty-touch.onrender.com

DB_CONNECTION=pgsql
DATABASE_URL=[AUTO-PROVIDED-BY-RENDER]

SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error

MAIL_MAILER=smtp
MAIL_HOST=smtp.zohocloud.ca
MAIL_PORT=465
MAIL_USERNAME=info@dabsbeautytouch.com
MAIL_PASSWORD=[YOUR_EMAIL_PASSWORD]
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@dabsbeautytouch.com
MAIL_FROM_NAME="Dab's Beauty Touch"
ADMIN_EMAIL=info@dabsbeautytouch.com
BOOKING_NOTIFICATION_EMAIL=info@dabsbeautytouch.com
```

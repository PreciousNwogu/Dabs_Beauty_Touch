# ESSENTIAL Environment Variables for Render Dashboard

## Copy and paste these into your Render service Environment tab:

### Core Laravel Settings (REQUIRED)
```
APP_NAME="Dab's Beauty Touch"
APP_ENV=production
APP_DEBUG=false
APP_KEY=[YOUR_APP_KEY_FROM_LOCAL_ENV]
APP_URL=https://dabs-beauty-touch.onrender.com
```

### Database (Start with SQLite - Simple)
```
DB_CONNECTION=sqlite
```

### Session & Cache (File-based for simplicity)
```
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_LEVEL=error
```

### Email Configuration
```
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

## Step-by-Step Fix Process:

### Step 1: Add Environment Variables
1. Go to Render dashboard
2. Select your service
3. Go to "Environment" tab  
4. Add ALL variables above
5. Click "Save Changes"

### Step 2: Force Redeploy
1. Go to "Manual Deploy" tab
2. Click "Deploy Latest Commit"
3. Wait for deployment to complete

### Step 3: Check Logs Again
1. Go to "Logs" tab
2. Look for any remaining errors
3. The logs will show you exactly what's wrong

## Common Error Messages and Fixes:

### "Class 'PDO' not found"
- Database extension missing (should be handled by Dockerfile)

### "storage/logs/laravel.log could not be opened"
- Permission issue (should be handled by startup script)

### "Route [login] not defined"
- Missing routes or auth middleware issue

### "SQLSTATE[HY000]: General error: 14 unable to open database file"
- SQLite database path issue

## If SQLite Still Doesn't Work:
Use in-memory database temporarily:
```
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

## Quick Test Commands:
After fixing, you can test these routes:
- `https://dabs-beauty-touch.onrender.com/` - Homepage
- `https://dabs-beauty-touch.onrender.com/test-email` - Email test (if route exists)

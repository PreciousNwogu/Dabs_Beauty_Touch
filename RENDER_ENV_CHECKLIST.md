# Render Environment Variables Checklist

## Required Environment Variables for Render Dashboard

### Essential Laravel Configuration
```
APP_NAME="Dab's Beauty Touch"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:WfGr1b95qvy90XxIn/q9UqiPlDPpHc/awFdE4gFj0Io=
APP_URL=https://dabs-beauty-touch.onrender.com
```

### Database Configuration
```
DB_CONNECTION=sqlite
# OR for PostgreSQL:
# DB_CONNECTION=pgsql
# DATABASE_URL will be auto-provided by Render if you add PostgreSQL
```

### Session & Cache
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
MAIL_PASSWORD=m3db0fL9LSJ9
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@dabsbeautytouch.com
MAIL_FROM_NAME="Dab's Beauty Touch"
ADMIN_EMAIL=info@dabsbeautytouch.com
BOOKING_NOTIFICATION_EMAIL=info@dabsbeautytouch.com
```

## Steps to Fix Server Error:

1. **Go to Render Dashboard**
   - Navigate to your service
   - Go to Environment tab
   - Add ALL variables above

2. **Check Logs**
   - Go to Logs tab
   - Look for specific error messages

3. **Force Redeploy**
   - After adding environment variables
   - Go to Manual Deploy tab
   - Click "Deploy Latest Commit"

## Common Error Messages and Solutions:

### "No application encryption key has been specified"
- Missing APP_KEY environment variable
- Add: `APP_KEY=base64:WfGr1b95qvy90XxIn/q9UqiPlDPpHc/awFdE4gFj0Io=`

### Database Connection Errors
- Use SQLite for simple setup: `DB_CONNECTION=sqlite`
- Or add PostgreSQL service in Render

### Storage/Permission Errors
- Should be handled by Dockerfile
- If persisting, might need to adjust startup script

### 500 Internal Server Error
- Check Laravel logs in Render dashboard
- Usually missing environment variables or database issues

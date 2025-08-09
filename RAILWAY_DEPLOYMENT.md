# Railway Deployment Guide

## Prerequisites
1. Railway account (https://railway.app)
2. GitHub repository connected

## Step-by-Step Deployment

### 1. Create Project on Railway
1. Go to [Railway](https://railway.app)
2. Click "Start a New Project"
3. Select "Deploy from GitHub repo"
4. Choose: `PreciousNwogu/Dabs_Beauty_Touch`

### 2. Railway Auto-Detection
Railway will automatically:
- Detect the Dockerfile
- Build the container
- Deploy the application

### 3. Add Database
1. In your Railway project dashboard
2. Click "New Service" 
3. Select "PostgreSQL"
4. Railway will provide DATABASE_URL automatically

### 4. Configure Environment Variables
Add in Railway dashboard > Variables:
```
APP_NAME=Dab's Beauty Touch
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:eB1ucQSBfg/NXJHIBMvIs2+p3zCcpAqO3XitD5J30bQ=
DB_CONNECTION=pgsql
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
PORT=80
```

### 5. Custom Domain (Optional)
1. Go to Settings > Domains
2. Add your custom domain
3. Update APP_URL environment variable

## Railway Benefits
- Zero-configuration deployment
- Automatic HTTPS
- Built-in database
- Easy scaling
- Fair pricing ($5/month after free tier)

## Commands for Local Testing
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login to Railway  
railway login

# Link to your project
railway link

# Deploy manually
railway up
```

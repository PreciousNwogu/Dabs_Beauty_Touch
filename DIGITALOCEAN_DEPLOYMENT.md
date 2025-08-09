# DigitalOcean App Platform Deployment Guide

## Prerequisites
1. DigitalOcean account
2. GitHub repository with Docker configuration

## Step-by-Step Deployment

### 1. Create App on DigitalOcean
1. Go to [DigitalOcean Apps](https://cloud.digitalocean.com/apps)
2. Click "Create App"
3. Connect your GitHub repository: `PreciousNwogu/Dabs_Beauty_Touch`
4. Select branch: `main`

### 2. Configure App Settings
**Service Configuration:**
- Service Type: Web Service  
- Source Type: Docker Hub or GitHub
- Dockerfile Path: `Dockerfile`
- HTTP Port: 80

**Environment Variables:**
Add these in the App Platform dashboard:
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
```

### 3. Add Database
1. Add a PostgreSQL database component
2. DigitalOcean will provide DATABASE_URL automatically

### 4. Deploy
1. Click "Create Resources"
2. Wait for deployment (5-10 minutes)
3. Get your app URL and update APP_URL environment variable

## Pricing
- Basic plan: $5/month
- Includes database and SSL certificate
- Auto-scaling available

## Benefits
- Easy Docker deployment
- Managed database included  
- Auto SSL certificates
- GitHub integration
- Monitoring included

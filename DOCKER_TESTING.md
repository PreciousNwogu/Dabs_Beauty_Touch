# Local Docker Testing Guide

## Prerequisites
- Docker Desktop installed
- Docker Compose installed

## Quick Start

### 1. Test with Docker Compose
```bash
# Start all services (app + database)
docker-compose up -d

# Check logs
docker-compose logs -f app

# Stop services
docker-compose down
```

### 2. Test with Docker only
```bash
# Build the image
docker build -t dabs-beauty-touch .

# Run container (without database)
docker run -p 8000:80 \
  -e APP_ENV=local \
  -e APP_DEBUG=true \
  -e DB_CONNECTION=sqlite \
  dabs-beauty-touch
```

### 3. Run deployment script
```bash
# Make script executable (Linux/Mac)
chmod +x deploy-docker.sh

# Run deployment
./deploy-docker.sh
```

## Access Your Application
- Local URL: http://localhost:8000
- Check health: http://localhost:8000/test

## Troubleshooting

### Build Issues
```bash
# Check build logs
docker build -t dabs-beauty-touch . --progress=plain

# Remove cache and rebuild
docker build -t dabs-beauty-touch . --no-cache
```

### Container Issues  
```bash
# Check container logs
docker logs dabs-beauty-touch

# Access container shell
docker exec -it dabs-beauty-touch bash

# Check Apache status
docker exec dabs-beauty-touch service apache2 status
```

### Database Issues
```bash
# Check database connection
docker-compose exec app php artisan migrate:status

# Reset database
docker-compose exec app php artisan migrate:fresh
```

#!/bin/bash

# Docker deployment script for Dab's Beauty Touch

echo "🐳 Starting Docker deployment..."

# Build the Docker image
echo "📦 Building Docker image..."
docker build -t dabs-beauty-touch .

# Check if build was successful
if [ $? -eq 0 ]; then
    echo "✅ Docker image built successfully!"
else
    echo "❌ Docker build failed!"
    exit 1
fi

# Stop and remove existing container (if running)
echo "🔄 Stopping existing container..."
docker stop dabs-beauty-touch 2>/dev/null || true
docker rm dabs-beauty-touch 2>/dev/null || true

# Run the new container
echo "🚀 Starting new container..."
docker run -d \
  --name dabs-beauty-touch \
  -p 8000:80 \
  -e APP_NAME="Dab's Beauty Touch" \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e APP_KEY=base64:eB1ucQSBfg/NXJHIBMvIs2+p3zCcpAqO3XitD5J30bQ= \
  -e APP_URL=http://localhost:8000 \
  -e DB_CONNECTION=pgsql \
  -e SESSION_DRIVER=database \
  -e CACHE_STORE=database \
  -e QUEUE_CONNECTION=database \
  -e LOG_LEVEL=error \
  dabs-beauty-touch

# Check if container is running
if [ $? -eq 0 ]; then
    echo "✅ Container started successfully!"
    echo "🌐 Application available at: http://localhost:8000"
else
    echo "❌ Container failed to start!"
    exit 1
fi

echo "📋 Container status:"
docker ps | grep dabs-beauty-touch

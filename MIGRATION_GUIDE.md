# DBT Website Migration to Laravel + React SPA

## Overview

This guide will help you convert your existing PHP website to a modern Laravel + React Single Page Application (SPA) while maintaining the exact same design, colors, and functionality.

## Project Structure

```
dbt-laravel-react/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── BookingController.php
│   │       ├── HomeController.php
│   │       └── ApiController.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── Header.tsx
│   │   │   ├── Hero.tsx
│   │   │   ├── About.tsx
│   │   │   ├── Services.tsx
│   │   │   ├── Gallery.tsx
│   │   │   ├── FAQ.tsx
│   │   │   ├── Reviews.tsx
│   │   │   └── Footer.tsx
│   │   ├── App.tsx
│   │   └── app.tsx
│   ├── css/
│   │   ├── app.css
│   │   └── custom.css
│   └── views/
│       └── app.blade.php
├── public/
│   ├── images/ (copy from original)
│   ├── css/ (copy from original)
│   └── js/ (copy from original)
└── routes/
    ├── web.php
    └── api.php
```

## Migration Steps

### 1. Setup Laravel with React

```bash
# Navigate to your Laravel project
cd /c/Users/nwogu/dabs-beauty-touch/dbt-laravel-react

# Install React dependencies
npm install react react-dom @vitejs/plugin-react typescript @types/react @types/react-dom

# Install Bootstrap and React Bootstrap
npm install bootstrap react-bootstrap @types/bootstrap

# Install additional packages for SPA
npm install react-router-dom @types/react-router-dom axios
```

### 2. Configure Vite (vite.config.js)

```javascript
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.tsx"],
            refresh: true,
        }),
    ],
});
```

### 3. Update TypeScript Config (tsconfig.json)

```json
{
    "compilerOptions": {
        "target": "ES2020",
        "useDefineForClassFields": true,
        "lib": ["ES2020", "DOM", "DOM.Iterable"],
        "module": "ESNext",
        "skipLibCheck": true,
        "moduleResolution": "bundler",
        "allowImportingTsExtensions": true,
        "resolveJsonModule": true,
        "isolatedModules": true,
        "noEmit": true,
        "jsx": "react-jsx",
        "strict": true,
        "noUnusedLocals": true,
        "noUnusedParameters": true,
        "noFallthroughCasesInSwitch": true
    },
    "include": ["resources/js"],
    "references": [{ "path": "./tsconfig.node.json" }]
}
```

### 4. Main Laravel Blade Template (resources/views/app.blade.php)

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Dab's Beauty Touch</title>
        <link
            rel="icon"
            href="{{ asset('images/icon.ico.jpg') }}"
            type="image/x-icon"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="//fonts.googleapis.com/css?family=DM+Sans:400,400i,500,500i,700,700i&display=swap"
        />
        @vite(['resources/css/app.css', 'resources/js/app.tsx'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>
```

### 5. Main React App (resources/js/app.tsx)

```typescript
import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import App from "./App";

const container = document.getElementById("app");
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}
```

### 6. Laravel Routes (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;

// SPA Route - catch all routes and return the main view
Route::get('/{any}', [HomeController::class, 'index'])->where('any', '.*');

// API Routes for form submissions
Route::prefix('api')->group(function () {
    Route::post('/booking', [BookingController::class, 'store']);
    Route::post('/contact', [BookingController::class, 'contact']);
});
```

### 7. Controllers

#### HomeController.php

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('app');
    }
}
```

#### BookingController.php

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'service' => 'required|string|max:255',
            'date' => 'required|date',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Process booking (save to database, send emails, etc.)
        // Implementation depends on your requirements

        return response()->json([
            'success' => true,
            'message' => 'Booking submitted successfully!'
        ]);
    }
}
```

### 8. Copy Assets

Copy the following from your original project to the Laravel project:

```bash
# Copy images
cp -r /c/Users/nwogu/dabs-beauty-touch/dbt-project/images/* /c/Users/nwogu/dabs-beauty-touch/dbt-laravel-react/public/images/

# Copy CSS files (for reference)
cp -r /c/Users/nwogu/dabs-beauty-touch/dbt-project/css/* /c/Users/nwogu/dabs-beauty-touch/dbt-laravel-react/public/css/

# Copy JS files (for reference)
cp -r /c/Users/nwogu/dabs-beauty-touch/dbt-project/js/* /c/Users/nwogu/dabs-beauty-touch/dbt-laravel-react/public/js/
```

### 9. Environment Setup

Update your `.env` file:

```env
APP_NAME="Dab's Beauty Touch"
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost

# Add any other configuration you need
```

### 10. Development Commands

```bash
# Start the Laravel development server
php artisan serve

# In another terminal, start Vite for asset compilation
npm run dev

# For production build
npm run build
```

## Key Features Preserved

1. **Exact Color Scheme**: Orange theme (#FFA500) maintained
2. **Single Page Layout**: All sections in one scrollable page
3. **Bootstrap Responsive Design**: Using React Bootstrap components
4. **Interactive Elements**: FAQ accordions, service toggles, etc.
5. **Image Gallery**: Service showcases and testimonials
6. **Contact Forms**: Booking and contact functionality

## Benefits of Laravel + React Migration

1. **Modern Development**: Component-based architecture
2. **Better Performance**: SPA with faster navigation
3. **SEO Friendly**: Can be enhanced with server-side rendering
4. **Scalability**: Easy to add new features and pages
5. **Maintainability**: Separation of concerns, reusable components
6. **State Management**: Better form handling and user interactions
7. **API Ready**: Easy to create mobile apps or integrate with other services

## Next Steps

1. Copy the React components from the migration folder
2. Set up the Laravel routes and controllers
3. Configure the database for booking storage
4. Set up email notifications for bookings
5. Test all functionality
6. Deploy to production

## Production Deployment

For production, you'll want to:

1. Configure a proper database (MySQL/PostgreSQL)
2. Set up email service (SMTP/SendGrid/etc.)
3. Configure web server (Apache/Nginx)
4. Set up SSL certificates
5. Configure caching and optimization
6. Set up monitoring and backups

This migration maintains your beautiful design while providing a modern, scalable foundation for future growth!

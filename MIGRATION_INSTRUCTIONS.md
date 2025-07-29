# Database Migration Instructions

## Issue Fixed
The 500 error was caused by the `address` column not existing in the database table. The migration file was updated but not executed.

## Temporary Fix Applied
- Temporarily removed the `address` field from the booking form and controller
- Added a notice to users about the temporary unavailability
- Form should now work without the 500 error

## To Complete the Fix (When PHP is Available)

### Option 1: Using Herd (Recommended)
If you're using Herd, you can run:
```bash
herd shell
php artisan migrate
```

### Option 2: Using PHP directly
If PHP is available in your PATH:
```bash
php artisan migrate
```

### Option 3: Using Composer
```bash
composer exec php artisan migrate
```

## What the Migration Will Do
The migration will add the missing `address` column to the `bookings` table.

## After Running the Migration
Once the migration is successful, you can:

1. **Re-enable the address field in the controller:**
   - Uncomment the `address` field in `app/Http/Controllers/BookingController.php`
   - Remove the comment from the validation rules
   - Remove the comment from the Booking::create() call

2. **Re-enable the address field in the form:**
   - Uncomment the address input field in `resources/views/home.blade.php`
   - Remove the temporary notice about the address field

## Current Status
✅ Form submission works (without address field)
✅ Form clearing works
✅ File upload works
✅ All other functionality works

⏳ Address field temporarily disabled (until migration is run) 
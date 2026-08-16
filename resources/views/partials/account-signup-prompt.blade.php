@php
    $variant = $variant ?? 'page';
    $details = $bookingDetails ?? [];
    $showAccountSignup = false;
    $accountSignupUrl = route('register');

    if ($variant === 'email') {
        $showAccountSignup = ($is_recipient_owner ?? true)
            && isset($booking)
            && $booking instanceof \App\Models\Booking
            && $booking->needsAccountSignup();
        if ($showAccountSignup) {
            $accountSignupUrl = $booking->accountSignupUrl();
        }
    } else {
        $showAccountSignup = ! auth()->check();
        if ($showAccountSignup && isset($booking) && $booking instanceof \App\Models\Booking) {
            $showAccountSignup = $booking->needsAccountSignup();
            $accountSignupUrl = $booking->accountSignupUrl();
        } elseif ($showAccountSignup) {
            $detailEmail = $details['email'] ?? null;
            $showAccountSignup = \App\Models\Booking::emailNeedsAccount($detailEmail, $details['user_id'] ?? null);
            $accountSignupUrl = \App\Models\Booking::signupUrlFor($detailEmail, $details['name'] ?? null);
        }
    }
@endphp
@if($showAccountSignup)
    @if($variant === 'email')
      <div style="background:#f0f6ff;border:2px solid #030f68;border-radius:10px;padding:16px;margin:20px 0;text-align:center;">
        <p style="margin:0 0 8px 0;font-weight:800;color:#030f68;">Coming back next time?</p>
        <p style="margin:0 0 12px 0;font-size:14px;color:#4a5568;">Create an account so your details and bookings are saved for easier booking.</p>
        <a href="{{ $accountSignupUrl }}" style="display:inline-block;padding:12px 20px;background:#ff6600;color:#fff;text-decoration:none;border-radius:6px;font-weight:700;">Create account</a>
      </div>
    @else
      <div class="account-signup-prompt" style="background:#f0f6ff;border:2px solid #030f68;border-radius:14px;padding:16px 18px;margin:16px 0 0;text-align:center;">
        <p class="mb-1" style="font-weight:800;color:#030f68;">Coming back next time?</p>
        <p class="mb-3" style="font-size:0.92rem;color:#555;">Create an account so your details and bookings are saved for easier booking.</p>
        <a href="{{ $accountSignupUrl }}" class="btn" style="background:#ff6600;color:#fff;font-weight:800;border-radius:10px;padding:10px 18px;">Create account</a>
      </div>
    @endif
@endif

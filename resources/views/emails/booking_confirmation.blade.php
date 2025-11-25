<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial; background:#f6f9fc; color:#222; }
    .card { max-width:640px; margin:28px auto; background:#fff; border-radius:12px; padding:22px; box-shadow:0 8px 30px rgba(16,24,40,0.08); }
    .brand { color:#0b3a66; font-weight:800; font-size:20px; }
    .muted { color:#6c757d; }
    .price { color:#0b3a66; font-weight:800; font-size:20px; }
    .cta { display:inline-block; background:#ffb703;color:#081c15;padding:10px 16px;border-radius:8px;text-decoration:none;font-weight:700;margin-top:12px; }
    .meta { background:#f1f5f9;padding:12px;border-radius:8px;margin-top:12px;font-size:14px; }
    .summary-row { display:flex; gap:12px; align-items:center; justify-content:space-between; }
    .summary-item { text-align:center; }
  </style>
</head>
<body>
  <div class="card">
    <div class="brand">Dabs Beauty Touch</div>
    <h2>Booking Confirmation</h2>
    <p class="muted">Hello {{ $booking->name ?? 'Customer' }},</p>

    <p>Thanks — we've received your booking. Below are the details we have on file.</p>

    <div class="meta">
      <div><strong>Booking ID:</strong> BK{{ str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT) }}</div>
      <div><strong>Confirmation code:</strong> {{ $booking->confirmation_code ?? 'N/A' }}</div>
      <div><strong>Service:</strong> {{ $booking->service ?? 'N/A' }}</div>
      @if(!empty($booking->hair_mask_option))
        <div><strong>Option:</strong> {{ $booking->hair_mask_option === 'mask-with-weave' ? 'With Weaving (+$30 estimate)' : 'Mask / Relaxing only' }}</div>
      @endif
      {{-- Show length only when this is NOT a hair-mask booking --}}
      @if(empty($booking->hair_mask_option))
        <div><strong>Length:</strong> {{ isset($booking->length) ? ucwords(str_replace('_', ' ', $booking->length)) : 'N/A' }}</div>
      @endif
      <div><strong>Appointment:</strong> {{ optional($booking->appointment_date)->format('F j, Y') ?? '' }} {{ $booking->appointment_time ?? '' }}</div>
    </div>

    <p style="margin-top:14px;">Price summary:</p>
    <div class="summary-row">
      <div class="summary-item">
        <div class="muted">Base price</div>
        <div>${{ number_format($basePrice ?? ($booking->base_price ?? 0),2) }}</div>
      </div>
      <div class="summary-item">
        <div class="muted">Adjustment</div>
        <div>${{ number_format($adjust ?? ($booking->length_adjustment ?? 0),2) }}</div>
      </div>
      <div class="summary-item">
        <div class="muted">Total</div>
        <div class="price">${{ number_format($booking->final_price ?? 0,2) }}</div>
      </div>
    </div>

    <p style="margin-top:16px;">If you need to make changes, click the button below to view your booking.</p>

    <a class="cta" href="{{ url('/bookings/confirm/' . ($booking->id ?? '') . '/' . ($booking->confirmation_code ?? '')) }}">View booking</a>

    <p style="margin-top:18px; font-size:13px; color:#6c757d;">We look forward to seeing you — Dabs Beauty Touch</p>
  </div>
</body>
</html>

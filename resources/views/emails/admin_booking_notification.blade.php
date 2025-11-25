<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>New Booking Received</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial; background:#f6f9fc; color:#222; }
    .card { max-width:700px; margin:28px auto; background:#fff; border-radius:12px; padding:22px; box-shadow:0 8px 30px rgba(16,24,40,0.08); }
    .brand { color:#0b3a66; font-weight:800; font-size:18px; }
    .muted { color:#6c757d; }
    .meta { background:#f1f5f9;padding:12px;border-radius:8px;margin-top:12px;font-size:14px; }
    .cta { display:inline-block; background:#0b66ff;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none;font-weight:700;margin-top:12px; }
  </style>
</head>
<body>
  <div class="card">
    <div class="brand">Dabs Beauty Touch — Admin</div>
    <h2>New Booking Received</h2>
    <p class="muted">A new booking has been made on the site. Below are the details.</p>

    <div class="meta">
      <div><strong>Booking ID:</strong> {{ $formattedId ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT)) }}</div>
      <div><strong>Name:</strong> {{ $booking->name ?? 'N/A' }}</div>
      <div><strong>Email:</strong> {{ $booking->email ?? 'N/A' }}</div>
      <div><strong>Phone:</strong> {{ $booking->phone ?? 'N/A' }}</div>
      <div><strong>Service:</strong> {{ $booking->service ?? 'N/A' }}</div>
      {{-- Show length for non-hair-mask services only --}}
      @if(empty($booking->hair_mask_option))
        <div><strong>Length:</strong> {{ isset($booking->length) ? ucwords(str_replace('_', ' ', $booking->length)) : 'N/A' }}</div>
      @endif
      @if(!empty($booking->hair_mask_option))
        <div><strong>Option:</strong> {{ $booking->hair_mask_option === 'mask-with-weave' ? 'With Weaving (+$30 estimate)' : 'Mask / Relaxing only' }}</div>
      @endif
      <div><strong>Appointment:</strong> {{ optional($booking->appointment_date)->format('F j, Y') ?? '' }} {{ $booking->appointment_time ?? '' }}</div>
      <div><strong>Total:</strong> ${{ number_format($booking->final_price ?? 0, 2) }}</div>
    </div>

    <p style="margin-top:14px;">Quick actions:</p>
    <a class="cta" href="{{ url('/admin/bookings/' . ($booking->id ?? '')) }}">Open booking in admin</a>

    <p style="margin-top:18px; font-size:13px; color:#6c757d;">This is an automated message.</p>
  </div>
</body>
</html>

@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Appointment confirmed</title>
</head>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;background:#f6f9fc;color:#1a202c;margin:0;padding:24px;">
  <div style="max-width:600px;margin:0 auto;background:#fff;border-radius:8px;overflow:hidden;">
    <div style="background:#030f68;padding:24px;text-align:center;color:#fff;">
      <h1 style="margin:0;font-size:24px;">You're confirmed</h1>
    </div>
    <div style="padding:24px;">
      <p>Hi {{ $booking->name ?? 'there' }},</p>
      <p>We received your {{ \App\Support\InteracDeposit::amountLabel() }} deposit. Your appointment is now <strong>confirmed</strong>.</p>
      <p>
        <strong>{{ $booking->service ?? 'Appointment' }}</strong><br>
        {{ $booking->appointment_date ? $booking->appointment_date->format('l, F j, Y') : '' }}
        @if($booking->appointment_time)
          at {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
        @endif
      </p>
      @if(($booking->appointment_type ?? '') === 'mobile')
        <p>This is a home service. Please be ready at your address at the appointment time.</p>
      @else
        <p>Please arrive on time for your studio appointment.</p>
      @endif
      @if(!empty($booking->confirmation_code))
        <p><a href="{{ url('/bookings/confirm/'.$booking->id.'/'.$booking->confirmation_code) }}" style="display:inline-block;padding:12px 20px;background:#ff6600;color:#fff;text-decoration:none;border-radius:6px;font-weight:700;">View booking</a></p>
      @endif
      <p style="color:#718096;font-size:13px;">Dab's Beauty Touch</p>
    </div>
  </div>
</body>
</html>
@php $html = ob_get_clean(); echo preg_replace('/\s+/', ' ', trim($html)); @endphp

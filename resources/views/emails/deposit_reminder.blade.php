@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Deposit reminder</title>
</head>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;background:#f6f9fc;color:#1a202c;margin:0;padding:24px;">
  <div style="max-width:600px;margin:0 auto;background:#fff;border-radius:8px;overflow:hidden;">
    <div style="background:#ff6600;padding:24px;text-align:center;color:#fff;">
      <h1 style="margin:0;font-size:24px;">Hold your appointment</h1>
    </div>
    <div style="padding:24px;">
      <p>Hi {{ $booking->name ?? 'there' }},</p>
      <p>Your booking is still pending. Send the {{ $amountLabel }} Interac e-Transfer so we can confirm your time.</p>
      <p>
        <strong>Send {{ $amountLabel }} to:</strong><br>
        <a href="mailto:{{ $interacEmail }}">{{ $interacEmail }}</a>
      </p>
      <p>Put booking ID <strong>BK{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong> in the Interac message.</p>
      <p>
        {{ $booking->service ?? 'Appointment' }} —
        {{ $booking->appointment_date ? $booking->appointment_date->format('l, F j, Y') : '' }}
        @if($booking->appointment_time)
          at {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
        @endif
      </p>
      <p style="color:#718096;font-size:13px;">Dab's Beauty Touch</p>
    </div>
  </div>
</body>
</html>
@php $html = ob_get_clean(); echo preg_replace('/\s+/', ' ', trim($html)); @endphp

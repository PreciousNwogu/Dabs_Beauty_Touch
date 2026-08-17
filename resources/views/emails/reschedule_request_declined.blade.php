<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Appointment time unchanged</title>
</head>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1a202c;background:#f8f9fc;margin:0;padding:24px;">
  <div style="max-width:560px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e6eaf5;">
    <div style="background:linear-gradient(135deg,#030f68,#4a8bc2);color:#fff;padding:22px 24px;">
      <h2 style="margin:0;font-size:1.3rem;">About your time-change request</h2>
    </div>
    <div style="padding:24px;">
      <p>Hi {{ $booking->name ?: 'there' }},</p>
      <p>
        We received your request to move your appointment
        @if(!empty($requestedLabel))
          to <strong>{{ $requestedLabel }}</strong>
        @endif
        . That new time is not available, so your original appointment is still booked:
      </p>
      <p style="background:#fff7ef;border-left:4px solid #ff6600;padding:12px 14px;border-radius:8px;">
        <strong>{{ $booking->currentAppointmentLabel() ?: 'See your confirmation email' }}</strong><br>
        {{ $booking->service }}
      </p>
      @if(!empty($note))
        <p>{{ $note }}</p>
      @endif
      <p>If you need a different day, reply to this email or send another request from your booking page and we will look at what is open.</p>
      @if($booking->id && $booking->confirmation_code)
        <p style="text-align:center;margin:24px 0;">
          <a href="{{ url('/bookings/confirm/'.$booking->id.'/'.$booking->confirmation_code) }}" style="display:inline-block;background:#ff6600;color:#fff;text-decoration:none;font-weight:700;padding:12px 22px;border-radius:8px;">View your booking</a>
        </p>
      @endif
      <p style="margin-bottom:0;">Thank you,<br><strong>Dab's Beauty Touch</strong></p>
    </div>
  </div>
</body>
</html>

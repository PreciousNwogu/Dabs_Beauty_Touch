@php ob_start(); @endphp
<!doctype html>
<html>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1a202c;background:#f8f9fc;margin:0;padding:24px;">
  <div style="max-width:560px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e6eaf5;">
    <div style="background:linear-gradient(135deg,#030f68,#4a8bc2);color:#fff;padding:22px 24px;">
      <h2 style="margin:0;font-size:1.3rem;">About your time-change request</h2>
    </div>
    <div style="padding:24px;">
      <p>Hi {{ $booking->name ?: 'there' }},</p>
      <p>We received your request to move your appointment@if($requestedLabel) to <strong>{{ $requestedLabel }}</strong>@endif. That new time is not available, so your original appointment is still booked:</p>
      <p style="background:#fff7ef;border-left:4px solid #ff6600;padding:12px 14px;border-radius:8px;">
        <strong>{{ $booking->currentAppointmentLabel() ?: 'See your confirmation email' }}</strong><br>
        {{ $booking->service }}
      </p>
      @if($note)
        <p>{{ $note }}</p>
      @endif
      <p>If you need a different day, reply to this email or send another request from your booking page and we will look at what is open.</p>
      <p style="margin-bottom:0;">Thank you,<br><strong>Dab's Beauty Touch</strong></p>
    </div>
  </div>
</body>
</html>
@php $html = ob_get_clean(); echo preg_replace('/\s+/', ' ', trim($html)); @endphp

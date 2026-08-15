@php ob_start(); @endphp
<!doctype html>
<html>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1a202c;padding:24px;">
  <h2>Reschedule request</h2>
  <p>Client <strong>{{ $booking->name }}</strong> asked to change booking #{{ $booking->id }}.</p>
  <p>
    Current:
    {{ $booking->appointment_date ? $booking->appointment_date->format('F j, Y') : 'N/A' }}
    {{ $booking->appointment_time }}
    — {{ $booking->service }}
  </p>
  <p>
    Requested:
    {{ $preferredDate ?: 'not specified' }}
    {{ $preferredTime ?: '' }}
  </p>
  @if($note)
    <p>Note: {{ $note }}</p>
  @endif
  <p><a href="{{ url('/admin/bookings/'.$booking->id) }}">Open booking in admin</a></p>
</body>
</html>
@php $html = ob_get_clean(); echo preg_replace('/\s+/', ' ', trim($html)); @endphp

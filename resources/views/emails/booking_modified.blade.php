@php
  $b = $booking;
  $id = $formattedId ?? ('BK' . str_pad($b->id ?? 0, 6, '0', STR_PAD_LEFT));
  $code = $b->confirmation_code ?? null;
  $publicUrl = ($b->id && $code) ? secure_url('/bookings/confirm/' . $b->id . '/' . $code) : null;
  $fmtMoney = function($v){
    if ($v === null || $v === '') return '—';
    if (!is_numeric($v)) return (string)$v;
    return '$' . number_format((float)$v, 2);
  };
  $fmtLen = function($v){
    if (!$v) return '—';
    return ucwords(str_replace(['_','-'], ' ', (string)$v));
  };
  $beforeService = $before['service'] ?? null;
  $afterService = $after['service'] ?? null;
  $beforeLen = $before['kb_length'] ?? $before['length'] ?? null;
  $afterLen = $after['kb_length'] ?? $after['length'] ?? null;
  $beforeBraid = $before['kb_braid_type'] ?? null;
  $afterBraid = $after['kb_braid_type'] ?? null;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Updated</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f6f8fb; color:#111827; margin:0; padding:0; }
    .wrap { max-width: 720px; margin: 0 auto; padding: 24px; }
    .card { background:#ffffff; border-radius: 14px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); overflow:hidden; }
    .header { background: linear-gradient(135deg, #0ea5e9 0%, #4a8bc2 100%); color:#fff; padding: 18px 22px; }
    .header h2 { margin:0; font-size: 18px; }
    .content { padding: 20px 22px; }
    .pill { display:inline-block; padding:6px 10px; border-radius: 999px; font-size: 12px; font-weight:700; background:#e7f3ff; color:#0b3a66; }
    .grid { width:100%; border-collapse: collapse; margin-top: 12px; }
    .grid td { padding: 8px 10px; border-bottom: 1px solid #eef2f6; vertical-align: top; }
    .grid td:first-child { font-weight:700; color:#374151; width: 180px; }
    .muted { color:#6b7280; font-size: 13px; }
    .diff { display:inline-block; padding:2px 6px; border-radius: 8px; background:#fff3cd; color:#92400e; font-weight:700; }
    .cta { display:inline-block; margin-top: 14px; background:#030f68; color:#fff !important; text-decoration:none; padding: 10px 14px; border-radius: 10px; font-weight: 800; }
    .footer { margin-top: 16px; font-size: 12px; color:#6b7280; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <div class="header">
        <h2>Booking Updated — {{ $id }}</h2>
      </div>
      <div class="content">
        <div class="pill">Change confirmation</div>
        <p class="muted" style="margin-top:10px;">
          @if(!empty($is_recipient_owner))
            You successfully updated your booking details.
          @else
            A customer updated their booking details.
          @endif
        </p>

        @if(!empty($showContactInfo))
          <table class="grid" role="presentation">
            <tr><td>Customer</td><td>{{ $b->name ?? '—' }}</td></tr>
            <tr><td>Email</td><td>{{ $b->email ?? '—' }}</td></tr>
            <tr><td>Phone</td><td>{{ $b->phone ?? '—' }}</td></tr>
          </table>
        @endif

        <table class="grid" role="presentation">
          <tr>
            <td>Service</td>
            <td>
              {{ $afterService ?? $b->service ?? '—' }}
              @if($beforeService && $afterService && $beforeService !== $afterService)
                <span class="diff">was {{ $beforeService }}</span>
              @endif
            </td>
          </tr>
          <tr>
            <td>Length</td>
            <td>
              {{ $fmtLen($afterLen ?? $b->kb_length ?? $b->length) }}
              @if($beforeLen && ($afterLen ?? null) && $beforeLen !== $afterLen)
                <span class="diff">was {{ $fmtLen($beforeLen) }}</span>
              @endif
            </td>
          </tr>
          @if($afterBraid || $beforeBraid || $b->kb_braid_type)
          <tr>
            <td>Braid type</td>
            <td>
              {{ $afterBraid ?? $b->kb_braid_type ?? '—' }}
              @if($beforeBraid && ($afterBraid ?? null) && $beforeBraid !== $afterBraid)
                <span class="diff">was {{ $beforeBraid }}</span>
              @endif
            </td>
          </tr>
          @endif
          <tr>
            <td>Date / Time</td>
            <td>
              {{ $b->appointment_date ? $b->appointment_date->format('M j, Y') : '—' }}
              @if(!empty($b->appointment_time)) at {{ $b->appointment_time }} @endif
            </td>
          </tr>
          <tr>
            <td>Updated price</td>
            <td><strong>{{ $fmtMoney($after['final_price'] ?? $b->final_price ?? null) }}</strong></td>
          </tr>
        </table>

        @if($publicUrl)
          <a class="cta" href="{{ $publicUrl }}">View booking details</a>
        @endif

        <div class="footer">
          If anything looks incorrect, reply to this email or contact Dab's Beauty Touch.
        </div>
      </div>
    </div>
  </div>
</body>
</html>


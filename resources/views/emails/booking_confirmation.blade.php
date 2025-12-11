@php ob_start(); @endphp
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
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <div class="brand">Dabs Beauty Touch</div>
      @if(isset($showHeader) ? $showHeader : true)
        <div style="font-size:12px;color:#6c757d;">Booking Confirmation</div>
      @endif
    </div>
    <p class="muted">Hi {{ $booking->name ?? 'Customer' }}, thank you — your booking is confirmed.</p>

    <table width="100%" cellpadding="6" style="border-collapse:collapse;margin-top:6px;">
      <tr style="background:#f8fafc;"><td style="width:40%;font-weight:700;">Booking ID</td><td>BK{{ str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT) }}</td></tr>
      <tr><td style="font-weight:700;">Confirmation Number</td><td>{{ $confirmation_number ?? ($booking->confirmation_code ?? '—') }}</td></tr>
      @if(isset($showContactInfo) && $showContactInfo)
        <tr><td style="font-weight:700;">Name</td><td>{{ $booking->name ?? 'N/A' }}</td></tr>
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Email</td><td>{{ $booking->email ?? 'N/A' }}</td></tr>
        <tr><td style="font-weight:700;">Phone</td><td>{{ $booking->phone ?? 'N/A' }}</td></tr>
      @endif
      <tr style="background:#f8fafc;"><td style="font-weight:700;">Service</td><td>{{ $booking->service ?? 'N/A' }}</td></tr>

      @php
        // Prefer selector passed from notification; fallback to parsing notes
        $selector = $selector ?? null;
        if(!$selector && preg_match('/Selector:\s*(\{.*\})/s', $booking->notes ?? '', $m)){
          $selector = json_decode($m[1], true);
        }

        $sf = $selector_friendly ?? null;
        $braidType = $sf['braid_type'] ?? $selector['braid_type'] ?? ($booking->kb_braid_type ?? ($booking->service ?? null));
        $finishVal = $sf['finish'] ?? $selector['finish'] ?? ($booking->kb_finish ?? null);
        $lengthVal = $sf['length'] ?? $selector['length'] ?? ($booking->kb_length ?? ($booking->length ?? null));

        // `hideLengthFinish` should be provided by the Notification; default to false if not passed
        $hideLengthFinish = $hideLengthFinish ?? false;
        $extrasVal = null;
        if(!empty($sf['extras']) && is_array($sf['extras'])){
            $extrasVal = implode(', ', $sf['extras']);
        } else {
            $extrasVal = $selector['extras'] ?? ($booking->kb_extras ?? null);
            if(is_array($extrasVal)) $extrasVal = implode(', ', $extrasVal);
        }

        // Compute authoritative pricing values
        $basePrice = $booking->base_price ?? ($selector_base ?? null);
        $lengthAdjust = $booking->length_adjustment ?? ($selector_adjust ?? 0);
        // Determine addons total robustly: prefer selector_addons, then parse booking->kb_extras as CSV of numbers
        $addons_total = null;
        if (isset($selector_addons) && is_numeric($selector_addons)) {
          $addons_total = (float) $selector_addons;
        } elseif (!empty($booking->kb_extras)) {
          if (is_string($booking->kb_extras) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $booking->kb_extras)) {
            $addons_total = array_sum(array_map('floatval', explode(',', $booking->kb_extras)));
          } else {
            // named extras mapping (same as admin mapping)
            $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
            $sum = 0;
            foreach (explode(',', $booking->kb_extras) as $it) {
              $it = trim($it);
              if (isset($addonMap[$it])) $sum += $addonMap[$it];
            }
            $addons_total = $sum;
          }
        }

        // Use explicit breakdown values passed from the notification when available
        $basePrice = $basePrice ?? ($booking->base_price ?? 0);
        $lengthAdjust = $lengthAdjust ?? ($booking->length_adjustment ?? 0);
        $addons_total = $addons_total ?? 0;
        $adjustmentsTotal = ($lengthAdjust + (is_numeric($addons_total) ? $addons_total : 0));
        // Prefer explicit final_price passed from the notification, then booking->final_price, then recomputed
        $finalPrice = $final_price ?? $booking->final_price ?? round($basePrice + $lengthAdjust + (is_numeric($addons_total) ? $addons_total : 0), 2);
      @endphp

      @if(!$hideLengthFinish)
        <tr><td style="font-weight:700;">Length</td>
          <td>
            @if(!empty($booking->hair_mask_option))
              -
            @else
              {{ isset($lengthVal) ? ucwords(str_replace('_',' ',$lengthVal)) : 'N/A' }}
            @endif
          </td>
        </tr>
      @endif
      <tr style="background:#f8fafc;"><td style="font-weight:700;">Braid Type</td><td>{{ $braidType ?? '—' }}</td></tr>
      @if(!$hideLengthFinish)
        <tr><td style="font-weight:700;">Finish</td><td>{{ $finishVal ?? '—' }}</td></tr>
      @endif
      <tr style="background:#f8fafc;"><td style="font-weight:700;">Add-ons</td><td>{{ $extrasVal ?: 'None' }}</td></tr>
    </table>

    <h4 style="margin-top:16px;margin-bottom:8px;color:#0b3a66;">Price Summary</h4>
    <table width="100%" cellpadding="6" style="border-collapse:collapse;">
      <tr style="background:#f8fafc;"><td style="font-weight:700;">Base price</td><td>{{ isset($basePrice) ? sprintf('$%.2f', $basePrice) : '—' }}</td></tr>
      <tr><td style="font-weight:700;">Adjustments / Add-ons</td><td>{{ sprintf('$%.2f', $adjustmentsTotal) }}</td></tr>
      <tr><td style="font-weight:700;">Add-ons</td><td>{{ sprintf('$%.2f', $addons_total) }}</td></tr>
      <tr style="background:#f8fafc;font-size:18px;font-weight:800;"><td style="font-weight:800;">Final price</td><td>{{ isset($finalPrice) ? sprintf('$%.2f', $finalPrice) : '—' }}</td></tr>
    </table>

    <div style="margin-top:16px;padding:12px;border-radius:8px;background:#f8fafc;border:1px solid #e6eef6;">
      <strong style="display:block;margin-bottom:8px;color:#0b3a66;">Add to your calendar</strong>
      @php
        $date = isset($booking->appointment_date) ? $booking->appointment_date->format('Y-m-d') : null;
        $time = $booking->appointment_time ?? null;
        $tz = config('app.timezone') ?: 'UTC';
        $gcal = null;
        if ($date && $time) {
            try {
                $start = \Carbon\Carbon::parse($date . ' ' . $time, $tz)->utc()->format('Ymd\THis\Z');
                $duration = (int) ($booking->service_duration_minutes ?? 90);
                $end = \Carbon\Carbon::parse($date . ' ' . $time, $tz)->addMinutes($duration)->utc()->format('Ymd\THis\Z');
                $title = rawurlencode(($booking->service ?? 'Appointment') . ' (' . ($confirmation_number ?? 'Booking') . ')');
                $details = rawurlencode('Customer: ' . ($booking->name ?? '') . '\nPhone: ' . ($booking->phone ?? ''));
                $gcal = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . $title . '&dates=' . $start . '/' . $end . '&details=' . $details;
            } catch (\Exception $e) { $gcal = null; }
        }
      @endphp
      <p style="margin:0 0 8px 0;">Add this booking to your calendar using one of the options below.</p>
      <p style="margin:0;">
        @if($gcal)
          <a href="{{ $gcal }}" style="display:inline-block;background:#0b3a66;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none;margin-right:8px;">Add to Google Calendar</a>
        @endif
      </p>
    </div>

    {{-- Debug block removed per request: remove APP_DEBUG diagnostics from customer email --}}

    <p style="margin-top:14px;">If you need to make changes, click the button below to view your booking.</p>
    <a class="cta" href="{{ url('/bookings/confirm/' . ($booking->id ?? '') . '/' . ($booking->confirmation_code ?? '')) }}">View booking</a>

    <div style="margin-top:18px;border-top:1px solid #eef2f6;padding-top:12px;font-size:13px;color:#6c757d;">
      <p style="margin:6px 0 8px 0;font-weight:700;color:#0b3a66;">Stay connected</p>
      <p style="margin:0;">Follow us for updates and styling inspiration:</p>
      <p style="margin:8px 0 0 0;">
                    <a href="https://www.instagram.com/dabs_beauty_touch?igsh=MXYycGNraGxwem5tZw%3D%3D&utm_source=qr" style="margin-right:12px;color:#0b3a66;text-decoration:none;">Instagram</a>
                    <a href="https://wa.me/13432548848" style="color:#0b3a66;text-decoration:none;">WhatsApp</a>
      </p>
    </div>

    <p style="margin-top:12px;color:#6c757d;font-size:13px;">Thanks,<br/>Dabs Beauty Touch</p>
  @php
    $html = ob_get_clean();
    echo preg_replace('/\s+/', ' ', trim($html));
  @endphp

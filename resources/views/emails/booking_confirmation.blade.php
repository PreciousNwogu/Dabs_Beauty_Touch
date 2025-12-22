@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation - Dabs Beauty Touch</title>
  <style>
    body { 
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; 
      background: #f6f9fc; 
      color: #1a202c; 
      margin: 0; 
      padding: 0;
      line-height: 1.6;
    }
    .email-container { 
      max-width: 600px; 
      margin: 0 auto; 
      background: #ffffff;
    }
    .header {
      background: linear-gradient(135deg, #0b3a66 0%, #1e5a8a 100%);
      padding: 32px 24px;
      text-align: center;
      border-radius: 8px 8px 0 0;
    }
    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      margin: 0;
      letter-spacing: -0.5px;
    }
    .header-badge {
      display: inline-block;
      background: rgba(255, 255, 255, 0.2);
      color: #ffffff;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      margin-top: 12px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .content {
      padding: 32px 24px;
    }
    .greeting {
      font-size: 18px;
      color: #1a202c;
      font-weight: 600;
      margin: 0 0 16px 0;
    }
    .message {
      font-size: 16px;
      color: #4a5568;
      margin: 0 0 24px 0;
      line-height: 1.7;
    }
    .info-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .info-card h3 {
      color: #0b3a66;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 16px 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-size: 13px;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .info-table tr {
      border-bottom: 1px solid #e2e8f0;
    }
    .info-table tr:last-child {
      border-bottom: none;
    }
    .info-table td {
      padding: 12px 0;
      font-size: 15px;
    }
    .info-table td:first-child {
      color: #718096;
      font-weight: 600;
      width: 40%;
      vertical-align: top;
    }
    .info-table td:last-child {
      color: #1a202c;
      font-weight: 500;
    }
    .price-summary {
      background: linear-gradient(135deg, #fff7e0 0%, #ffe6cc 100%);
      border-left: 4px solid #ff6600;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .price-summary h3 {
      color: #0b3a66;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 16px 0;
    }
    .price-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid rgba(11, 58, 102, 0.1);
    }
    .price-row:last-child {
      border-bottom: none;
      font-size: 18px;
      font-weight: 700;
      color: #0b3a66;
      padding-top: 16px;
      margin-top: 8px;
      border-top: 2px solid rgba(11, 58, 102, 0.2);
    }
    .price-label {
      color: #4a5568;
      font-weight: 500;
    }
    .price-value {
      color: #1a202c;
      font-weight: 600;
    }
    .price-row:last-child .price-label,
    .price-row:last-child .price-value {
      color: #0b3a66;
      font-size: 18px;
    }
    .calendar-section {
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .calendar-section h3 {
      color: #0b3a66;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .calendar-section p {
      color: #4a5568;
      font-size: 14px;
      margin: 0 0 16px 0;
    }
    .btn {
      display: inline-block;
      padding: 14px 28px;
      background: #ff6600;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 15px;
      text-align: center;
      margin: 8px 8px 8px 0;
      transition: background 0.2s;
    }
    .btn:hover {
      background: #e55a00;
    }
    .btn-secondary {
      background: #0b3a66;
    }
    .btn-secondary:hover {
      background: #0a2d4d;
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 24px;
      text-align: center;
      border-radius: 0 0 8px 8px;
    }
    .footer h4 {
      color: #0b3a66;
      font-size: 14px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .footer p {
      color: #718096;
      font-size: 13px;
      margin: 8px 0;
      line-height: 1.6;
    }
    .signature {
      color: #4a5568;
      font-size: 14px;
      margin-top: 24px;
      padding-top: 24px;
      border-top: 1px solid #e2e8f0;
    }
    @media only screen and (max-width: 600px) {
      .content { padding: 24px 16px; }
      .header { padding: 24px 16px; }
      .header h1 { font-size: 24px; }
      .btn { display: block; margin: 8px 0; }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <!-- Header -->
    <div class="header">
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">✓ Booking Confirmed</div>
    </div>

    <!-- Content -->
    <div class="content">
      <p class="greeting">Hello {{ $booking->name ?? 'Valued Customer' }},</p>
      
      <p class="message">
        Thank you for choosing Dabs Beauty Touch! We're delighted to confirm that your booking has been successfully processed. 
        We look forward to providing you with exceptional service.
      </p>

      <!-- Booking Details Card -->
      <div class="info-card">
        <h3>Booking Details</h3>
        <table class="info-table">
          <tr>
            <td>Booking ID</td>
            <td><strong>BK{{ str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT) }}</strong></td>
          </tr>
          <tr>
            <td>Confirmation Code</td>
            <td><strong>{{ $confirmation_number ?? ($booking->confirmation_code ?? '—') }}</strong></td>
          </tr>
          @if(isset($showContactInfo) && $showContactInfo)
          <tr>
            <td>Name</td>
            <td>{{ $booking->name ?? 'N/A' }}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{{ $booking->email ?? 'N/A' }}</td>
          </tr>
          <tr>
            <td>Phone</td>
            <td>{{ $booking->phone ?? 'N/A' }}</td>
          </tr>
          @endif
          <tr>
            <td>Service</td>
            <td><strong>{{ $booking->service ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>Appointment Date</td>
            <td>
              <strong>
                @if($booking->appointment_date)
                  {{ \Carbon\Carbon::parse($booking->appointment_date)->format('l, F j, Y') }}
                @else
                  N/A
                @endif
              </strong>
            </td>
          </tr>
          <tr>
            <td>Appointment Time</td>
            <td>
              <strong>
                @if($booking->appointment_time)
                  {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
                @else
                  N/A
                @endif
              </strong>
            </td>
          </tr>

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
            $hideLengthFinish = $hideLengthFinish ?? false;
            $extrasVal = null;
            if(!empty($sf['extras']) && is_array($sf['extras'])){
                $extrasVal = implode(', ', $sf['extras']);
            } else {
                $extrasVal = $selector['extras'] ?? ($booking->kb_extras ?? null);
                if(is_array($extrasVal)) $extrasVal = implode(', ', $extrasVal);
            }

            // Map any internal addon codes to friendly labels
            if(is_string($extrasVal) && preg_match('/[,\s]/', $extrasVal)){
              $parts = array_map('trim', explode(',', $extrasVal));
            } elseif(is_string($extrasVal) && strlen($extrasVal) > 0){
              $parts = [trim($extrasVal)];
            } else {
              $parts = [];
            }
            if(!empty($parts)){
              $friendly = ['kb_add_detangle'=>'Detangle','kb_add_beads'=>'Beads','kb_add_beads_full'=>'Full beads','kb_add_extension'=>'Extension','kb_add_rest'=>'Resting'];
              $displayParts = [];
              foreach($parts as $p){
                if(isset($friendly[$p])) $displayParts[] = $friendly[$p]; else $displayParts[] = $p;
              }
              $extrasVal = implode(', ', $displayParts);
            }
          @endphp

          @if(!$hideLengthFinish && isset($lengthVal))
          <tr>
            <td>Hair Length</td>
            <td>
              @if(!empty($booking->hair_mask_option))
                N/A
              @else
                {{ ucwords(str_replace('_',' ',$lengthVal)) }}
              @endif
            </td>
          </tr>
          @endif
          @if(isset($braidType) && $braidType)
          <tr>
            <td>Braid Type</td>
            <td>{{ $braidType }}</td>
          </tr>
          @endif
          @if(!$hideLengthFinish && isset($finishVal) && $finishVal)
          <tr>
            <td>Finish</td>
            <td>{{ $finishVal }}</td>
          </tr>
          @endif
          @if(isset($extrasVal) && $extrasVal)
          <tr>
            <td>Add-ons</td>
            <td>{{ $extrasVal }}</td>
          </tr>
          @endif
        </table>
      </div>

      <!-- Price Summary -->
      @php
        $bd = $breakdown ?? [];
        $basePrice = $bd['resolved_base'] ?? $booking->base_price ?? ($selector_base ?? 0);
        $typeLengthFinishAdjust = $bd['adjustments_total'] ?? $bd['selector_adjust'] ?? $bd['length_adjust'] ?? $booking->length_adjustment ?? $booking->kb_length_adjustment ?? ($selector_adjust ?? 0);
        $addons_total = $bd['addons_total'] ?? $bd['selector_addons'] ?? null;
        if((is_null($addons_total) || $addons_total == 0)){
          if(isset($selector_addons) && is_numeric($selector_addons)){
            $addons_total = (float) $selector_addons;
          } elseif(!empty($booking->kb_extras)){
            if(is_string($booking->kb_extras) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $booking->kb_extras)){
              $addons_total = array_sum(array_map('floatval', explode(',', $booking->kb_extras)));
            } else {
              $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
              $sum = 0;
              foreach(explode(',', $booking->kb_extras) as $it){ $it = trim($it); if(isset($addonMap[$it])) $sum += $addonMap[$it]; }
              $addons_total = $sum;
            }
          } elseif(isset($booking->kb_final_price) && isset($booking->kb_base_price)){
            $addons_total = round(($booking->kb_final_price - $booking->kb_base_price) - ($booking->kb_length_adjustment ?? 0), 2);
          }
        }
        $addons_total = $addons_total ?? 0;
        $adjustmentsTotal = ($typeLengthFinishAdjust ?? 0) + (is_numeric($addons_total) ? $addons_total : 0);
        $finalPrice = $final_price ?? $booking->final_price ?? round(($basePrice ?? 0) + $adjustmentsTotal, 2);
      @endphp

      <div class="price-summary">
        <h3>Price Summary</h3>
        <div class="price-row">
          <span class="price-label">Base Price</span>
          <span class="price-value">{{ isset($basePrice) ? sprintf('$%.2f', $basePrice) : '—' }}</span>
        </div>
        <div class="price-row">
          <span class="price-label">Adjustments / Add-ons</span>
          <span class="price-value">{{ sprintf('$%.2f', $adjustmentsTotal) }}</span>
        </div>
        <div class="price-row">
          <span class="price-label">Total Amount</span>
          <span class="price-value">{{ isset($finalPrice) ? sprintf('$%.2f', $finalPrice) : '—' }}</span>
        </div>
      </div>

      <!-- Calendar Section -->
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

      @if($gcal)
      <div class="calendar-section">
        <h3>📅 Add to Your Calendar</h3>
        <p>Don't forget your appointment! Add it to your calendar to receive reminders.</p>
        <a href="{{ $gcal }}" class="btn btn-secondary">Add to Google Calendar</a>
      </div>
      @endif

      <!-- Action Buttons -->
      <div style="text-align: center; margin: 32px 0;">
        <a href="{{ url('/bookings/confirm/' . ($booking->id ?? '') . '/' . ($booking->confirmation_code ?? '')) }}" class="btn">View Booking Details</a>
      </div>

      <!-- Important Notes -->
      <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 6px; margin: 24px 0;">
        <p style="margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;">
          <strong>Important:</strong> Please arrive 10 minutes before your scheduled appointment time. 
          If you need to make any changes or have questions, please contact us as soon as possible.
        </p>
      </div>

      <!-- Signature -->
      <div class="signature">
        <p style="margin: 0; color: #4a5568;">Best regards,<br>
        <strong style="color: #0b3a66;">The Dabs Beauty Touch Team</strong></p>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <h4>Stay Connected</h4>
      <p>Follow us for updates, styling inspiration, and special offers:</p>
      {!! \App\Helpers\SocialLinks::render() !!}
      <p style="margin-top: 20px; font-size: 12px; color: #a0aec0;">
        This is an automated confirmation email. Please do not reply directly to this message.<br>
        If you have any questions, please contact us through our website or phone.
      </p>
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>

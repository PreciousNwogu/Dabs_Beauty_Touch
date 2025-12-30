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
      border-radius: 8px;
      overflow: hidden;
    }
    .header {
      background: linear-gradient(135deg, #0066ff 0%, #0080ff 100%);
      padding: 24px;
      text-align: center;
    }
    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 900;
      margin: 0;
      text-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), 0 0 20px rgba(255, 255, 255, 0.3);
      letter-spacing: 0.5px;
      filter: brightness(1.1);
    }
    .header-badge {
      display: inline-block;
      background: rgba(255, 255, 255, 0.35);
      color: #ffffff;
      padding: 6px 14px;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 700;
      margin-top: 8px;
      text-transform: uppercase;
      border: 1px solid rgba(255, 255, 255, 0.5);
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4), 0 0 10px rgba(255, 255, 255, 0.2);
      filter: brightness(1.15);
    }
    .content {
      padding: 24px;
    }
    .greeting {
      font-size: 16px;
      color: #1a202c;
      font-weight: 600;
      margin: 0 0 12px 0;
    }
    .message {
      font-size: 15px;
      color: #4a5568;
      margin: 0 0 20px 0;
    }
    .info-card {
      background: #f8fafc;
      border-radius: 6px;
      padding: 16px;
      margin: 16px 0;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
    }
    .info-table tr {
      border-bottom: 1px solid #e2e8f0;
    }
    .info-table tr:last-child {
      border-bottom: none;
    }
    .info-table td {
      padding: 10px 0;
      font-size: 14px;
    }
    .info-table td:first-child {
      color: #718096;
      font-weight: 600;
      width: 40%;
    }
    .info-table td:last-child {
      color: #1a202c;
      font-weight: 500;
    }
    .price-box {
      background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%);
      border-left: 4px solid #ffb366;
      border-radius: 8px;
      padding: 20px;
      margin: 20px 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    .price-row {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.3);
    }
    .price-row:last-child {
      border-bottom: none;
      font-size: 22px;
      font-weight: 800;
      color: #ffffff;
      padding-top: 14px;
      margin-top: 10px;
      border-top: 2px solid rgba(255, 255, 255, 0.5);
    }
    .price-label {
      color: #ffffff;
      font-weight: 700;
      font-size: 17px;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
      letter-spacing: 0.3px;
    }
    .price-value {
      color: #ffffff;
      font-weight: 800;
      font-size: 19px;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
      letter-spacing: 0.3px;
    }
    .price-row:last-child .price-label,
    .price-row:last-child .price-value {
      color: #ffffff;
      font-size: 26px;
      font-weight: 900;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
      letter-spacing: 0.5px;
    }
    .btn {
      display: inline-block;
      padding: 12px 24px;
      background: #ff6600;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
      text-align: center;
      margin: 8px 8px 8px 0;
    }
    .btn-secondary {
      background: #0b3a66;
    }
    .reminder {
      background: #f0f9ff;
      border-left: 4px solid #0ea5e9;
      border-radius: 6px;
      padding: 12px;
      margin: 16px 0;
      font-size: 14px;
      color: #0c4a6e;
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 20px;
      text-align: center;
    }
    .footer p {
      color: #718096;
      font-size: 12px;
      margin: 8px 0;
    }
    @media only screen and (max-width: 600px) {
      .content { padding: 20px; }
      .header { padding: 20px; }
      .btn { display: block; margin: 8px 0; }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">✓ Confirmed</div>
    </div>

    <div class="content">
      <p class="greeting">Hi {{ $booking->name ?? 'Customer' }},</p>
      <p class="message">Your booking is confirmed. We look forward to seeing you!</p>

      <div class="info-card">
        <table class="info-table">
          <tr>
            <td>Booking ID</td>
            <td><strong>BK{{ str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT) }}</strong></td>
          </tr>
          <tr>
            <td>Service</td>
            <td><strong>
              @php
                $serviceDisplay = $booking->service ?? 'N/A';
                // If service name doesn't include "with Weaving" but hair_mask_option indicates weave, append it
                if (!str_contains(strtolower($serviceDisplay), 'with weaving') && !empty($booking->hair_mask_option)) {
                  $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$booking->hair_mask_option)));
                  if (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) {
                    $serviceNameLower = strtolower($serviceDisplay);
                    if (str_contains($serviceNameLower, 'hair mask') || 
                        str_contains($serviceNameLower, 'hair-mask') || 
                        str_contains($serviceNameLower, 'relaxing') || 
                        str_contains($serviceNameLower, 'retouch')) {
                      $serviceDisplay = trim($serviceDisplay) . ' with Weaving';
                    }
                  }
                }
              @endphp
              {{ $serviceDisplay }}
            </strong></td>
          </tr>
          <tr>
            <td>Date</td>
            <td>
              <strong>
                @if($booking->appointment_date)
                  {{ \Carbon\Carbon::parse($booking->appointment_date)->format('F j, Y') }}
                @else
                  N/A
                @endif
              </strong>
            </td>
          </tr>
          <tr>
            <td>Time</td>
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
            $selector = $selector ?? null;
            if(!$selector && preg_match('/Selector:\s*(\{.*\})/s', $booking->notes ?? '', $m)){
              $selector = json_decode($m[1], true);
            }
            $sf = $selector_friendly ?? null;
            $braidType = $sf['braid_type'] ?? $selector['braid_type'] ?? ($booking->kb_braid_type ?? null);
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
        
        // Check for hair mask weaving option - new pricing uses $80 base, no separate addon
        $weavingAddon = 0.00;
        $hasWeavingAddon = false;
        $isMaskWithWeave = false;
        if (!empty($booking->hair_mask_option)) {
          $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$booking->hair_mask_option)));
          if (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) {
            $isMaskWithWeave = true;
            // With new pricing, base price is $80 for mask-with-weave, no separate addon
            // Check if base price is already $80 (new pricing) or if we need to add $30 (old pricing)
            if (($basePrice ?? 0) >= 80.00) {
              // New pricing: base is already $80, no addon needed
              $weavingAddon = 0.00;
              $hasWeavingAddon = false;
            } else {
              // Legacy pricing: add $30 addon
              $weavingAddon = 30.00;
              $hasWeavingAddon = true;
            }
            // If length_adjustment contains the weaving addon, subtract it to get pure length adjustment
            if ($typeLengthFinishAdjust > 0 && $typeLengthFinishAdjust == 30.00) {
              $typeLengthFinishAdjust = 0.00;
            }
          }
        }
        
        // Calculate adjustments total (excluding weaving addon which is shown separately)
        $adjustmentsTotal = ($typeLengthFinishAdjust ?? 0) + (is_numeric($addons_total) ? $addons_total : 0);
        // Final price should match what's stored in the database (which includes weaving addon or $80 base)
        $finalPrice = $final_price ?? $booking->final_price ?? round(($basePrice ?? 0) + $adjustmentsTotal + $weavingAddon, 2);
      @endphp

      <div class="price-box">
        <div class="price-row">
          <span class="price-label">Base</span>
          <span class="price-value">{{ isset($basePrice) ? sprintf('$%.2f', $basePrice) : '—' }}</span>
        </div>
        @if($hasWeavingAddon)
        <div class="price-row">
          <span class="price-label">Weaving Add-on</span>
          <span class="price-value">{{ sprintf('$%.2f', $weavingAddon) }}</span>
        </div>
        @endif
        @if(($typeLengthFinishAdjust ?? 0) > 0 || (is_numeric($addons_total) && $addons_total > 0))
        <div class="price-row">
          <span class="price-label">Adjustments</span>
          <span class="price-value">{{ sprintf('$%.2f', ($typeLengthFinishAdjust ?? 0) + (is_numeric($addons_total) ? $addons_total : 0)) }}</span>
        </div>
        @endif
        <div class="price-row">
          <span class="price-label">Total</span>
          <span class="price-value">{{ isset($finalPrice) ? sprintf('$%.2f', $finalPrice) : '—' }}</span>
        </div>
      </div>

      @php
        $date = isset($booking->appointment_date) ? $booking->appointment_date->format('Y-m-d') : null;
        $time = $booking->appointment_time ?? null;
        $tz = config('app.timezone') ?: 'America/Toronto';
        $gcal = null;
        if ($date && $time) {
            try {
                $start = \Carbon\Carbon::parse($date . ' ' . $time, $tz);
                $duration = (int) ($booking->service_duration_minutes ?? 90);
                $end = $start->copy()->addMinutes($duration);
                
                // Format dates for Google Calendar (YYYYMMDDTHHMMSSZ format in UTC)
                $startUtc = $start->utc()->format('Ymd\THis\Z');
                $endUtc = $end->utc()->format('Ymd\THis\Z');
                
                // Build Google Calendar URL with proper encoding
                $title = ($booking->service ?? 'Appointment') . ' - ' . ($confirmation_number ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT)));
                $details = 'Booking ID: ' . ($confirmation_number ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT))) . "\n";
                $details .= 'Customer: ' . ($booking->name ?? '') . "\n";
                $details .= 'Phone: ' . ($booking->phone ?? '') . "\n";
                if ($booking->email) {
                    $details .= 'Email: ' . $booking->email . "\n";
                }
                $location = 'Dabs Beauty Touch';
                
                // Build Google Calendar URL
                $gcal = 'https://calendar.google.com/calendar/render?' . http_build_query([
                    'action' => 'TEMPLATE',
                    'text' => $title,
                    'dates' => $startUtc . '/' . $endUtc,
                    'details' => $details,
                    'location' => $location,
                    'sf' => 'true',
                    'output' => 'xml'
                ]);
            } catch (\Exception $e) { 
                $gcal = null;
            }
        }
      @endphp

      @if($gcal)
      <div style="text-align: center; margin: 20px 0;">
        <a href="{{ $gcal }}" target="_blank" rel="noopener" class="btn btn-secondary">Add to Google Calendar</a>
      </div>
      @endif

      <div class="reminder">
        <strong>Reminder:</strong> Please arrive on time for your appointment.
      </div>

      <!-- Signature -->
      <div class="signature">
        <p style="margin: 0; color: #4a5568;">Best regards,<br>
        <strong style="color: #0b3a66;"> Dabs Beauty Touch</strong></p>
      </div>
    </div>

    <div class="footer">
      <h4>Stay Connected</h4>
      <p>Follow us for updates, styling inspiration, and special offers:</p>
      {!! \App\Helpers\SocialLinks::render() !!}
      <p style="margin-top: 16px;">Thanks,<br><strong>Dabs Beauty Touch</strong></p>
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>

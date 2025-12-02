<!doctype html>
    @php
      // Prefer breakdown values provided by the notification
      $displayBase = $basePrice ?? ($booking->base_price ?? 0);
      $displayLengthAdjust = $length_adjust ?? ($booking->length_adjustment ?? 0);
      $displayAddons = $addons_total ?? 0;
      // If addons_total not provided, try to parse booking->kb_extras
      if(empty($displayAddons) && !empty($booking->kb_extras)){
        $ex = $booking->kb_extras;
        $sum = 0;
        if(is_string($ex) && preg_match('/^\d+(?:\.\d+)?(,\d+(?:\.\d+)?)*$/', $ex)){
          foreach(explode(',', $ex) as $n) $sum += floatval($n);
        } else {
          $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
          foreach(explode(',', $ex) as $it){ $it = trim($it); if(isset($addonMap[$it])) $sum += $addonMap[$it]; }
        }
        $displayAddons = $sum;
      }
      $displayAdjustmentsTotal = ($displayLengthAdjust ?? 0) + ($displayAddons ?? 0);
      $displayFinal = $final_price ?? $computedTotal ?? $booking->final_price ?? round($displayBase + $displayLengthAdjust + $displayAddons, 2);
    @endphp
    <li><strong>Base price:</strong> {{ isset($displayBase) ? sprintf('$%.2f', $displayBase) : '—' }}</li>
    <li><strong>Adjustment:</strong> {{ sprintf('$%.2f', $displayLengthAdjust) }}</li>
    <li><strong>Add-ons:</strong> {{ sprintf('$%.2f', $displayAddons) }}</li>
    <li><strong>Final price:</strong> {{ isset($displayFinal) ? sprintf('$%.2f', $displayFinal) : '—' }}</li>
      </div>

      <p class="muted">A new booking was placed. Details below.</p>

      <table width="100%" cellpadding="6" style="border-collapse:collapse;margin-top:6px;">
        <tr style="background:#f8fafc;"><td style="width:40%;font-weight:700;">Booking ID</td><td>{{ $formattedId ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT)) }}</td></tr>
        <tr><td style="font-weight:700;">Name</td><td>{{ $booking->name ?? 'N/A' }}</td></tr>
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Email</td><td>{{ $booking->email ?? 'N/A' }}</td></tr>
        <tr><td style="font-weight:700;">Phone</td><td>{{ $booking->phone ?? 'N/A' }}</td></tr>
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Service</td><td>{{ $booking->service ?? 'N/A' }}</td></tr>
      </table>

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

        // Determine authoritative pricing values
        $basePrice = $booking->base_price ?? ($selector_base ?? null);
        $lengthAdjust = $booking->length_adjustment ?? ($selector_adjust ?? 0);
        $addons = $selector_addons ?? null;
        if((is_null($addons) || $addons == 0) && !empty($booking->kb_extras)){
            if(is_string($booking->kb_extras) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $booking->kb_extras)){
                $addons = array_sum(array_map('floatval', explode(',', $booking->kb_extras)));
            } else {
                $addons = 0;
            }
        }
        $adjustmentsTotal = ($lengthAdjust ?? 0) + ($addons ?? 0);
        $finalPrice = $booking->final_price ?? ($computedTotal ?? null);
      @endphp

      <h4 style="margin-top:16px;margin-bottom:8px;color:#0b3a66;">Details</h4>
      <table width="100%" cellpadding="6" style="border-collapse:collapse;">
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Braid Type</td><td>{{ $braidType ?? '—' }}</td></tr>
        @if(!$hideLengthFinish)
          <tr><td style="font-weight:700;">Finish</td><td>{{ $finishVal ?? '—' }}</td></tr>
          <tr style="background:#f8fafc;"><td style="font-weight:700;">Hair Length</td><td>{{ $lengthVal ?? '—' }}</td></tr>
        @endif
        <tr><td style="font-weight:700;">Add-ons</td><td>{{ $extrasVal ?: 'None' }}</td></tr>
      </table>

      <h4 style="margin-top:12px;margin-bottom:8px;color:#0b3a66;">Price Summary</h4>
      <table width="100%" cellpadding="6" style="border-collapse:collapse;">
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Base price</td><td>{{ isset($basePrice) ? sprintf('$%.2f', $basePrice) : '—' }}</td></tr>
        <tr><td style="font-weight:700;">Adjustments / Add-ons</td><td>{{ sprintf('$%.2f', $adjustmentsTotal) }}</td></tr>
        <tr style="background:#f8fafc;font-size:18px;font-weight:800;"><td style="font-weight:800;">Final price</td><td>{{ isset($finalPrice) ? sprintf('$%.2f', $finalPrice) : '—' }}</td></tr>
      </table>

      <p style="margin-top:14px;">Quick actions:</p>
      <a class="cta" href="{{ url('/admin/bookings/' . ($booking->id ?? '')) }}">Open booking in admin</a>

      <p style="margin-top:18px; font-size:13px; color:#6c757d;">This is an automated message.</p>
    </div>
</body>
</html>

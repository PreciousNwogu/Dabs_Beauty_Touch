@php ob_start(); @endphp
<!doctype html>
    @php
      // Prefer the centralized breakdown if provided by the Notification
      $bd = $breakdown ?? [];
      $displayBase = $bd['resolved_base'] ?? $booking->base_price ?? 0;
      $displayLengthAdjust = $bd['length_adjust'] ?? $booking->length_adjustment ?? 0;
      $displayAddons = $bd['addons_total'] ?? null;

      // If addons_total not provided, try to parse booking->kb_extras
      if((is_null($displayAddons) || $displayAddons == 0) && !empty($booking->kb_extras)){
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
      $displayFinal = $bd['final_price'] ?? $booking->final_price ?? round($displayBase + $displayLengthAdjust + $displayAddons, 2);
    @endphp

    <li><strong>Base price:</strong> {{ isset($displayBase) ? sprintf('$%.2f', $displayBase) : '—' }}</li>
    <li><strong>Adjustment:</strong> {{ sprintf('$%.2f', $displayLengthAdjust) }}</li>
    <li><strong>Add-ons:</strong> {{ sprintf('$%.2f', $displayAddons ?? 0) }}</li>
    <li><strong>Final price:</strong> {{ isset($displayFinal) ? sprintf('$%.2f', $displayFinal) : '—' }}</li>
      </div>

      <p class="muted">A new booking has been received. Details are shown below.</p>

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

        $sf = $selector_friendly ?? ($breakdown['selector_friendly'] ?? null);
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

        // Determine authoritative pricing values - prefer breakdown
        $bd = $breakdown ?? [];
        $basePrice = $bd['resolved_base'] ?? $booking->base_price ?? null;
        $lengthAdjust = $bd['length_adjust'] ?? $booking->length_adjustment ?? 0;
        $addons = $bd['addons_total'] ?? null;
        if((is_null($addons) || $addons == 0) && !empty($booking->kb_extras)){
          if(is_string($booking->kb_extras) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $booking->kb_extras)){
            $addons = array_sum(array_map('floatval', explode(',', $booking->kb_extras)));
          } else {
            $addons = 0;
          }
        }
        $adjustmentsTotal = ($lengthAdjust ?? 0) + ($addons ?? 0);
        $finalPrice = $bd['final_price'] ?? $booking->final_price ?? null;
      @endphp

      <h4 style="margin-top:16px;margin-bottom:8px;color:#0b3a66;">Details</h4>
      <table width="100%" cellpadding="6" style="border-collapse:collapse;">
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Braid Type</td><td>{{ $braidType ?? '—' }}</td></tr>
        @if(!$hideLengthFinish)
          <tr><td style="font-weight:700;">Finish</td><td>{{ $finishVal ?? '—' }}</td></tr>
          <tr style="background:#f8fafc;"><td style="font-weight:700;">Hair Length</td>
            <td>
              @if(!empty($booking->hair_mask_option))
                -
              @else
                {{ $lengthVal ?? '—' }}
              @endif
            </td>
          </tr>
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

      <div style="margin-top:18px;border-top:1px solid #eef2f6;padding-top:12px;font-size:13px;color:#6c757d;">
        <p style="margin:6px 0 8px 0;font-weight:700;color:#0b3a66;">Stay connected</p>
        <p style="margin:0;">Customer-facing profiles for reference:</p>
        <p style="margin:8px 0 0 0;">
          <a href="https://www.instagram.com/dabs_beauty_touch?igsh=MXYycGNraGxwem5tZw%3D%3D&utm_source=qr" style="margin-right:12px;color:#0b3a66;text-decoration:none;">Instagram</a>
          <a href="https://wa.me/13432548848" style="color:#0b3a66;text-decoration:none;">WhatsApp</a>
        </p>
      </div>

      <p style="margin-top:12px; font-size:13px; color:#6c757d;">This is an automated message for staff. Reply to the admin inbox for assistance.</p>
      </div>
    @php
      $html = ob_get_clean();
      echo preg_replace('/\s+/', ' ', trim($html));
    @endphp
  </body>
  </html>

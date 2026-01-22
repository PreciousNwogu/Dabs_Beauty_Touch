@php ob_start(); @endphp
<!doctype html>
    @php
      // Prefer the centralized breakdown if provided by the Notification
      $bd = $breakdown ?? [];
      $displayBase = $bd['resolved_base'] ?? $booking->base_price ?? 0;

      // For kids bookings, use adjustments_total from breakdown which includes type + length + finish
      // Otherwise fall back to length_adjust or selector_adjust
      $displayTypeLengthFinishAdjust = $bd['adjustments_total'] ?? $bd['selector_adjust'] ?? $bd['length_adjust'] ?? $booking->length_adjustment ?? $booking->kb_length_adjustment ?? 0;

      // Determine addons from breakdown or booking extras
      $displayAddons = $bd['addons_total'] ?? $bd['selector_addons'] ?? null;
      if((is_null($displayAddons) || $displayAddons == 0) && !empty($booking->kb_extras)){
        $ex = $booking->kb_extras;
        $sum = 0;
        if(is_string($ex) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $ex)){
          foreach(explode(',', $ex) as $n) $sum += floatval($n);
        } else {
          $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
          foreach(explode(',', $ex) as $it){ $it = trim($it); if(isset($addonMap[$it])) $sum += $addonMap[$it]; }
        }
        $displayAddons = $sum;
      }

      // Check for hair mask weaving addon
      $displayWeavingAddon = 0.00;
      if (!empty($booking->hair_mask_option)) {
        $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$booking->hair_mask_option)));
        if (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) {
          $displayWeavingAddon = 30.00;
          // If length_adjustment contains the weaving addon, subtract it to get pure length adjustment
          if ($displayTypeLengthFinishAdjust > 0 && $displayTypeLengthFinishAdjust == $displayWeavingAddon) {
            $displayTypeLengthFinishAdjust = 0.00;
          }
        }
      }

      // Adjustments total = type + length + finish adjustments + addons + weaving addon (matches UI)
      $displayAdjustmentsTotal = ($displayTypeLengthFinishAdjust ?? 0) + ($displayAddons ?? 0) + $displayWeavingAddon;
      $displayFinal = $bd['final_price'] ?? $booking->final_price ?? round($displayBase + $displayAdjustmentsTotal, 2);
    @endphp

      <p class="muted">A new booking has been received. Details are shown below.</p>

      <table width="100%" cellpadding="6" style="border-collapse:collapse;margin-top:6px;">
        <tr style="background:#f8fafc;"><td style="width:40%;font-weight:700;">Booking ID</td><td>{{ $formattedId ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT)) }}</td></tr>
        <tr><td style="font-weight:700;">Name</td><td>{{ $booking->name ?? 'N/A' }}</td></tr>
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Email</td><td>{{ $booking->email ?? 'N/A' }}</td></tr>
        <tr><td style="font-weight:700;">Phone</td><td>{{ $booking->phone ?? 'N/A' }}</td></tr>
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Service</td><td>
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
        </td></tr>
        <tr><td style="font-weight:700;">Appointment Date</td><td>
          @if($booking->appointment_date)
            {{ \Carbon\Carbon::parse($booking->appointment_date)->format('F j, Y') }}
          @else
            N/A
          @endif
        </td></tr>
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Appointment Time</td><td>
          @if($booking->appointment_time)
            {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
          @else
            N/A
          @endif
        </td></tr>
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

        // Determine authoritative pricing values - prefer breakdown and selector-aware fields
        $bd = $breakdown ?? [];
        $basePrice = $bd['resolved_base'] ?? $booking->base_price ?? null;

        // For kids bookings, use adjustments_total from breakdown which includes type + length + finish
        // Otherwise fall back to length_adjust or selector_adjust
        $typeLengthFinishAdjust = $bd['adjustments_total'] ?? $bd['selector_adjust'] ?? $bd['length_adjust'] ?? $booking->length_adjustment ?? $booking->kb_length_adjustment ?? 0;

        // Determine addons from breakdown or booking extras (numeric CSV or named ids)
        $addons = $bd['addons_total'] ?? $bd['selector_addons'] ?? null;
        if((is_null($addons) || $addons == 0)){
          if(!empty($booking->kb_extras)){
            if(is_string($booking->kb_extras) && preg_match('/^\d+(?:\.\d+)?(?:,\d+(?:\.\d+)?)*$/', $booking->kb_extras)){
              $addons = array_sum(array_map('floatval', explode(',', $booking->kb_extras)));
            } else {
              $addonMap = ['kb_add_detangle'=>15,'kb_add_beads'=>10,'kb_add_beads_full'=>15,'kb_add_extension'=>20,'kb_add_rest'=>5];
              $sum = 0;
              foreach(explode(',', $booking->kb_extras) as $it){ $it = trim($it); if(isset($addonMap[$it])) $sum += $addonMap[$it]; }
              $addons = $sum;
            }
          } elseif(isset($booking->kb_final_price) && isset($booking->kb_base_price)){
            // Fallback: use persisted kids final/base delta minus kb length adjustment
            $addons = round(($booking->kb_final_price - $booking->kb_base_price) - ($booking->kb_length_adjustment ?? 0), 2);
          }
        }

        // Check for hair mask with weave - now priced as flat $80 (base price is $80, no separate addon)
        $weavingAddon = 0.00;
        $hasWeavingAddon = false;
        if (!empty($booking->hair_mask_option)) {
          $maskOptionNormalized = strtolower(trim(str_replace(['_', ' '], '-', (string)$booking->hair_mask_option)));
          if (str_contains($maskOptionNormalized, 'weave') || str_contains($maskOptionNormalized, 'weav')) {
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

        // Stitch braids tiny rows (>10) add-on (+$20)
        $stitchAddon = 0.00;
        $hasStitchAddon = false;
        $svcLower = strtolower((string)($booking->service ?? ''));
        $isStitchSvc = str_contains($svcLower, 'stitch');
        $stitchChoice = $booking->stitch_rows_option ?? null;
        if ($isStitchSvc && $stitchChoice === 'more_than_ten') {
          $stitchAddon = 20.00;
          $hasStitchAddon = true;
        }

        // Adjustments total = type + length + finish adjustments + addons + weaving addon + stitch addon (matches UI)
        $adjustmentsTotal = ($typeLengthFinishAdjust ?? 0) + ($addons ?? 0) + $weavingAddon + $stitchAddon;
        $finalPrice = $bd['final_price'] ?? $booking->final_price ?? round(($basePrice ?? 0) + $adjustmentsTotal, 2);
      @endphp

      <h4 style="margin-top:16px;margin-bottom:8px;color:#0b3a66;">Details</h4>
      <table width="100%" cellpadding="6" style="border-collapse:collapse;">
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Braid Type</td><td>{{ $braidType ?? '—' }}</td></tr>
        @if($isStitchSvc)
          <tr>
            <td style="font-weight:700;">Stitch rows</td>
            <td>
              @if($stitchChoice === 'more_than_ten')
                More than 10 rows (tiny) +$20
              @elseif($stitchChoice === 'ten_or_less')
                8–10 rows (base price)
              @else
                —
              @endif
            </td>
          </tr>
        @endif
        @if(!$hideLengthFinish)
          <tr><td style="font-weight:700;">Finish</td><td>{{ $finishVal ?? '—' }}</td></tr>
        @endif
        <tr><td style="font-weight:700;">Add-ons</td><td>{{ $extrasVal ?: 'None' }}</td></tr>
      </table>

      <h4 style="margin-top:12px;margin-bottom:8px;color:#0b3a66;">Price Summary</h4>
      <table width="100%" cellpadding="6" style="border-collapse:collapse;">
        <tr style="background:#f8fafc;"><td style="font-weight:700;">Base price</td><td>{{ isset($basePrice) ? sprintf('$%.2f', $basePrice) : '—' }}</td></tr>
        @if($hasWeavingAddon)
        <tr><td style="font-weight:700;">Weaving Add-on</td><td>{{ sprintf('$%.2f', $weavingAddon) }}</td></tr>
        @endif
        @if($hasStitchAddon)
        <tr><td style="font-weight:700;">Tiny stitch (&gt;10 rows)</td><td>{{ sprintf('$%.2f', $stitchAddon) }}</td></tr>
        @endif
        @if(($typeLengthFinishAdjust ?? 0) > 0 || ($addons ?? 0) > 0)
        <tr style="{{ $hasWeavingAddon ? 'background:#f8fafc;' : '' }}"><td style="font-weight:700;">Adjustments / Add-ons</td><td>{{ sprintf('$%.2f', ($typeLengthFinishAdjust ?? 0) + ($addons ?? 0)) }}</td></tr>
        @endif
        <tr style="background:#f8fafc;font-size:18px;font-weight:800;"><td style="font-weight:800;">Final price</td><td>{{ isset($finalPrice) ? sprintf('$%.2f', $finalPrice) : '—' }}</td></tr>
        {{-- Debugging visibility removed per request --}}
      </table>

      <p style="margin-top:14px;">Quick actions:</p>
      @php
        $bookingId = $booking->id ?? null;
        $code = $booking->confirmation_code ?? null;
        // Prefer the public confirmation link so it works from email without admin login.
        $publicUrl = ($bookingId && $code)
          ? secure_url('/bookings/confirm/' . $bookingId . '/' . $code)
          : null;
        // Fallback: admin view (requires login)
        $adminUrl = $bookingId ? secure_url('/admin/bookings/' . $bookingId) : null;
      @endphp

      <div style="margin-top:10px;">
        <a href="{{ $publicUrl ?: ($adminUrl ?: '#') }}"
           style="display:block;width:100%;text-align:center;background:#ff6600;color:#ffffff !important;text-decoration:none;padding:14px 16px;border-radius:12px;font-weight:800;font-size:16px;letter-spacing:0.2px;">
          Edit Booking
        </a>
        <a href="{{ $publicUrl ?: ($adminUrl ?: '#') }}"
           style="display:block;width:100%;text-align:center;background:#0b3a66;color:#ffffff !important;text-decoration:none;padding:12px 16px;border-radius:12px;font-weight:800;font-size:14px;margin-top:10px;">
          View Booking Details
        </a>
      </div>

      <div style="margin-top:18px;border-top:1px solid #eef2f6;padding-top:12px;font-size:13px;color:#6c757d;">
        <p style="margin:6px 0 8px 0;font-weight:700;color:#0b3a66;">Stay connected</p>
        <p style="margin:0;">Customer-facing profiles for reference:</p>
        {!! \App\Helpers\SocialLinks::render() !!}
      </div>

      <p style="margin-top:12px; font-size:13px; color:#6c757d;">This is an automated message for staff. Reply to the admin inbox for assistance.</p>
      </div>
    @php
      $html = ob_get_clean();
      echo preg_replace('/\s+/', ' ', trim($html));
    @endphp
  </body>
  </html>

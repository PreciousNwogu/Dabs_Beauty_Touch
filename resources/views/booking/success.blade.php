<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Booking Confirmed - Dab's Beauty Touch | Appointment Success</title>
    <meta name="title" content="Booking Confirmed - Dab's Beauty Touch | Appointment Success">
    <meta name="description" content="Your appointment has been successfully booked. Booking confirmation details and next steps for your hair braiding service at Dab's Beauty Touch.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="{{ url('/booking/success') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/booking/success') }}">
    <meta property="og:title" content="Booking Confirmed - Dab's Beauty Touch">
    <meta property="og:description" content="Your appointment has been successfully booked.">
    <meta property="og:image" content="{{ asset('images/logo.jpg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ url('/booking/success') }}">
    <meta name="twitter:title" content="Booking Confirmed - Dab's Beauty Touch">
    <meta name="twitter:description" content="Your appointment has been successfully booked.">
    <meta name="twitter:image" content="{{ asset('images/logo.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            margin: auto;
        }
        .success-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
        }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        .booking-details {
            background: #f8f9fa;
            padding: 1.5rem;
            margin: 1.5rem;
            border-radius: 15px;
            border-left: 5px solid #28a745;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #212529;
            font-weight: 500;
        }
        .btn-home {
            background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s ease;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            @php
                // When accessed via /bookings/confirm/{id}/{code}, render as a booking details page
                // (so admin/customer don't see the "Booking Confirmed!" marketing success message).
                $isDetailsMode = isset($confirmId) && isset($confirmCode);
                // Read-only mode: hide the modify form (used by admin/staff email "View Booking Details")
                $isReadOnly = $isDetailsMode && request()->query('view') === '1';
            @endphp
            <div class="success-header" style="{{ $isDetailsMode ? 'background: linear-gradient(135deg, #0ea5e9 0%, #4a8bc2 100%);' : '' }}">
                <div class="success-icon" style="{{ $isDetailsMode ? 'animation:none;' : '' }}">
                    <i class="fas {{ $isDetailsMode ? 'fa-receipt' : 'fa-check-circle' }}"></i>
                </div>
                <h1 class="mb-3">{{ $isDetailsMode ? 'Booking Details' : 'Booking Confirmed!' }}</h1>
                <p class="lead mb-0">
                    {{ $isDetailsMode ? 'View and manage your booking information' : 'Your appointment has been successfully booked' }}
                </p>
            </div>

            <div class="p-4">
                <div class="booking-details">
                    <h5 class="mb-3 text-success">
                        <i class="fas fa-calendar-check me-2"></i>
                        Appointment Details
                    </h5>

                    @if($isDetailsMode)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This is your booking details page. You can edit supported fields below (length / braid type) and the price will be recalculated automatically.
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-info-circle me-2"></i>
                            Your booking has been confirmed! <br>
                            All booking details (Booking ID, Confirmation Code and pricing) have been emailed to you. Please check your email for confirmation.
                        </div>
                    @endif
                </div>

                @if(isset($bookingDetails) && is_array($bookingDetails) && !empty($bookingDetails['confirmation_code']))
                    @php
                        $bd = $bookingDetails;
                        $fmtMoney = function($v){
                            if ($v === null || $v === '') return '—';
                            if (!is_numeric($v)) return (string)$v;
                            return '$' . number_format((float)$v, 2);
                        };
                        $isKids = !empty($bd['kb_braid_type']) || !empty($bd['kb_length']) || (isset($bd['service']) && stripos((string)$bd['service'], 'kids') !== false);
                        $serviceNameLower = strtolower((string)($bd['service'] ?? ''));
                        $isBraidService = (
                            str_contains($serviceNameLower, 'braid') ||
                            str_contains($serviceNameLower, 'braids') ||
                            str_contains($serviceNameLower, 'knotless') ||
                            str_contains($serviceNameLower, 'stitch') ||
                            str_contains($serviceNameLower, 'boho')
                        );
                        $currentLen = $bd['kb_length'] ?? $bd['length'] ?? null;
                    @endphp

                    @if(session('message'))
                        <div class="alert alert-success">
                            {!! e(session('message')) !!}
                        </div>
                    @endif
                    @if(session('booking_error') && session('error_message'))
                        <div class="alert alert-danger">
                            {!! e(session('error_message')) !!}
                        </div>
                    @endif

                    <div class="booking-details">
                        <h6 class="mb-3 text-primary">
                            <i class="fas fa-receipt me-2"></i>
                            Your Booking Information
                        </h6>
                        <div class="detail-row">
                            <div class="detail-label">Booking ID</div>
                            <div class="detail-value">{{ $bd['booking_id'] ?? ('BK' . str_pad($bd['id'] ?? 0, 6, '0', STR_PAD_LEFT)) }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Confirmation Code</div>
                            <div class="detail-value">{{ $bd['confirmation_code'] ?? '—' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Service</div>
                            <div class="detail-value">{{ $bd['service'] ?? '—' }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Length</div>
                            <div class="detail-value">{{ $currentLen ? ucwords(str_replace(['_','-'], ' ', $currentLen)) : '—' }}</div>
                        </div>
                        @if(isset($bd['appointment_date']) || isset($bd['appointment_time']))
                            @php
                                $formattedTime = null;
                                try {
                                    if (!empty($bd['appointment_time'])) {
                                        $formattedTime = \Carbon\Carbon::parse($bd['appointment_time'])->format('g:i A');
                                    }
                                } catch (\Throwable $e) {
                                    $formattedTime = $bd['appointment_time'] ?? null;
                                }
                            @endphp
                            <div class="detail-row">
                                <div class="detail-label">Date / Time</div>
                                <div class="detail-value">
                                    {{ $bd['appointment_date'] ?? '—' }}{{ !empty($formattedTime) ? (' at ' . $formattedTime) : '' }}
                                </div>
                            </div>
                        @endif
                        <div class="detail-row">
                            <div class="detail-label">Final Price</div>
                            <div class="detail-value">{{ $fmtMoney($bd['final_price'] ?? null) }}</div>
                        </div>
                    </div>

                    @php
                        $imgPath = $bd['sample_picture'] ?? ($booking->sample_picture ?? null);
                        $imgUrl = null;
                        if ($imgPath) {
                            // stored via disk('public') as sample_pictures/...
                            $imgUrl = asset('storage/' . ltrim($imgPath, '/'));
                        }
                    @endphp
                    @if($imgUrl)
                        <div class="booking-details">
                            <h6 class="mb-3 text-primary">
                                <i class="fas fa-image me-2"></i>
                                Reference Image
                            </h6>
                            <a href="{{ $imgUrl }}" target="_blank" rel="noopener" style="text-decoration:none;">
                                <img src="{{ $imgUrl }}" alt="Reference image" style="width:100%;max-width:520px;border-radius:14px;border:1px solid #e9ecef;display:block;">
                            </a>
                            <div class="form-text mt-2">Tap the image to open full size.</div>
                        </div>
                    @endif

                    @if(!$isReadOnly)
                        <div class="booking-details">
                            <h6 class="mb-3 text-warning">
                                <i class="fas fa-pen-to-square me-2"></i>
                                Modify your booking (length / braid type)
                            </h6>
                            <div class="alert alert-info">
                                <i class="fas fa-circle-info me-2"></i>
                                Changes will automatically recalculate pricing and email an update to you and the admin.
                            </div>

                        @php
                            $editId = $confirmId ?? ($bd['id'] ?? null);
                            $editCode = $confirmCode ?? ($bd['confirmation_code'] ?? null);
                            // Force HTTPS for the modify POST to avoid browser “not secure” warnings on staging
                            // when behind a proxy / forwarded proto is misdetected.
                            $modifyUrl = ($editId && $editCode)
                                ? secure_url('/bookings/confirm/' . $editId . '/' . $editCode . '/modify')
                                : '#';
                        @endphp
                        <form method="POST" action="{{ $modifyUrl }}">
                            @csrf

                            @if($isKids)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label detail-label">Braid type</label>
                                        <select class="form-select" name="kb_braid_type">
                                            <option value="">Keep current</option>
                                            @php
                                                $opts = ['protective'=>'Protective style','cornrows'=>'Cornrows','knotless_small'=>'Knotless (small)','knotless_med'=>'Knotless (medium)','box_small'=>'Box (small)','box_med'=>'Box (medium)','stitch'=>'Stitch'];
                                                $cur = $bd['kb_braid_type'] ?? null;
                                            @endphp
                                            @foreach($opts as $k=>$label)
                                                <option value="{{ $k }}" {{ $cur === $k ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label detail-label">Length</label>
                                        <select class="form-select" name="kb_length">
                                            <option value="">Keep current</option>
                                            @php $kidsLens = ['shoulder'=>'Shoulder','armpit'=>'Armpit','mid_back'=>'Mid Back','waist'=>'Waist']; @endphp
                                            @foreach($kidsLens as $k=>$label)
                                                <option value="{{ $k }}" {{ ($bd['kb_length'] ?? null) === $k ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                @if($isBraidService)
                                    <div class="mb-3">
                                        <label class="form-label detail-label">Braid type / style</label>
                                        @php
                                            $allowedBraidServices = [
                                                'Small Knotless Braids',
                                                'Smedium Knotless Braids',
                                                'Medium Knotless Braids',
                                                'Jumbo Knotless Braids',
                                                '8–10 Rows Stitch Braids',
                                                'Smedium Boho Braids',
                                            ];
                                            $curSvc = $bd['service'] ?? null;
                                        @endphp
                                        <select class="form-select" name="service">
                                            <option value="">Keep current</option>
                                            @foreach($allowedBraidServices as $svc)
                                                <option value="{{ $svc }}" {{ $curSvc === $svc ? 'selected' : '' }}>{{ $svc }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form-text">Changing braid style will automatically recalculate pricing.</div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label detail-label">Length</label>
                                    <select class="form-select" name="length">
                                        <option value="">Keep current</option>
                                        @php
                                            $lens = ['neck'=>'Neck','shoulder'=>'Shoulder','armpit'=>'Armpit','bra_strap'=>'Bra strap','mid_back'=>'Mid Back','waist'=>'Waist','hip'=>'Hip','tailbone'=>'Tailbone','classic'=>'Classic'];
                                            $cur = $bd['length'] ?? null;
                                        @endphp
                                        @foreach($lens as $k=>$label)
                                            <option value="{{ $k }}" {{ $cur === $k ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 25px; font-weight: 700;">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            </form>
                        </div>
                    @endif
                @endif

                <div style="background:linear-gradient(135deg,#fff7ed,#fff3e0);border:2px solid #ff6600;border-radius:14px;padding:20px;margin:20px 0;">
                    <h6 style="color:#ff6600;font-weight:800;margin-bottom:12px;">
                        <i class="fas fa-credit-card me-2"></i>Deposit Required to Confirm Your Appointment
                    </h6>
                    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:14px;">
                        <div style="background:linear-gradient(135deg,#ff6600,#ff8533);color:#fff;border-radius:10px;padding:12px 24px;text-align:center;min-width:100px;">
                            <div style="font-size:1.6rem;font-weight:800;">$20.00</div>
                            <div style="font-size:0.75rem;opacity:0.9;">Deposit due</div>
                        </div>
                        <div style="font-size:0.92rem;color:#555;flex:1;min-width:180px;">
                            Your booking is <strong>pending</strong> until the $20 deposit is received.<br>
                            The deposit is <strong>non-refundable</strong> once confirmed.
                        </div>
                    </div>
                    <div style="font-size:0.9rem;color:#333;margin-bottom:8px;"><strong>How to pay:</strong></div>
                    <ol style="font-size:0.88rem;color:#444;line-height:1.9;margin:0 0 12px 0;padding-left:20px;">
                        <li>Contact us via phone, email, or WhatsApp</li>
                        <li>Make a <strong>bank transfer</strong> of $20.00</li>
                        <li>Send us your payment receipt</li>
                        <li>We'll confirm your appointment within 24 hours</li>
                    </ol>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <a href="tel:+13432548848" class="btn btn-sm" style="background:#030f68;color:#fff;border-radius:8px;font-weight:600;"><i class="fas fa-phone me-1"></i>(343) 254-8848</a>
                        <a href="mailto:info@dabsbeautytouch.com" class="btn btn-sm" style="background:#030f68;color:#fff;border-radius:8px;font-weight:600;"><i class="fas fa-envelope me-1"></i>Email Us</a>
                        <a href="https://wa.me/13432548848" target="_blank" rel="noopener" class="btn btn-sm" style="background:#25d366;color:#fff;border-radius:8px;font-weight:600;"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important:</strong> Save your Booking ID and Confirmation Code. Your appointment is pending until the $20 deposit is received and verified.
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn-home me-3">
                        <i class="fas fa-home me-2"></i>
                        Back to Home
                    </a>
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-phone me-1"></i>
                                Questions? Call us at <strong>(343) 254-8848</strong>
                            </small>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if(isset($booking))
            Booking #{{ $booking->id }} - Dab's Beauty Touch
        @else
            Custom Request #{{ $customRequest->id }} - Dab's Beauty Touch
        @endif
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fb; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container { margin-top: 40px; max-width: 1100px; }
        .sample-img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .meta { color: #6c757d; }
        .section-title { color: #030f68; font-weight: 700; font-size: 1.05rem; margin: 18px 0 10px; }
        .form-label { font-weight: 600; color: #334155; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-link mb-3">&larr; Back to dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    @endif

    @if(isset($booking) && $booking)
        @php
            $timeValue = $booking->appointment_time;
            try { $timeValue = $booking->appointment_time ? \Carbon\Carbon::parse($booking->appointment_time)->format('H:i') : ''; } catch (\Throwable $e) {}
            $dateValue = $booking->appointment_date ? $booking->appointment_date->format('Y-m-d') : '';
            $isKids = stripos((string) $booking->service, 'kids') !== false || !empty($booking->kb_braid_type) || !empty($booking->kb_length);
            $lengths = ['neck'=>'Neck','shoulder'=>'Shoulder','armpit'=>'Armpit','bra_strap'=>'Bra strap','mid_back'=>'Mid back','waist'=>'Waist','hip'=>'Hip','tailbone'=>'Tailbone','classic'=>'Classic'];
            $kidsTypes = ['protective'=>'Natural Hair Twist','cornrows'=>'Cornrows','cornrow_weave'=>'Cornrow Weave','knotless_small'=>'Knotless Small','knotless_med'=>'Knotless Medium','box_small'=>'Box Small','box_med'=>'Box Medium','stitch'=>'Stitch','half_weave_braid'=>'1/2 Weave & 1/2 Braid','half_weave_crotchet'=>'1/2 Weave & 1/2 Crotchet','crotchet_style'=>'Crotchet Style'];
        @endphp
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Booking Details — #{{ sprintf('BK%06d', $booking->id) }}</h4>
                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning text-dark' : 'secondary') }}">{{ ucfirst($booking->status) }}</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.update', ['id' => $booking->id]) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <div class="section-title">Customer</div>
                            <div class="mb-2">
                                <label class="form-label">Name</label>
                                <input class="form-control" name="name" value="{{ old('name', $booking->name) }}" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email', $booking->email === 'no-email@example.com' ? '' : $booking->email) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" name="phone" value="{{ old('phone', $booking->phone) }}">
                                </div>
                            </div>

                            <div class="section-title">Appointment</div>
                            <div class="mb-2">
                                <label class="form-label">Service</label>
                                <input class="form-control" name="service" value="{{ old('service', $booking->service) }}">
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Date</label>
                                    <input class="form-control" type="date" name="appointment_date" value="{{ old('appointment_date', $dateValue) }}" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Time</label>
                                    <input class="form-control" type="time" name="appointment_time" value="{{ old('appointment_time', $timeValue) }}" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Length</label>
                                    <select class="form-select" name="length">
                                        <option value="">Not specified</option>
                                        @foreach($lengths as $k => $label)
                                            <option value="{{ $k }}" @selected(old('length', $booking->length) === $k)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Location</label>
                                    <select class="form-select" name="appointment_type" id="adminAppointmentType">
                                        <option value="in-studio" @selected(old('appointment_type', $booking->appointment_type) !== 'mobile')>Stylist location</option>
                                        <option value="mobile" @selected(old('appointment_type', $booking->appointment_type) === 'mobile')>Home service</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Parking</label>
                                    <select class="form-select" name="parking_type">
                                        <option value="">Not provided</option>
                                        <option value="free" @selected(old('parking_type', $booking->parking_type) === 'free')>Free parking</option>
                                        <option value="paid" @selected(old('parking_type', $booking->parking_type) === 'paid')>Paid parking (client covers ticket)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Service Address</label>
                                <input class="form-control" name="address" value="{{ old('address', $booking->address) }}" placeholder="Required for home service">
                            </div>

                            @if($isKids)
                                <div class="section-title">Kids style details</div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Braid type</label>
                                        <select class="form-select" name="kb_braid_type">
                                            <option value="">Not specified</option>
                                            @foreach($kidsTypes as $k => $label)
                                                <option value="{{ $k }}" @selected(old('kb_braid_type', $booking->kb_braid_type) === $k)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Finish</label>
                                        <input class="form-control" name="kb_finish" value="{{ old('kb_finish', $booking->kb_finish) }}">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Kids length</label>
                                        <select class="form-select" name="kb_length">
                                            <option value="">Not specified</option>
                                            @foreach($lengths as $k => $label)
                                                <option value="{{ $k }}" @selected(old('kb_length', $booking->kb_length) === $k)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Extras</label>
                                    <input class="form-control" name="kb_extras" value="{{ old('kb_extras', is_array($booking->kb_extras) ? implode(',', $booking->kb_extras) : $booking->kb_extras) }}">
                                </div>
                            @endif

                            <div class="section-title">Pricing &amp; status</div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Base price</label>
                                    <input class="form-control" type="number" step="0.01" name="base_price" value="{{ old('base_price', $booking->base_price ?? $booking->kb_base_price) }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Length adjustment</label>
                                    <input class="form-control" type="number" step="0.01" name="length_adjustment" value="{{ old('length_adjustment', $booking->length_adjustment ?? $booking->kb_length_adjustment) }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Final price</label>
                                    <input class="form-control" type="number" step="0.01" name="final_price" value="{{ old('final_price', $booking->final_price ?? $booking->kb_final_price) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        @foreach(['pending','confirmed','cancelled','completed'] as $st)
                                            <option value="{{ $st }}" @selected(old('status', $booking->status) === $st)>{{ ucfirst($st) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Payment</label>
                                    <select class="form-select" name="payment_status">
                                        @foreach(['pending'=>'Pending','deposit_paid'=>'Deposit paid','fully_paid'=>'Fully paid'] as $k => $label)
                                            <option value="{{ $k }}" @selected(old('payment_status', $booking->payment_status) === $k)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Customer message</label>
                                <textarea class="form-control" name="message" rows="2">{{ old('message', $booking->message) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Admin notes</label>
                                <textarea class="form-control" name="notes" rows="2">{{ old('notes', $booking->notes) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="background:#030f68; border:none; font-weight:700;">
                                Save booking changes
                            </button>
                        </div>

                        <div class="col-md-5">
                            <div class="section-title">Sample picture</div>
                            @if($booking->sample_picture)
                                <img src="{{ asset('storage/' . $booking->sample_picture) }}" alt="Sample picture" class="sample-img mb-2" id="samplePreview">
                                <div>
                                    <a href="{{ asset('storage/' . $booking->sample_picture) }}" download class="btn btn-sm btn-outline-primary">Download image</a>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="openImageModal()">View larger</button>
                                </div>
                            @else
                                <div class="border rounded p-4 text-center text-muted">
                                    <p class="mb-0">No sample image provided</p>
                                </div>
                            @endif

                            <hr>
                            <h6>Summary</h6>
                            <p class="meta mb-1">Booking ID: {{ sprintf('BK%06d', $booking->id) }}</p>
                            <p class="meta mb-1">Confirmation: {{ $booking->confirmation_code ?: 'N/A' }}</p>
                            <p class="meta mb-1">Created: {{ $booking->created_at ? $booking->created_at->setTimezone('America/Toronto')->format('F j, Y g:i A') : 'N/A' }}</p>
                            @if($booking->hair_mask_option)
                                <p class="meta mb-1">Hair mask option: {{ $booking->hair_mask_option }}</p>
                            @endif
                            @if($booking->stitch_rows_option)
                                <p class="meta mb-1">Stitch rows: {{ $booking->stitch_rows_option }}</p>
                            @endif
                            <input type="hidden" name="hair_mask_option" value="{{ $booking->hair_mask_option }}">
                            <input type="hidden" name="stitch_rows_option" value="{{ $booking->stitch_rows_option }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @elseif(isset($customRequest) && $customRequest)
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Custom Service Request — #{{ $customRequest->id }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <h5>Requester</h5>
                        <p><strong>{{ $customRequest->name }}</strong><br>
                        <span class="meta">{{ $customRequest->email ?: 'No email' }} • {{ $customRequest->phone ?: 'No phone' }}</span></p>

                        <h5>Request Details</h5>
                        <p>
                            <strong>Service:</strong> {{ $customRequest->service ?: 'Custom' }}<br>
                            <strong>Requested Date:</strong> 
                            @if($customRequest->appointment_date)
                                @php
                                    $date = is_string($customRequest->appointment_date) 
                                        ? \Carbon\Carbon::parse($customRequest->appointment_date) 
                                        : $customRequest->appointment_date;
                                @endphp
                                {{ $date->format('F j, Y') }}
                            @else
                                N/A
                            @endif
                            <br>
                            <strong>Requested Time:</strong> {{ $customRequest->appointment_time ?: 'N/A' }}
                        </p>

                        @if($customRequest->message)
                            <h5>Message</h5>
                            <p class="border rounded p-3 bg-light">{{ $customRequest->message }}</p>
                        @endif
                    </div>

                    <div class="col-md-5">
                        <h5>Meta</h5>
                        <p class="meta">Request ID: {{ $customRequest->id }}<br>
                        Status: <span id="custom-status">{{ ucfirst($customRequest->status) }}</span><br>
                        Submitted: {{ $customRequest->created_at ? $customRequest->created_at->setTimezone('America/Toronto')->format('F j, Y g:i A') : 'N/A' }}</p>

                        <div class="d-grid gap-2 mb-4">
                            <button class="btn btn-sm btn-outline-warning" onclick="updateCustomStatus({{ $customRequest->id }}, 'in_progress')">Mark In Progress</button>
                            <button class="btn btn-sm btn-outline-success" onclick="updateCustomStatus({{ $customRequest->id }}, 'handled')">Mark Handled</button>
                        </div>

                        @if($customRequest->converted_booking_id)
                            <div class="alert alert-info mb-0">
                                Already converted to
                                <a href="{{ route('admin.bookings.show', ['id' => $customRequest->converted_booking_id]) }}">
                                    booking #{{ sprintf('BK%06d', $customRequest->converted_booking_id) }}
                                </a>.
                            </div>
                        @else
                            <h5>Create booking</h5>
                            <form method="POST" action="{{ route('admin.custom-requests.convert', $customRequest->id) }}">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $customRequest->name) }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $customRequest->email) }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $customRequest->phone) }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Service</label>
                                    <input type="text" name="service" class="form-control" value="{{ old('service', $customRequest->service ?: 'Custom') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Date</label>
                                    @php
                                        $convertDate = old('appointment_date');
                                        if (! $convertDate && $customRequest->appointment_date) {
                                            try {
                                                $convertDate = \Carbon\Carbon::parse($customRequest->appointment_date)->toDateString();
                                            } catch (\Throwable $e) {
                                                $convertDate = '';
                                            }
                                        }
                                    @endphp
                                    <input type="date" name="appointment_date" class="form-control" value="{{ $convertDate }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Time (24h)</label>
                                    <input type="text" name="appointment_time" class="form-control" placeholder="14:00" value="{{ old('appointment_time', $customRequest->appointment_time) }}" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Type</label>
                                    <select name="appointment_type" class="form-select" required>
                                        <option value="in-studio" @selected(old('appointment_type', 'in-studio') === 'in-studio')>In studio</option>
                                        <option value="mobile" @selected(old('appointment_type') === 'mobile')>Mobile</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Mobile address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Required for mobile">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Quoted price</label>
                                    <input type="number" step="0.01" min="0" name="final_price" class="form-control" value="{{ old('final_price') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea name="message" class="form-control" rows="3">{{ old('message', $customRequest->message) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Convert to booking</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">No booking or custom request found.</div>
    @endif
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sample Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imageModalImg" src="" alt="Sample" style="max-width:100%; height:auto; border-radius:8px;">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openImageModal() {
    const img = document.getElementById('samplePreview');
    if (!img) return;
    document.getElementById('imageModalImg').src = img.src;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function updateCustomStatus(id, status) {
    if (!confirm('Change status to ' + status + '?')) return;

    fetch(`/admin/custom-requests/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('custom-status').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            alert('Status updated');
        } else {
            alert('Failed to update status');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error updating status');
    });
}
</script>
</body>
</html>

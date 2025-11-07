<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .container { margin-top: 40px; }
        .sample-img { max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
        .meta { color: #6c757d; }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-link mb-3">&larr; Back to dashboard</a>

    @if(isset($booking) && $booking)
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Booking Details — #{{ sprintf('BK%06d', $booking->id) }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <h5>Customer</h5>
                        <p><strong>{{ $booking->name }}</strong><br>
                        <span class="meta">{{ $booking->email ?: 'No email' }} • {{ $booking->phone ?: 'No phone' }}</span></p>

                        <h5>Appointment</h5>
                        <p>
                            <strong>Service:</strong> {{ $booking->service ?: 'General Service' }}<br>
                            <strong>Date:</strong> {{ $booking->appointment_date ? $booking->appointment_date->format('F j, Y') : 'N/A' }}<br>
                            <strong>Time:</strong> {{ $booking->appointment_time ?: 'N/A' }}<br>
                            <strong>Length:</strong> {{ $booking->length ?: 'Not specified' }}<br>
                            <strong>Final Price:</strong> {{ isset($booking->final_price) ? '$' . number_format($booking->final_price, 2) : 'N/A' }}
                        </p>

                        @if($booking->message)
                            <h5>Customer Message</h5>
                            <p class="border rounded p-3 bg-light">{{ $booking->message }}</p>
                        @endif

                        @if($booking->status === 'completed')
                            <h5>Completion</h5>
                            <p>
                                <strong>Completed At:</strong> {{ $booking->completed_at ? $booking->completed_at->format('F j, Y H:i') : 'N/A' }}<br>
                                <strong>Completed By:</strong> {{ $booking->completed_by ?: 'N/A' }}<br>
                                <strong>Service Duration:</strong> {{ $booking->service_duration_minutes ? $booking->service_duration_minutes . ' minutes' : 'N/A' }}
                            </p>
                            @if($booking->completion_notes)
                                <p class="border rounded p-2 bg-light"><strong>Notes:</strong> {{ $booking->completion_notes }}</p>
                            @endif
                        @endif
                    </div>

                    <div class="col-md-5">
                        <h5>Sample Picture</h5>
                        @if($booking->sample_picture)
                            <img src="{{ asset('storage/' . $booking->sample_picture) }}" alt="Sample picture" class="sample-img mb-2" id="samplePreview">
                            <div>
                                <a href="{{ asset('storage/' . $booking->sample_picture) }}" download class="btn btn-sm btn-outline-primary">Download image</a>
                                <button class="btn btn-sm btn-secondary" onclick="openImageModal()">View larger</button>
                            </div>
                        @else
                            <div class="border rounded p-4 text-center text-muted">
                                <i class="bi bi-image" style="font-size: 2rem"></i>
                                <p class="mb-0">No sample image provided</p>
                            </div>
                        @endif

                        <hr>

                        <h6>Meta</h6>
                        <p class="meta">Booking ID: {{ sprintf('BK%06d', $booking->id) }}<br>
                        Status: {{ ucfirst($booking->status) }}<br>
                        Created: {{ $booking->created_at->format('F j, Y H:i') }}</p>
                    </div>
                </div>
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
                            <strong>Requested Date:</strong> {{ $customRequest->appointment_date ? \\Carbon\\Carbon::parse($customRequest->appointment_date)->format('F j, Y') : 'N/A' }}<br>
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
                        Submitted: {{ $customRequest->created_at->format('F j, Y H:i') }}</p>

                        <div class="d-grid gap-2">
                            <button class="btn btn-sm btn-outline-warning" onclick="updateCustomStatus({{ $customRequest->id }}, 'in_progress')">Mark In Progress</button>
                            <button class="btn btn-sm btn-outline-success" onclick="updateCustomStatus({{ $customRequest->id }}, 'handled')">Mark Handled</button>
                        </div>
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

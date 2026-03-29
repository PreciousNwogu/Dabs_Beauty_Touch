<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Completed Services - Dab's Beauty Touch Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg,#f8f9fa,#e3eafc); min-height:100vh; }
        .top-nav { background:rgba(255,255,255,.95); backdrop-filter:blur(10px); box-shadow:0 2px 20px rgba(0,0,0,.1); padding:14px 24px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:100; }
        .top-nav .brand { font-weight:800; color:#030f68; font-size:1.15rem; text-decoration:none; }
        .top-nav .nav-links a { color:#030f68; text-decoration:none; font-weight:600; margin-left:20px; font-size:.9rem; }
        .top-nav .nav-links a:hover { color:#ff6600; }
        .page-header { background:linear-gradient(135deg,#0f5132,#1f7a4d); color:white; padding:32px 32px 24px; border-radius:0 0 20px 20px; margin-bottom:28px; }
        .page-header h1 { font-size:1.8rem; font-weight:800; margin:0 0 4px; }
        .page-header p { margin:0; opacity:.85; font-size:.95rem; }
        .stat-pill { display:inline-flex; align-items:center; gap:8px; background:white; border-radius:10px; padding:10px 18px; box-shadow:0 2px 10px rgba(0,0,0,.07); font-weight:700; color:#0f5132; }
        .stat-pill .num { font-size:1.4rem; color:#198754; }
        .card-shell { background:white; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); overflow:hidden; }
        .card-header-custom { padding:18px 22px; border-bottom:2px solid #f0f0f0; background:#fafafa; }
        .filters { padding:14px 22px; background:white; border-bottom:1px solid #f0f0f0; }
        .table th { font-size:.78rem; text-transform:uppercase; letter-spacing:.05em; color:#888; font-weight:700; border:none; background:#fafafa; }
        .table td { vertical-align:middle; border-color:#f0f0f0; }
        .table tbody tr:hover { background:#f7fff9; }
    </style>
</head>
<body>

<nav class="top-nav">
    <a class="brand" href="{{ route('admin.dashboard') }}"><i class="bi bi-scissors me-2" style="color:#ff6600"></i>Dab's Beauty Touch - Admin</a>
    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        <a href="{{ route('admin.services.index') }}"><i class="bi bi-grid me-1"></i>Services</a>
        <a href="{{ route('admin.completed-services') }}" style="color:#198754"><i class="bi bi-check2-square me-1"></i>Completed Services</a>
        <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i>View Site</a>
    </div>
</nav>

<div class="container-fluid px-3 px-md-4 pb-5">
    <div class="page-header mt-3">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h1><i class="bi bi-check2-square me-2"></i>Completed Services</h1>
                <p>All completed appointments, sorted by most recent completion first.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light fw-bold px-4">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <div class="stat-pill"><span class="num">{{ $stats['completed_bookings'] }}</span> Total Completed</div>
    </div>

    <div class="card-shell">
        <div class="card-header-custom">
            <div class="fw-bold" style="color:#0f5132">Filter Completed Services</div>
        </div>
        <div class="filters">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
                    <label class="form-label mb-1">Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label mb-1">Service</label>
                    <input type="text" name="service" value="{{ request('service') }}" class="form-control" placeholder="Search by service name">
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-funnel me-1"></i>Apply</button>
                    <a href="{{ route('admin.completed-services') }}" class="btn btn-outline-secondary w-100">Clear</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table mb-0 table-hover">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Service</th>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Duration</th>
                        <th>Completed By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completedServices as $booking)
                    <tr>
                        <td>
                            <strong>{{ $booking->id }}</strong>
                            @if($booking->confirmation_code)
                                <br><small class="text-muted">Conf: {{ $booking->confirmation_code }}</small>
                            @endif
                        </td>
                        <td>
                            <div><strong>{{ $booking->name }}</strong></div>
                            @if($booking->email)
                                <small class="text-muted">{{ $booking->email }}</small>
                            @endif
                        </td>
                        <td>{{ $booking->phone ?? 'N/A' }}</td>
                        <td>{{ $booking->service ?: 'General Service' }}</td>
                        <td>
                            {{ $booking->appointment_date?->format('M d, Y') }}
                            <br><small class="text-muted">{{ $booking->appointment_date?->format('l') }}</small>
                        </td>
                        <td>{{ $booking->appointment_time }}</td>
                        <td>
                            @if($booking->service_duration_minutes)
                                <span class="badge bg-success">{{ $booking->getFormattedDuration() }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $booking->completed_by ?: 'N/A' }}</td>
                        <td>
                            <a class="btn btn-outline-info btn-sm" href="{{ route('admin.bookings.show', $booking->id) }}" title="View Booking">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No completed services found for this filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 p-md-4 border-top">
            @if($completedServices->hasPages())
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <small class="text-muted">
                        Showing {{ $completedServices->firstItem() }} to {{ $completedServices->lastItem() }} of {{ $completedServices->total() }} completed services
                    </small>
                    {{ $completedServices->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>

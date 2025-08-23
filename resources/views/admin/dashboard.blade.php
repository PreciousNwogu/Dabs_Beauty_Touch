<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Dab's Beauty Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .dashboard-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px 0;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #030f68 0%, #05137c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 25px;
            margin: 15px 0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ff6600;
        }

        .stats-label {
            color: #666;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .appointment-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin: 15px 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .appointment-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .appointment-body {
            padding: 20px;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-completed {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 102, 0, 0.3);
        }

        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .table thead th {
            background: linear-gradient(135deg, #030f68 0%, #05137c 100%);
            color: white;
            border: none;
            padding: 15px;
            position: relative;
        }
        
        .table thead th.cursor-pointer::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: transparent;
            transition: background-color 0.3s ease;
        }
        
        .table thead th.cursor-pointer:hover::after {
            background: #ff6600;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .cursor-pointer {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .cursor-pointer:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }
        
        .table th.cursor-pointer {
            position: relative;
            user-select: none;
        }
        
        .table th.cursor-pointer i {
            margin-left: 5px;
            font-size: 0.8rem;
        }
        
        .table th.cursor-pointer:hover i {
            color: #ff6600 !important;
        }

        .timeline-item {
            border-left: 3px solid #dee2e6;
            padding-left: 15px;
            position: relative;
            margin-bottom: 10px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #6c757d;
        }

        .btn-group-vertical .btn {
            border-radius: 0.375rem !important;
            margin-bottom: 2px;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .card-header h6 {
            margin: 0;
            font-weight: 600;
        }

        .modal-xl {
            max-width: 90%;
        }

        .sample-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid #dee2e6;
            transition: transform 0.2s;
        }

        .sample-image:hover {
            transform: scale(1.05);
            border-color: #007bff;
        }

        @media (max-width: 768px) {
            .btn-group-vertical {
                display: flex;
                flex-direction: column;
            }
            .table-responsive {
                font-size: 0.875rem;
            }
            .modal-xl {
                max-width: 95%;
            }
        }

        /* Pagination Styles */
        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            color: #030f68;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
            margin: 0 2px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: #030f68;
            border-color: #030f68;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background-color: #030f68;
            border-color: #030f68;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination-info {
            display: flex;
            align-items: center;
            height: 38px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                <span style="font-weight: bold; font-size: 1.3rem; color: #ff6600;">Dab's Beauty Touch</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('calendar') }}">Calendar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">Admin</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="background: none; border: none; color: #dc3545; font-weight: 600;">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <!-- Dashboard Header -->
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1 class="mb-3">Admin Dashboard</h1>
                <p class="mb-0">Manage appointments and view business insights</p>
            </div>

            <!-- Statistics -->
            <div class="row p-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['total_bookings'] }}</div>
                        <div class="stats-label">Total Appointments</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['today_bookings'] }}</div>
                        <div class="stats-label">Today's Appointments</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['pending_bookings'] }}</div>
                        <div class="stats-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['confirmed_bookings'] }}</div>
                        <div class="stats-label">Confirmed</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card bg-success text-white">
                        <div class="stats-number">₵<span>{{ number_format($stats['today_revenue'], 2) }}</span></div>
                        <div class="stats-label">Today's Revenue</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card bg-primary text-white">
                        <div class="stats-number">₵<span>{{ number_format($stats['monthly_revenue'], 2) }}</span></div>
                        <div class="stats-label">This Month</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card bg-info text-white">
                        <div class="stats-number">{{ $stats['completed_bookings'] }}</div>
                        <div class="stats-label">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Status Filter</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="dateFilter" class="form-label">Date Filter</label>
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-md-3">
                    <label for="serviceFilter" class="form-label">Service Filter</label>
                    <select class="form-select" id="serviceFilter">
                        <option value="">All Services</option>
                        <option value="Small Knotless Braids">Small Knotless Braids</option>
                        <option value="Smedium Knotless Braids">Smedium Knotless Braids</option>
                        <option value="Wig Installation">Wig Installation</option>
                        <option value="Large Knotless Braids">Large Knotless Braids</option>
                        <option value="Jumbo Knotless Braids">Jumbo Knotless Braids</option>
                        <option value="Kids Braids">Kids Braids</option>
                        <option value="8 Rows Stitch Braids">8 Rows Stitch Braids</option>
                        <option value="Hair Mask/Relaxing">Hair Mask/Relaxing</option>
                        <option value="Smedium Boho Braids">Smedium Boho Braids</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary w-100" type="button" onclick="applyFilters()">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-outline-secondary w-100" type="button" onclick="clearFilters()" title="Clear all filters">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="dashboard-container">
            <div class="dashboard-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0">Appointments</h3>
                    <div class="d-flex align-items-center gap-3">
                        @if($bookings->hasPages())
                            <small class="text-white-50">
                                Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }} ({{ $bookings->total() }} total)
                            </small>
                        @endif
                        @if(request('sort_by'))
                            <small class="text-white-50">
                                <i class="bi bi-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} me-1"></i>
                                Sorted by {{ ucfirst(str_replace('_', ' ', request('sort_by'))) }} 
                                ({{ request('sort_order') == 'asc' ? 'A-Z' : 'Z-A' }})
                            </small>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.complete-service') }}" class="btn btn-success">
                    <i class="bi bi-check-circle me-2"></i>Complete Service
                </a>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="cursor-pointer" onclick="sortTable('id')">
                                    Booking ID
                                    @if(request('sort_by') == 'id')
                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </th>
                                <th class="cursor-pointer" onclick="sortTable('name')">
                                    Customer Name
                                    @if(request('sort_by') == 'name')
                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </th>
                                <th>Contact</th>
                                <th class="cursor-pointer" onclick="sortTable('service')">
                                    Service
                                    @if(request('sort_by') == 'service')
                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </th>
                                <th class="cursor-pointer" onclick="sortTable('appointment_date')">
                                    Appointment Date
                                    @if(request('sort_by') == 'appointment_date')
                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </th>
                                <th class="cursor-pointer" onclick="sortTable('appointment_time')">
                                    Appointment Time
                                    @if(request('sort_by') == 'appointment_time')
                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </th>
                                <th>Sample Image</th>
                                <th class="cursor-pointer" onclick="sortTable('status')">
                                    Status
                                    @if(request('sort_by') == 'status')
                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    @endif
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTable">
                            @if($bookings->count() > 0)
                                @foreach($bookings as $booking)
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
                                            @else
                                                <small class="text-muted">No email</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $booking->phone }}</div>
                                            @if($booking->address)
                                                <small class="text-muted">{{ $booking->address }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $booking->service ?: 'General Service' }}</div>
                                            @if($booking->length)
                                                <small class="text-muted">Length: {{ $booking->length }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                @if($booking->appointment_date)
                                                    {{ $booking->appointment_date->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">No date</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">
                                                @if($booking->appointment_date)
                                                    {{ $booking->appointment_date->format('l') }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            <div>{{ $booking->appointment_time }}</div>
                                            <small class="text-muted">
                                                @if($booking->appointment_date)
                                                    {{ $booking->appointment_date->format('l') }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>
                                            @if($booking->sample_picture)
                                                <img src="{{ asset('storage/' . $booking->sample_picture) }}"
                                                     alt="Sample"
                                                     class="sample-image"
                                                     onclick="viewImageModal('{{ asset('storage/' . $booking->sample_picture) }}', '{{ $booking->name }}')"
                                                     title="Click to view full size">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $booking->status }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical" role="group">
                                                <button class="btn btn-outline-info btn-sm mb-1" onclick="viewBookingDetails({{ $booking->id }})" title="View Details">
                                                    <i class="bi bi-eye"></i> View Details
                                                </button>
                                                @if($booking->status === 'pending')
                                                    <button class="btn btn-success btn-sm mb-1" onclick="updateStatus({{ $booking->id }}, 'confirmed')">
                                                        <i class="bi bi-check"></i> Confirm
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $booking->id }}, 'cancelled')">
                                                        <i class="bi bi-x"></i> Cancel
                                                    </button>
                                                @elseif($booking->status === 'confirmed')
                                                    <button class="btn btn-info btn-sm mb-1" onclick="updateStatus({{ $booking->id }}, 'completed')">
                                                        <i class="bi bi-award"></i> Complete
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $booking->id }}, 'cancelled')">
                                                        <i class="bi bi-x"></i> Cancel
                                                    </button>
                                                @else
                                                    <small class="text-muted">{{ ucfirst($booking->status) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No appointments found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="pagination-info">
                        <small class="text-muted">
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
                        </small>
                    </div>
                    <nav aria-label="Bookings pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($bookings->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bookings->appends(request()->except('page'))->previousPageUrl() }}">Previous</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($bookings->appends(request()->except('page'))->getUrlRange(1, $bookings->lastPage()) as $page => $url)
                                @if ($page == $bookings->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($bookings->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bookings->appends(request()->except('page'))->nextPageUrl() }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="bookingDetailsContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Appointment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        <div class="mb-3">
                            <label for="newStatus" class="form-label">New Status</label>
                            <select class="form-select" id="newStatus" required onchange="toggleCompletionFields()">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <!-- Completion fields - only show when status is 'completed' -->
                        <div id="completionFields" style="display: none;">
                            <div class="mb-3">
                                <label for="completedBy" class="form-label">Completed By (Staff Member)</label>
                                <input type="text" class="form-control" id="completedBy" placeholder="Enter staff member name">
                            </div>

                            <div class="mb-3">
                                <label for="serviceDuration" class="form-label">Service Duration (minutes)</label>
                                <input type="number" class="form-control" id="serviceDuration" placeholder="e.g., 180" min="1">
                            </div>

                            <div class="mb-3">
                                <label for="finalPrice" class="form-label">Final Price (₵)</label>
                                <input type="number" class="form-control" id="finalPrice" placeholder="e.g., 150.00" min="0" step="0.01">
                            </div>

                            <div class="mb-3">
                                <label for="paymentStatus" class="form-label">Payment Status</label>
                                <select class="form-select" id="paymentStatus">
                                    <option value="pending">Pending</option>
                                    <option value="deposit_paid">Deposit Paid</option>
                                    <option value="fully_paid">Fully Paid</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="statusNotes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="statusNotes" rows="3" placeholder="Add any additional notes..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="updateStatus()">Update Status</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalTitle">Sample Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="imageModalImg" src="" alt="Sample Image" style="max-width: 100%; height: auto; border-radius: 10px;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="imageDownloadLink" href="" download class="btn btn-primary">
                        <i class="bi bi-download me-2"></i>Download Image
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="appointmentDetailsContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentAppointmentId = null;

        // Load dashboard data on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Dashboard data is already loaded server-side, no need to fetch
            console.log('Dashboard loaded');
        });

        // Function to sort table columns
        function sortTable(column) {
            const currentSortBy = '{{ request('sort_by', 'appointment_date') }}';
            const currentSortOrder = '{{ request('sort_order', 'desc') }}';
            
            // Determine new sort order
            let newSortOrder = 'asc';
            if (currentSortBy === column && currentSortOrder === 'asc') {
                newSortOrder = 'desc';
            }
            
            // Show loading state
            const tableBody = document.getElementById('appointmentsTable');
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            
            // Build query parameters
            const params = new URLSearchParams(window.location.search);
            params.set('sort_by', column);
            params.set('sort_order', newSortOrder);
            
            // Update URL without reloading
            const baseUrl = window.location.pathname;
            const newUrl = `${baseUrl}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);
            
            // Fetch sorted data via AJAX
            fetch(newUrl)
                .then(response => response.text())
                .then(html => {
                    // Create a temporary div to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Extract the table body content
                    const newTableBody = tempDiv.querySelector('#appointmentsTable');
                    if (newTableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }
                    
                    // Update sorting indicators in headers
                    updateSortingIndicators(column, newSortOrder);
                    
                    // Update pagination info if it exists
                    const paginationInfo = tempDiv.querySelector('.pagination-info');
                    if (paginationInfo) {
                        const currentPaginationInfo = document.querySelector('.pagination-info');
                        if (currentPaginationInfo) {
                            currentPaginationInfo.innerHTML = paginationInfo.innerHTML;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error sorting table:', error);
                    // Fallback to page reload if AJAX fails
                    window.location.href = newUrl;
                });
        }
        
        // Function to update sorting indicators
        function updateSortingIndicators(column, order) {
            // Remove all sorting indicators
            document.querySelectorAll('.table th.cursor-pointer i').forEach(icon => {
                icon.className = 'bi bi-arrow-down-up text-muted';
            });
            
            // Add sorting indicator to the clicked column
            const headerCell = document.querySelector(`th[onclick="sortTable('${column}')"]`);
            if (headerCell) {
                const icon = headerCell.querySelector('i');
                if (icon) {
                    icon.className = `bi bi-arrow-${order === 'asc' ? 'up' : 'down'}`;
                }
            }
        }

        // Simple filter function that updates the table without page reload
        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const serviceFilter = document.getElementById('serviceFilter').value;

            // Show loading state
            const tableBody = document.getElementById('appointmentsTable');
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';

            // Build query parameters
            const params = new URLSearchParams();
            if (statusFilter) params.append('status', statusFilter);
            if (dateFilter) params.append('date', dateFilter);
            if (serviceFilter) params.append('service', serviceFilter);
            
            // Preserve current sorting
            const currentSortBy = '{{ request('sort_by', 'appointment_date') }}';
            const currentSortOrder = '{{ request('sort_order', 'desc') }}';
            params.set('sort_by', currentSortBy);
            params.set('sort_order', currentSortOrder);

            // Update URL without reloading
            const baseUrl = window.location.pathname;
            const newUrl = `${baseUrl}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);

            // Fetch filtered data via AJAX
            fetch(newUrl)
                .then(response => response.text())
                .then(html => {
                    // Create a temporary div to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Extract the table body content
                    const newTableBody = tempDiv.querySelector('#appointmentsTable');
                    if (newTableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }
                    
                    // Update pagination info if it exists
                    const paginationInfo = tempDiv.querySelector('.pagination-info');
                    if (paginationInfo) {
                        const currentPaginationInfo = document.querySelector('.pagination-info');
                        if (currentPaginationInfo) {
                            currentPaginationInfo.innerHTML = paginationInfo.innerHTML;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error applying filters:', error);
                    // Fallback to page reload if AJAX fails
                    window.location.href = newUrl;
                });
        }

        // Function to clear all filters
        function clearFilters() {
            // Clear filter inputs
            document.getElementById('statusFilter').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('serviceFilter').value = '';
            
            // Show loading state
            const tableBody = document.getElementById('appointmentsTable');
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            
            // Build query parameters with only sorting
            const params = new URLSearchParams();
            const currentSortBy = '{{ request('sort_by', 'appointment_date') }}';
            const currentSortOrder = '{{ request('sort_order', 'desc') }}';
            params.set('sort_by', currentSortBy);
            params.set('sort_order', currentSortOrder);
            
            // Update URL without reloading
            const baseUrl = window.location.pathname;
            const newUrl = `${baseUrl}?${params.toString()}`;
            window.history.pushState({}, '', newUrl);

            // Fetch unfiltered data via AJAX
            fetch(newUrl)
                .then(response => response.text())
                .then(html => {
                    // Create a temporary div to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Extract the table body content
                    const newTableBody = tempDiv.querySelector('#appointmentsTable');
                    if (newTableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }
                    
                    // Update pagination info if it exists
                    const paginationInfo = tempDiv.querySelector('.pagination-info');
                    if (paginationInfo) {
                        const currentPaginationInfo = document.querySelector('.pagination-info');
                        if (currentPaginationInfo) {
                            currentPaginationInfo.innerHTML = paginationInfo.innerHTML;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error clearing filters:', error);
                    // Fallback to page reload if AJAX fails
                    window.location.href = newUrl;
                });
        }

        function viewBookingDetails(bookingId) {
            // Fetch booking details
            fetch(`/admin/booking-details/${bookingId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showBookingDetails(data.booking);
                    } else {
                        alert('Error loading booking details: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error loading booking details:', error);
                    alert('Error loading booking details. Please try again.');
                });
        }

        function showBookingDetails(booking) {
            const detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bi bi-person me-2"></i>Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr><td><strong>Name:</strong></td><td>${booking.name}</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>${booking.phone}</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>${booking.email || 'Not provided'}</td></tr>
                                    <tr><td><strong>Address:</strong></td><td>${booking.address || 'Not provided'}</td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Appointment Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr><td><strong>Booking ID:</strong></td><td>${booking.booking_id || booking.id}</td></tr>
                                    <tr><td><strong>Confirmation Code:</strong></td><td>${booking.confirmation_code || 'N/A'}</td></tr>
                                    <tr><td><strong>Service:</strong></td><td>${booking.service}</td></tr>
                                    <tr><td><strong>Length:</strong></td><td>${booking.length || 'Not specified'}</td></tr>
                                    <tr><td><strong>Date:</strong></td><td>${new Date(booking.appointment_date).toLocaleDateString()}</td></tr>
                                    <tr><td><strong>Time:</strong></td><td>${booking.appointment_time}</td></tr>
                                    <tr><td><strong>Status:</strong></td><td><span class="status-badge status-${booking.status}">${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}</span></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        ${booking.sample_picture ? `
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="bi bi-image me-2"></i>Sample Image</h6>
                                </div>
                                <div class="card-body text-center">
                                    <img src="${booking.sample_picture.startsWith('http') ? booking.sample_picture : '/storage/' + booking.sample_picture}"
                                         alt="Sample Image"
                                         style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"
                                         onclick="viewImageModal('${booking.sample_picture.startsWith('http') ? booking.sample_picture : '/storage/' + booking.sample_picture}', '${booking.name}')"
                                         class="cursor-pointer">
                                    <div class="mt-2">
                                        <a href="${booking.sample_picture.startsWith('http') ? booking.sample_picture : '/storage/' + booking.sample_picture}" download class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        ` : `
                            <div class="card mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0"><i class="bi bi-image me-2"></i>Sample Image</h6>
                                </div>
                                <div class="card-body text-center text-muted">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                    <p>No sample image uploaded</p>
                                </div>
                            </div>
                        `}

                        ${booking.message ? `
                            <div class="card mb-3">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="bi bi-chat-text me-2"></i>Customer Message</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">"${booking.message}"</p>
                                </div>
                            </div>
                        ` : ''}

                        ${booking.status === 'completed' && booking.completed_at ? `
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Service Completion Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <strong>Completed By:</strong><br>
                                            ${booking.completed_by || 'N/A'}
                                        </div>
                                        <div class="col-6">
                                            <strong>Duration:</strong><br>
                                            ${booking.service_duration_minutes ? booking.service_duration_minutes + ' minutes' : 'N/A'}
                                        </div>
                                        <div class="col-6">
                                            <strong>Final Price:</strong><br>
                                            ${booking.final_price ? '₵' + parseFloat(booking.final_price).toFixed(2) : 'N/A'}
                                        </div>
                                    </div>
                                    ${booking.completion_notes ? `
                                        <div class="mt-3">
                                            <strong>Completion Notes:</strong><br>
                                            <em>"${booking.completion_notes}"</em>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;

            document.getElementById('bookingDetailsContent').innerHTML = detailsHtml;
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        }

        function updateAppointmentStatus(appointmentId) {
            currentAppointmentId = appointmentId;
            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        function updateStatus() {
            const newStatus = document.getElementById('newStatus').value;
            const notes = document.getElementById('statusNotes').value;
            const completedBy = document.getElementById('completedBy').value;
            const serviceDuration = document.getElementById('serviceDuration').value;
            const finalPrice = document.getElementById('finalPrice').value;
            const paymentStatus = document.getElementById('paymentStatus').value;

            if (!currentAppointmentId) {
                alert('No appointment selected');
                return;
            }

            // Show loading state
            const updateBtn = document.querySelector('#statusModal .btn-primary');
            const originalText = updateBtn.innerHTML;
            updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
            updateBtn.disabled = true;

            // Prepare request data
            const requestData = {
                appointment_id: currentAppointmentId,
                status: newStatus,
                completion_notes: notes
            };

            // Add completion data if status is 'completed'
            if (newStatus === 'completed') {
                if (completedBy) requestData.completed_by = completedBy;
                if (serviceDuration) requestData.service_duration_minutes = parseInt(serviceDuration);
                if (finalPrice) requestData.final_price = parseFloat(finalPrice);
                if (paymentStatus) requestData.payment_status = paymentStatus;
            }

            // Send update to API
            fetch('/admin/bookings/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and reload page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
                    modal.hide();
                    window.location.reload();

                    // Show success message
                    alert('Appointment status updated successfully!');
                } else {
                    alert('Error updating status: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
                alert('Error updating appointment status. Please try again.');
            })
            .finally(() => {
                // Reset button state
                updateBtn.innerHTML = originalText;
                updateBtn.disabled = false;
            });
        }

        function toggleCompletionFields() {
            const status = document.getElementById('newStatus').value;
            const completionFields = document.getElementById('completionFields');

            if (status === 'completed') {
                completionFields.style.display = 'block';
                // Make completion fields required when status is completed
                document.getElementById('completedBy').required = true;
                document.getElementById('serviceDuration').required = true;
                document.getElementById('finalPrice').required = true;
            } else {
                completionFields.style.display = 'none';
                // Remove required attribute when not completing
                document.getElementById('completedBy').required = false;
                document.getElementById('serviceDuration').required = false;
                document.getElementById('finalPrice').required = false;
            }
        }

        function viewImageModal(imageSrc, customerName) {
            document.getElementById('imageModalTitle').textContent = `Sample Image - ${customerName}`;
            document.getElementById('imageModalImg').src = imageSrc;
            document.getElementById('imageDownloadLink').href = imageSrc;

            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }

        // Simple status update function
        function updateStatus(bookingId, newStatus) {
            console.log('updateStatus called with:', bookingId, newStatus);

            const confirmMessage = `Are you sure you want to mark booking #${bookingId} as ${newStatus}?`;
            console.log('Showing confirm dialog:', confirmMessage);

            if (!confirm(confirmMessage)) {
                console.log('User cancelled the action');
                return;
            }

            console.log('User confirmed, proceeding with update...');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);

            fetch('{{ route("admin.bookings.update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    booking_id: bookingId,
                    status: newStatus
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Reload the page to show updated status
                    window.location.reload();
                } else {
                    alert('Error updating booking status: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating booking status. Please try again.');
            });
        }
    </script>
</body>
</html>

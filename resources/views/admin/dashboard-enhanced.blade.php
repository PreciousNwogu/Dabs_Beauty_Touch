<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Dab's Beauty Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            color: #667eea !important;
        }

        .container-fluid {
            padding: 20px;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            color: white;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .stats-card.total { border-left-color: #667eea; }
        .stats-card.pending { border-left-color: #fbbf24; }
        .stats-card.confirmed { border-left-color: #10b981; }
        .stats-card.completed { border-left-color: #8b5cf6; }
        .stats-card.today { border-left-color: #f59e0b; }
        .stats-card.week { border-left-color: #06b6d4; }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stats-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .bookings-section {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .section-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .booking-card {
            padding: 20px 30px;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .booking-card:hover {
            background: #f9fafb;
        }

        .booking-card:last-child {
            border-bottom: none;
        }

        .booking-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 15px;
        }

        .customer-info {
            flex: 1;
        }

        .customer-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .customer-contact {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .booking-status {
            display: flex;
            flex-direction: column;
            align-items: end;
            gap: 8px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-completed {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .appointment-datetime {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f3f4f6;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .detail-icon {
            color: #9ca3af;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm {
            background: #10b981;
            color: white;
        }

        .btn-confirm:hover {
            background: #059669;
        }

        .btn-complete {
            background: #8b5cf6;
            color: white;
        }

        .btn-complete:hover {
            background: #7c3aed;
        }

        .btn-cancel {
            background: #ef4444;
            color: white;
        }

        .btn-cancel:hover {
            background: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 60px 30px;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .pagination-wrapper {
            padding: 25px 30px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .booking-header {
                flex-direction: column;
                align-items: start;
                gap: 10px;
            }

            .booking-status {
                align-items: start;
            }

            .booking-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-gem me-2"></i>Dab's Beauty Touch Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-house me-1"></i>View Website
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>Welcome to Admin Dashboard</h1>
            <p class="mb-0">Manage your beauty appointments and customer bookings</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stats-card total">
                <div class="stats-icon text-primary">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stats-number text-primary">{{ $stats['total_bookings'] }}</div>
                <div class="stats-label">Total Bookings</div>
            </div>

            <div class="stats-card pending">
                <div class="stats-icon text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stats-number text-warning">{{ $stats['pending_bookings'] }}</div>
                <div class="stats-label">Pending</div>
            </div>

            <div class="stats-card confirmed">
                <div class="stats-icon text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stats-number text-success">{{ $stats['confirmed_bookings'] }}</div>
                <div class="stats-label">Confirmed</div>
            </div>

            <div class="stats-card completed">
                <div class="stats-icon text-info">
                    <i class="bi bi-award"></i>
                </div>
                <div class="stats-number text-info">{{ $stats['completed_bookings'] }}</div>
                <div class="stats-label">Completed</div>
            </div>

            <div class="stats-card today">
                <div class="stats-icon text-warning">
                    <i class="bi bi-calendar-day"></i>
                </div>
                <div class="stats-number text-warning">{{ $stats['today_bookings'] }}</div>
                <div class="stats-label">Today</div>
            </div>

            <div class="stats-card week">
                <div class="stats-icon text-info">
                    <i class="bi bi-calendar-week"></i>
                </div>
                <div class="stats-number text-info">{{ $stats['this_week_bookings'] }}</div>
                <div class="stats-label">This Week</div>
            </div>
        </div>

        <!-- Bookings Section -->
        <div class="bookings-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-calendar2-check me-2"></i>
                    Recent Bookings
                </h2>
            </div>

            @if($bookings->count() > 0)
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="customer-info">
                                <div class="customer-name">{{ $booking->name }}</div>
                                <div class="customer-contact">
                                    <i class="bi bi-envelope me-1"></i>{{ $booking->email }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-telephone me-1"></i>{{ $booking->phone }}
                                </div>
                            </div>
                            <div class="booking-status">
                                <span class="status-badge status-{{ $booking->status }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                <div class="appointment-datetime">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $booking->appointment_date?->format('M d, Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $booking->appointment_time }}
                                </div>
                            </div>
                        </div>

                        <div class="booking-details">
                            <div class="detail-item">
                                <i class="bi bi-scissors detail-icon"></i>
                                <span><strong>Service:</strong> {{ $booking->service ?: 'General Service' }}</span>
                            </div>
                            @if($booking->length)
                                <div class="detail-item">
                                    <i class="bi bi-rulers detail-icon"></i>
                                    <span><strong>Length:</strong> {{ $booking->length }}</span>
                                </div>
                            @endif
                            <div class="detail-item">
                                <i class="bi bi-calendar-plus detail-icon"></i>
                                <span><strong>Booked:</strong> {{ $booking->created_at->format('M d, Y g:i A') }}</span>
                            </div>
                            @if($booking->message)
                                <div class="detail-item">
                                    <i class="bi bi-chat-text detail-icon"></i>
                                    <span><strong>Message:</strong> {{ Str::limit($booking->message, 100) }}</span>
                                </div>
                            @endif
                        </div>

                        @if($booking->status === 'pending')
                            <div class="action-buttons">
                                <button class="btn-action btn-confirm" onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')">
                                    <i class="bi bi-check-lg me-1"></i>Confirm
                                </button>
                                <button class="btn-action btn-cancel" onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                                    <i class="bi bi-x-lg me-1"></i>Cancel
                                </button>
                            </div>
                        @elseif($booking->status === 'confirmed')
                            <div class="action-buttons">
                                <button class="btn-action btn-complete" onclick="updateBookingStatus({{ $booking->id }}, 'completed')">
                                    <i class="bi bi-award me-1"></i>Mark Complete
                                </button>
                                <button class="btn-action btn-cancel" onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                                    <i class="bi bi-x-lg me-1"></i>Cancel
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3>No bookings found</h3>
                    <p>When customers make appointments, they will appear here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to update booking status
        function updateBookingStatus(bookingId, newStatus) {
            if (!confirm(`Are you sure you want to ${newStatus} this booking?`)) {
                return;
            }

            fetch('{{ route("admin.bookings.update-status") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    booking_id: bookingId,
                    status: newStatus
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        // Extract a concise summary from HTML or plain text responses
                        let summary = text;
                        if (/<[a-z][\s\S]*>/i.test(text)) {
                            const titleMatch = text.match(/<title[^>]*>([^<]*)<\/title>/i);
                            const h1Match = text.match(/<h1[^>]*>([^<]*)<\/h1>/i);
                            summary = (titleMatch && titleMatch[1]) || (h1Match && h1Match[1]) || text.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
                        }
                        summary = summary.split('\n')[0].trim();
                        if (summary.length > 200) summary = summary.slice(0, 200) + '...';
                        // Throw an object so the catch block can log full body while showing a concise message
                        throw { message: `Server error (HTTP ${response.status}): ${summary}`, status: response.status, body: text };
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated status
                    window.location.reload();
                } else {
                    alert('Error updating booking status: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                // If we threw an object with a body, log the full response body for debugging
                if (error && error.body) {
                    console.error('Full server response for booking status update:', error.body);
                } else {
                    console.error('Error updating booking status:', error);
                }
                const userMessage = (error && error.message) ? error.message : 'Error updating booking status. Please try again.';
                alert(userMessage);
            });
        }

        // Auto-refresh dashboard every 5 minutes
        setTimeout(() => {
            window.location.reload();
        }, 300000); // 5 minutes

        // Add real-time timestamp
        function updateTimestamp() {
            const now = new Date();
            const timestamp = now.toLocaleString();
            // You can add a timestamp display if needed
        }

        // Update timestamp every minute
        setInterval(updateTimestamp, 60000);
        updateTimestamp();
    </script>
</body>
</html>

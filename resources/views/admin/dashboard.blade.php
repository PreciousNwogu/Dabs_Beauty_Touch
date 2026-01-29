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

        /* Ensure bookings table stays readable and scrolls on small screens */
        .admin-bookings-table {
            min-width: 1100px;
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

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .dashboard-container {
                margin: 10px 0;
                border-radius: 15px;
            }

            .dashboard-header {
                padding: 20px 15px;
            }

            .dashboard-header h1 {
                font-size: 1.5rem;
            }

            .stats-card {
                padding: 20px 15px;
                margin: 10px 0;
            }

            .stats-number {
                font-size: 2rem;
            }

            .stats-label {
                font-size: 1rem;
            }

            .btn-group-vertical {
                display: flex;
                flex-direction: column;
            }

            .btn-group-vertical .btn {
                margin-bottom: 5px;
            }

            .table-responsive {
                font-size: 0.875rem;
                -webkit-overflow-scrolling: touch;
            }

            .modal-xl {
                max-width: 95%;
            }

            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-lg {
                max-width: calc(100% - 20px);
            }

            .modal-xl {
                max-width: calc(100% - 20px);
            }

            .modal-body {
                padding: 15px;
            }

            .modal-header {
                padding: 15px;
            }

            .appointment-card {
                margin: 10px 0;
            }

            .appointment-header {
                padding: 15px;
                flex-direction: column;
                align-items: flex-start !important;
            }

            .appointment-header .btn-group {
                width: 100%;
                margin-top: 10px;
            }

            .appointment-header .btn-group .btn {
                flex: 1;
            }

            .filter-section {
                padding: 15px;
            }

            .filter-section .row {
                margin: 0;
            }

            .filter-section .col-md-3,
            .filter-section .col-md-4,
            .filter-section .col-md-2,
            .filter-section .col-md-1 {
                margin-bottom: 15px;
            }

            /* Hide table on mobile, show card layout */
            .table-mobile-hide {
                display: none;
            }

            /* Mobile card layout for appointments */
            .appointment-mobile-card {
                display: block;
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                padding: 15px;
                margin-bottom: 15px;
            }

            .appointment-mobile-card .card-header-mobile {
                border-bottom: 2px solid #e9ecef;
                padding-bottom: 10px;
                margin-bottom: 15px;
            }

            .appointment-mobile-card .card-header-mobile .booking-id {
                font-size: 1.2rem;
                font-weight: bold;
                color: #030f68;
                margin-bottom: 5px;
            }

            .appointment-mobile-card .card-row {
                display: flex;
                justify-content: space-between;
                padding: 8px 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .appointment-mobile-card .card-row:last-child {
                border-bottom: none;
            }

            .appointment-mobile-card .card-label {
                font-weight: 600;
                color: #666;
                font-size: 0.9rem;
            }

            .appointment-mobile-card .card-value {
                color: #333;
                text-align: right;
                flex: 1;
                margin-left: 10px;
            }

            .appointment-mobile-card .card-actions {
                margin-top: 15px;
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .appointment-mobile-card .card-actions .btn {
                flex: 1;
                min-width: 100px;
            }

            /* Calendar mobile styles */
            .calendar-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            #adminCalendar {
                min-height: 500px !important;
            }

            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }

            .fc-button {
                padding: 0.4rem 0.8rem;
                font-size: 0.875rem;
                min-height: 44px;
            }

            .fc-header-toolbar {
                margin-bottom: 1em;
            }

            .fc-dayGridMonth-view,
            .fc-timeGridWeek-view,
            .fc-timeGridDay-view {
                font-size: 0.875rem;
            }

            .fc-event {
                font-size: 0.75rem;
                padding: 2px 4px;
            }

            .fc-col-header-cell {
                font-size: 0.875rem;
                padding: 8px 4px;
            }

            .fc-daygrid-day-frame {
                min-height: 60px;
            }

            /* Navbar mobile improvements */
            .navbar-brand {
                font-size: 1rem;
            }

            .navbar-brand img {
                height: 30px;
            }

            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                margin-top: 10px;
                border-radius: 8px;
                padding: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            /* Touch-friendly buttons */
            .btn {
                min-height: 44px;
                padding: 10px 15px;
            }

            .btn-sm {
                min-height: 38px;
                padding: 8px 12px;
            }

            /* Container padding on mobile */
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            body > .container {
                margin-top: 80px !important;
            }

            /* Pagination mobile */
            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }

            .pagination .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header h1 {
                font-size: 1.25rem;
            }

            .stats-number {
                font-size: 1.75rem;
            }

            .appointment-mobile-card .card-actions .btn {
                min-width: 80px;
                font-size: 0.875rem;
            }

            .fc-button {
                padding: 0.3rem 0.6rem;
                font-size: 0.75rem;
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
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .pagination-info {
                height: auto;
                margin-bottom: 10px;
                justify-content: center;
                text-align: center;
            }
        }
    </style>
    <!-- FullCalendar CSS (loaded from CDN to avoid deep-import issues during Vite analysis) -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/main.min.css" rel="stylesheet">
    <style>
        /* Styling for blocked ranges so their title text is visible inside the calendar.
           We target common FullCalendar event classes across views (dayGrid/timeGrid).
        */
        .fc-event.blocked-range,
        .fc-daygrid-event.blocked-range,
        .fc-timegrid-event.blocked-range {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            background-color: #dc3545 !important;
            border-color: #a71e2a !important;
            border-width: 2px !important;
            color: #ffffff !important;
            opacity: 1 !important;
            font-weight: 600 !important;
        }

        /* Make multi-day/all-day blocked bars fuller so the title is readable */
        .fc-daygrid-event.blocked-range .fc-event-main,
        .fc-event.blocked-range .fc-event-main {
            padding: 4px 8px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        /* Ensure blocked events stand out in all views */
        .fc-timegrid-event.blocked-range {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
            border-left: 4px solid #a71e2a !important;
        }

        /* Prevent pointer interactions (admins already have separate manage UI) */
        .fc-event.blocked-range { 
            pointer-events: auto; 
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
        
        /* Hover effect for blocked events */
        .fc-event.blocked-range:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%) !important;
            box-shadow: 0 3px 6px rgba(220, 53, 69, 0.4);
        }

        /* Booking details modal (View Details) */
        .bd-card {
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .bd-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            padding: 12px 16px;
        }
        .bd-card-header.bd-customer { background: #0d6efd; color: #fff; }
        .bd-card-header.bd-sample { background: #6c757d; color: #fff; }
        .bd-card-header.bd-appointment { background: #198754; color: #fff; }

        .bd-panel {
            padding: 14px 16px;
            border-radius: 12px;
            background: #ffffff;
        }
        .bd-row {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 16px;
            padding: 10px 0;
        }
        .bd-row + .bd-row { border-top: 1px solid rgba(0,0,0,0.06); }
        .bd-label { font-weight: 700; color: #212529; }
        .bd-value { color: #212529; word-break: break-word; }

        .bd-sample-placeholder {
            border: 1px solid rgba(0,0,0,0.08);
            border-radius: 12px;
            padding: 26px 14px;
            background: #fff;
        }
        .bd-sample-img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.10);
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
                        <a class="nav-link" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person-circle me-1"></i>Profile
                        </a>
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
            <div class="row p-4 p-md-4 p-3">
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['total_bookings'] }}</div>
                        <div class="stats-label">Total Appointments</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['today_bookings'] }}</div>
                        <div class="stats-label">Today's Appointments</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['pending_bookings'] }}</div>
                        <div class="stats-label">Pending</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">{{ $stats['confirmed_bookings'] }}</div>
                        <div class="stats-label">Confirmed</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Stats -->
            <div class="row mb-4 px-4 px-md-4 px-3">
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <div class="stats-card bg-success text-white">
                        <div class="stats-number">$<span>{{ number_format($stats['today_revenue'], 2) }}</span></div>
                        <div class="stats-label">Today's Revenue</div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-3 mb-md-0">
                    <div class="stats-card bg-primary text-white">
                        <div class="stats-number">$<span>{{ number_format($stats['monthly_revenue'], 2) }}</span></div>
                        <div class="stats-label">This Month</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="stats-card bg-info text-white">
                        <div class="stats-number">{{ $stats['completed_bookings'] }}</div>
                        <div class="stats-label">Completed</div>
                    </div>
                </div>
            </div>

                    <!-- Block Dates Modal -->
                    <div class="modal fade" id="blockModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border-bottom: none; padding: 20px 24px;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-slash-circle-fill me-2" style="font-size: 1.5rem;"></i>
                                        <h5 class="modal-title mb-0" style="font-weight: 700;">Block Dates / Range</h5>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="padding: 24px;">
                                    <div class="alert alert-info d-flex align-items-start mb-4" style="background: #e7f3ff; border-left: 4px solid #0ea5e9; border-radius: 6px;">
                                        <i class="bi bi-info-circle-fill me-2" style="color: #0ea5e9; font-size: 1.2rem;"></i>
                                        <div>
                                            <strong>Note:</strong> Blocked dates will prevent bookings during the selected period. Users will see these dates/times as unavailable on the booking calendar.
                                        </div>
                                    </div>

                                    <div id="editingBlockNotice" class="alert alert-warning d-flex align-items-start mb-4" style="display:none; background:#fff3cd; border-left: 4px solid #ffc107; border-radius: 6px;">
                                        <i class="bi bi-pencil-square me-2" style="color:#b45309; font-size: 1.2rem;"></i>
                                        <div>
                                            <strong>Editing block:</strong> update the title/reason, date, or time and click <strong>Update Block</strong> to save.
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-tag me-1"></i>Title / Reason
                                            <span class="text-muted small">(optional)</span>
                                        </label>
                                        <input id="blockTitle" type="text" class="form-control form-control-lg" placeholder="e.g., Closed for holidays, Staff training, Maintenance">
                                        <small class="form-text text-muted">This will be displayed to users when they try to book on blocked dates.</small>
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check form-switch mb-2">
                                            <input type="checkbox" class="form-check-input" id="blockAllDay" checked style="width: 3rem; height: 1.5rem;">
                                            <label class="form-check-label fw-semibold" for="blockAllDay">
                                                <i class="bi bi-calendar-day me-1"></i>All Day Block
                                            </label>
                                        </div>
                                        <div id="allDayHelpText" class="form-text text-muted">
                                            <i class="bi bi-check-circle me-1 text-success"></i><strong>Full Day:</strong> Blocks the entire day(s). Perfect for holidays, training days, or complete closures.
                                            <br><small class="text-muted mt-1 d-block">💡 <strong>Tip:</strong> For multi-day blocks, select start and end dates. The entire range will be blocked.</small>
                                        </div>
                                        <div id="timeSpecificHelpText" class="form-text text-muted" style="display: none;">
                                            <i class="bi bi-clock me-1 text-warning"></i><strong>Time-Specific:</strong> Blocks only specific hours. Keep the rest of the day available for bookings.
                                            <br><small class="text-muted mt-1 d-block">
                                                💡 <strong>Examples:</strong><br>
                                                • Block mornings (00:00 - 14:00) → Open from 3 PM (15:00)<br>
                                                • Block afternoons (14:00 - 23:59) → Open till 1 PM (13:00)<br>
                                                • Block lunch (12:00 - 13:00) → Morning & afternoon open
                                            </small>
                                            <br><small class="text-muted mt-1 d-block">
                                                📋 <strong>Available Time Slots:</strong> 9 AM, 10 AM, 11 AM, 12 PM, 1 PM, 2 PM, 3 PM, 4 PM, 5 PM, 6 PM
                                            </small>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold mb-2">
                                                <i class="bi bi-calendar-event me-1"></i><span id="startLabel">Start Date</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input id="blockStart" type="datetime-local" class="form-control form-control-lg" required>
                                            <small id="startHelpText" class="form-text text-muted">Select the first day to block</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold mb-2">
                                                <i class="bi bi-calendar-x me-1"></i><span id="endLabel">End Date</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input id="blockEnd" type="datetime-local" class="form-control form-control-lg" required>
                                            <small id="endHelpText" class="form-text text-muted">Select the last day to block (inclusive)</small>
                                        </div>
                                    </div>

                                    <!-- Quick Examples Section -->
                                    <div class="mt-4 mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-lightbulb me-2" style="color: #ffc107;"></i>
                                            <strong class="text-muted small">Quick Examples:</strong>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillBlockExample('fullday-single')">
                                                <i class="bi bi-calendar-day me-1"></i>Single Day
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="fillBlockExample('fullday-range')">
                                                <i class="bi bi-calendar-range me-1"></i>Date Range
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="fillBlockExample('time-morning')">
                                                <i class="bi bi-sunrise me-1"></i>Block Till 2 PM
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="fillBlockExample('time-afternoon')">
                                                <i class="bi bi-sunset me-1"></i>Block From 2 PM
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="fillBlockExample('time-lunch')">
                                                <i class="bi bi-egg-fried me-1"></i>Lunch Block
                                            </button>
                                        </div>
                                    </div>

                                    <div id="blockPreview" class="mt-4 p-4 rounded" style="background: #f8f9fa; border: 2px solid #ff6600; border-left: 6px solid #ff6600; display: none;">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-eye-fill me-2" style="color: #ff6600; font-size: 1.3rem;"></i>
                                            <strong style="color: #0b3a66; font-size: 1.1rem;">Block Preview</strong>
                                        </div>
                                        <div id="blockPreviewContent" class="text-muted small"></div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 16px 24px;">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-1"></i>Cancel
                                    </button>
                                    <button type="button" id="submitBlock" class="btn btn-danger btn-lg px-4" style="font-weight: 600;">
                                        <i class="bi bi-slash-circle me-2"></i>Create Block
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                                <!-- Manage Blocks Modal -->
                                <div class="modal fade" id="manageBlocksModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border-bottom: none; padding: 20px 24px;">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-list-ul me-2" style="font-size: 1.5rem;"></i>
                                                    <h5 class="modal-title mb-0" style="font-weight: 700;">Manage Blocked Dates</h5>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="padding: 24px; max-height: 500px; overflow-y: auto;">
                                                <div class="alert alert-info d-flex align-items-start mb-4" style="background: #e7f3ff; border-left: 4px solid #0ea5e9; border-radius: 6px;">
                                                    <i class="bi bi-info-circle-fill me-2" style="color: #0ea5e9; font-size: 1.2rem;"></i>
                                                    <div>
                                                        <strong>Manage your blocked date ranges:</strong> View all active blocked periods and remove them if needed.
                                                    </div>
                                                </div>
                                                <div id="blocksList" class="list-group" style="border-radius: 8px; overflow: hidden;">
                                                    <div class="text-center text-muted py-4">
                                                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                        Loading blocked ranges...
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 16px 24px;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="bi bi-x-circle me-1"></i>Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    </div>
        </div>

            <!-- Admin Calendar -->
            <div class="row p-4">
                <div class="col-12">
                    <div class="appointment-card">
                        <div class="appointment-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Schedule (Calendar)</h4>
                                <small class="text-muted">Drag confirmed/pending bookings to reschedule</small>
                            </div>
                            <div class="btn-group" role="group">
                                <button id="openBlockModal" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-slash-circle me-1"></i>Block Dates
                                </button>
                                <button id="openManageBlocks" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list-ul me-1"></i>Manage Blocks
                                </button>
                                <button id="openCompleteServicesModal" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-award me-1"></i>Complete Services
                                </button>
                            </div>
                        </div>
                        <div class="appointment-body">
                            <div id="adminCalendar" data-events-url="{{ route('admin.schedules.events') }}" data-reschedule-url="{{ route('admin.schedules.reschedule') }}" data-store-url="{{ route('admin.schedules.store') }}" style="max-width: 100%; min-height: 650px;" class="calendar-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reschedule Booking Modal (Admin-only) -->
            <div class="modal fade" id="rescheduleBookingModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 14px; overflow: hidden;">
                        <div class="modal-header" style="background: linear-gradient(135deg, #0ea5e9 0%, #4a8bc2 100%); color: white;">
                            <h5 class="modal-title" style="font-weight: 800;">
                                <i class="bi bi-calendar2-week me-2"></i>Reschedule Booking
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Select a new <strong>date</strong> and <strong>time</strong>. This updates the booking and sends the customer a reschedule email.
                            </div>

                            <input type="hidden" id="rescheduleBookingId" value="">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Date</label>
                                <input type="date" class="form-control" id="rescheduleDate" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Time</label>
                                <select class="form-select" id="rescheduleTime">
                                    <option value="">Select a time</option>
                                </select>
                                <div class="form-text">Only shows available times (not booked + not blocked).</div>
                            </div>

                            <div id="rescheduleError" class="alert alert-danger" style="display:none;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmRescheduleBtn">
                                <i class="bi bi-check2-circle me-1"></i>Reschedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Filters -->
        <div class="filter-section px-4 px-md-4 px-3 py-3">
            <div class="row align-items-end">
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <label for="statusFilter" class="form-label">Status Filter</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <label for="dateFilter" class="form-label">Date Filter</label>
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <label for="serviceFilter" class="form-label">Service Filter</label>
                    <select class="form-select" id="serviceFilter">
                        <option value="">All Services</option>
                        <option value="Small Knotless Braids">Small Knotless Braids</option>
                        <option value="Smedium Knotless Braids">Smedium Knotless Braids</option>
                        <option value="Wig Installation">Wig Installation</option>
                        <option value="Medium Knotless Braids">Medium Knotless Braids</option>
                        <option value="Jumbo Knotless Braids">Jumbo Knotless Braids</option>
                        <option value="Kids Braids">Kids Braids</option>
                        <option value="8–10 Rows Stitch Braids">8–10 Rows Stitch Braids</option>
                        <option value="Hair Mask/Relaxing">Hair Mask/Relaxing</option>
                        <option value="Smedium Boho Braids">Smedium Boho Braids</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 mb-3 mb-md-0">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button class="btn btn-primary w-100" type="button" onclick="applyFilters()">
                        <i class="bi bi-search me-2"></i><span class="d-none d-md-inline">Filter</span><span class="d-md-none">Filter</span>
                    </button>
                </div>
                <div class="col-6 col-md-1 mb-3 mb-md-0">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button class="btn btn-outline-secondary w-100" type="button" onclick="clearFilters()" title="Clear all filters">
                        <i class="bi bi-x-circle d-md-none"></i><span class="d-none d-md-inline"><i class="bi bi-x-circle"></i></span>
                    </button>
                </div>

                <!-- Bookings Table (all screen sizes; scrolls horizontally on small screens) -->
                <div class="table-responsive mt-4">
                    <table class="table table-hover admin-bookings-table">
                        <thead>
                            <tr>
                                <th class="cursor-pointer" onclick="sortTable('id')">Booking ID <i class="bi bi-arrow-down-up text-muted"></i></th>
                                <th class="cursor-pointer" onclick="sortTable('name')">Customer Name <i class="bi bi-arrow-down-up text-muted"></i></th>
                                <th>Contact</th>
                                <th class="cursor-pointer" onclick="sortTable('service')">Service <i class="bi bi-arrow-down-up text-muted"></i></th>
                                <th>Final Price</th>
                                <th class="cursor-pointer" onclick="sortTable('appointment_date')">Appointment Date <i class="bi bi-arrow-down-up text-muted"></i></th>
                                <th class="cursor-pointer" onclick="sortTable('appointment_time')">Appointment Time <i class="bi bi-arrow-down-up text-muted"></i></th>
                                <th>Sample Image</th>
                                <th class="cursor-pointer" onclick="sortTable('status')">Status <i class="bi bi-arrow-down-up text-muted"></i></th>
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
                                                @if(isset($booking->final_price))
                                                    ${{ number_format($booking->final_price, 2) }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
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
                                                @if($booking->confirmation_code)
                                                    <a class="btn btn-outline-primary btn-sm mb-1"
                                                       href="{{ url('/bookings/confirm/' . $booking->id . '/' . $booking->confirmation_code) }}"
                                                       target="_blank" rel="noopener"
                                                       title="Edit Booking (public link)">
                                                        <i class="bi bi-pencil-square"></i> Edit Booking
                                                    </a>
                                                @endif
                                                @if($booking->status === 'pending')
                                                    <button class="btn btn-success btn-sm mb-1" onclick="updateStatusQuick({{ $booking->id }}, 'confirmed')">
                                                        <i class="bi bi-check"></i> Confirm
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="updateStatusQuick({{ $booking->id }}, 'cancelled')">
                                                        <i class="bi bi-x"></i> Cancel
                                                    </button>
                                                @elseif($booking->status === 'confirmed')
                                                    <button class="btn btn-info btn-sm mb-1" onclick="updateStatusQuick({{ $booking->id }}, 'completed')" title="Mark service as completed">
                                                        <i class="bi bi-award"></i> Complete Service
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="updateStatusQuick({{ $booking->id }}, 'cancelled')">
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
                                    <td colspan="10" class="text-center">No appointments found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View (disabled; keeping markup for now) -->
                <div class="d-none mt-4 px-3" id="appointmentsMobileCards">
                    @if($bookings->count() > 0)
                        @foreach($bookings as $booking)
                            <div class="appointment-mobile-card">
                                <div class="card-header-mobile">
                                    <div class="booking-id">Booking #{{ $booking->id }}</div>
                                    @if($booking->confirmation_code)
                                        <small class="text-muted">Conf: {{ $booking->confirmation_code }}</small>
                                    @endif
                                    <div class="mt-2">
                                        <span class="status-badge status-{{ $booking->status }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-row">
                                    <span class="card-label">Customer:</span>
                                    <span class="card-value"><strong>{{ $booking->name }}</strong></span>
                                </div>
                                
                                @if($booking->email)
                                <div class="card-row">
                                    <span class="card-label">Email:</span>
                                    <span class="card-value">{{ $booking->email }}</span>
                                </div>
                                @endif
                                
                                <div class="card-row">
                                    <span class="card-label">Phone:</span>
                                    <span class="card-value">{{ $booking->phone }}</span>
                                </div>
                                
                                @if($booking->address)
                                <div class="card-row">
                                    <span class="card-label">Address:</span>
                                    <span class="card-value">{{ $booking->address }}</span>
                                </div>
                                @endif
                                
                                <div class="card-row">
                                    <span class="card-label">Service:</span>
                                    <span class="card-value">{{ $booking->service ?: 'General Service' }}</span>
                                </div>
                                
                                @if($booking->length)
                                <div class="card-row">
                                    <span class="card-label">Length:</span>
                                    <span class="card-value">{{ $booking->length }}</span>
                                </div>
                                @endif
                                
                                @if(isset($booking->final_price))
                                <div class="card-row">
                                    <span class="card-label">Price:</span>
                                    <span class="card-value"><strong>${{ number_format($booking->final_price, 2) }}</strong></span>
                                </div>
                                @endif
                                
                                @if($booking->appointment_date)
                                <div class="card-row">
                                    <span class="card-label">Date:</span>
                                    <span class="card-value">{{ $booking->appointment_date->format('M d, Y') }} ({{ $booking->appointment_date->format('l') }})</span>
                                </div>
                                @endif
                                
                                <div class="card-row">
                                    <span class="card-label">Time:</span>
                                    <span class="card-value">{{ $booking->appointment_time }}</span>
                                </div>
                                
                                @if($booking->sample_picture)
                                <div class="card-row">
                                    <span class="card-label">Sample:</span>
                                    <span class="card-value">
                                        <img src="{{ asset('storage/' . $booking->sample_picture) }}"
                                             alt="Sample"
                                             class="sample-image"
                                             onclick="viewImageModal('{{ asset('storage/' . $booking->sample_picture) }}', '{{ $booking->name }}')"
                                             title="Click to view full size"
                                             style="width: 60px; height: 60px;">
                                    </span>
                                </div>
                                @endif
                                
                                <div class="card-actions">
                                    <button class="btn btn-outline-info btn-sm" onclick="viewBookingDetails({{ $booking->id }})">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                    @if($booking->confirmation_code)
                                        <a class="btn btn-outline-primary btn-sm"
                                           href="{{ url('/bookings/confirm/' . $booking->id . '/' . $booking->confirmation_code) }}"
                                           target="_blank" rel="noopener"
                                           title="Edit Booking (public link)">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    @endif
                                    @if($booking->status === 'pending')
                                        <button class="btn btn-success btn-sm" onclick="updateStatusQuick({{ $booking->id }}, 'confirmed')">
                                            <i class="bi bi-check"></i> Confirm
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="updateStatusQuick({{ $booking->id }}, 'cancelled')">
                                            <i class="bi bi-x"></i> Cancel
                                        </button>
                                    @elseif($booking->status === 'confirmed')
                                        <button class="btn btn-info btn-sm" onclick="updateStatusQuick({{ $booking->id }}, 'completed')">
                                            <i class="bi bi-award"></i> Complete
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="updateStatusQuick({{ $booking->id }}, 'cancelled')">
                                            <i class="bi bi-x"></i> Cancel
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">No appointments found.</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if($bookings->hasPages())
                <div id="bookingsPaginationBar" class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-3 px-md-0">
                    <div class="pagination-info mb-3 mb-md-0">
                        <small class="text-muted">
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} bookings
                        </small>
                    </div>
                    <nav aria-label="Bookings pagination">
                        <ul class="pagination pagination-sm mb-0">
                            @php
                                $paginated = $bookings->appends(request()->except('page'));
                                $current = $bookings->currentPage();
                                $last = $bookings->lastPage();
                                $start = max(1, $current - 3);
                                $end = min($last, $current + 3);
                            @endphp
                            {{-- Previous Page Link --}}
                            @if ($bookings->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $paginated->previousPageUrl() }}">Previous</a>
                                </li>
                            @endif

                            {{-- First page + leading ellipsis --}}
                            @if($start > 1)
                                <li class="page-item"><a class="page-link" href="{{ $paginated->url(1) }}">1</a></li>
                                @if($start > 2)
                                    <li class="page-item disabled"><span class="page-link">…</span></li>
                                @endif
                            @endif

                            {{-- Page window --}}
                            @foreach ($paginated->getUrlRange($start, $end) as $page => $url)
                                @if ($page == $bookings->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Trailing ellipsis + last page --}}
                            @if($end < $last)
                                @if($end < ($last - 1))
                                    <li class="page-item disabled"><span class="page-link">…</span></li>
                                @endif
                                <li class="page-item"><a class="page-link" href="{{ $paginated->url($last) }}">{{ $last }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($bookings->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $paginated->nextPageUrl() }}">Next</a>
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
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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

    <!-- Recent Custom Service Requests -->
    <div class="container mb-5">
        <div class="card shadow-sm" style="border-radius: 16px; overflow: hidden;">
            <div class="card-header" style="background: linear-gradient(135deg, #0d6efd 0%, #05137c 100%); color: white;">
                <h5 class="mb-0">Recent Custom Service Requests</h5>
            </div>
            <div class="card-body p-0">
                @if(isset($customRequests) && $customRequests->count())
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Service</th>
                                    <th>Submitted</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customRequests as $req)
                                    <tr>
                                        <td>{{ $req->id }}</td>
                                        <td>{{ $req->name }}</td>
                                        <td>{{ $req->email ?? '-' }}</td>
                                        <td>{{ $req->phone ?? '-' }}</td>
                                        <td>{{ $req->service ?? '-' }}</td>
                                        <td>{{ $req->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ url('/admin/bookings/'.$req->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-4">
                        <p class="text-muted mb-0">No custom service requests yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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

                        <!-- Cancelled by input (show when status is 'cancelled') -->
                        <div id="cancelFields" style="display: none;">
                            <div class="mb-3">
                                <label for="cancelledBy" class="form-label">Cancelled By (Name)</label>
                                <input type="text" class="form-control" id="cancelledBy" placeholder="Enter who cancelled (e.g., Admin, User)">
                            </div>
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
                                <label for="finalPrice" class="form-label">Final Price ($)</label>
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
                    <button type="button" class="btn btn-primary" onclick="updateStatusModal()">Update Status</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete Services Modal -->
    <div class="modal fade" id="completeServicesModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-bottom: none;">
                    <h5 class="modal-title">
                        <i class="bi bi-award me-2"></i>Complete Services
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Form -->
                    <div class="card mb-4" style="border: 2px solid #28a745;">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="bi bi-search me-2"></i>Search Bookings
                            </h6>
                            <form id="completeServicesSearchForm">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label for="searchBookingId" class="form-label">Booking ID</label>
                                        <input type="number" class="form-control" id="searchBookingId" placeholder="e.g., 123">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="searchCustomerName" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="searchCustomerName" placeholder="e.g., John Doe">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="searchDate" class="form-label">Appointment Date</label>
                                        <input type="date" class="form-control" id="searchDate">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="searchService" class="form-label">Service Name</label>
                                        <input type="text" class="form-control" id="searchService" placeholder="e.g., Small Knotless Braids">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-search me-2"></i>Search
                                        </button>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-secondary w-100" onclick="clearCompleteServicesSearch()">
                                            <i class="bi bi-x-circle me-2"></i>Clear Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Search Results -->
                    <div id="completeServicesResults" style="display: none;">
                        <h6 class="mb-3">
                            <i class="bi bi-list-ul me-2"></i>Search Results
                            <span id="resultsCount" class="badge bg-success ms-2"></span>
                        </h6>
                        <div id="completeServicesResultsList" class="list-group">
                            <!-- Results will be populated here -->
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="completeServicesEmpty" class="text-center py-5">
                        <i class="bi bi-search" style="font-size: 3rem; color: #dee2e6;"></i>
                        <p class="text-muted mt-3">Use the search form above to find bookings to complete</p>
                    </div>

                    <!-- Loading State -->
                    <div id="completeServicesLoading" style="display: none;" class="text-center py-5">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-3">Searching bookings...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete Service Detail Modal -->
    <div class="modal fade" id="completeServiceDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-bottom: none;">
                    <h5 class="modal-title">
                        <i class="bi bi-award me-2"></i>Complete Service - Booking #<span id="completeBookingId"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="completeServiceForm">
                        <input type="hidden" id="completeBookingIdInput" name="booking_id">
                        
                        <!-- Booking Info -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Booking Information</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <strong>Customer:</strong> <span id="completeCustomerName"></span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Service:</strong> <span id="completeServiceName"></span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Date:</strong> <span id="completeAppointmentDate"></span>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <strong>Time:</strong> <span id="completeAppointmentTime"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completion Fields -->
                        <div class="mb-3">
                            <label for="completeStaffMember" class="form-label">Completed By (Staff Member) *</label>
                            <input type="text" class="form-control" id="completeStaffMember" name="completed_by" required>
                        </div>

                        <div class="mb-3">
                            <label for="completeServiceDuration" class="form-label">Service Duration (minutes) *</label>
                            <input type="number" class="form-control" id="completeServiceDuration" name="service_duration_minutes" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="completeFinalPrice" class="form-label">Final Price ($) *</label>
                            <input type="number" class="form-control" id="completeFinalPrice" name="final_price" step="0.01" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="completePaymentStatus" class="form-label">Payment Status</label>
                            <select class="form-select" id="completePaymentStatus" name="payment_status" required>
                                <option value="pending">Pending</option>
                                <option value="fully_paid">Fully Paid</option>
                                <option value="deposit_paid">Deposit Only</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="completeNotes" class="form-label">Completion Notes</label>
                            <textarea class="form-control" id="completeNotes" name="completion_notes" rows="3" placeholder="Optional notes about the service completion..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="submitCompleteService">
                        <i class="bi bi-award me-2"></i>Complete Service
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image View Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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

    <!-- Note: removed duplicate Enhanced Details Modal to avoid duplicate IDs -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FullCalendar script will be loaded and initialized at the end of the page to avoid breaking Blade directives -->
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

            // Show loading state for both desktop and mobile views
            const tableBody = document.getElementById('appointmentsTable');
            const mobileCards = document.getElementById('appointmentsMobileCards');
            
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            }
            
            if (mobileCards) {
                mobileCards.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            }

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

                    // Extract the table body content (desktop view)
                    const newTableBody = tempDiv.querySelector('#appointmentsTable');
                    if (newTableBody && tableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }

                    // Extract the mobile cards content
                    const mobileCards = document.getElementById('appointmentsMobileCards');
                    const newMobileCards = tempDiv.querySelector('#appointmentsMobileCards');
                    if (newMobileCards && mobileCards) {
                        mobileCards.innerHTML = newMobileCards.innerHTML;
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

                    // Update pagination bar (page numbers / prev-next)
                    const newPaginationBar = tempDiv.querySelector('#bookingsPaginationBar');
                    const currentPaginationBar = document.getElementById('bookingsPaginationBar');
                    if (newPaginationBar && currentPaginationBar) {
                        currentPaginationBar.innerHTML = newPaginationBar.innerHTML;
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

            // Show loading state for both desktop and mobile views
            const tableBody = document.getElementById('appointmentsTable');
            const mobileCards = document.getElementById('appointmentsMobileCards');
            
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            }
            
            if (mobileCards) {
                mobileCards.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            }

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

                    // Extract the table body content (desktop view)
                    const newTableBody = tempDiv.querySelector('#appointmentsTable');
                    if (newTableBody && tableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }

                    // Extract the mobile cards content
                    const newMobileCards = tempDiv.querySelector('#appointmentsMobileCards');
                    if (newMobileCards && mobileCards) {
                        mobileCards.innerHTML = newMobileCards.innerHTML;
                    }

                    // Update pagination info if it exists
                    const paginationInfo = tempDiv.querySelector('.pagination-info');
                    if (paginationInfo) {
                        const currentPaginationInfo = document.querySelector('.pagination-info');
                        if (currentPaginationInfo) {
                            currentPaginationInfo.innerHTML = paginationInfo.innerHTML;
                        }
                    }

                    // Update pagination bar (page numbers / prev-next)
                    const newPaginationBar = tempDiv.querySelector('#bookingsPaginationBar');
                    const currentPaginationBar = document.getElementById('bookingsPaginationBar');
                    if (newPaginationBar && currentPaginationBar) {
                        currentPaginationBar.innerHTML = newPaginationBar.innerHTML;
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

            // Show loading state for both desktop and mobile views
            const tableBody = document.getElementById('appointmentsTable');
            const mobileCards = document.getElementById('appointmentsMobileCards');
            
            if (tableBody) {
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';
            }
            
            if (mobileCards) {
                mobileCards.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            }

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

                    // Extract the table body content (desktop view)
                    const newTableBody = tempDiv.querySelector('#appointmentsTable');
                    if (newTableBody && tableBody) {
                        tableBody.innerHTML = newTableBody.innerHTML;
                    }

                    // Extract the mobile cards content
                    const newMobileCards = tempDiv.querySelector('#appointmentsMobileCards');
                    if (newMobileCards && mobileCards) {
                        mobileCards.innerHTML = newMobileCards.innerHTML;
                    }

                    // Update pagination info if it exists
                    const paginationInfo = tempDiv.querySelector('.pagination-info');
                    if (paginationInfo) {
                        const currentPaginationInfo = document.querySelector('.pagination-info');
                        if (currentPaginationInfo) {
                            currentPaginationInfo.innerHTML = paginationInfo.innerHTML;
                        }
                    }

                    // Update pagination bar (page numbers / prev-next)
                    const newPaginationBar = tempDiv.querySelector('#bookingsPaginationBar');
                    const currentPaginationBar = document.getElementById('bookingsPaginationBar');
                    if (newPaginationBar && currentPaginationBar) {
                        currentPaginationBar.innerHTML = newPaginationBar.innerHTML;
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
                        showBookingDetails(data.booking, data.breakdown || null);
                    } else {
                        alert('Error loading booking details: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error loading booking details:', error);
                    alert('Error loading booking details. Please try again.');
                });
        }

        function showBookingDetails(booking, breakdown) {
            const safe = (v, fallback = 'Not provided') => {
                if (v === null || typeof v === 'undefined') return fallback;
                const s = String(v).trim();
                return s.length ? s : fallback;
            };

            const bookingId = booking.booking_id || booking.id;
            const confirmationCode = booking.confirmation_code ? String(booking.confirmation_code).trim() : '';
            const editUrl = (booking.id && confirmationCode)
                ? (`/bookings/confirm/${booking.id}/${encodeURIComponent(confirmationCode)}`)
                : null;
            const apptDate = booking.appointment_date
                ? new Date(String(booking.appointment_date).slice(0, 10) + 'T00:00:00').toLocaleDateString()
                : 'N/A';
            const finalPrice = (booking.final_price !== null && typeof booking.final_price !== 'undefined' && String(booking.final_price).length)
                ? ('$' + parseFloat(booking.final_price).toFixed(2))
                : 'N/A';
            const sampleUrl = booking.sample_picture
                ? (String(booking.sample_picture).startsWith('http') ? booking.sample_picture : '/storage/' + booking.sample_picture)
                : null;

            const isKids = !!(booking.kb_braid_type || booking.kb_length || (String(booking.service || '').toLowerCase().includes('kids')));
            const stitchRows = booking.stitch_rows_option ? String(booking.stitch_rows_option) : '';
            const hairMaskOpt = booking.hair_mask_option ? String(booking.hair_mask_option) : (booking.selectedHairMaskOption ? String(booking.selectedHairMaskOption) : '');

            const pretty = (raw) => {
                const s = (raw || '').toString();
                return s.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
            };

            const breakdownHtml = (breakdown && typeof breakdown === 'object' && Object.keys(breakdown).length)
                ? `
                    <div class="col-12">
                        <div class="bd-card">
                            <div class="bd-card-header" style="background:#0ea5e9;color:white;">
                                <i class="bi bi-cash-coin"></i>
                                <span>Pricing Breakdown</span>
                            </div>
                            <div class="bd-panel">
                                <div class="bd-row">
                                    <div class="bd-label">Resolved Base:</div>
                                    <div class="bd-value">${(breakdown.resolved_base !== null && typeof breakdown.resolved_base !== 'undefined') ? ('$' + parseFloat(breakdown.resolved_base).toFixed(2)) : 'N/A'}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Length Adjust:</div>
                                    <div class="bd-value">${(breakdown.length_adjust !== null && typeof breakdown.length_adjust !== 'undefined') ? ('$' + parseFloat(breakdown.length_adjust).toFixed(2)) : 'N/A'}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Add-ons Total:</div>
                                    <div class="bd-value">${(breakdown.addons_total !== null && typeof breakdown.addons_total !== 'undefined') ? ('$' + parseFloat(breakdown.addons_total).toFixed(2)) : 'N/A'}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Computed Total:</div>
                                    <div class="bd-value">${(breakdown.computed_total !== null && typeof breakdown.computed_total !== 'undefined') ? ('$' + parseFloat(breakdown.computed_total).toFixed(2)) : 'N/A'}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Final Price Saved:</div>
                                    <div class="bd-value">${finalPrice}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
                : '';

            const detailsHtml = `
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="bd-card">
                            <div class="bd-card-header bd-customer">
                                <i class="bi bi-person"></i>
                                <span>Customer Information</span>
                            </div>
                            <div class="bd-panel">
                                <div class="bd-row">
                                    <div class="bd-label">Name:</div>
                                    <div class="bd-value">${safe(booking.name, '—')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Phone:</div>
                                    <div class="bd-value">${safe(booking.phone, '—')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Email:</div>
                                    <div class="bd-value">${safe(booking.email, 'Not provided')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Address:</div>
                                    <div class="bd-value">${safe(booking.address, 'Not provided')}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="bd-card">
                            <div class="bd-card-header bd-sample">
                                <i class="bi bi-image"></i>
                                <span>Sample Image</span>
                            </div>
                            <div class="bd-panel text-center">
                                ${sampleUrl ? `
                                    <img
                                        src="${sampleUrl}"
                                        alt="Sample Image"
                                        class="bd-sample-img cursor-pointer"
                                        onclick="viewImageModal('${sampleUrl}', '${safe(booking.name, 'Customer')}')"
                                    >
                                    <div class="mt-3">
                                        <a href="${sampleUrl}" download class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i>Download
                                        </a>
                                    </div>
                                ` : `
                                    <div class="bd-sample-placeholder text-muted">
                                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                                        <div class="mt-2">No sample image uploaded</div>
                                    </div>
                                `}
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="bd-card">
                            <div class="bd-card-header bd-appointment">
                                <i class="bi bi-calendar"></i>
                                <span>Appointment Information</span>
                            </div>
                            <div class="bd-panel">
                                <div class="bd-row">
                                    <div class="bd-label">Booking ID:</div>
                                    <div class="bd-value">${safe(bookingId, '—')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Confirmation Code:</div>
                                    <div class="bd-value">${safe(booking.confirmation_code, 'N/A')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Service:</div>
                                    <div class="bd-value">${safe(booking.service, '—')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Length:</div>
                                    <div class="bd-value">${safe(booking.length, 'Not specified')}</div>
                                </div>
                                ${hairMaskOpt ? `
                                    <div class="bd-row">
                                        <div class="bd-label">Hair Mask Option:</div>
                                        <div class="bd-value">${pretty(hairMaskOpt)}</div>
                                    </div>
                                ` : ''}
                                ${stitchRows ? `
                                    <div class="bd-row">
                                        <div class="bd-label">Stitch Rows:</div>
                                        <div class="bd-value">${pretty(stitchRows)}</div>
                                    </div>
                                ` : ''}
                                <div class="bd-row">
                                    <div class="bd-label">Final Price:</div>
                                    <div class="bd-value">${finalPrice}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Date:</div>
                                    <div class="bd-value">${apptDate}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Time:</div>
                                    <div class="bd-value">${safe(booking.appointment_time, '—')}</div>
                                </div>
                                <div class="bd-row">
                                    <div class="bd-label">Status:</div>
                                    <div class="bd-value">
                                        <span class="status-badge status-${safe(booking.status, 'pending').toLowerCase()}">
                                            ${safe(booking.status, 'pending').charAt(0).toUpperCase() + safe(booking.status, 'pending').slice(1)}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    ${isKids ? `
                        <div class="col-12">
                            <div class="bd-card">
                                <div class="bd-card-header" style="background:#7c3aed;color:white;">
                                    <i class="bi bi-people"></i>
                                    <span>Kids Booking Details</span>
                                </div>
                                <div class="bd-panel">
                                    <div class="bd-row">
                                        <div class="bd-label">Braid Type:</div>
                                        <div class="bd-value">${safe(pretty(booking.kb_braid_type), '—')}</div>
                                    </div>
                                    <div class="bd-row">
                                        <div class="bd-label">Finish:</div>
                                        <div class="bd-value">${safe(pretty(booking.kb_finish), '—')}</div>
                                    </div>
                                    <div class="bd-row">
                                        <div class="bd-label">Kids Length:</div>
                                        <div class="bd-value">${safe(pretty(booking.kb_length), '—')}</div>
                                    </div>
                                    <div class="bd-row">
                                        <div class="bd-label">Extras:</div>
                                        <div class="bd-value">${safe(pretty(booking.kb_extras), '—')}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ` : ''}

                    ${booking.message ? `
                        <div class="col-12">
                            <div class="bd-card">
                                <div class="bd-card-header" style="background:#ffc107;color:#212529;">
                                    <i class="bi bi-chat-text"></i>
                                    <span>Customer Message</span>
                                </div>
                                <div class="bd-panel">
                                    <div class="text-muted">${safe(booking.message, '')}</div>
                                </div>
                            </div>
                        </div>
                    ` : ''}

                    ${booking.status === 'completed' && booking.completed_at ? `
                        <div class="col-12">
                            <div class="bd-card">
                                <div class="bd-card-header bd-appointment">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Service Completion Details</span>
                                </div>
                                <div class="bd-panel">
                                    <div class="bd-row">
                                        <div class="bd-label">Completed By:</div>
                                        <div class="bd-value">${safe(booking.completed_by, 'N/A')}</div>
                                    </div>
                                    <div class="bd-row">
                                        <div class="bd-label">Duration:</div>
                                        <div class="bd-value">${booking.service_duration_minutes ? (booking.service_duration_minutes + ' minutes') : 'N/A'}</div>
                                    </div>
                                    ${booking.completion_notes ? `
                                        <div class="bd-row">
                                            <div class="bd-label">Notes:</div>
                                            <div class="bd-value">${safe(booking.completion_notes, '')}</div>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    ` : ''}

                    ${breakdownHtml}
                </div>
            `;

            // Add a modal footer with action buttons (Close + Complete Service when applicable)
            const footerHtml = `
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    ${editUrl ? `
                        <a href="${editUrl}" target="_blank" rel="noopener" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-1"></i> Edit Booking
                        </a>
                    ` : ''}
                    ${(booking.status !== 'completed' && booking.status !== 'cancelled') ? `
                        <button type="button" class="btn btn-outline-primary" onclick="openRescheduleModal(${booking.id}, '${String(booking.appointment_date || '').slice(0,10)}', '${safe(booking.appointment_time, '')}')">
                            <i class="bi bi-calendar2-week me-1"></i> Reschedule
                        </button>
                    ` : ''}
                    ${booking.status !== 'completed' && booking.status !== 'cancelled' ? `
                        <button type="button" class="btn btn-info" onclick="updateStatusQuick(${booking.id}, 'completed')">
                            <i class="bi bi-award me-1"></i> Complete Service
                        </button>
                    ` : ''}
                </div>
            `;

            document.getElementById('bookingDetailsContent').innerHTML = detailsHtml + footerHtml;
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        }

        // --- Admin reschedule modal ---
        window.openRescheduleModal = async function(bookingId, currentDateRaw, currentTimeRaw) {
            const modalEl = document.getElementById('rescheduleBookingModal');
            if (!modalEl) return;

            // Ensure the reschedule modal appears on top by hiding the details modal first.
            // Bootstrap doesn't reliably stack modals/backdrops without custom z-index handling.
            try {
                const detailsEl = document.getElementById('detailsModal');
                const detailsInst = detailsEl ? bootstrap.Modal.getInstance(detailsEl) : null;
                if (detailsInst) detailsInst.hide();
            } catch (e) { /* noop */ }

            const idEl = document.getElementById('rescheduleBookingId');
            const dateEl = document.getElementById('rescheduleDate');
            const timeEl = document.getElementById('rescheduleTime');
            const errEl = document.getElementById('rescheduleError');

            if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }
            if (idEl) idEl.value = bookingId;
            if (dateEl && currentDateRaw) dateEl.value = String(currentDateRaw).slice(0,10);

            // Normalize time to H:i where possible
            const normalizeTime = (t) => {
                const s = (t || '').toString().trim();
                if (!s) return '';
                // Already H:i
                if (/^\d{2}:\d{2}$/.test(s)) return s;
                // Try parse "h:mm AM/PM"
                const m = s.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
                if (m) {
                    let hh = parseInt(m[1], 10);
                    const mm = parseInt(m[2], 10);
                    const ap = m[3].toUpperCase();
                    if (ap === 'PM' && hh < 12) hh += 12;
                    if (ap === 'AM' && hh === 12) hh = 0;
                    return String(hh).padStart(2,'0') + ':' + String(mm).padStart(2,'0');
                }
                return '';
            };

            const currentTime = normalizeTime(currentTimeRaw);

            const loadSlots = async (ymd) => {
                if (!timeEl) return;
                timeEl.innerHTML = '<option value="">Loading...</option>';
                try {
                    const resp = await fetch(`/bookings/slots?date=${encodeURIComponent(ymd)}`);
                    const data = await resp.json();
                    if (!data.success) throw new Error(data.message || 'Failed to load slots');
                    const slots = Array.isArray(data.slots) ? data.slots : [];
                    if (!slots.length) {
                        timeEl.innerHTML = '<option value="">No available times</option>';
                        return;
                    }
                    timeEl.innerHTML = '<option value="">Select a time</option>' + slots.map(s => {
                        const val = s.time || '';
                        const label = s.formatted_time || val;
                        return `<option value="${val}">${label}</option>`;
                    }).join('');

                    // Preselect current time if present and available; otherwise leave blank
                    if (currentTime) {
                        const opt = Array.from(timeEl.options).find(o => o.value === currentTime);
                        if (opt) timeEl.value = currentTime;
                    }
                } catch (e) {
                    timeEl.innerHTML = '<option value="">Failed to load times</option>';
                    if (errEl) { errEl.style.display = 'block'; errEl.textContent = 'Failed to load available times.'; }
                }
            };

            const initialDate = dateEl ? dateEl.value : '';
            if (initialDate) await loadSlots(initialDate);

            if (dateEl) {
                dateEl.onchange = async function() {
                    const ymd = dateEl.value;
                    if (!ymd) return;
                    await loadSlots(ymd);
                };
            }

            // Wait a moment for the details modal/backdrop to finish hiding, then show reschedule.
            setTimeout(() => {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }, 250);
        };

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('confirmRescheduleBtn');
            if (!btn) return;

            btn.addEventListener('click', async function() {
                const bookingId = document.getElementById('rescheduleBookingId')?.value;
                const dateVal = document.getElementById('rescheduleDate')?.value;
                const timeVal = document.getElementById('rescheduleTime')?.value;
                const errEl = document.getElementById('rescheduleError');

                if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }
                if (!bookingId || !dateVal || !timeVal) {
                    if (errEl) { errEl.style.display = 'block'; errEl.textContent = 'Please select both a date and a time.'; }
                    return;
                }

                // Build UTC ISO start to match FullCalendar admin settings
                const [y, m, d] = dateVal.split('-').map(n => parseInt(n, 10));
                const [hh, mm] = timeVal.split(':').map(n => parseInt(n, 10));
                const start = new Date(Date.UTC(y, m - 1, d, hh, mm, 0, 0));
                const end = new Date(start.getTime() + 60 * 60 * 1000);

                const calendarEl = document.getElementById('adminCalendar');
                const rescheduleUrl = calendarEl?.dataset?.rescheduleUrl || @json(route('admin.schedules.reschedule'));
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Rescheduling...';

                try {
                    const resp = await fetch(rescheduleUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify({ booking_id: parseInt(bookingId, 10), start: start.toISOString(), end: end.toISOString() })
                    });
                    const data = await resp.json();
                    if (!resp.ok || !data.success) {
                        throw new Error(data.message || `Failed (HTTP ${resp.status})`);
                    }

                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('rescheduleBookingModal'));
                    if (modal) modal.hide();

                    // Refresh calendar events and reload table
                    try { window.adminCalendar?.refetchEvents(); } catch (e) {}
                    window.location.reload();
                } catch (e) {
                    if (errEl) { errEl.style.display = 'block'; errEl.textContent = e.message || 'Failed to reschedule.'; }
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        });

        function updateAppointmentStatus(appointmentId) {
            currentAppointmentId = appointmentId;
            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        function updateStatusModal() {
            const newStatus = document.getElementById('newStatus').value;
            const notes = document.getElementById('statusNotes').value;
            const completedBy = document.getElementById('completedBy').value;
            const serviceDuration = document.getElementById('serviceDuration').value;
            const finalPrice = document.getElementById('finalPrice').value;
            const paymentStatus = document.getElementById('paymentStatus').value;
            const cancelledBy = document.getElementById('cancelledBy') ? document.getElementById('cancelledBy').value : null;

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

            // Add cancelled_by if status is 'cancelled'
            if (newStatus === 'cancelled' && cancelledBy) {
                requestData.cancelled_by = cancelledBy;
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
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        // Build a short summary from HTML or plain text
                        let summary = text;
                        if (/<[a-z][\s\S]*>/i.test(text)) {
                            const titleMatch = text.match(/<title[^>]*>([^<]*)<\/title>/i);
                            const h1Match = text.match(/<h1[^>]*>([^<]*)<\/h1>/i);
                            summary = (titleMatch && titleMatch[1]) || (h1Match && h1Match[1]) || text.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
                        }
                        summary = summary.split('\n')[0].trim();
                        if (summary.length > 200) summary = summary.slice(0, 200) + '...';
                        throw { message: `Server error (HTTP ${response.status}): ${summary}`, status: response.status, body: text };
                    });
                }
                return response.json();
            })
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
                if (error && error.body) {
                    console.error('Full server response for appointment status update:', error.body);
                } else {
                    console.error('Error updating status:', error);
                }
                const userMessage = (error && error.message) ? error.message : 'Error updating appointment status. Please try again.';
                alert(userMessage);
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
            const cancelFields = document.getElementById('cancelFields');

            if (status === 'completed') {
                completionFields.style.display = 'block';
                // Make completion fields required when status is completed
                document.getElementById('completedBy').required = true;
                document.getElementById('serviceDuration').required = true;
                document.getElementById('finalPrice').required = true;
                // hide cancelled fields
                if (cancelFields) cancelFields.style.display = 'none';
                if (document.getElementById('cancelledBy')) document.getElementById('cancelledBy').required = false;
            } else {
                completionFields.style.display = 'none';
                // Remove required attribute when not completing
                document.getElementById('completedBy').required = false;
                document.getElementById('serviceDuration').required = false;
                document.getElementById('finalPrice').required = false;
            }

            if (status === 'cancelled') {
                if (cancelFields) cancelFields.style.display = 'block';
                if (document.getElementById('cancelledBy')) document.getElementById('cancelledBy').required = false;
            } else {
                if (cancelFields) cancelFields.style.display = 'none';
            }
        }

        function viewImageModal(imageSrc, customerName) {
            document.getElementById('imageModalTitle').textContent = `Sample Image - ${customerName}`;
            document.getElementById('imageModalImg').src = imageSrc;
            document.getElementById('imageDownloadLink').href = imageSrc;

            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        }

        // Quick status update function used by inline buttons
        // Make sure it's globally accessible
        window.updateStatusQuick = function(bookingId, newStatus) {
            console.log('updateStatusQuick called with:', bookingId, newStatus);
            
            // Validate inputs
            if (!bookingId || !newStatus) {
                console.error('Invalid parameters:', { bookingId, newStatus });
                alert('Error: Missing booking ID or status');
                return;
            }

            const confirmMessage = `Are you sure you want to mark booking #${bookingId} as ${newStatus}?`;
            if (!confirm(confirmMessage)) {
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('❌ CSRF token not found. Please refresh the page and try again.');
                return;
            }
            const csrfTokenValue = csrfToken.getAttribute('content');

            // If cancelling via quick action, ask who cancelled (optional) so notification can include it
            let cancelledBy = null;
            if (newStatus === 'cancelled') {
                cancelledBy = prompt('Enter name to record as who cancelled (leave blank for Admin):', 'Admin');
                // If user cancels the prompt, abort the operation
                if (cancelledBy === null) {
                    return;
                }
            }

            // Build the URL - use absolute URL to ensure it works on hosted sites.
            // NOTE: Avoid literal "{{" in this JS (Blade will try to compile it and can throw a ParseError).
            let updateStatusUrl = @json(route('admin.bookings.update-status'));

            // Fallback: if route helper didn't work (empty or contains Blade syntax), construct manually
            const bladeEchoToken = '{' + '{';
            if (!updateStatusUrl || updateStatusUrl.includes(bladeEchoToken) || updateStatusUrl.includes('route(' + "'")) {
                updateStatusUrl = '/admin/bookings/update-status';
            }
            
            let fullUpdateUrl = updateStatusUrl;
            if (updateStatusUrl.startsWith('/')) {
                // Relative URL - make it absolute using current origin
                // Force HTTPS to prevent mixed content errors
                const protocol = window.location.protocol === 'https:' ? 'https:' : 'https:';
                const host = window.location.host;
                fullUpdateUrl = protocol + '//' + host + updateStatusUrl;
            } else if (updateStatusUrl.startsWith('http://')) {
                // If URL is HTTP, convert to HTTPS to prevent mixed content errors
                fullUpdateUrl = updateStatusUrl.replace('http://', 'https://');
            }

            console.log('Updating booking status:', {
                bookingId,
                newStatus,
                url: fullUpdateUrl,
                hasCsrf: !!csrfTokenValue,
                cancelledBy: cancelledBy
            });

            // Show loading indicator - store button reference and original text for error handling
            let button = null;
            let originalText = null;
            try {
                // Try to find the button that was clicked
                button = event?.target || document.querySelector(`button[onclick*="updateStatusQuick(${bookingId}"]`);
                if (button) {
                    originalText = button.innerHTML;
                    button.disabled = true;
                    button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Updating...';
                    
                    // Re-enable button after 10 seconds as fallback
                    setTimeout(() => {
                        if (button && button.disabled) {
                            button.disabled = false;
                            button.innerHTML = originalText || 'Retry';
                        }
                    }, 10000);
                }
            } catch (e) {
                console.warn('Could not find button for loading indicator:', e);
            }

            fetch(fullUpdateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfTokenValue,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin', // Include cookies for CSRF
                body: JSON.stringify({
                    booking_id: bookingId,
                    status: newStatus,
                    cancelled_by: cancelledBy || null
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        let summary = text;
                        if (/<[a-z][\s\S]*>/i.test(text)) {
                            const titleMatch = text.match(/<title[^>]*>([^<]*)<\/title>/i);
                            const h1Match = text.match(/<h1[^>]*>([^<]*)<\/h1>/i);
                            summary = (titleMatch && titleMatch[1]) || (h1Match && h1Match[1]) || text.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
                        }
                        summary = summary.split('\n')[0].trim();
                        if (summary.length > 200) summary = summary.slice(0, 200) + '...';
                        throw { message: `Server error (HTTP ${response.status}): ${summary}`, status: response.status, body: text };
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Status update response:', data);
                if (data.success) {
                    // Show success message briefly before reload
                    const successMsg = document.createElement('div');
                    successMsg.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                    successMsg.style.zIndex = '9999';
                    successMsg.innerHTML = `
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Success!</strong> Booking status updated to ${newStatus}.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(successMsg);
                    
                    // Reload after short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    alert('Error updating booking status: ' + (data.message || 'Unknown error'));
                    // Re-enable button
                    if (button) {
                        button.disabled = false;
                        button.innerHTML = originalText || button.innerHTML.replace('<span class="spinner-border spinner-border-sm me-1"></span>Updating...', '');
                    }
                }
            })
            .catch(error => {
                console.error('Error updating booking status:', error);
                console.error('Error details:', {
                    message: error.message,
                    name: error.name,
                    stack: error.stack,
                    url: fullUpdateUrl,
                    bookingId: bookingId,
                    status: newStatus
                });

                let userMessage = 'Error updating booking status. ';
                
                if (error.message === 'Failed to fetch') {
                    userMessage += 'Unable to reach the server.\n\n';
                    userMessage += 'Please check:\n';
                    userMessage += '1. Your internet connection\n';
                    userMessage += '2. The server is running\n';
                    userMessage += '3. Try refreshing the page\n\n';
                    userMessage += 'URL attempted: ' + fullUpdateUrl;
                } else if (error && error.body) {
                    console.error('Full server response for quick booking update:', error.body);
                    // Try to extract meaningful error message from HTML response
                    if (error.body.includes('CSRF token mismatch') || error.body.includes('419')) {
                        userMessage = 'Session expired. Please refresh the page and try again.';
                    } else {
                        userMessage += (error.message || 'Please try again.');
                    }
                } else {
                    userMessage += (error.message || 'Please try again.');
                }
                
                alert('❌ ' + userMessage);
                
                // Re-enable button on error
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalText || button.innerHTML.replace('<span class="spinner-border spinner-border-sm me-1"></span>Updating...', '');
                }
            });
        };
        
        // Complete Services Modal functionality
        const openCompleteServicesModalBtn = document.getElementById('openCompleteServicesModal');
        if (openCompleteServicesModalBtn) {
            openCompleteServicesModalBtn.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('completeServicesModal'));
                modal.show();
                // Clear previous search results
                clearCompleteServicesSearch();
            });
        }

        // Complete Services Search Form
        const completeServicesSearchForm = document.getElementById('completeServicesSearchForm');
        if (completeServicesSearchForm) {
            completeServicesSearchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                searchCompleteServices();
            });
        }

        function searchCompleteServices() {
            const bookingId = document.getElementById('searchBookingId').value;
            const customerName = document.getElementById('searchCustomerName').value;
            const date = document.getElementById('searchDate').value;
            const service = document.getElementById('searchService').value;

            // Show loading state
            document.getElementById('completeServicesLoading').style.display = 'block';
            document.getElementById('completeServicesResults').style.display = 'none';
            document.getElementById('completeServicesEmpty').style.display = 'none';

            // Build search params
            const params = new URLSearchParams();
            if (bookingId) params.append('booking_id', bookingId);
            if (customerName) params.append('customer_name', customerName);
            if (date) params.append('date', date);
            if (service) params.append('service', service);

            fetch('/admin/bookings/search-complete?' + params.toString(), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('completeServicesLoading').style.display = 'none';

                if (data.success && data.bookings && data.bookings.length > 0) {
                    displayCompleteServicesResults(data.bookings);
                } else {
                    document.getElementById('completeServicesEmpty').style.display = 'block';
                    document.getElementById('completeServicesEmpty').innerHTML = `
                        <i class="bi bi-search" style="font-size: 3rem; color: #dee2e6;"></i>
                        <p class="text-muted mt-3">No bookings found matching your search criteria</p>
                    `;
                }
            })
            .catch(error => {
                console.error('Error searching bookings:', error);
                document.getElementById('completeServicesLoading').style.display = 'none';
                document.getElementById('completeServicesEmpty').style.display = 'block';
                document.getElementById('completeServicesEmpty').innerHTML = `
                    <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: #dc3545;"></i>
                    <p class="text-danger mt-3">Error searching bookings. Please try again.</p>
                `;
            });
        }

        function displayCompleteServicesResults(bookings) {
            const resultsList = document.getElementById('completeServicesResultsList');
            const resultsCount = document.getElementById('resultsCount');
            
            resultsCount.textContent = bookings.length;
            document.getElementById('completeServicesResults').style.display = 'block';
            document.getElementById('completeServicesEmpty').style.display = 'none';

            resultsList.innerHTML = bookings.map(booking => `
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                Booking #${booking.id} - ${booking.name}
                                <span class="badge bg-${booking.status === 'confirmed' ? 'primary' : 'warning'} ms-2">${booking.status}</span>
                            </h6>
                            <p class="mb-1">
                                <strong>Service:</strong> ${booking.service || 'N/A'}<br>
                                <strong>Date:</strong> ${booking.appointment_date || 'N/A'}<br>
                                <strong>Time:</strong> ${booking.appointment_time || 'N/A'}<br>
                                <strong>Phone:</strong> ${booking.phone || 'N/A'}
                            </p>
                        </div>
                        <button class="btn btn-success btn-sm" onclick="openCompleteServiceDetail(${booking.id}, '${booking.name.replace(/'/g, "\\'")}', '${(booking.service || '').replace(/'/g, "\\'")}', '${booking.appointment_date_raw || ''}', '${booking.appointment_time || ''}')">
                            <i class="bi bi-award me-1"></i>Complete
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function clearCompleteServicesSearch() {
            document.getElementById('searchBookingId').value = '';
            document.getElementById('searchCustomerName').value = '';
            document.getElementById('searchDate').value = '';
            document.getElementById('searchService').value = '';
            document.getElementById('completeServicesResults').style.display = 'none';
            document.getElementById('completeServicesLoading').style.display = 'none';
            document.getElementById('completeServicesEmpty').style.display = 'block';
            document.getElementById('completeServicesEmpty').innerHTML = `
                <i class="bi bi-search" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">Use the search form above to find bookings to complete</p>
            `;
        }

        function openCompleteServiceDetail(bookingId, customerName, serviceName, appointmentDate, appointmentTime) {
            document.getElementById('completeBookingId').textContent = bookingId;
            document.getElementById('completeBookingIdInput').value = bookingId;
            document.getElementById('completeCustomerName').textContent = customerName;
            document.getElementById('completeServiceName').textContent = serviceName;
            document.getElementById('completeAppointmentDate').textContent = appointmentDate || 'N/A';
            document.getElementById('completeAppointmentTime').textContent = appointmentTime || 'N/A';

            // Clear form
            document.getElementById('completeStaffMember').value = '';
            document.getElementById('completeServiceDuration').value = '';
            document.getElementById('completeFinalPrice').value = '';
            document.getElementById('completePaymentStatus').value = 'pending';
            document.getElementById('completeNotes').value = '';

            // Close search modal and open detail modal
            const searchModal = bootstrap.Modal.getInstance(document.getElementById('completeServicesModal'));
            if (searchModal) searchModal.hide();

            const detailModal = new bootstrap.Modal(document.getElementById('completeServiceDetailModal'));
            detailModal.show();
        }

        // Submit Complete Service Form
        const submitCompleteServiceBtn = document.getElementById('submitCompleteService');
        if (submitCompleteServiceBtn) {
            submitCompleteServiceBtn.addEventListener('click', function() {
                const form = document.getElementById('completeServiceForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const formData = {
                    booking_id: document.getElementById('completeBookingIdInput').value,
                    status: 'completed',
                    completed_by: document.getElementById('completeStaffMember').value,
                    service_duration_minutes: parseInt(document.getElementById('completeServiceDuration').value),
                    final_price: parseFloat(document.getElementById('completeFinalPrice').value),
                    payment_status: document.getElementById('completePaymentStatus').value,
                    completion_notes: document.getElementById('completeNotes').value
                };

                submitCompleteServiceBtn.disabled = true;
                submitCompleteServiceBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Completing...';

                fetch('/admin/bookings/update-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Service completed successfully!');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('completeServiceDetailModal'));
                        if (modal) modal.hide();
                        window.location.reload();
                    } else {
                        alert('Error completing service: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error completing service:', error);
                    alert('Error completing service. Please try again.');
                })
                .finally(() => {
                    submitCompleteServiceBtn.disabled = false;
                    submitCompleteServiceBtn.innerHTML = '<i class="bi bi-award me-2"></i>Complete Service';
                });
            });
        }

        // FullCalendar is bundled via Vite (resources/js/admin-calendar.js). See Vite build for the asset.
    </script>
    @vite(['resources/css/app.css', 'resources/js/admin-calendar.js'])
</body>
</html>

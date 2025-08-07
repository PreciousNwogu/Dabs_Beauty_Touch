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
                        <div class="stats-number" id="totalAppointments">0</div>
                        <div class="stats-label">Total Appointments</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number" id="todayAppointments">0</div>
                        <div class="stats-label">Today's Appointments</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number" id="pendingAppointments">0</div>
                        <div class="stats-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number" id="confirmedAppointments">0</div>
                        <div class="stats-label">Confirmed</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card bg-success text-white">
                        <div class="stats-number">₵<span id="revenueToday">0.00</span></div>
                        <div class="stats-label">Today's Revenue</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card bg-primary text-white">
                        <div class="stats-number">₵<span id="revenueMonth">0.00</span></div>
                        <div class="stats-label">This Month</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card bg-info text-white">
                        <div class="stats-number" id="completedAppointments">0</div>
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
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary w-100" onclick="loadAppointments()">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="dashboard-container">
            <div class="dashboard-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Appointments</h3>
                <a href="{{ route('admin.complete-service') }}" class="btn btn-success">
                    <i class="bi bi-check-circle me-2"></i>Complete Service
                </a>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Contact</th>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Sample Image</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTable">
                            <tr>
                                <td colspan="8" class="text-center">Loading appointments...</td>
                            </tr>
                        </tbody>
                    </table>
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
            loadDashboardStats();
            loadAppointments();
        });

        function loadDashboardStats() {
            // Fetch appointment statistics
            fetch('/appointments/stats')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('totalAppointments').textContent = data.stats.total || 0;
                        document.getElementById('todayAppointments').textContent = data.stats.today || 0;
                        document.getElementById('pendingAppointments').textContent = data.stats.pending || 0;
                        document.getElementById('confirmedAppointments').textContent = data.stats.confirmed || 0;
                        document.getElementById('completedAppointments').textContent = data.stats.completed || 0;

                        // Update revenue stats
                        document.getElementById('revenueToday').textContent = (data.stats.revenue_today || 0).toFixed(2);
                        document.getElementById('revenueMonth').textContent = (data.stats.revenue_month || 0).toFixed(2);
                    }
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                    // Set default values if API fails
                    document.getElementById('totalAppointments').textContent = '0';
                    document.getElementById('todayAppointments').textContent = '0';
                    document.getElementById('pendingAppointments').textContent = '0';
                    document.getElementById('confirmedAppointments').textContent = '0';
                    document.getElementById('completedAppointments').textContent = '0';
                    document.getElementById('revenueToday').textContent = '0.00';
                    document.getElementById('revenueMonth').textContent = '0.00';
                });
        }

        function loadAppointments() {
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const serviceFilter = document.getElementById('serviceFilter').value;

            // Show loading
            document.getElementById('appointmentsTable').innerHTML =
                '<tr><td colspan="7" class="text-center">Loading appointments...</td></tr>';

            // Build query parameters
            const params = new URLSearchParams();
            if (statusFilter) params.append('status', statusFilter);
            if (dateFilter) params.append('date', dateFilter);
            if (serviceFilter) params.append('service', serviceFilter);

            // Fetch appointments from API
            fetch('/appointments/list?' + params.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderAppointments(data.appointments);
                    } else {
                        document.getElementById('appointmentsTable').innerHTML =
                            '<tr><td colspan="7" class="text-center text-danger">Error loading appointments: ' + (data.message || 'Unknown error') + '</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Error loading appointments:', error);
                    document.getElementById('appointmentsTable').innerHTML =
                        '<tr><td colspan="7" class="text-center text-danger">Error loading appointments. Please try again.</td></tr>';
                });
        }

        function renderAppointments(appointments) {
            const tbody = document.getElementById('appointmentsTable');

            if (!appointments || appointments.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">No appointments found.</td></tr>';
                return;
            }

            tbody.innerHTML = appointments.map(appointment => `
                <tr>
                    <td>
                        <strong>${appointment.booking_id || appointment.id}</strong>
                        ${appointment.confirmation_code ? `<br><small class="text-muted">Conf: ${appointment.confirmation_code}</small>` : ''}
                    </td>
                    <td>
                        <div><strong>${appointment.name}</strong></div>
                        ${appointment.email ? `<small class="text-muted">${appointment.email}</small>` : '<small class="text-muted">No email</small>'}
                    </td>
                    <td>
                        <div>${appointment.phone}</div>
                        ${appointment.address ? `<small class="text-muted">${appointment.address}</small>` : ''}
                    </td>
                    <td>
                        <div>${appointment.service}</div>
                        ${appointment.length ? `<small class="text-muted">Length: ${appointment.length}</small>` : ''}
                    </td>
                    <td>
                        <div>${formatDate(appointment.appointment_date)}</div>
                        <small class="text-muted">${formatTime(appointment.appointment_time)}</small>
                    </td>
                    <td>
                        ${appointment.sample_picture ?
                            `<img src="/storage/${appointment.sample_picture}"
                                 alt="Sample"
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                                 onclick="viewImageModal('/storage/${appointment.sample_picture}', '${appointment.name}')"
                                 title="Click to view full size">`
                            : '<span class="text-muted">No image</span>'
                        }
                    </td>
                    <td>${getStatusBadge(appointment.status)}</td>
                    <td>
                        <div class="btn-group-vertical btn-group-sm">
                            <button class="btn btn-outline-primary btn-sm mb-1" onclick="updateAppointmentStatus('${appointment.id}')" title="Update Status">
                                <i class="bi bi-pencil"></i> Update
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="viewAppointmentDetails('${appointment.id}')" title="View Details">
                                <i class="bi bi-eye"></i> View
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        function formatTime(timeString) {
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const hour12 = hour % 12 || 12;
            return `${hour12}:${minutes} ${ampm}`;
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
            fetch('/appointments/update-status', {
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
                    // Close modal and reload
                    const modal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
                    modal.hide();
                    loadAppointments();
                    loadDashboardStats();

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

        function viewAppointmentDetails(appointmentId) {
            // Fetch appointment details
            fetch('/appointments/details?id=' + appointmentId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showEnhancedAppointmentDetails(data.appointment);
                    } else {
                        alert('Error loading appointment details: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error loading appointment details:', error);
                    alert('Error loading appointment details. Please try again.');
                });
        }

        function showEnhancedAppointmentDetails(appointment) {
            const detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bi bi-person me-2"></i>Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr><td><strong>Name:</strong></td><td>${appointment.name}</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>${appointment.phone}</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>${appointment.email || 'Not provided'}</td></tr>
                                    <tr><td><strong>Address:</strong></td><td>${appointment.address || 'Not provided'}</td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Appointment Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tr><td><strong>Booking ID:</strong></td><td>${appointment.booking_id || appointment.id}</td></tr>
                                    <tr><td><strong>Confirmation Code:</strong></td><td>${appointment.confirmation_code || 'N/A'}</td></tr>
                                    <tr><td><strong>Service:</strong></td><td>${appointment.service}</td></tr>
                                    <tr><td><strong>Length:</strong></td><td>${appointment.length || 'Not specified'}</td></tr>
                                    <tr><td><strong>Date:</strong></td><td>${formatDate(appointment.appointment_date)}</td></tr>
                                    <tr><td><strong>Time:</strong></td><td>${formatTime(appointment.appointment_time)}</td></tr>
                                    <tr><td><strong>Status:</strong></td><td>${getStatusBadge(appointment.status)}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        ${appointment.sample_picture ? `
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="bi bi-image me-2"></i>Sample Image</h6>
                                </div>
                                <div class="card-body text-center">
                                    <img src="/storage/${appointment.sample_picture}"
                                         alt="Sample Image"
                                         style="max-width: 100%; height: auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"
                                         onclick="viewImageModal('/storage/${appointment.sample_picture}', '${appointment.name}')"
                                         class="cursor-pointer">
                                    <div class="mt-2">
                                        <a href="/storage/${appointment.sample_picture}" download class="btn btn-sm btn-outline-primary">
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

                        ${appointment.message ? `
                            <div class="card mb-3">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="bi bi-chat-text me-2"></i>Customer Message</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">"${appointment.message}"</p>
                                </div>
                            </div>
                        ` : ''}

                        ${appointment.status_history ? `
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Status History</h6>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        ${appointment.status_history.map(entry => `
                                            <div class="timeline-item mb-2">
                                                <small class="text-muted">${new Date(entry.timestamp).toLocaleString()}</small><br>
                                                <strong>${entry.from} → ${entry.to}</strong><br>
                                                <span class="text-muted">By: ${entry.updated_by}</span>
                                                ${entry.notes ? `<br><em>"${entry.notes}"</em>` : ''}
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </div>

                ${appointment.completed_at ? `
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Service Completion Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Completed By:</strong><br>
                                            ${appointment.completed_by || 'N/A'}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Duration:</strong><br>
                                            ${appointment.service_duration_minutes ? appointment.service_duration_minutes + ' minutes' : 'N/A'}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Final Price:</strong><br>
                                            ${appointment.final_price ? '₵' + parseFloat(appointment.final_price).toFixed(2) : 'N/A'}
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Payment Status:</strong><br>
                                            ${appointment.payment_status ? appointment.payment_status.replace('_', ' ').toUpperCase() : 'N/A'}
                                        </div>
                                    </div>
                                    ${appointment.completion_notes ? `
                                        <div class="mt-3">
                                            <strong>Completion Notes:</strong><br>
                                            <em>"${appointment.completion_notes}"</em>
                                        </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                ` : ''}
            `;

            document.getElementById('appointmentDetailsContent').innerHTML = detailsHtml;
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        }

        function viewAppointmentDetails(appointmentId) {
            // Fetch appointment details
            fetch('/appointments/details?id=' + appointmentId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAppointmentDetails(data.appointment);
                    } else {
                        alert('Error loading appointment details: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error loading appointment details:', error);
                    alert('Error loading appointment details. Please try again.');
                });
        }

        function showAppointmentDetails(appointment) {
            const detailsHtml = `
                <div class="modal fade" id="detailsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Appointment Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Client Information</h6>
                                        <p><strong>Name:</strong> ${appointment.name}</p>
                                        <p><strong>Phone:</strong> ${appointment.phone}</p>
                                        <p><strong>Email:</strong> ${appointment.email || 'Not provided'}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Appointment Information</h6>
                                        <p><strong>Booking ID:</strong> ${appointment.booking_id}</p>
                                        <p><strong>Service:</strong> ${appointment.service}</p>
                                        <p><strong>Date:</strong> ${formatDate(appointment.appointment_date)}</p>
                                        <p><strong>Time:</strong> ${formatTime(appointment.appointment_time)}</p>
                                        <p><strong>Status:</strong> ${getStatusBadge(appointment.status)}</p>
                                    </div>
                                </div>
                                ${appointment.notes ? `<div class="mt-3"><h6>Notes</h6><p>${appointment.notes}</p></div>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('detailsModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add new modal to body
            document.body.insertAdjacentHTML('beforeend', detailsHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();

            // Remove modal from DOM after hiding
            document.getElementById('detailsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        function getStatusBadge(status) {
            const statusClasses = {
                'pending': 'status-pending',
                'confirmed': 'status-confirmed',
                'completed': 'status-completed',
                'cancelled': 'status-cancelled'
            };

            return `<span class="status-badge ${statusClasses[status] || 'status-pending'}">${status}</span>`;
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            loadDashboardStats();
        }, 30000);
    </script>
</body>
</html>

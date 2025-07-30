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
            <div class="dashboard-header">
                <h3 class="mb-0">Appointments</h3>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Date & Time</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTable">
                            <tr>
                                <td colspan="7" class="text-center">Loading appointments...</td>
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
                            <select class="form-select" id="newStatus" required>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="statusNotes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="statusNotes" rows="3"></textarea>
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
                    }
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                    // Set default values if API fails
                    document.getElementById('totalAppointments').textContent = '0';
                    document.getElementById('todayAppointments').textContent = '0';
                    document.getElementById('pendingAppointments').textContent = '0';
                    document.getElementById('confirmedAppointments').textContent = '0';
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
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">No appointments found.</td></tr>';
                return;
            }

            tbody.innerHTML = appointments.map(appointment => `
                <tr>
                    <td><strong>${appointment.booking_id}</strong></td>
                    <td>${appointment.name}</td>
                    <td>${appointment.service}</td>
                    <td>
                        <div>${formatDate(appointment.appointment_date)}</div>
                        <small class="text-muted">${formatTime(appointment.appointment_time)}</small>
                    </td>
                    <td>${appointment.phone}</td>
                    <td>${getStatusBadge(appointment.status)}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-2" onclick="updateAppointmentStatus('${appointment.id}')">
                            <i class="bi bi-pencil"></i> Update
                        </button>
                        <button class="btn btn-sm btn-outline-info" onclick="viewAppointmentDetails('${appointment.id}')">
                            <i class="bi bi-eye"></i> View
                        </button>
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

            if (!currentAppointmentId) {
                alert('No appointment selected');
                return;
            }

            // Show loading state
            const updateBtn = document.querySelector('#statusModal .btn-primary');
            const originalText = updateBtn.innerHTML;
            updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
            updateBtn.disabled = true;

            // Send update to API
            fetch('/appointments/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    appointment_id: currentAppointmentId,
                    status: newStatus,
                    notes: notes
                })
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
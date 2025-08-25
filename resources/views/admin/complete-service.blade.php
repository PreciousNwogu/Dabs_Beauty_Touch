<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complete Service - Dab's Beauty Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .completion-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 600px;
        }
        .service-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .service-header h2 {
            color: #030f68;
            font-weight: 700;
        }
        .btn-complete {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: transform 0.2s;
        }
        .btn-complete:hover {
            transform: translateY(-2px);
            color: white;
        }
        .form-control, .form-select {
            border-radius: 15px;
            border: 2px solid #e3eafc;
            padding: 12px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }
        .appointment-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="completion-card">
            <div class="service-header">
                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                <h2>Complete Service</h2>
                <p class="text-muted">Mark appointment as completed and record service details</p>
            </div>

            <!-- Appointment Search -->
            <div class="mb-4">
                <label for="bookingSearch" class="form-label">Search Appointment</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="bookingSearch" placeholder="Enter booking ID, phone, or customer name">
                    <button class="btn btn-outline-primary" onclick="searchAppointment()">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
                <div id="searchResults" class="list-group mt-2" style="display:none;"></div>
            </div>

            <!-- Appointment Info (hidden until appointment is found) -->
            <div id="appointmentInfo" class="appointment-info" style="display: none;">
                <h5><i class="bi bi-info-circle me-2"></i>Appointment Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Customer:</strong> <span id="customerName"></span></p>
                        <p><strong>Service:</strong> <span id="serviceName"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong> <span id="appointmentDate"></span></p>
                        <p><strong>Time:</strong> <span id="appointmentTime"></span></p>
                    </div>
                </div>
            </div>

            <!-- Completion Form (hidden until appointment is found) -->
            <form id="completionForm" style="display: none;">
                <input type="hidden" id="appointmentId">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="staffMember" class="form-label">Completed By (Staff Member)</label>
                        <input type="text" class="form-control" id="staffMember" required placeholder="Enter your name">
                    </div>
                    <div class="col-md-6">
                        <label for="actualDuration" class="form-label">Actual Service Duration</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="actualDuration" required placeholder="180" min="1">
                            <span class="input-group-text">minutes</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="finalPrice" class="form-label">Final Price Charged</label>
                        <div class="input-group">
                                <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="finalPrice" required placeholder="150.00" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="paymentStatus" class="form-label">Payment Status</label>
                        <select class="form-select" id="paymentStatus" required>
                            <option value="">Select payment status</option>
                            <option value="fully_paid">Fully Paid</option>
                            <option value="deposit_paid">Deposit Only</option>
                            <option value="pending">Payment Pending</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="completionNotes" class="form-label">Service Notes</label>
                    <textarea class="form-control" id="completionNotes" rows="3" placeholder="Any additional notes about the service (optional)"></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-complete btn-lg">
                        <i class="bi bi-check-circle me-2"></i>Mark as Completed
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Start Over
                    </button>
                </div>
            </form>

            <!-- Loading indicator -->
            <div id="loadingIndicator" style="display: none;" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Processing...</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentAppointment = null;

        function searchAppointment() {
            const searchTerm = document.getElementById('bookingSearch').value.trim();

            if (!searchTerm) {
                alert('Please enter a booking ID, phone number, or customer name');
                return;
            }

            showLoading(true);

            // Search for appointment
            fetch('/admin/bookings/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ search: searchTerm })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // server may return single booking (legacy) or array of bookings
                    if (data.booking) {
                        showAppointmentDetails(data.booking);
                    } else if (data.bookings && data.bookings.length > 0) {
                        // show a list for admin to choose from
                        renderSearchResults(data.bookings);
                    } else {
                        alert('No matching appointments found.');
                    }
                } else {
                    alert('Appointment not found. Please check the booking details and try again.');
                }
            })
            .catch(error => {
                console.error('Error searching appointment:', error);
                alert('Error searching for appointment. Please try again.');
            })
            .finally(() => {
                showLoading(false);
            });
        }

        function showAppointmentDetails(appointment) {
            currentAppointment = appointment;

            // Populate appointment info
            document.getElementById('customerName').textContent = appointment.name;
            document.getElementById('serviceName').textContent = appointment.service;
            document.getElementById('appointmentDate').textContent = appointment.appointment_date;
            document.getElementById('appointmentTime').textContent = appointment.appointment_time;
            document.getElementById('appointmentId').value = appointment.id;

            // Show appointment info and form
            document.getElementById('appointmentInfo').style.display = 'block';
            document.getElementById('completionForm').style.display = 'block';

            // Scroll to form
            document.getElementById('appointmentInfo').scrollIntoView({ behavior: 'smooth' });
        }

        function renderSearchResults(bookings) {
            const container = document.getElementById('searchResults');
            container.innerHTML = '';
            if (!bookings || bookings.length === 0) {
                container.style.display = 'none';
                return;
            }

            bookings.forEach(b => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'list-group-item list-group-item-action';
                item.textContent = `${b.name} — ${b.service} — ${b.appointment_date} ${b.appointment_time} (ID: ${b.id})`;
                item.addEventListener('click', function() {
                    // When an item is clicked, populate the appointment details
                    showAppointmentDetails(b);
                    // Hide results
                    container.style.display = 'none';
                });
                container.appendChild(item);
            });

            container.style.display = 'block';
        }

        function resetForm() {
            document.getElementById('bookingSearch').value = '';
            document.getElementById('appointmentInfo').style.display = 'none';
            document.getElementById('completionForm').style.display = 'none';
            document.getElementById('completionForm').reset();
            currentAppointment = null;
        }

        function showLoading(show) {
            document.getElementById('loadingIndicator').style.display = show ? 'block' : 'none';
        }

        // Handle form submission
        document.getElementById('completionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!currentAppointment) {
                alert('No appointment selected');
                return;
            }

            const formData = {
                appointment_id: document.getElementById('appointmentId').value,
                status: 'completed',
                completed_by: document.getElementById('staffMember').value,
                service_duration_minutes: parseInt(document.getElementById('actualDuration').value),
                final_price: parseFloat(document.getElementById('finalPrice').value),
                payment_status: document.getElementById('paymentStatus').value,
                completion_notes: document.getElementById('completionNotes').value
            };

            showLoading(true);

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
                    resetForm();
                } else {
                    alert('Error completing service: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error completing service:', error);
                alert('Error completing service. Please try again.');
            })
            .finally(() => {
                showLoading(false);
            });
        });

        // Allow Enter key to search
        document.getElementById('bookingSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchAppointment();
            }
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Dab's Beauty Touch</title>
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

        .calendar-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px 0;
        }

        .calendar-header {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .calendar-nav {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .calendar-grid {
            padding: 30px;
        }

        .calendar-day {
            border: 1px solid #e9ecef;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .calendar-day:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            color: white;
            border-color: #ff6600;
        }

        .calendar-day.available {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .calendar-day.booked {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            cursor: not-allowed;
        }

        .calendar-day.past {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        .calendar-day.other-month {
            background-color: #f8f9fa;
            color: #adb5bd;
        }

        /* Hide completely unavailable dates */
        .calendar-day.hidden-date {
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            background-color: transparent !important;
            border-color: transparent !important;
            min-height: 80px; /* Maintain grid structure */
        }

        .time-slots {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            margin: 20px 0;
            overflow: hidden;
        }

        .time-slot {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .time-slot:hover {
            background-color: #f8f9fa;
        }

        .time-slot.available {
            background-color: #d4edda;
        }

        .time-slot.booked {
            background-color: #f8d7da;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .time-slot.selected {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            color: white;
        }

        .booking-form {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            margin: 20px 0;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #030f68 0%, #05137c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .form-body {
            padding: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 102, 0, 0.3);
        }

        .confirmation-modal {
            border-radius: 20px;
            overflow: hidden;
        }

        .confirmation-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner-border {
            color: #ff6600;
        }

        .alert {
            border-radius: 15px;
            border: none;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        @media (max-width: 768px) {
            .calendar-day {
                min-height: 60px;
                padding: 10px;
                font-size: 0.9rem;
            }
            
            .calendar-grid {
                padding: 15px;
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
                        <a class="nav-link active" href="{{ route('calendar') }}">Book Appointment</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <!-- Calendar Header -->
        <div class="calendar-container">
            <div class="calendar-header">
                <h1 class="mb-3">Book Your Appointment</h1>
                <p class="mb-0">Select a date and time that works best for you</p>
            </div>

            <!-- Calendar Navigation -->
            <div class="calendar-nav">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <button class="btn btn-outline-primary" onclick="previousMonth()">
                            <i class="bi bi-chevron-left"></i> Previous
                        </button>
                    </div>
                    <div class="col-md-4 text-center">
                        <h3 id="currentMonth" class="mb-0"></h3>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-outline-primary" onclick="nextMonth()">
                            Next <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col text-center fw-bold">Sun</div>
                            <div class="col text-center fw-bold">Mon</div>
                            <div class="col text-center fw-bold">Tue</div>
                            <div class="col text-center fw-bold">Wed</div>
                            <div class="col text-center fw-bold">Thu</div>
                            <div class="col text-center fw-bold">Fri</div>
                            <div class="col text-center fw-bold">Sat</div>
                        </div>
                    </div>
                </div>
                <div id="calendarDays" class="row mt-2"></div>
            </div>
        </div>

        <!-- Time Slots -->
        <div id="timeSlotsContainer" class="time-slots" style="display: none;">
            <div class="calendar-header">
                <h3 class="mb-0">Available Time Slots</h3>
                <p class="mb-0" id="selectedDateText"></p>
            </div>
            <div id="timeSlots" class="p-3"></div>
        </div>

        <!-- Booking Form -->
        <div id="bookingFormContainer" class="booking-form" style="display: none;">
            <div class="form-header">
                <h3 class="mb-0">Complete Your Booking</h3>
                <p class="mb-0" id="bookingSummary"></p>
            </div>
            <div class="form-body">
                <form id="bookingForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service" class="form-label">Service *</label>
                            <select class="form-select" id="service" name="service" required>
                                <option value="">Select a service</option>
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
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Special Requests or Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loading -->
        <div id="loading" class="loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading available slots...</p>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content confirmation-modal">
                <div class="modal-header confirmation-header">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Booking Confirmed!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="confirmationDetails"></div>
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Important:</strong> Please save your booking ID and confirmation code for future reference.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;
        let selectedService = null;

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            renderCalendar();
            loadCalendarData();
        });

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            document.getElementById('currentMonth').textContent = 
                new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            // Fetch booked dates for this month
            fetch(`/appointments/booked-dates?year=${year}&month=${month + 1}`)
                .then(response => response.json())
                .then(data => {
                    const bookedDates = data.success ? data.booked_dates : [];
                    console.log('Booked dates for month:', bookedDates);

                    for (let i = 0; i < 42; i++) {
                        const date = new Date(startDate);
                        date.setDate(startDate.getDate() + i);
                        const dateString = date.toISOString().split('T')[0];

                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'col calendar-day';
                        dayDiv.textContent = date.getDate();

                        if (date.getMonth() !== month) {
                            dayDiv.classList.add('other-month');
                        } else if (date < new Date().setHours(0, 0, 0, 0)) {
                            dayDiv.classList.add('past');
                        } else if (bookedDates.includes(dateString)) {
                            // HIDE dates that are booked with non-completed appointments
                            dayDiv.style.visibility = 'hidden';
                            dayDiv.style.pointerEvents = 'none';
                            dayDiv.innerHTML = ''; // Remove date number
                            dayDiv.classList.add('hidden-date');
                        } else {
                            dayDiv.classList.add('available');
                            dayDiv.onclick = () => selectDate(date);
                        }

                        calendarDays.appendChild(dayDiv);
                    }
                })
                .catch(error => {
                    console.error('Error fetching booked dates:', error);
                    
                    // Fallback: render calendar without booking checks
                    for (let i = 0; i < 42; i++) {
                        const date = new Date(startDate);
                        date.setDate(startDate.getDate() + i);

                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'col calendar-day';
                        dayDiv.textContent = date.getDate();

                        if (date.getMonth() !== month) {
                            dayDiv.classList.add('other-month');
                        } else if (date < new Date().setHours(0, 0, 0, 0)) {
                            dayDiv.classList.add('past');
                        } else {
                            dayDiv.classList.add('available');
                            dayDiv.onclick = () => selectDate(date);
                        }

                        calendarDays.appendChild(dayDiv);
                    }
                });
        }

        function selectDate(date) {
            selectedDate = date;
            
            // Update calendar display
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.classList.remove('selected');
            });
            event.target.classList.add('selected');

            // Show time slots
            loadTimeSlots(date);
        }

        function loadTimeSlots(date) {
            const loading = document.getElementById('loading');
            const timeSlotsContainer = document.getElementById('timeSlotsContainer');
            const timeSlots = document.getElementById('timeSlots');
            const selectedDateText = document.getElementById('selectedDateText');

            loading.style.display = 'block';
            timeSlotsContainer.style.display = 'none';

            selectedDateText.textContent = date.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });

            fetch(`/appointments/slots?date=${date.toISOString().split('T')[0]}`)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    timeSlotsContainer.style.display = 'block';

                    if (data.success) {
                        renderTimeSlots(data.slots);
                    } else {
                        timeSlots.innerHTML = '<div class="alert alert-danger">Error loading time slots</div>';
                    }
                })
                .catch(error => {
                    loading.style.display = 'none';
                    timeSlots.innerHTML = '<div class="alert alert-danger">Error loading time slots</div>';
                });
        }

        function renderTimeSlots(slots) {
            const timeSlots = document.getElementById('timeSlots');
            timeSlots.innerHTML = '';

            // Filter to only show available slots
            const availableSlots = slots.filter(slot => slot.available);

            if (availableSlots.length === 0) {
                timeSlots.innerHTML = '<div class="alert alert-info">No available slots for this date</div>';
                return;
            }

            availableSlots.forEach(slot => {
                const slotDiv = document.createElement('div');
                slotDiv.className = 'time-slot available';
                slotDiv.innerHTML = `
                    <span>${slot.formatted_time}</span>
                    <span>Available</span>
                `;
                slotDiv.onclick = () => selectTimeSlot(slot);
                timeSlots.appendChild(slotDiv);
            });
        }

        function selectTimeSlot(slot) {
            selectedTime = slot;
            
            document.querySelectorAll('.time-slot').forEach(timeSlot => {
                timeSlot.classList.remove('selected');
            });
            event.target.classList.add('selected');

            showBookingForm();
        }

        function showBookingForm() {
            const bookingFormContainer = document.getElementById('bookingFormContainer');
            const bookingSummary = document.getElementById('bookingSummary');

            bookingSummary.textContent = `${selectedDate.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            })} at ${selectedTime.formatted_time}`;

            bookingFormContainer.style.display = 'block';
            bookingFormContainer.scrollIntoView({ behavior: 'smooth' });
        }

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            formData.append('appointment_date', selectedDate.toISOString().split('T')[0]);
            formData.append('appointment_time', selectedTime.time);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Booking...';
            submitBtn.disabled = true;

            fetch('/appointments/book', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showConfirmation(data.appointment);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error booking appointment. Please try again.');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        function showConfirmation(appointment) {
            const confirmationDetails = document.getElementById('confirmationDetails');
            confirmationDetails.innerHTML = `
                <div class="text-center mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Booking ID:</strong><br>${appointment.booking_id}</p>
                        <p><strong>Confirmation Code:</strong><br>${appointment.confirmation_code}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong><br>${appointment.appointment_date}</p>
                        <p><strong>Time:</strong><br>${appointment.appointment_time}</p>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p><strong>Service:</strong> ${appointment.service}</p>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
            loadCalendarData();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
            loadCalendarData();
        }

        function loadCalendarData() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth() + 1;

            fetch(`/appointments/calendar?year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCalendarDisplay(data.calendar_data);
                    }
                })
                .catch(error => {
                    console.error('Error loading calendar data:', error);
                });
        }

        function updateCalendarDisplay(calendarData) {
            // This function would update the calendar to show booked dates
            // Implementation can be added later for visual indicators
        }
    </script>
</body>
</html> 
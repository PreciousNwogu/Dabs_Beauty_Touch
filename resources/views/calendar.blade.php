<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>Book Appointment - Dab's Beauty Touch | Online Booking</title>
    <meta name="title" content="Book Appointment - Dab's Beauty Touch | Online Booking">
    <meta name="description" content="Book your hair braiding appointment online. Choose from professional braiding services including knotless braids, box braids, wig installation, and custom styles. Easy online scheduling available.">
    <meta name="keywords" content="book hair braiding appointment, online booking, Ottawa braiding salon, schedule appointment, hair braiding booking">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/calendar') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/calendar') }}">
    <meta property="og:title" content="Book Appointment - Dab's Beauty Touch | Online Booking">
    <meta property="og:description" content="Book your hair braiding appointment online. Choose from professional braiding services. Easy online scheduling available.">
    <meta property="og:image" content="{{ asset('images/logo.jpg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/calendar') }}">
    <meta name="twitter:title" content="Book Appointment - Dab's Beauty Touch">
    <meta name="twitter:description" content="Book your hair braiding appointment online. Easy online scheduling available.">
    <meta name="twitter:image" content="{{ asset('images/logo.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);
            min-height: 100vh;
            -webkit-tap-highlight-color: transparent;
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

        /* Weekday header row */
        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }

        .calendar-weekday {
            text-align: center;
            font-weight: 700;
            color: #212529;
            min-width: 0;
        }

        /* Day cells grid */
        #calendarDays.calendar-days {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 12px;
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
            width: 100%;
            box-sizing: border-box;
            touch-action: manipulation;
            border-radius: 12px;
            position: relative;
            min-width: 0; /* prevent min-content overflow from widening columns */
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
            pointer-events: none;
            opacity: 0.7;
            position: relative;
        }

        .calendar-day.booked:hover {
            background-color: #f8d7da;
            transform: none;
            box-shadow: none;
        }

        .calendar-day.booked::after {
            content: '×';
            position: absolute;
            top: 2px;
            right: 4px;
            color: #dc3545;
            font-weight: bold;
            font-size: 12px;
        }

        /* Blocked day styling (admin-created blocked ranges) */
        .calendar-day.blocked-range {
            background: linear-gradient(180deg, #343a40 0%, #495057 100%);
            color: #ffffff;
            cursor: not-allowed;
            opacity: 0.95;
            position: relative;
        }

        .calendar-day .blocked-text {
            font-size: 0.7rem;
            margin-top: 6px;
            line-height: 1.1;
            max-width: 100%;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .calendar-day.past {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.6;
        }

        .calendar-day.past:hover {
            background-color: #e9ecef;
            transform: none;
            box-shadow: none;
        }

        .calendar-day.other-month {
            background-color: #f8f9fa;
            color: #adb5bd;
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
            touch-action: manipulation;
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
            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .calendar-container,
            .time-slots,
            .booking-form {
                border-radius: 16px;
            }

            .calendar-header {
                padding: 18px 14px;
            }

            .calendar-header h1 {
                font-size: 1.4rem;
                margin-bottom: 6px !important;
            }

            .calendar-header p {
                font-size: 0.95rem;
            }

            .calendar-nav {
                padding: 12px;
            }

            .calendar-nav .row > [class^="col-"] {
                margin-bottom: 8px;
            }

            .calendar-nav .row > [class^="col-"]:last-child {
                margin-bottom: 0;
            }

            #currentMonth {
                font-size: 1.2rem;
            }

            .calendar-day {
                min-height: 52px;
                padding: 10px 6px;
                font-size: 0.95rem;
                aspect-ratio: 1 / 1;
            }

            .calendar-grid {
                padding: 15px;
            }

            .calendar-weekdays {
                gap: 8px;
                margin-bottom: 8px;
            }

            #calendarDays.calendar-days {
                gap: 8px;
            }

            .calendar-weekday {
                font-size: 0.8rem;
            }

            .time-slot {
                padding: 14px 14px;
                font-size: 0.95rem;
            }

            .form-header {
                padding: 18px 14px;
            }

            .form-body {
                padding: 16px;
            }

            .btn-primary {
                width: 100%;
            }
        }

        /* Extra-small phones */
        @media (max-width: 576px) {
            /* Reduce gaps so 7 columns fit comfortably */
            .calendar-weekdays { gap: 6px; }
            #calendarDays.calendar-days { gap: 6px; }

            .calendar-weekday {
                font-size: 0.72rem;
                letter-spacing: 0.02em;
            }

            .calendar-day {
                min-height: 46px;
                padding: 8px 4px;
                border-radius: 10px;
                aspect-ratio: 1 / 1;
            }

            .calendar-day .blocked-text {
                font-size: 0.6rem;
                margin-top: 4px;
                position: absolute;
                left: 6px;
                right: 6px;
                bottom: 6px;
                margin-top: 0;
                /* Let text wrap without affecting grid sizing */
                white-space: normal;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Disable hover lift on touch devices */
            .calendar-day:hover {
                transform: none;
                box-shadow: none;
            }

            .time-slot {
                border-radius: 0;
            }

            .time-slot span:last-child {
                margin-left: 10px;
                font-size: 0.85rem;
                opacity: 0.9;
            }

            /* Make nav buttons easier to tap */
            .calendar-nav button {
                width: 100%;
                padding: 12px 14px;
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
                <div class="row align-items-center g-2">
                    <div class="col-6 col-md-4">
                        <button class="btn btn-outline-primary w-100" onclick="previousMonth()">
                            <i class="bi bi-chevron-left"></i> Previous
                        </button>
                    </div>
                    <div class="col-12 col-md-4 text-center order-3 order-md-2">
                        <h3 id="currentMonth" class="mb-0"></h3>
                    </div>
                    <div class="col-6 col-md-4 text-end order-2 order-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="nextMonth()">
                            Next <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <div class="calendar-weekdays">
                    <div class="calendar-weekday">Sun</div>
                    <div class="calendar-weekday">Mon</div>
                    <div class="calendar-weekday">Tue</div>
                    <div class="calendar-weekday">Wed</div>
                    <div class="calendar-weekday">Thu</div>
                    <div class="calendar-weekday">Fri</div>
                    <div class="calendar-weekday">Sat</div>
                </div>
                <div id="calendarDays" class="calendar-days"></div>
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
                        <input type="hidden" id="final_price_input" name="final_price" value="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                            <div class="invalid-feedback" id="phoneFeedback"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div class="invalid-feedback" id="emailFeedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service" class="form-label">Service *</label>
                            <!-- Keep the real select for form submit, but hide it and drive selection via a guided modal -->
                            <select class="form-select d-none" id="service" name="service" required>
                                <option value="">Select a service</option>
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
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       id="serviceDisplay"
                                       placeholder="Select a service"
                                       readonly
                                       style="background-color:#f8f9fa; cursor:pointer;"
                                       onclick="openServiceForWhoModalCal()">
                                <button class="btn btn-outline-secondary" type="button" onclick="openServiceForWhoModalCal()">
                                    Choose
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Special Requests or Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <!-- Terms acceptance (required) -->
                    <input type="hidden" name="terms_accepted" value="0">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="termsAcceptedCal" name="terms_accepted" value="1" required>
                        <label class="form-check-label" for="termsAcceptedCal">
                            I agree to the <a href="{{ route('home') }}#terms" target="_blank" rel="noopener" style="font-weight:600; text-decoration:none;">Terms &amp; Conditions</a>.
                        </label>
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

    <!-- Who is this service for? (Calendar page) -->
    <div class="modal fade" id="serviceForWhoModalCal" tabindex="-1" aria-labelledby="serviceForWhoModalCalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 18px; border: none; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="serviceForWhoModalCalLabel" style="font-weight: 700;">
                        <i class="bi bi-question-circle me-2"></i>Who is this service for?
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3" style="color:#0b3a66; font-weight: 600;">Select one option:</p>
                    <div class="d-grid gap-3">
                        <button type="button" class="btn btn-outline-primary btn-lg" onclick="chooseServiceForKidsCal()"
                                style="border-radius: 14px; font-weight: 700; padding: 14px 16px;">
                            <i class="bi bi-emoji-smile me-2"></i>Kid (0–8 years)
                        </button>
                        <button type="button" class="btn btn-primary btn-lg" onclick="chooseServiceForNotKidsCal()"
                                style="border-radius: 14px; font-weight: 700; padding: 14px 16px;">
                            <i class="bi bi-person-check me-2"></i>Not a kid
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Gate Modal (Calendar page) -->
    <div class="modal fade" id="termsGateModalCal" tabindex="-1" aria-labelledby="termsGateModalCalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 18px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="termsGateModalCalLabel" style="font-weight: 800;">
                        <i class="bi bi-shield-check me-2"></i>Terms &amp; Policies
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3" style="color:#0b3a66; font-weight: 600;">
                        Please review and accept our Terms &amp; Conditions before booking.
                    </p>
                    <div class="alert alert-info" style="border-left: 5px solid #0ea5e9; border-radius: 12px;">
                        <div class="mb-1" style="font-weight:800;">Quick summary</div>
                        <ul class="mb-0" style="padding-left: 18px;">
                            <li>Deposits are non-refundable once the appointment is confirmed.</li>
                            <li>Minimum 48 hours notice is required for cancellations.</li>
                            <li>Rescheduling requires 48 hours notice and must be within 1 month of the initial appointment date.</li>
                            <li>No-shows may result in a full charge and may affect future bookings.</li>
                            <li>For home service: clients cover fueling for the stylist’s transportation; fees vary by distance.</li>
                        </ul>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="termsGateAgreeCal">
                        <label class="form-check-label" for="termsGateAgreeCal" style="font-weight: 700; color:#0b3a66;">
                            I agree to the Terms &amp; Conditions
                        </label>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('home') }}#terms" target="_blank" rel="noopener" style="color:#030f68; font-weight:600; text-decoration:none;">
                            View full Terms &amp; Conditions
                        </a>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="termsGateContinueBtnCal" disabled>Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Non-kids services list (Calendar page, excludes Kids Braids) -->
    <div class="modal fade" id="nonKidsServicesModalCal" tabindex="-1" aria-labelledby="nonKidsServicesModalCalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 18px; border: none; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="nonKidsServicesModalCalLabel" style="font-weight: 700;">
                        <i class="bi bi-scissors me-2"></i>Select a service
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info" style="background:#e7f3ff; border-left: 4px solid #17a2b8; border-radius: 10px;">
                        <i class="bi bi-info-circle me-2"></i>Choose a service to continue booking.
                    </div>
                    <div id="nonKidsServicesListCal" class="row g-2"></div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="openServiceForWhoModalCal()">Back</button>
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

        // Base prices (single source of truth: config/service_prices.php)
        @php
            $basePriceByServiceNameCal = [
                'Small Knotless Braids' => (int) config('service_prices.small_knotless', 170),
                'Smedium Knotless Braids' => (int) config('service_prices.smedium_knotless', 150),
                'Wig Installation' => (int) config('service_prices.wig_installation', 150),
                'Medium Knotless Braids' => (int) config('service_prices.medium_knotless', 130),
                'Jumbo Knotless Braids' => (int) config('service_prices.jumbo_knotless', 100),
                'Kids Braids' => (int) config('service_prices.kids_braids', 80),
                '8–10 Rows Stitch Braids' => (int) config('service_prices.stitch_braids', 120),
                'Hair Mask/Relaxing' => (int) config('service_prices.hair_mask', 50),
                'Smedium Boho Braids' => (int) config('service_prices.boho_braids', 150),
            ];
        @endphp
        const basePriceByServiceNameCal = @json($basePriceByServiceNameCal);

        // --- Booking draft (persist typed info across service flows / redirects) ---
        const DBT_BOOKING_DRAFT_KEY = 'dbt_booking_draft_v1';

        function loadBookingDraftCal() {
            try {
                const raw = sessionStorage.getItem(DBT_BOOKING_DRAFT_KEY);
                return raw ? (JSON.parse(raw) || {}) : {};
            } catch (e) { return {}; }
        }

        function clearBookingDraftCal() {
            try { sessionStorage.removeItem(DBT_BOOKING_DRAFT_KEY); } catch (e) { /* noop */ }
        }

        function saveBookingDraftCal() {
            try {
                const draft = loadBookingDraftCal();
                const nameEl = document.getElementById('name');
                const phoneEl = document.getElementById('phone');
                const emailEl = document.getElementById('email');
                const notesEl = document.getElementById('notes');

                const next = { ...draft };
                if (nameEl && nameEl.value && nameEl.value.trim()) next.name = nameEl.value.trim();
                if (phoneEl && phoneEl.value && phoneEl.value.trim()) next.phone = phoneEl.value.trim();
                if (emailEl && emailEl.value && emailEl.value.trim()) next.email = emailEl.value.trim();
                if (notesEl && notesEl.value && notesEl.value.trim()) next.message = notesEl.value.trim(); // map calendar notes -> home message

                // Date/time (so home modal & kids modal can auto-fill)
                try {
                    if (selectedDate) {
                        next.appointment_date = formatYMD(selectedDate);
                        next.bookingDateDisplay = selectedDate.toLocaleDateString('en-US', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    }
                    if (selectedTime && selectedTime.time) {
                        next.appointment_time = selectedTime.time;
                        next.timeDisplay = selectedTime.formatted_time || selectedTime.formattedTime || selectedTime.time;
                    }
                } catch (e) { /* noop */ }

                sessionStorage.setItem(DBT_BOOKING_DRAFT_KEY, JSON.stringify(next));
            } catch (e) { /* noop */ }
        }

        // --- Service selection (guided flow) ---
        function openServiceForWhoModalCal() {
            const modalEl = document.getElementById('serviceForWhoModalCal');
            if (!modalEl || typeof bootstrap === 'undefined') {
                // Fallback: allow user to use the hidden select if Bootstrap isn't available
                const select = document.getElementById('service');
                if (select) select.classList.remove('d-none');
                return;
            }
            const m = new bootstrap.Modal(modalEl);
            m.show();
        }

        function chooseServiceForKidsCal() {
            try {
                const whoModal = bootstrap.Modal.getInstance(document.getElementById('serviceForWhoModalCal'));
                if (whoModal) whoModal.hide();
            } catch (e) {}

            // Persist any typed draft details before redirecting
            saveBookingDraftCal();

            // Kids bookings require the kids flow/selector.
            // Redirect to kids selector page.
            window.location.href = '/kids-selector';
        }

        function chooseServiceForNotKidsCal() {
            try {
                const whoModal = bootstrap.Modal.getInstance(document.getElementById('serviceForWhoModalCal'));
                if (whoModal) whoModal.hide();
            } catch (e) {}
            openNonKidsServicesModalCal();
        }

        function openNonKidsServicesModalCal() {
            const modalEl = document.getElementById('nonKidsServicesModalCal');
            if (!modalEl || typeof bootstrap === 'undefined') return;
            populateNonKidsServicesListCal();
            const m = new bootstrap.Modal(modalEl);
            m.show();
        }

        function populateNonKidsServicesListCal() {
            const container = document.getElementById('nonKidsServicesListCal');
            const select = document.getElementById('service');
            if (!container || !select) return;
            container.innerHTML = '';

            const services = Array.from(select.querySelectorAll('option'))
                .map(o => (o.value || '').trim())
                .filter(v => v.length > 0)
                .filter(v => !/kids/i.test(v)); // exclude Kids Braids

            const unique = Array.from(new Set(services));
            if (!unique.length) {
                container.innerHTML = '<div class="col-12"><div class="alert alert-warning mb-0">No services available.</div></div>';
                return;
            }

            unique.forEach(serviceName => {
                const col = document.createElement('div');
                col.className = 'col-12 col-md-6 col-lg-4';
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-primary w-100';
                btn.style.borderRadius = '12px';
                btn.style.padding = '12px 10px';
                btn.style.fontWeight = '700';
                btn.textContent = serviceName;
                btn.addEventListener('click', function () {
                    selectNonKidsServiceCal(serviceName);
                });
                col.appendChild(btn);

                // Price hint (pulled from same config as Services section)
                try {
                    const p = basePriceByServiceNameCal[serviceName];
                    if (typeof p === 'number' && !isNaN(p) && p > 0) {
                        const priceEl = document.createElement('div');
                        priceEl.className = 'small text-muted mt-1 text-center';
                        priceEl.textContent = 'Starting at $' + p;
                        col.appendChild(priceEl);
                    }
                } catch (e) {}
                container.appendChild(col);
            });
        }

        function selectNonKidsServiceCal(serviceName) {
            // Persist any typed draft details before redirecting
            saveBookingDraftCal();

            // Redirect to home and open the main booking modal with this service preselected
            const homeUrl = @json(route('home'));
            try {
                const u = new URL(homeUrl, window.location.origin);
                u.searchParams.set('openBooking', '1');
                u.searchParams.set('service', serviceName);
                window.location.href = u.toString();
            } catch (e) {
                // Fallback: simple redirect
                window.location.href = '/?openBooking=1&service=' + encodeURIComponent(serviceName);
            }
        }

        // Helper: format a Date as local YYYY-MM-DD (avoids timezone shifts from toISOString())
        function formatYMD(d){
            try{
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }catch(e){
                try{ return d.toISOString().split('T')[0]; }catch(er){ return ''+d; }
            }
        }

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            // If user refreshed/reloaded the page, clear the draft (per request)
            try {
                const navEntry = (performance && performance.getEntriesByType) ? performance.getEntriesByType('navigation')[0] : null;
                const navType = navEntry ? navEntry.type : ((performance && performance.navigation) ? performance.navigation.type : null);
                const isReload = (navType === 'reload') || (navType === 1);
                if (isReload) {
                    clearBookingDraftCal();
                }
            } catch (e) { /* noop */ }

            // Save typed fields as the user types (so switching flows doesn't lose data)
            try {
                const form = document.getElementById('bookingForm');
                if (form) {
                    ['name','phone','email','notes'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.addEventListener('input', saveBookingDraftCal);
                    });
                    // Clear draft once the calendar page booking form is submitted
                    form.addEventListener('submit', function () { clearBookingDraftCal(); });
                }
            } catch (e) {}

            renderCalendar();
            loadCalendarData();

            // Initialize service display if a value already exists
            try {
                const select = document.getElementById('service');
                const display = document.getElementById('serviceDisplay');
                if (select && display && select.value) display.value = select.value;
            } catch (e) {}
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
            fetch(`/bookings/booked-dates?year=${year}&month=${month + 1}`)
                .then(response => response.json())
                .then(data => {
                    const bookedDates = data.success ? data.booked_dates : [];
                    console.log('Booked dates for month:', bookedDates);

                    for (let i = 0; i < 42; i++) {
                        const date = new Date(startDate);
                        date.setDate(startDate.getDate() + i);
                        const dateString = formatYMD(date);

                        const dayDiv = document.createElement('div');
                        dayDiv.className = 'col calendar-day';
                        dayDiv.textContent = date.getDate();

                        if (date.getMonth() !== month) {
                            dayDiv.classList.add('other-month');
                        } else if (date < new Date().setHours(0, 0, 0, 0)) {
                            dayDiv.classList.add('past');
                            dayDiv.title = 'Past dates are not available';
                        } else if (bookedDates.includes(dateString)) {
                            dayDiv.classList.add('booked');
                            dayDiv.title = 'This date is already booked';
                            // Don't add click event for booked dates
                        } else {
                            dayDiv.classList.add('available');
                            dayDiv.onclick = () => selectDate(date);
                            dayDiv.title = 'Click to see available time slots';
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

            // Save partial draft (date chosen)
            saveBookingDraftCal();
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

            fetch(`/bookings/slots?date=${formatYMD(date)}`)
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

            if (slots.length === 0) {
                timeSlots.innerHTML = '<div class="alert alert-info">No available slots for this date</div>';
                return;
            }

            slots.forEach(slot => {
                const slotDiv = document.createElement('div');
                slotDiv.className = `time-slot ${slot.available ? 'available' : 'booked'}`;
                slotDiv.innerHTML = `
                    <span>${slot.formatted_time}</span>
                    <span>${slot.available ? 'Available' : 'Booked'}</span>
                `;

                if (slot.available) {
                    slotDiv.onclick = () => selectTimeSlot(slot);
                }

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

            // Save draft (date + time chosen)
            saveBookingDraftCal();
        }

        function showBookingForm() {
            // Terms gate: show once per device before allowing booking UI
            const ensureTermsAccepted = (next) => {
                const KEY = 'dbt_terms_accepted_v1';
                const hasAccepted = () => { try { return localStorage.getItem(KEY) === '1'; } catch(e) { return false; } };
                const setAccepted = () => { try { localStorage.setItem(KEY, '1'); } catch(e) {} };
                if (hasAccepted()) {
                    try { const chk = document.getElementById('termsAcceptedCal'); if (chk) chk.checked = true; } catch(e) {}
                    return next();
                }

                const modalEl = document.getElementById('termsGateModalCal');
                const agreeEl = document.getElementById('termsGateAgreeCal');
                const contBtn = document.getElementById('termsGateContinueBtnCal');
                if (!modalEl || !agreeEl || !contBtn) return next();

                agreeEl.checked = false;
                contBtn.disabled = true;
                agreeEl.onchange = () => { contBtn.disabled = !agreeEl.checked; };
                contBtn.onclick = () => {
                    if (!agreeEl.checked) return;
                    setAccepted();
                    try { const chk = document.getElementById('termsAcceptedCal'); if (chk) chk.checked = true; } catch(e) {}
                    try { (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).hide(); } catch(e) {}
                    next();
                };
                try { (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).show(); } catch(e) { next(); }
            };

            const bookingFormContainer = document.getElementById('bookingFormContainer');
            const bookingSummary = document.getElementById('bookingSummary');

            ensureTermsAccepted(() => {
                bookingSummary.textContent = `${selectedDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                })} at ${selectedTime.formatted_time}`;

                bookingFormContainer.style.display = 'block';
                bookingFormContainer.scrollIntoView({ behavior: 'smooth' });
            });
        }

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Terms must be accepted (required). Since we preventDefault, enforce it manually.
            const termsCb = document.getElementById('termsAcceptedCal');
            if (termsCb && !termsCb.checked) {
                alert('Please accept the Terms & Conditions to continue.');
                try { termsCb.focus(); } catch(e) {}
                return;
            }

            // Ensure a service is selected via the guided flow
            const svc = document.getElementById('service');
            if (!svc || !svc.value) {
                alert('Please select a service to continue.');
                openServiceForWhoModalCal();
                return;
            }

            const formData = new FormData(this);
            formData.append('appointment_date', formatYMD(selectedDate));
            formData.append('appointment_time', selectedTime.time);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Validate contact details before submitting
            try {
                const emailInput = this.querySelector('input[name="email"]') || document.getElementById('email');
                const phoneInput = this.querySelector('input[name="phone"]') || document.getElementById('phone');
                const emailVal = emailInput && emailInput.value ? emailInput.value.trim() : '';
                const phoneVal = phoneInput && phoneInput.value ? phoneInput.value.trim() : '';

                // Clear previous inline errors
                if (window.clearFieldError) {
                    try { clearFieldError(emailInput); clearFieldError(phoneInput); } catch(e){}
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailVal || !emailRegex.test(emailVal)) {
                    if (window.showFieldError) {
                        showFieldError(emailInput, 'Please enter a valid email address');
                    } else {
                        alert('Please enter a valid email address.');
                    }
                    if (emailInput) emailInput.focus();
                    return;
                }

                const phoneDigits = phoneVal.replace(/\D/g, '');
                if (!phoneVal || phoneDigits.length < 7 || phoneDigits.length > 15) {
                    if (window.showFieldError) {
                        showFieldError(phoneInput, 'Please enter a valid phone number (7–15 digits)');
                    } else {
                        alert('Please enter a valid phone number (7–15 digits).');
                    }
                    if (phoneInput) phoneInput.focus();
                    return;
                }
            } catch (e) {
                console.warn('Contact validation failed', e);
            }

            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            submitBtn.disabled = true;

            fetch('/bookings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async (response) => {
                const data = await response.json().catch(() => null);
                if (!response.ok) {
                    // Laravel validation errors typically come back as { errors: { field: [...] } }
                    const msg = (data && data.message) ? data.message : 'Unable to complete booking.';
                    const errors = data && data.errors ? data.errors : null;
                    if (errors && errors.terms_accepted && errors.terms_accepted.length) {
                        alert(errors.terms_accepted[0]);
                        // Prompt terms checkbox focus
                        try { document.getElementById('termsAcceptedCal')?.focus(); } catch(e) {}
                        return;
                    }
                    if (errors) {
                        const firstKey = Object.keys(errors)[0];
                        if (firstKey && errors[firstKey] && errors[firstKey][0]) {
                            alert(errors[firstKey][0]);
                            return;
                        }
                    }
                    alert(msg);
                    return;
                }
                if (data && data.success) {
                    showConfirmation(data.appointment);
                } else {
                    alert('Error: ' + ((data && data.message) ? data.message : 'Unknown error'));
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

        // Disable submit until Terms is checked (calendar)
        document.addEventListener('DOMContentLoaded', function(){
            const form = document.getElementById('bookingForm');
            const cb = document.getElementById('termsAcceptedCal');
            if (!form || !cb) return;
            const btn = form.querySelector('button[type="submit"]');
            if (!btn) return;
            const sync = () => { btn.disabled = !cb.checked; };
            sync();
            cb.addEventListener('change', sync);
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
            console.log('📅 Loading calendar data for separate calendar page');

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth() + 1; // 1-based month

            // Fetch booked dates API and blocked dates in parallel
            const bookedPromise = fetch('/api/booked-dates').then(r => r.json()).catch(e => { console.error('Booked-dates fetch failed', e); return null; });
            const blockedPromise = fetch(`/schedules/blocked-dates?year=${year}&month=${month}`).then(r => r.json()).catch(e => { console.error('Blocked-dates fetch failed', e); return null; });

            Promise.all([bookedPromise, blockedPromise]).then(([bookedResp, blockedResp]) => {
                let bookedDates = [];
                if (bookedResp && bookedResp.success) {
                    bookedDates = bookedResp.booked_dates.filter(booking => booking.disabled).map(booking => booking.date);
                }

                let blockedDates = [];
                if (blockedResp && blockedResp.success) {
                    blockedDates = blockedResp.blocked_dates || [];
                }

                console.log('🔴 Booked dates:', bookedDates);
                console.log('⛔ Blocked dates:', blockedDates);

                updateCalendarDisplay(bookedDates, blockedDates);
            }).catch(error => {
                console.error('❌ Error loading calendar data:', error);
            });
        }

        function updateCalendarDisplay(bookedDates, blockedDates) {
            console.log('🎨 Updating calendar display with booked dates and blocked dates:', bookedDates, blockedDates);

            // Index blockedDates by date for quick lookup
            const blockedIndex = {};
            (blockedDates || []).forEach(b => {
                blockedIndex[b.date] = b;
            });

            // Find all calendar day elements and mark booked/blocked ones
            const calendarDays = document.querySelectorAll('.calendar-day');

            calendarDays.forEach(dayElement => {
                const rawText = dayElement.textContent.trim();
                // remove any injected blocked text before parsing
                const dayText = rawText.split('\n')[0].trim();

                if (dayText && !isNaN(dayText)) {
                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();
                    const day = parseInt(dayText);
                    const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // Clean previous state
                    dayElement.classList.remove('booked', 'available', 'blocked-range');
                    dayElement.style.backgroundColor = '';
                    dayElement.style.color = '';
                    dayElement.style.cursor = '';
                    dayElement.style.opacity = '';
                    dayElement.title = '';

                    // Remove old blocked-text node if exists
                    const oldBlocked = dayElement.querySelector('.blocked-text');
                    if (oldBlocked) oldBlocked.remove();

                    if (bookedDates && bookedDates.includes(dateString)) {
                        // Mark as booked with red styling
                        dayElement.classList.add('booked');
                        dayElement.title = 'This date is fully booked';
                        // keep day number visible but add a cross
                        dayElement.innerHTML = dayText + '<span style="position:absolute;top:2px;right:4px;color:#ffffff;font-size:12px;">×</span>';
                        console.log(`🔴 Marked ${dateString} as BOOKED`);

                    } else if (blockedIndex[dateString]) {
                        const blockedInfo = blockedIndex[dateString];
                        const isFullDay = blockedInfo.full_day === true || blockedInfo.full_day === 1;
                        
                        if (isFullDay) {
                            // Mark as blocked-range and show title text
                            dayElement.classList.add('blocked-range');
                            dayElement.title = blockedInfo.title || 'Blocked';
                            const textDiv = document.createElement('div');
                            textDiv.className = 'blocked-text';
                            textDiv.textContent = blockedInfo.title || 'Blocked';
                            dayElement.appendChild(textDiv);
                            console.log(`⛔ Marked ${dateString} as FULLY BLOCKED (${blockedInfo.title})`);
                        } else {
                            // Time-specific block: mark as available
                            dayElement.classList.add('available');
                            dayElement.title = (blockedInfo.title || 'Blocked') + ' - Some times blocked, click to see available times';
                            console.log(`🟡 Marked ${dateString} as AVAILABLE with time-specific blocks`);
                        }

                    } else {
                        // Available
                        dayElement.classList.add('available');
                        dayElement.title = 'Click to see available time slots';
                        console.log(`🟢 Marked ${dateString} as AVAILABLE`);
                    }
                }
            });
        }
    </script>
</body>
</html>

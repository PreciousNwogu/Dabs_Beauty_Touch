<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dab's Beauty Touch - Professional Hair Braiding Services</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <!-- Bootstrap CDN (backup) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <!-- Additional styling -->
    <style>
        /* Section headings color and About font size */
        .section-title {
            color: #ff6600 !important;
        }
        .about-section h2.section-title {
            font-size: 2rem !important;
            font-weight: bold;
            line-height: 1.1;
        }
        .book-now-btn {
            background-color: #030f68 !important;
            color: #fff !important;
            border: 2px solid #05137c !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(0,123,255,0.15);
            font-weight: 600;
            font-size: 1rem !important;
            padding: 8px 24px !important;
            display: inline-block;
            transition: background 0.3s, color 0.3s, border 0.3s;
        }
        .book-now-btn:hover, .book-now-btn:focus {
            background-color: #0056b3 !important;
            color: #fff !important;
            border-color: #0056b3 !important;
        }
        .navbar-nav .nav-link {
            color: #05137c !important;
        }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link:focus {
            color: #ff6600 !important;
        }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('images/backgroundbraid.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .hero-content {
            background: rgba(0,0,0,0.5);
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            display: inline-block;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            color: #ff6600;
            margin-bottom: 1rem;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            max-width: 650px;
            color: #fff;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .btn-book {
            background-color: #ff6600;
            color: white;
            padding: 15px 40px;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-book:hover {
            background-color: #e55a00;
            color: white;
            text-decoration: none;
        }

        .services-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .service-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);
            padding: 32px 18px 28px 18px;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            margin-bottom: 32px;
            text-align: center;
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .service-card:hover {
            box-shadow: 0 16px 40px rgba(0,0,0,0.14);
            transform: translateY(-4px) scale(1.03);
            cursor: pointer;
        }

        .service-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .service-card img {
            width: 220px;
            height: 220px;
            object-fit: cover;
            background: #fff;
            border-radius: 50%;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            display: block;
            margin-left: auto;
            margin-right: auto;
            border: 4px solid #fff;
        }

        /* Specific styling for stitch braid and hair mask images */
        .service-card img[src*="stitch braid.jpg"] {
            object-fit: cover;
            object-position: center;
            padding: 5px;
        }

        .service-card img[src*="hair_mask.png"] {
            object-fit: contain;
            object-position: center;
            padding: 8px;
        }


        .service-card h4 {
            font-size: 1.45rem;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 10px;
        }
        .service-card p {
            font-size: 1.08rem;
            color: #222;
            margin-bottom: 8px;
        }
        .service-card .price {
            font-size: 1.12rem;
            color: #030f68;
            font-weight: 700;
            margin-top: 10px;
        }

        .about-section {
            padding: 80px 0;
        }

        .contact-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        /* Booking Form Fixes */
        .booking-form .form-control,
        .booking-form .form-select {
            border: 2px solid #e3e3e0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #ffffff;
            position: relative;
            z-index: 1;
        }

        .booking-form .form-control:focus,
        .booking-form .form-select:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
            outline: none;
        }

        .booking-form .form-label {
            position: static !important;
            transform: none !important;
            font-weight: 600;
            color: #05137c;
            font-size: 1rem;
            margin-bottom: 8px;
            display: block;
        }

        .booking-form .input-group-text {
            background-color: #f8f9fa;
            border: 2px solid #e3e3e0;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .booking-form .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .booking-form .btn-book {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            border: none;
            color: white;
            font-weight: 700;
            padding: 14px 48px;
            border-radius: 10px;
            font-size: 1.15rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 102, 0, 0.3);
        }

        .booking-form .btn-book:hover {
            background: linear-gradient(135deg, #e55a00 0%, #ff6600 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 102, 0, 0.4);
        }

        .booking-form .form-text {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 4px;
        }

        /* Ensure select dropdowns are clickable */
        .booking-form .form-select {
            cursor: pointer;
            pointer-events: auto;
            z-index: 10;
            position: relative;
        }

        .booking-form .form-select:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
            outline: none;
        }

        .booking-form .form-select option {
            background-color: #ffffff;
            color: #333;
            padding: 8px;
        }

        .booking-form .form-select optgroup {
            font-weight: bold;
            color: #ff6600;
            background-color: #f8f9fa;
        }

        /* Debug and fix dropdown visibility */
        .booking-form .form-select {
            display: block !important;
            width: 100% !important;
            padding: 12px 16px !important;
            font-size: 16px !important;
            line-height: 1.5 !important;
            color: #495057 !important;
            background-color: #fff !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 16px 12px !important;
            border: 2px solid #e3e3e0 !important;
            border-radius: 8px !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
        }

        .booking-form .form-select:focus {
            border-color: #ff6600 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25) !important;
            outline: none !important;
        }

        .booking-form .form-select option {
            background-color: #ffffff !important;
            color: #333 !important;
            padding: 8px !important;
        }

        .booking-form .form-select optgroup {
            font-weight: bold !important;
            color: #ff6600 !important;
            background-color: #f8f9fa !important;
        }

        /* Ensure dropdown arrow is visible */
        .booking-form .form-select::after {
            content: '' !important;
            position: absolute !important;
            right: 12px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 0 !important;
            height: 0 !important;
            border-left: 5px solid transparent !important;
            border-right: 5px solid transparent !important;
            border-top: 5px solid #666 !important;
            pointer-events: none !important;
        }

        /* Modal Styling */
        .modal-content {
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-body {
            background: #f8f9fa;
        }

        /* Fix form label positioning */
        .modal-body .form-label {
            position: static !important;
            transform: none !important;
            font-weight: 600;
            color: #05137c;
            font-size: 1rem;
            margin-bottom: 8px;
            display: block;
            line-height: 1.2;
        }

        .form-control {
            border: 2px solid #e3e3e0;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-top: 0;
            position: relative;
            z-index: 1;
            background-color: #fff;
            color: #333;
        }

        .form-control:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
            outline: none;
        }



        /* Ensure proper spacing between form groups */
        .modal-body .row.g-3 > div {
            margin-bottom: 20px;
        }

        /* FAQ Styling */
        .faq-question {
            transition: all 0.3s ease;
            user-select: none;
            border-radius: 8px;
        }

        .faq-question:hover {
            background-color: rgba(255, 102, 0, 0.05);
            padding: 8px;
            margin: -8px;
        }

        .faq-answer {
            display: none;
            transition: all 0.3s ease;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
        }

        .faq-answer.show {
            display: block;
            max-height: 500px;
            opacity: 1;
            margin-top: 12px;
        }

        .faq-arrow {
            transition: transform 0.3s ease;
        }

        .faq-arrow.rotated {
            transform: rotate(180deg);
        }

        /* Carousel Styling */
        .carousel {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .carousel-indicators {
            bottom: 20px;
        }

        .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 102, 0, 0.5);
            border: 2px solid #fff;
            margin: 0 5px;
        }

        .carousel-indicators button.active {
            background-color: #ff6600;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background-color: rgba(255, 102, 0, 0.8);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            margin: 0 20px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 25px;
            height: 25px;
        }

        .slide-content {
            animation: slideInLeft 0.8s ease-out;
        }

        .slide-image {
            animation: slideInRight 0.8s ease-out;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .carousel-item {
            padding: 40px 0;
        }

        .modal-body .form-text {
            margin-top: 5px;
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Form group styling */
        .modal-body .form-group {
            margin-bottom: 20px;
        }

        .modal-body .form-group .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #05137c;
            font-size: 1rem;
            line-height: 1.2;
        }

        .modal-body .form-group .form-control {
            width: 100%;
            margin-top: 0;
        }

        /* Fix for dropdowns and date inputs in modal */
        #bookingModal select,
        #bookingModal input[type="date"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            z-index: 10 !important;
        }

        /* Ensure form controls are properly visible */
        .modal-body .form-control,
        .modal-body .form-select {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Clean dropdown styling like the screenshot */
        #bookingModal .form-select {
            background-color: white !important;
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            color: #495057 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 8px center !important;
            background-size: 16px 12px !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
        }

        #bookingModal .form-select:focus {
            border-color: #80bdff !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }

        #bookingModal .form-select:hover {
            border-color: #adb5bd !important;
        }

        /* Calendar Modal Styles */
        .calendar-day {
            border: 1px solid #e9ecef;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 0.9rem;
        }

        .calendar-day:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
            color: white;
            border-color: #17a2b8;
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

        .time-slot-btn {
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .time-slot-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .time-slot-btn.btn-primary {
            background-color: #030f68 !important;
            border-color: #030f68 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(3, 15, 104, 0.4);
        }

        .time-slot-btn.booked {
            background-color: #f8f9fa !important;
            border-color: #dee2e6 !important;
            color: #6c757d !important;
            cursor: not-allowed;
        }

        .time-slot-btn.booked:hover {
            transform: none;
            box-shadow: none;
        }

        /* Book Appointment button styles */
        #bookAppointmentBtn {
            transition: all 0.3s ease !important;
        }

        #bookAppointmentBtn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4) !important;
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
        }

        #bookAppointmentBtn:active {
            transform: translateY(0) !important;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3) !important;
        }

        #bookAppointmentBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Service Selection Modal Styles */
        .service-quick-btn {
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .service-quick-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(3, 15, 104, 0.2);
            background-color: #030f68;
            border-color: #030f68;
            color: white;
        }

        .service-quick-btn:active {
            transform: translateY(0);
        }

        #customServiceInput {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }

        #customServiceInput:focus {
            border-color: #030f68;
            box-shadow: 0 0 0 0.2rem rgba(3, 15, 104, 0.1);
        }

        /* Service Display Field Styles */
        #serviceDisplay {
            font-weight: 500;
            color: #030f68;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white" style="margin-bottom: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
        <div class="container-fluid py-2">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                <span style="font-weight: bold; font-size: 1.3rem; color: #ff6600;">Dab's Beauty Touch</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="#terms">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('calendar') }}" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); color: white; border-radius: 20px; padding: 8px 20px !important;">Book Now</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container" style="padding-top: 120px; padding-bottom: 80px;">
            <div class="hero-content">
                <h1>Dab's Beauty Touch</h1>
                <p>Flawless Results - Looking for a stylist who delivers neat, long-lasting braids? Experience the expert touch at Dab's Beauty Touch today!</p>
            </div>
        </div>
    </section>

    <!-- Image Slider Section -->
    <section class="image-slider-section" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #030f68;">Customer Transformations</h2>
                <p class="lead" style="color: #666; font-size: 1.2rem;">See Real Results from Our Satisfied Clients</p>
            </div>

            <div id="workSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="5" aria-label="Slide 6"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="6" aria-label="Slide 7"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="7" aria-label="Slide 8"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="8" aria-label="Slide 9"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="9" aria-label="Slide 10"></button>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <!-- Slide 1: Small Knotless Braids -->
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Small Knotless Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Ultra-fine knotless braids that blend seamlessly with your natural hair. Perfect for a sleek, professional look with minimal tension and maximum comfort.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Seamless blend</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Professional look</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Minimal tension</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $150</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Small Knotless Braids', 'small-knotless')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book This Style
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/small braid.jpg') }}" alt="Small Knotless Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Smedium Knotless Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Smedium Knotless Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Perfect balance between small and medium braids for a versatile, everyday style. Offers excellent durability while maintaining a natural, lightweight feel.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Perfect balance</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Excellent durability</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Lightweight feel</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $130</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Smedium Knotless Braids', 'smedium-knotless')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book This Style
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/webbraids2.jpg') }}" alt="Smedium Knotless Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Wig Installation -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Wig Installation</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Professional wig installation with custom fitting and styling. Sleek natural hairline blending, and personalized styling to match your desired look.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Custom fitting</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Natural hairline</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Personalized styling</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $150</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Wig Installation', 'wig-installation')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/wig installation.jpg') }}" alt="Wig Installation" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Large Knotless Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Large Knotless Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Bold, statement-making braids that create a dramatic, eye-catching look. Perfect for those who want to make a strong fashion statement with their hair.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Bold statement</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Eye-catching look</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Fashion statement</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $110</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Large Knotless Braids', 'large-knotless')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/large braid.jpg') }}" alt="Large Knotless Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5: Jumbo Knotless Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Jumbo Knotless Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Extra large, voluminous braids for maximum impact and style. Creates a bold, confident look that's perfect for special occasions and fashion-forward individuals.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Extra large volume</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Maximum impact</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Special occasions</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $80</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Jumbo Knotless Braids', 'jumbo-knotless')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/jumbo braid.jpg') }}" alt="Jumbo Knotless Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 6: Kids Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Kids Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Specialized braiding services for children with gentle, age-appropriate techniques. Creates adorable, manageable styles that are comfortable and long-lasting for active kids.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Gentle techniques</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Adorable styles</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Kid-friendly comfort</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $80</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Kids Braids', 'kids-braids')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/kids hair style.webp') }}" alt="Kids Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 7: Stitch Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">6 Rows Stitch Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Unique stitch pattern braids that create a distinctive, textured look. Features a special weaving technique that adds dimension and style to your braided hairstyle.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Unique stitch pattern</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Distinctive texture</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Special weaving</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $120</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('8 Rows Stitch Braids', 'stitch-braids')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/stitch braid.jpg') }}" alt="Stitch Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 8: Hair Mask/Relaxing -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Hair Mask/Relaxing</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Professional hair mask treatment and relaxing services to restore moisture, shine, and manageability. Perfect for maintaining healthy, beautiful hair.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Restore moisture</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Add shine</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Professional treatment</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $50</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Hair Mask/Relaxing', 'hair-mask')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/hair_mask.png') }}" alt="Hair Mask/Relaxing" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 9: Smedium Boho Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Smedium Boho Braids</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Bohemian-inspired braids with a free-spirited, artistic touch. Features curly strands for a trendy, fashion-forward look.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Bohemian-inspired</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Voluminous</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Fashionable</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at $150</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Smedium Boho Braids', 'boho-braids')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/boho braid.jpg') }}" alt="Smedium Boho Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 10: Custom Service -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Custom Styles Available</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Don't see what you're looking for? We offer many more services beyond what's listed. Book a consultation and let us know what you need!
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Custom consultations</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Personalized service</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #ff6600; margin-right: 10px;"></i>
                                            <span style="color: #333; font-weight: 500;">Expert guidance</span>
                                        </div>
                                    </div>
                                    <div class="pricing-info mb-3" style="background: rgba(3, 15, 104, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #030f68;">
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Pricing varies by service</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Custom Service Request', 'custom')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-plus-circle me-2"></i>Book Consultation
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%); border-radius: 20px; height: 400px;">
                                    <div class="text-center" style="color: #030f68;">
                                        <i class="bi bi-scissors" style="font-size: 4rem; margin-bottom: 20px; color: #ff6600;"></i>
                                        <h4 style="font-weight: 700; margin-bottom: 10px;">Tell Us Your Vision</h4>
                                        <p style="font-size: 1.1rem; color: #666;">We'll make it happen!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#workSlider" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#workSlider" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <!-- Reviews Section -->
    <div class="section section-lg bg-gray-150" style="padding: 80px 0; background: #f8f9fa;">
        <div class="text-center mb-5">
            <p class="subtitle" style="font-size:1.5rem; color:#ff6600; font-weight:600;">Our customers love DBT</p>
            <div class="subtitle-box" style="display:inline-block; margin-bottom:18px;">
                <div class="subtitle-box-text" style="font-size:2rem; color:#030f68; font-weight:700;">Reviews</div>
            </div>
        </div>
        <div class="owl-carousel owl-theme-1" data-items="1" data-sm-items="1" data-md-items="1" data-lg-items="1" data-xl-items="2" data-xxl-items="3" data-margin="15px" data-nav="false" data-dots="true" data-autoplay="5000">
            <div class="testimonial-box" style="background:linear-gradient(135deg,#e3eafc 0%,#f8f9fa 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Cool!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">"DBT offers great services and she delivers excellently. </div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 1</div>
            </div>
            <div class="testimonial-box" style="background:linear-gradient(135deg,#fff6e3 0%,#ffe3e3 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Excellent!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">"Very patient and time conscious. She follows up and ensures customer comfortability. I always leave happy!"</div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 2</div>
            </div>
            <div class="testimonial-box" style="background:linear-gradient(135deg,#e3ffe3 0%,#e3f8ff 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Amazing!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">"DBT braided my child's hair and my child was very comfortable. Her braids don't hurt much and last long!"</div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 3</div>
            </div>
            <div class="testimonial-box" style="background:linear-gradient(135deg,#f8e3ff 0%,#e3eaff 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Excellent!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;"> "Customer relationship is amazing. Very professional and very affordable service. Highly recommend DBT!"</div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 4</div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container" style="padding-top: 60px; padding-bottom: 60px;">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10">
                    <div class="card flex-row shadow-lg border-0" style="border-radius: 24px; overflow: hidden; background: #fff;">
                        <div class="col-md-7 p-5 d-flex flex-column justify-content-center">
                            <h2 class="section-title mb-3" style="font-size:2.5rem; font-weight:700;">About Dab's Beauty Touch</h2>
                            <p class="lead mb-3" style="font-size:1.25rem; color:#333;">Professional hair braiding services with over 10 years of experience.</p>
                            <p style="font-size:1.05rem; color:#444;">At Dab's Beauty Touch, we specialize in creating beautiful, long-lasting braided hairstyles that enhance your natural beauty. <br>We believe that confidence begins with feeling great about how you look. Known for our exceptional craftsmanship and creative hairstyle designs, we don't just transform appearances—we help you radiate self-assurance. Whether it's a fresh new look or a signature style, we're here to be the touch that enhances your natural beauty and leaves you feeling confident.</p>
                            <ul class="list-unstyled mt-3 mb-0" style="font-size:1.08rem;">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Expert braiding techniques</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>High-quality hair products</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Personalized consultations</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Affordable pricing</li>
                            </ul>
                        </div>
                        <div class="col-md-5 d-flex align-items-center justify-content-center p-4" style="background:linear-gradient(135deg,#e3eafc 0%,#f8f9fa 100%);">
                            <img src="{{ asset('images/About DBT.jpg') }}" alt="About Dab's Beauty Touch" class="img-fluid" style="max-width:320px; border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); border:6px solid #fff;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container" style="padding-top: 60px; padding-bottom: 60px;">
            <div class="text-center mb-5">
                <h2>Our Services</h2>
                <p class="lead">Professional hair braiding and styling services</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Small Knotless Braids', 'small-knotless')">
                        <img src="{{ asset('images/small braid.jpg') }}" alt="Small Knotless Braids">
                        <h4>Small Knotless Braids</h4>
                        <p>Ultra-fine knotless braids that blend seamlessly with your natural hair. Perfect for a sleek, professional look with minimal tension and maximum comfort.</p>
                        <p class="price"><strong>Starting at $150</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Smedium Knotless Braids', 'smedium-knotless')">
                        <img src="{{ asset('images/webbraids2.jpg') }}" alt="Smedium Knotless Braids">
                        <h4>Smedium Knotless Braids</h4>
                        <p>Perfect balance between small and medium braids for a versatile, everyday style. Offers excellent durability while maintaining a natural, lightweight feel.</p>
                        <p class="price"><strong>Starting at $130</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Wig Installation', 'wig-installation')">
                        <img src="{{ asset('images/wig installation.jpg') }}" alt="Smedium Knotless Braids">
                        <h4>Wig Installation</h4>
                        <p>Professional wig installation with custom fitting and styling. Sleek natural hairline blending, and personalized styling to match your desired look.</p>
                        <p class="price"><strong>Starting at $150</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Large Knotless Braids', 'large-knotless')">
                        <img src="{{ asset('images/large braid.jpg') }}" alt="Large Knotless Braids">
                        <h4>Large Knotless Braids</h4>
                        <p>Bold, statement-making braids that create a dramatic, eye-catching look. Perfect for those who want to make a strong fashion statement with their hair.</p>
                        <p class="price"><strong>Starting at $110</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Jumbo Knotless Braids', 'jumbo-knotless')">
                        <img src="{{ asset('images/jumbo braid.jpg') }}" alt="Jumbo Knotless Braids">
                        <h4>Jumbo Knotless Braids</h4>
                        <p>Extra large, voluminous braids for maximum impact and style. Creates a bold, confident look that's perfect for special occasions and fashion-forward individuals.</p>
                        <p class="price"><strong>Starting at $80</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Kids Braids', 'kids-braids')">
                        <img src="{{ asset('images/kids hair style.webp') }}" alt="Kids Braids">
                        <h4>Kids Braids</h4>
                        <p>Specialized braiding services for children with gentle, age-appropriate techniques. Creates adorable, manageable styles that are comfortable and long-lasting for active kids.</p>
                        <p class="price"><strong>Starting at $80</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('8 Rows Stitch Braids', 'stitch-braids')">
                        <img src="{{ asset('images/stitch braid.jpg') }}" alt="8 Rows Stitch Braids">
                        <h4>6 Rows Stitch Braids</h4>
                        <p>Unique stitch pattern braids that create a distinctive, textured look. Features a special weaving technique that adds dimension and style to your braided hairstyle.</p>
                        <p class="price"><strong>Starting at $120</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Hair Mask/Relaxing', 'hair-mask')">
                        <img src="{{ asset('images/hair_mask.png') }}" alt="Hair Mask/Relaxing">
                        <h4>Hair Mask/Relaxing</h4>
                        <p>Professional hair mask treatment and relaxing services to restore moisture, shine, and manageability.</p>
                        <p class="price"><strong>Starting at $50</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Smedium Boho Braids', 'boho-braids')">
                        <img src="{{ asset('images/boho braid.jpg') }}" alt="Smedium Boho Braids">
                        <h4>Smedium Boho Braids</h4>
                        <p>Bohemian-inspired braids with a free-spirited, artistic touch. Features unique styling elements and accessories for a trendy, fashion-forward look.</p>
                        <p class="price"><strong>Starting at $150</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Book Other Services Section -->
    <section class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h4 class="mb-3" style="color: #030f68; font-weight: 600;">
                        <i class="bi bi-star me-2"></i>Don't See Your Desired Service?
                    </h4>
                    <p class="lead mb-4" style="color: #6c757d;">
                        We offer many more services beyond what's listed above. Book a consultation and let us know what you need!
                    </p>
                    <button type="button" class="btn btn-outline-primary btn-lg px-5" onclick="openBookingModal('Custom Service Request', 'custom')" style="font-weight: 600; border-radius: 25px; box-shadow: 0 4px 12px rgba(3, 15, 104, 0.2);">
                        <i class="bi bi-plus-circle me-2"></i>Book Other Services
                    </button>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Tell us about your specific needs and we'll take care of you!
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title" id="bookingModalLabel">Book Your Appointment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="clearBookingForm()"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <!-- Pricing Notice -->
                    <div class="alert alert-warning mb-4" style="font-size: 0.95rem; border-left: 4px solid #ff6600;">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-currency-dollar me-3" style="color: #ff6600; font-size: 1.2rem; margin-top: 2px;"></i>
                            <div>
                                <h6 style="color: #030f68; font-weight: 700; margin-bottom: 10px;">
                                    <i class="bi bi-info-circle me-2" style="color: #ff6600;"></i>
                                    Pricing Information
                                </h6>
                                <div style="color: #333; line-height: 1.6;">
                                    <p style="margin-bottom: 15px; font-size: 1rem;">
                                        <strong>💰 Default Pricing:</strong> All service prices shown are for <strong>bra/mid back length</strong>.
                                    </p>

                                    <div style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; margin: 15px 0; border-left: 4px solid #ff6600;">
                                        <p style="margin-bottom: 8px; font-weight: 600; color: #030f68; font-size: 1rem;">
                                            📏 <strong>Length Adjustments:</strong>
                                        </p>
                                        <p style="margin: 0; font-size: 0.95rem;">
                                            • <strong>+$30</strong> for longer length (waist length and beyond)<br>
                                            • <strong>-$30</strong> for shorter length (shoulder length and above)
                                        </p>
                                    </div>


                                    <div style="background: rgba(3, 15, 104, 0.1); padding: 12px; border-radius: 8px; margin-top: 15px;">
                                        <p style="margin: 0; font-size: 0.9rem; color: #030f68;">
                                            💡 <strong>Example:</strong> Small Knotless Braids ($180) + Waist Length (+$30) = <strong>$210 total</strong>
                                        </p>
                                    </div>

                                    <div style="background: rgba(255, 0, 0, 0.1); padding: 12px; border-radius: 8px; margin-top: 15px; border-left: 4px solid #dc3545;">
                                        <p style="margin: 0; font-size: 0.9rem; color: #dc3545;">
                                            ⚠️ <strong>Stitch Braids Special:</strong> +$20 for more than 10 rows. Additional length charges apply based on your hair length.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Single Booking Form -->
                    <form id="bookingForm" action="{{ route('appointments.book') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" id="appointment_date" name="appointment_date">
                        <input type="hidden" id="appointment_time_hidden" name="appointment_time">
                        <input type="hidden" id="selectedService" name="service">

                        <div class="row g-4">
                            <!-- Service Selection -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="serviceSelection" class="form-label">Service *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="serviceDisplay" name="service_display" readonly style="background-color: #f8f9fa;">
                                        <button class="btn btn-outline-secondary" type="button" onclick="openServiceSelectionModal()">
                                            <i class="bi bi-pencil"></i> Change
                                        </button>
                                    </div>
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Selected service. Click "Change" to select a different service or add a custom service.
                                    </small>
                                </div>
                            </div>
                            <!-- Date Selection -->
                            <div class="col-md-6">
                                <label class="form-label">Appointment Date *</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="bookingDate" required autocomplete="off">
                                    <button class="btn btn-outline-secondary" type="button" onclick="openCalendarModal()">
                                        <i class="bi bi-calendar"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-calendar me-1"></i>
                                    Select your preferred date
                                </small>
                            </div>

                            <!-- Time Selection -->
                            <div class="col-md-6">
                                <label class="form-label">Appointment Time *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="timeInput" placeholder="e.g., 2:30 PM, 2:30, or 14:30" required autocomplete="off">
                                    <button class="btn btn-outline-secondary" type="button" onclick="openCalendarModal()">
                                        <i class="bi bi-calendar"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-clock me-1"></i>
                                    Easy input: Type "2:30 PM" or "2:30" - AM/PM is optional
                                </small>
                                <small class="form-text text-muted d-block">
                                    <i class="bi bi-info-circle me-1"></i>
                                    We will contact you if the date or/and time is not available.
                                </small>
                            </div>

                            <!-- Personal Details -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" autocomplete="off">
                                </div>
                            </div>
                            <!-- Address field temporarily hidden until migration is run -->
                            <!--
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="form-label">Home Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" autocomplete="off">
                                </div>
                            </div>
                            -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="samplePicture" class="form-label">Upload Sample Picture (optional)</label>
                                    <input class="form-control" type="file" id="samplePicture" name="sample_picture" accept="image/*" autocomplete="off">
                                    <small class="form-text">Accepted formats: JPG, PNG, JPEG. Max size: 2MB.</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message" class="form-label">Special Requests or Notes</label>
                                    <textarea class="form-control" id="message" name="message" placeholder="Any special requests or additional information..." rows="3" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning" id="bookAppointmentBtn" style="font-size:1.1rem; padding:12px 40px; font-weight:600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);">
                                <i class="bi bi-calendar-check me-2"></i>Book Appointment
                            </button>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    A $20 deposit is required to confirm your appointment
                                    (<a href="#terms" class="text-decoration-none" style="color: #030f68; font-weight: 500;" onclick="closeModalAndGoToTerms(event)">Terms & Conditions</a>)
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white;">
                    <h5 class="modal-title">
                        <i class="bi bi-calendar-event me-2"></i>
                        Select Date & Time
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Calendar Navigation -->
                    <div class="row align-items-center mb-3">
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary" onclick="previousMonth()">
                                <i class="bi bi-chevron-left"></i> Previous
                            </button>
                        </div>
                        <div class="col-md-4 text-center">
                            <h5 id="calendarMonth" class="mb-0"></h5>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-outline-primary" onclick="nextMonth()">
                                Next <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="calendar-grid mb-3">
                        <div class="row">
                            <div class="col text-center fw-bold">Sun</div>
                            <div class="col text-center fw-bold">Mon</div>
                            <div class="col text-center fw-bold">Tue</div>
                            <div class="col text-center fw-bold">Wed</div>
                            <div class="col text-center fw-bold">Thu</div>
                            <div class="col text-center fw-bold">Fri</div>
                            <div class="col text-center fw-bold">Sat</div>
                        </div>
                        <div id="calendarDays" class="row mt-2"></div>
                    </div>

                    <!-- Time Slots -->
                    <div id="timeSlotsContainer" style="display: none;">
                        <h6>Available Time Slots for <span id="selectedDateText"></span></h6>
                        <div id="timeSlots" class="row g-2"></div>
                    </div>

                    <!-- Loading -->
                    <div id="calendarLoading" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading available slots...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="confirmDateTime()" id="confirmDateTimeBtn" disabled>
                        <i class="bi bi-check-circle me-2"></i>CONFIRM SELECTION
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Selection Modal -->
    <div class="modal fade" id="serviceSelectionModal" tabindex="-1" aria-labelledby="serviceSelectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title" id="serviceSelectionModalLabel">
                        <i class="bi bi-scissors me-2"></i>Select Service
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Quick Service Selection -->
                        <div class="col-12">
                            <h6 class="fw-bold mb-3">Popular Services</h6>
                            <div class="row g-2">
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Weaving Crotchet')">
                                       Weaving Crotchet
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Single Crotchet')">
                                        Single Crotchet
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Natural Hair Twist')">
                                        Natural Hair Twist
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Weaving No-Extension')">
                                        Weaving No-Extension
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Kinky Twist')">
                                        Kinky Twist
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('wist Braids')">
                                        Twist Braids
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Service Input -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold mb-3">Custom Service</h6>
                            <div class="form-group">
                                <label for="customServiceInput" class="form-label">Enter your desired service</label>
                                <input type="text" class="form-control" id="customServiceInput" placeholder="e.g., Goddess Braids, Box Braids, Passion Twists, etc." maxlength="255">
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Describe the service you want if it's not listed above
                                </small>
                            </div>
                            <button type="button" class="btn btn-success mt-2" onclick="selectCustomService()">
                                <i class="bi bi-plus-circle me-1"></i>Use Custom Service
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Important Information Section -->
    <div class="section section-xl" style="padding: 80px 0; background-color: #fff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #030f68;">Important Information</h2>
                    </div>
                    <div class="card shadow-lg border-0" style="border-radius: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);">
                        <div class="card-body p-5">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="important-info-content">
                                        <div class="info-item mb-4">
                                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">
                                                <i class="bi bi-shield-check me-2" style="color: #ff6600;"></i>
                                                Health & Safety Standards
                                            </h5>
                                            <p style="color: #333; font-size: 1.1rem; line-height: 1.6;">
                                                We sterilize all combs, brushes and equipment used on clients daily to ensure the highest standards of hygiene and safety.
                                            </p>
                                        </div>

                                        <div class="info-item mb-4">
                                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">
                                                <i class="bi bi-house-heart me-2" style="color: #ff6600;"></i>
                                                Home Service Salon
                                            </h5>
                                            <p style="color: #333; font-size: 1.1rem; line-height: 1.6;">
                                                We are a home service salon that offers a variety of services to cater to your needs. travel fee is not included in the service price. Clientsare responsible for providing transportation to the address where service is required.
                                            </p>
                                        </div>

                                        <div class="info-item mb-4">
                                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">
                                                <i class="bi bi-tools me-2" style="color: #ff6600;"></i>
                                                Professional Equipment
                                            </h5>
                                            <p style="color: #333; font-size: 1.1rem; line-height: 1.6;">
                                                Our stylists use professional-grade equipment including sterilized scissors, brushes, hair dryers, and styling tools to ensure the best results for your hair. </br> We also sell varieties of colored hair braiding extensions.
                                            </p>
                                        </div>

                                        <div class="info-item">
                                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">
                                                <i class="bi bi-exclamation-triangle me-2" style="color: #ff6600;"></i>
                                                Client Preparation Requirement
                                            </h5>
                                            <p style="color: #ff6600; font-size: 1.2rem; font-weight: 600; line-height: 1.6; background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                                <strong>Important:</strong> Hair must come washed and blow dried/detangled for optimal styling results.
                                            </p>
                                        </div>

                                        <div class="info-item mt-4">
                                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">
                                                <i class="bi bi-telephone-fill me-2" style="color: #ff6600;"></i>
                                                For More Information Contact Us
                                            </h5>
                                            <div class="contact-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                                <div class="contact-item" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                                        <i class="bi bi-whatsapp" style="color: #25D366; font-size: 1.2rem; margin-right: 8px;"></i>
                                                        <strong style="color: #030f68;">WhatsApp:</strong>
                                                    </div>
                                                    <a href="https://wa.me/1234567890" style="color: #ff6600; text-decoration: none; font-weight: 600; font-size: 1.1rem;">
                                                        +233 24 123 4567
                                                    </a>
                                                </div>
                                                <div class="contact-item" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600;">
                                                    <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                                        <i class="bi bi-envelope-fill" style="color: #ff6600; font-size: 1.2rem; margin-right: 8px;"></i>
                                                        <strong style="color: #030f68;">Email:</strong>
                                                    </div>
                                                    <a href="mailto:info@dabsbeautytouch.com" style="color: #ff6600; text-decoration: none; font-weight: 600; font-size: 1.1rem;">
                                                        info@dabsbeautytouch.com
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <p style="color: #666; font-size: 1rem; margin: 0; font-style: italic;">
                                                    <i class="bi bi-clock me-1"></i>
                                                    We respond within 24 hours for all inquiries
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="equipment-image-container">
                                        <div class="equipment-image" style="width: 350px; height: 350px; border-radius: 20px; overflow: hidden; margin: 0 auto; border: 3px solid #ff6600; box-shadow: 0 15px 40px rgba(0,0,0,0.15); background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%); display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ asset('images/hair tools.jpg') }}" alt="Professional Hair Styling Tools" style="width: 100%; height: 100%; object-fit: cover; border-radius: 17px;">
                                        </div>
                                        <div class="image-caption mt-3" style="text-align: center;">
                                            <h6 style="color: #030f68; font-weight: 600; margin-bottom: 5px;">Professional Equipment</h6>
                                            <p style="color: #666; font-size: 0.9rem; margin: 0;">Sterilized tools for your safety</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions Section -->
    <section id="terms" class="section section-xl" style="padding: 80px 0; background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #030f68;">Terms & Conditions</h2>
                        <p class="lead" style="color: #666; font-size: 1.2rem;">Please read our terms and conditions carefully before booking your appointment</p>
                    </div>

                    <div class="row g-4">
                        <!-- Deposit & Payment Terms -->
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-credit-card" style="font-size: 3rem; color: #ff6600;"></i>
                                    </div>
                                    <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">Deposit & Payment</h4>
                                    <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                                        <li class="mb-3">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <strong>Deposit Required:</strong> A non-refundable deposit is required to secure your appointment
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <strong>Payment Methods:</strong> We accept cash, bank transfers, and mobile money payments
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <strong>Balance Payment:</strong> Remaining balance is due on the day of your appointment
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                            <strong>No Refunds:</strong> Deposits are non-refundable once appointment is confirmed
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Cancellation Policy -->
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ff6600;"></i>
                                    </div>
                                    <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">Cancellation Policy</h4>
                                    <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                                        <li class="mb-3">
                                            <i class="bi bi-clock-fill text-info me-2"></i>
                                            <strong>Notice Required:</strong> Minimum 48 hours notice required for cancellations
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                            <strong>Late Cancellation:</strong> Cancellations within 48 hours forfeit the deposit
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                            <strong>No Show:</strong> No-shows will result in full charge and may affect future bookings
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-arrow-clockwise text-success me-2"></i>
                                            <strong>Rescheduling:</strong> Rescheduling is allowed with 24 hours notice
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Home Service Terms -->
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-house-heart" style="font-size: 3rem; color: #ff6600;"></i>
                                    </div>
                                    <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">Home Service</h4>
                                    <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                                        <li class="mb-3">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            <strong>No Extra Fee:</strong> Home service does not affect our standard pricing
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-car-front-fill text-info me-2"></i>
                                            <strong>Transportation:</strong> Clients are responsible for providing transportation for the stylist
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                                            <strong>Service Area:</strong> Available within reasonable distance from our base location
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-lg-6">
                            <div class="card h-100 shadow-lg border-0" style="border-radius: 20px; background: linear-gradient(135deg, #030f68 0%, #05137c 100%); color: white;">
                                <div class="card-body p-4">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-telephone-fill" style="font-size: 3rem; color: #ff6600;"></i>
                                    </div>
                                    <h4 style="color: #fff; font-weight: 700; text-align: center; margin-bottom: 20px;">Contact for More Information</h4>
                                    <div class="contact-info" style="font-size: 1rem; line-height: 1.8;">
                                        <div class="mb-3">
                                            <i class="bi bi-telephone-fill text-warning me-2"></i>
                                            <strong>Phone:</strong>
                                            <a href="tel:+1234567890" style="color: #ff6600; text-decoration: none;">(123) 456-7890</a>
                                        </div>
                                        <div class="mb-3">
                                            <i class="bi bi-envelope-fill text-warning me-2"></i>
                                            <strong>Email:</strong>
                                            <a href="mailto:info@dabsbeautytouch.com" style="color: #ff6600; text-decoration: none;">info@dabsbeautytouch.com</a>
                                        </div>
                                        <div class="mb-3">
                                            <i class="bi bi-clock-fill text-warning me-2"></i>
                                            <strong>Response Time:</strong> Within 24 hours
                                        </div>
                                        <div class="mb-3">
                                            <i class="bi bi-chat-dots-fill text-warning me-2"></i>
                                            <strong>Consultation:</strong> Free consultation available
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p style="font-size: 0.9rem; opacity: 0.8;">
                                            For specific questions about services, pricing, or special requests, please contact us directly.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Terms -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card shadow-lg border-0" style="border-radius: 20px; background: #fff;">
                                <div class="card-body p-4">
                                    <h4 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 30px;">
                                        <i class="bi bi-file-text me-2" style="color: #ff6600;"></i>
                                        Additional Terms
                                    </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">
                                                <li class="mb-3">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    <strong>Hair Preparation:</strong> Hair must be washed and detangled before appointment
                                                </li>
                                                <li class="mb-3">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    <strong>Extensions:</strong> Clients may provide their own extensions or purchase from us
                                                </li>
                                                <li class="mb-3">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    <strong>Duration:</strong> Service duration varies based on style complexity
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled" style="font-size: 1rem; line-height: 1.8;">



                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="section section-xl" style="padding: 80px 0; background-color: #f8f9fa;">
        <div class="container">
            <div class="row row-md-80 row-sm-50">
                <div class="col-sm-12 col-lg-4 mb-4">
                    <div class="subtitle" style="font-size: 2rem; color: #ff6600; font-weight: 700; letter-spacing:-1px;">Frequently Asked <br class="br-none">Questions</div>
                </div>
                <div class="col-sm-12 col-lg-8">
                    <ul class="faq-list" style="list-style:none; padding:0; margin:0;">
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you provide services for children below 3 years?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="color:#222; font-size:1.08rem; margin-top:12px;">
                                Yes, at Dab's Beauty Touch, we offer gentle and tailored hair care services for children under 4 years. We are experienced in working with young children. We use age-appropriate, safe, and non-irritating products that are specifically designed for sensitive scalps. If you have any special requests, please feel free to reach out to us. We are here to make the experience enjoyable for both children and parents.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>How many hours is your cancellation notice and any penalty?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="color:#222; font-size:1.08rem; margin-top:12px;">
                                We kindly request a minimum 2-day cancellation notice for all appointments. If you cancel within less than 2 days, a deposit fee will be non-refundable. This helps us accommodate other clients who may need the time slot. We appreciate your understanding and cooperation.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you render home services and do you charge differently for that?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="color:#222; font-size:1.08rem; margin-top:12px;">
                                Yes, we offer home services for your convenience! Please note, we do not charge differently for home service fee, our clients take charge of the transportation to and fro. Clients can book a ride or use any other means.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you also do men's hair?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="color:#222; font-size:1.08rem; margin-top:12px;">
                                Absolutely! We provide a variety of grooming and hairstyling services for men, including braids, twists, and basic grooming. We ensure that each style is tailored to fit your preferences.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>What kind of extensions should I get for my appointment?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="color:#222; font-size:1.08rem; margin-top:12px;">
                                The type of hair extensions depends on the style you're looking for. For braids we recommend Xpression extension/attachment. We recommend human hair extensions for a natural look and durability. For a temporary style or budget-friendly option, synthetic extensions work well. Feel free to consult us before your appointment for personalized recommendations.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you charge the same amount for all ages?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="color:#222; font-size:1.08rem; margin-top:12px;">
                                Our pricing varies depending on the age group and the complexity of the service. For children under 10, we offer discounted rates for selected hairstyles. For adults and teens, standard pricing applies. We believe in providing fair pricing while maintaining the highest quality of service for all our clients, regardless of age.
                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container" style="padding-top: 60px; padding-bottom: 60px;">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10">
                    <div class="card flex-row shadow-lg border-0" style="border-radius: 24px; overflow: hidden; background: #fff;">
                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center" style="border-right:1px solid #e3eafc;">
                            <h2 class="section-title mb-3" style="font-size:2.2rem; font-weight:700;">Contact Information</h2>
                            <ul class="list-unstyled mb-4" style="font-size:1.08rem;">
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-primary me-2"></i><strong>Phone:</strong> <a href="tel:+1234567890" style="color:#030f68; text-decoration:none;">(123) 456-7890</a></li>
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-warning me-2"></i><strong>Email:</strong> <a href="mailto:info@dabsbeautytouch.com" style="color:#ff6600; text-decoration:none;">info@dabsbeautytouch.com</a></li>
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-danger me-2"></i><strong>Address:</strong> 123 Beauty Street, Hair City, HC 12345</li>
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-success me-2"></i><strong>Hours:</strong>
                                    <ul class="ps-4 mb-0" style="font-size:0.98rem;">
                                        <li>Monday - Friday: 9:00 AM - 7:00 PM</li>
                                        <li>Saturday: 8:00 AM - 6:00 PM</li>
                                        <li>Sunday: 10:00 AM - 4:00 PM</li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="social-links mt-3">
                                <a href="#" class="btn btn-outline-primary me-2"><i class="bi bi-facebook me-1"></i>Facebook</a>
                                <a href="#" class="btn btn-outline-info me-2"><i class="bi bi-instagram me-1"></i>Instagram</a>
                                <a href="#" class="btn btn-outline-success"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a>
                            </div>
                        </div>
                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                            <h2 class="section-title mb-4" style="font-size:2rem; font-weight:700;">Send us a Message</h2>
                            <form action="{{ route('contact.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm" style="border-radius:18px;">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="contact_name" name="name" placeholder="Name *" required>
                                            <label for="contact_name">Name *</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="contact_email" name="email" placeholder="Email *" required>
                                            <label for="contact_email">Email *</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="contact_subject" name="subject" placeholder="Subject">
                                            <label for="contact_subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="contact_message" name="message" placeholder="Message *" style="height: 120px" required></textarea>
                                            <label for="contact_message">Message *</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="font-size:1.1rem; font-weight:700; border-radius:8px;">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5>Dab's Beauty Touch</h5>
                    <p>Professional hair braiding services delivering flawless results with every appointment.</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p>&copy; 2024 Dab's Beauty Touch. All rights reserved.</p>
                    <p>Made with ❤️ for beautiful hair</p>
                </div>
            </div>
        </div>
    </footer>



    <!-- JavaScript Files -->
    <script>
        // FAQ collapse logic
        document.addEventListener('DOMContentLoaded', function() {
            console.log('FAQ script loaded');
            const faqQuestions = document.querySelectorAll('.faq-question');
            console.log('Found FAQ questions:', faqQuestions.length);

            faqQuestions.forEach(function(question, index) {
                question.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('FAQ question clicked:', index);

                    const answer = this.parentElement.querySelector('.faq-answer');
                    const arrow = this.querySelector('.faq-arrow');

                    if (!answer || !arrow) {
                        console.error('FAQ elements not found');
                        return;
                    }

                    const isOpen = answer.classList.contains('show');
                    console.log('FAQ is open:', isOpen);

                    // Close all answers first
                    document.querySelectorAll('.faq-answer').forEach(function(a) {
                        a.classList.remove('show');
                    });
                    document.querySelectorAll('.faq-arrow').forEach(function(ar) {
                        ar.classList.remove('rotated');
                    });

                    // Toggle current answer
                    if (!isOpen) {
                        answer.classList.add('show');
                        arrow.classList.add('rotated');
                        console.log('FAQ opened');
                    } else {
                        console.log('FAQ closed');
                    }
                });
            });
        });

        // Clear form when modal is closed
        const bookingModal = document.getElementById('bookingModal');
        if (bookingModal) {
            bookingModal.addEventListener('hidden.bs.modal', function () {
                clearBookingForm();
            });

            // Also clear form when clicking outside modal
            bookingModal.addEventListener('click', function (event) {
                if (event.target === bookingModal) {
                    clearBookingForm();
                }
            });
        }

        // Clear form on page load to ensure it starts fresh
        clearBookingForm();
    });

    // Clear form data when page is about to unload (refresh/close)
    window.addEventListener('beforeunload', function() {
        clearBookingForm();
    });

    // Clear form data when page is unloaded
    window.addEventListener('unload', function() {
        clearBookingForm();
    });

    // Function to handle contact for payment
    function contactForPayment() {
        // Close the deposit modal
        const depositModal = bootstrap.Modal.getInstance(document.getElementById('depositModal'));
        depositModal.hide();

        // Show contact information
        alert('Please contact us at:\n\nPhone: (123) 456-7890\nEmail: info@dabsbeautytouch.com\nWhatsApp: Available\n\nWe will provide you with payment details and confirm your appointment once payment is received.');
    }

    // Function to scroll to services section
    function scrollToServices() {
        const servicesSection = document.getElementById('services');
        if (servicesSection) {
            servicesSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    // Function to close modal and navigate to terms
    function closeModalAndGoToTerms(event) {
        event.preventDefault();

        // Close the booking modal
        const bookingModal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
        if (bookingModal) {
            bookingModal.hide();
        }

        // Wait for modal to close then scroll to terms
        setTimeout(function() {
            const termsSection = document.getElementById('terms');
            if (termsSection) {
                termsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }, 300); // Small delay to ensure modal closes first
    }


</script>
<script src="{{ asset('js/core.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>

<!-- Bootstrap JS (if not included in core.min.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Additional JavaScript -->
<script>
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });



    // Get CSRF token from form or meta tag
    function getCSRFToken() {
        const tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) {
            return tokenInput.value;
        }
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            return metaToken.getAttribute('content');
        }
        // Fallback: try to get from any form with CSRF token
        const anyForm = document.querySelector('form');
        if (anyForm) {
            const formToken = anyForm.querySelector('input[name="_token"]');
            if (formToken) {
                return formToken.value;
            }
        }
        return '';
    }

    // Booking Modal Functions
    function openBookingModal(serviceName, serviceType) {
        // Clear the form first
        clearBookingForm();

        // Set the service in the hidden input and display field
        const selectedServiceInput = document.getElementById('selectedService');
        const serviceDisplayInput = document.getElementById('serviceDisplay');

        if (selectedServiceInput && serviceName) {
            selectedServiceInput.value = serviceName;
            console.log('Service selected:', serviceName);
        }

        if (serviceDisplayInput) {
            serviceDisplayInput.value = serviceName || 'No service selected';
        }

        document.getElementById('bookingModalLabel').textContent = `Book ${serviceName || 'Appointment'}`;

        // Show the modal
        const modalEl = document.getElementById('bookingModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        // Force reflow of selects and date input
        setTimeout(() => {
            modalEl.querySelectorAll('select, input[type="date"]').forEach(el => {
                el.style.display = 'block';
                el.style.visibility = 'visible';
                el.style.opacity = '1';
            });
        }, 300);
    }

    // Function to open service selection modal
    function openServiceSelectionModal() {
        const serviceModal = new bootstrap.Modal(document.getElementById('serviceSelectionModal'));
        serviceModal.show();
    }

    // Function to select a quick service
    function selectQuickService(serviceName) {
        const selectedServiceInput = document.getElementById('selectedService');
        const serviceDisplayInput = document.getElementById('serviceDisplay');

        if (selectedServiceInput) {
            selectedServiceInput.value = serviceName;
        }

        if (serviceDisplayInput) {
            serviceDisplayInput.value = serviceName;
        }

        // Close the service selection modal
        const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
        if (serviceModal) {
            serviceModal.hide();
        }

        // Update booking modal title
        document.getElementById('bookingModalLabel').textContent = `Book ${serviceName}`;

        console.log('Quick service selected:', serviceName);
    }

    // Function to select a custom service
    function selectCustomService() {
        const customInput = document.getElementById('customServiceInput');
        const customService = customInput.value.trim();

        if (!customService) {
            alert('Please enter a service name');
            return;
        }

        const selectedServiceInput = document.getElementById('selectedService');
        const serviceDisplayInput = document.getElementById('serviceDisplay');

        if (selectedServiceInput) {
            selectedServiceInput.value = customService;
        }

        if (serviceDisplayInput) {
            serviceDisplayInput.value = customService;
        }

        // Close the service selection modal
        const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
        if (serviceModal) {
            serviceModal.hide();
        }

        // Update booking modal title
        document.getElementById('bookingModalLabel').textContent = `Book ${customService}`;

        // Clear the custom input
        customInput.value = '';

        console.log('Custom service selected:', customService);
    }

    // Function to clear the booking form
    function clearBookingForm() {
        const form = document.getElementById('bookingForm');
        if (form) {
            // Reset the form
            form.reset();

            // Clear all input elements
            const allInputs = form.querySelectorAll('input, textarea, select');
            allInputs.forEach(input => {
                // Don't clear CSRF token
                if (input.name === '_token') {
                    return;
                }

                // Clear based on input type
                switch(input.type) {
                    case 'file':
                        input.value = '';
                        break;
                    case 'checkbox':
                    case 'radio':
                        input.checked = false;
                        break;
                    default:
                        input.value = '';
                        break;
                }
            });

            // Also clear the service display field
            const serviceDisplayInput = document.getElementById('serviceDisplay');
            if (serviceDisplayInput) {
                serviceDisplayInput.value = 'No service selected';
            }

            // Force browser to clear any cached values
            form.setAttribute('autocomplete', 'off');

            // Trigger change events to ensure any listeners are notified
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.dispatchEvent(new Event('change', { bubbles: true }));
                input.dispatchEvent(new Event('input', { bubbles: true }));
            });
        }
    }

    // Function to parse and validate time input
    function parseTimeInput(timeString) {
        // Remove extra spaces and convert to uppercase
        timeString = timeString.trim().toUpperCase();

        // First, try to auto-format if user typed without colon
        if (timeString.match(/^\d{3,4}\s*(AM|PM)?$/)) {
            // User typed something like "230 PM" or "1430"
            const digits = timeString.replace(/[^\d]/g, '');
            const period = timeString.match(/(AM|PM)/)?.[1] || '';

            if (digits.length === 3) {
                // 3 digits like "230" - assume first digit is hour, last two are minutes
                timeString = digits[0] + ':' + digits.substring(1) + ' ' + period;
            } else if (digits.length === 4) {
                // 4 digits like "1430" - assume first two are hour, last two are minutes
                timeString = digits.substring(0, 2) + ':' + digits.substring(2) + ' ' + period;
            }
        }

        // Regex to match time patterns like "2:30 PM", "14:30", "2:30PM", "2:30", etc.
        const timeRegex = /^(\d{1,2}):(\d{2})\s*(AM|PM)?$/;
        const match = timeString.match(timeRegex);

        if (!match) {
            return null;
        }

        let hour = parseInt(match[1]);
        const minute = parseInt(match[2]);
        const period = match[3] || '';

        // Validate minute
        if (minute < 0 || minute > 59) {
            return null;
        }

        // Handle 12-hour format (with or without AM/PM)
        if (period) {
            // User specified AM/PM
            if (hour < 1 || hour > 12) {
                return null;
            }

            if (period === 'PM' && hour !== 12) {
                hour += 12;
            } else if (period === 'AM' && hour === 12) {
                hour = 0;
            }
        } else {
            // No AM/PM specified - assume 12-hour format and treat as AM
            if (hour < 1 || hour > 12) {
                return null;
            }
            // Keep as is (AM format)
        }

        return {
            hour: hour.toString().padStart(2, '0'),
            minute: minute.toString().padStart(2, '0'),
            time24: hour.toString().padStart(2, '0') + ':' + minute.toString().padStart(2, '0')
        };
    }

    // Function to validate business hours
    function validateBusinessHours(timeString) {
        // If no timeString provided, return false
        if (!timeString) {
            return false;
        }

        const parsed = parseTimeInput(timeString);
        if (!parsed) {
            alert('Please enter a valid time format (e.g., 2:30 PM, 2:30, 14:30). AM/PM is optional.');
            return false;
        }

        const time24 = parsed.time24;

        // Business hours: 9:00 AM to 6:00 PM (excluding 12:00-1:00 PM break)
        const businessStart = '09:00';
        const businessEnd = '18:00';
        const breakStart = '12:00';
        const breakEnd = '13:00';

        if (time24 < businessStart || time24 >= businessEnd) {
            alert('Please select a time between 9:00 AM and 6:00 PM.');
            return false;
        }

        if (time24 >= breakStart && time24 < breakEnd) {
            alert('Please note: We have a lunch break from 12:00 PM to 1:00 PM. Please select a different time.');
            return false;
        }

        return true;
    }

    // Add event listener for time input
    document.addEventListener('DOMContentLoaded', function() {
        const timeInput = document.getElementById('timeInput');
        if (timeInput) {
            // Auto-format time input as user types
            timeInput.addEventListener('input', function(e) {
                let value = this.value.replace(/[^\d]/g, ''); // Remove non-digits

                if (value.length >= 2) {
                    // Add colon after first two digits
                    value = value.substring(0, 2) + ':' + value.substring(2);
                }

                if (value.length >= 5) {
                    // Add space before AM/PM
                    value = value.substring(0, 5) + ' ' + value.substring(5);
                }

                // Limit to reasonable length
                if (value.length > 8) {
                    value = value.substring(0, 8);
                }

                this.value = value;
            });

            // Validate on blur (temporarily disabled for testing)
            /*
            timeInput.addEventListener('blur', function() {
                const timeString = this.value;
                if (timeString && !validateBusinessHours(timeString)) {
                    this.focus();
                }
            });
            */
        }
    });

    // Handle booking form submission
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Form submission started');
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);

        // Basic form validation
        const requiredFields = ['name', 'phone', 'bookingDate', 'timeInput'];
        const missingFields = [];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field || !field.value.trim()) {
                missingFields.push(fieldId);
            }
        });

        if (missingFields.length > 0) {
            alert('Please fill in all required fields: ' + missingFields.join(', '));
            return;
        }

        // Validate and process time input before submission
        const timeInput = document.getElementById('timeInput');
        const timeHidden = document.getElementById('appointment_time_hidden');

        if (timeInput && timeInput.value) {
            if (!validateBusinessHours(timeInput.value)) {
                timeInput.focus();
                return;
            }

            // Parse the time input and set the hidden field
            const parsed = parseTimeInput(timeInput.value);
            if (parsed) {
                timeHidden.value = parsed.time24;
                console.log('Time parsed successfully:', parsed.time24);
            } else {
                alert('Please enter a valid time format (e.g., 2:30 PM, 2:30, 14:30). AM/PM is optional.');
                timeInput.focus();
                return;
            }
        } else {
            alert('Please enter appointment time');
            timeInput.focus();
            return;
        }

        // Set the appointment date
        const bookingDate = document.getElementById('bookingDate');
        const appointmentDate = document.getElementById('appointment_date');
        if (bookingDate.value) {
            appointmentDate.value = bookingDate.value;
            console.log('Date set:', bookingDate.value);
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
        submitBtn.disabled = true;

        // Get form data
        const formData = new FormData(this);

        // Log form data for debugging
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }

        // Log selected service specifically
        const selectedService = document.getElementById('selectedService');
        if (selectedService && selectedService.value) {
            console.log('Selected service for booking:', selectedService.value);
        } else {
            console.log('No specific service selected, will use default');
        }

        // Submit via AJAX
        const csrfToken = getCSRFToken();

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Show success message
                const bookingId = data.appointment ? data.appointment.booking_id : 'N/A';
                const confirmationCode = data.appointment ? data.appointment.confirmation_code : 'N/A';
                const service = data.appointment ? data.appointment.service : 'General Service';
                const emailProvided = data.appointment ? data.appointment.email_provided : false;

                let successMessage = `✅ Appointment booked successfully!\n\n📋 Booking ID: ${bookingId}\n🔢 Confirmation Code: ${confirmationCode}\n💇‍♀️ Service: ${service}\n\n💰 Please contact us to arrange the $20 deposit payment.\n\n📞 Phone: (123) 456-7890\n📧 Email: info@dabsbeautytouch.com`;

                if (!emailProvided) {
                    successMessage += '\n\n📝 Note: No email provided. We will contact you via phone only.';
                }

                successMessage += '\n\nWe\'ll confirm your appointment once payment is received!';

                alert(successMessage);

                // Clear the form completely
                this.reset();

                // Clear any file inputs
                const fileInputs = this.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    input.value = '';
                });

                // Clear any hidden fields except CSRF token
                const hiddenInputs = this.querySelectorAll('input[type="hidden"]:not([name="_token"])');
                hiddenInputs.forEach(input => {
                    input.value = '';
                });

                // Clear textarea
                const textareas = this.querySelectorAll('textarea');
                textareas.forEach(textarea => {
                    textarea.value = '';
                });

                // Close the booking modal
                const bookingModal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                bookingModal.hide();

                // Force browser to clear form cache
                this.setAttribute('autocomplete', 'off');
            } else {
                // Show error message
                let errorMessage = 'Something went wrong. Please try again.';
                if (data.message) {
                    errorMessage = data.message;
                } else if (data.errors) {
                    errorMessage = Object.values(data.errors).flat().join(', ');
                }
                alert('Error: ' + errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'An error occurred. Please try again.';
            if (error.message) {
                errorMessage += ' Error: ' + error.message;
            }
            alert(errorMessage);
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Add click event listener to test button functionality
    document.addEventListener('DOMContentLoaded', function() {
        const bookBtn = document.getElementById('bookAppointmentBtn');
        if (bookBtn) {
            console.log('Book Appointment button found and ready');

            // Add click handler for better user feedback
            bookBtn.addEventListener('click', function(e) {
                console.log('Book Appointment button clicked');

                // Check if form is valid before submission
                const form = document.getElementById('bookingForm');
                if (form) {
                    // Trigger form validation
                    if (form.checkValidity()) {
                        console.log('Form is valid, proceeding with submission');
                        // The form submit event listener will handle the actual submission
                    } else {
                        console.log('Form validation failed');
                        // Show validation messages
                        form.reportValidity();
                    }
                }
            });
        } else {
            console.error('Book Appointment button not found!');
        }

        // Check if form exists
        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            console.log('Booking form found and ready for submission');
        } else {
            console.error('Booking form not found!');
        }
    });

    const contactForm = document.querySelector('form[action*="contact.store"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // You can add client-side validation here if needed
            console.log('Contact form submitted');
        });
    }

    // Calendar Integration Variables
    let calendarCurrentDate = new Date();
    let selectedCalendarDate = null;
    let selectedCalendarTime = null;

    // Calendar Modal Functions
    function openCalendarModal() {
        const calendarModal = new bootstrap.Modal(document.getElementById('calendarModal'));
        calendarModal.show();
        renderCalendarModal();
    }

    function renderCalendarModal() {
        const year = calendarCurrentDate.getFullYear();
        const month = calendarCurrentDate.getMonth();

        document.getElementById('calendarMonth').textContent =
            new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());

        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

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
                dayDiv.onclick = () => selectCalendarDate(date);
            }

            calendarDays.appendChild(dayDiv);
        }
    }

    function selectCalendarDate(date) {
        selectedCalendarDate = date;

        // Update calendar display
        document.querySelectorAll('#calendarModal .calendar-day').forEach(day => {
            day.classList.remove('selected');
        });
        event.target.classList.add('selected');

        // Load time slots for selected date
        loadTimeSlotsForDate(date);
    }

    function loadTimeSlotsForDate(date) {
        const loading = document.getElementById('calendarLoading');
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

        // Generate default time slots (9 AM to 6 PM, excluding 12-1 PM break)
        const defaultSlots = [
            { time: '09:00', available: true, formatted_time: '9:00 AM' },
            { time: '10:00', available: true, formatted_time: '10:00 AM' },
            { time: '11:00', available: true, formatted_time: '11:00 AM' },
            { time: '13:00', available: true, formatted_time: '1:00 PM' },
            { time: '14:00', available: true, formatted_time: '2:00 PM' },
            { time: '15:00', available: true, formatted_time: '3:00 PM' },
            { time: '16:00', available: true, formatted_time: '4:00 PM' },
            { time: '17:00', available: true, formatted_time: '5:00 PM' },
            { time: '18:00', available: true, formatted_time: '6:00 PM' }
        ];

        // Try to fetch from API first, but fallback to default slots
        fetch(`/appointments/slots?date=${date.toISOString().split('T')[0]}`)
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                timeSlotsContainer.style.display = 'block';

                if (data.success && data.slots && data.slots.length > 0) {
                    renderTimeSlotsInModal(data.slots);
                } else {
                    // Use default slots if API fails or returns no slots
                    renderTimeSlotsInModal(defaultSlots);
                }
            })
            .catch(error => {
                console.log('API error, using default slots:', error);
                loading.style.display = 'none';
                timeSlotsContainer.style.display = 'block';
                // Use default slots if API fails
                renderTimeSlotsInModal(defaultSlots);
            });
    }

    function renderTimeSlotsInModal(slots) {
        const timeSlots = document.getElementById('timeSlots');
        timeSlots.innerHTML = '';

        if (slots.length === 0) {
            timeSlots.innerHTML = '<div class="alert alert-info">No available slots for this date</div>';
            return;
        }

        // Add helpful message at the top
        const messageDiv = document.createElement('div');
        messageDiv.className = 'alert alert-info mb-3';
        messageDiv.innerHTML = '<i class="bi bi-info-circle me-2"></i>Click on a time slot below to select it, then click "CONFIRM SELECTION" to book your appointment.';
        timeSlots.appendChild(messageDiv);

        slots.forEach(slot => {
            const slotDiv = document.createElement('div');
            slotDiv.className = `col-md-4 mb-2`;
            slotDiv.innerHTML = `
                <button class="btn btn-outline-primary w-100 time-slot-btn ${slot.available ? 'available' : 'booked'}"
                        ${slot.available ? `onclick="selectCalendarTime('${slot.time}', '${slot.formatted_time}')"` : 'disabled'}>
                    ${slot.formatted_time}
                    <br><small>${slot.available ? 'Available' : 'Booked'}</small>
                </button>
            `;
            timeSlots.appendChild(slotDiv);
        });

        // Reset confirm button state
        document.getElementById('confirmDateTimeBtn').disabled = true;
        selectedCalendarTime = null;
    }

    function selectCalendarTime(time, formattedTime) {
        selectedCalendarTime = { time, formattedTime };

        // Update time slot buttons
        document.querySelectorAll('.time-slot-btn').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        event.target.classList.remove('btn-outline-primary');
        event.target.classList.add('btn-primary');

        // Enable confirm button
        document.getElementById('confirmDateTimeBtn').disabled = false;
    }

    function confirmDateTime() {
        if (selectedCalendarDate && selectedCalendarTime) {
            // Set the values in the booking form
            document.getElementById('bookingDate').value = selectedCalendarDate.toISOString().split('T')[0];
            document.getElementById('appointment_date').value = selectedCalendarDate.toISOString().split('T')[0];
            document.getElementById('appointment_time_hidden').value = selectedCalendarTime.time;

            // Convert 24-hour time to 12-hour format for display
            const timeString = selectedCalendarTime.time;
            const [hour24, minute] = timeString.split(':');
            const hour24Int = parseInt(hour24);

            // Convert to 12-hour format
            let hour12 = hour24Int;
            let period = 'AM';

            if (hour24Int >= 12) {
                period = 'PM';
                if (hour24Int > 12) {
                    hour12 = hour24Int - 12;
                }
            } else if (hour24Int === 0) {
                hour12 = 12;
            }

            // Set the manual time input
            const formattedTime = `${hour12}:${minute} ${period}`;
            document.getElementById('timeInput').value = formattedTime;

            // Close calendar modal
            const calendarModal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
            calendarModal.hide();
        }
    }

    function previousMonth() {
        calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() - 1);
        renderCalendarModal();
    }

    function nextMonth() {
        calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() + 1);
        renderCalendarModal();
    }


</script>

<!-- Deposit Payment Instructions Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #05137c 100%); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title" id="depositModalLabel">Complete Your Booking - Deposit Required</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Booking Submitted Successfully!</strong> Your appointment is pending deposit confirmation.
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <h4 style="color: #030f68; font-weight: 700; margin-bottom: 20px;">
                            <i class="bi bi-credit-card me-2" style="color: #ff6600;"></i>
                            Deposit Payment Instructions
                        </h4>

                        <div class="payment-methods mb-4">
                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">Payment Methods:</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="payment-option" style="border: 2px solid #e3e3e0; border-radius: 10px; padding: 15px; text-align: center; transition: all 0.3s ease;">
                                        <i class="bi bi-phone" style="font-size: 2rem; color: #ff6600; margin-bottom: 10px;"></i>
                                        <h6 style="color: #030f68; font-weight: 600;">Mobile Money</h6>
                                        <p style="font-size: 0.9rem; color: #666; margin: 0;">MTN, Airtel, or Vodafone</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="payment-option" style="border: 2px solid #e3e3e0; border-radius: 10px; padding: 15px; text-align: center; transition: all 0.3s ease;">
                                        <i class="bi bi-bank" style="font-size: 2rem; color: #ff6600; margin-bottom: 10px;"></i>
                                        <h6 style="color: #030f68; font-weight: 600;">Bank Transfer</h6>
                                        <p style="font-size: 0.9rem; color: #666; margin: 0;">Direct bank deposit</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="deposit-amount mb-4">
                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">Deposit Amount:</h5>
                            <div class="amount-display" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); color: white; padding: 20px; border-radius: 15px; text-align: center;">
                                <h3 style="font-weight: 700; margin: 0; font-size: 2rem;">₵50.00</h3>
                                <p style="margin: 5px 0 0 0; opacity: 0.9;">(Standard deposit for all services)</p>
                            </div>
                        </div>

                        <div class="payment-steps mb-4">
                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">Next Steps:</h5>
                            <ol style="font-size: 1rem; line-height: 1.8; color: #333;">
                                <li class="mb-2">Contact us via phone or email for payment details</li>
                                <li class="mb-2">Make the deposit payment using your preferred method</li>
                                <li class="mb-2">Send payment confirmation (screenshot/receipt)</li>
                                <li class="mb-2">We'll confirm your appointment within 24 hours</li>
                            </ol>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="contact-card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%); border-radius: 15px; padding: 25px; border: 2px solid #ff6600;">
                            <h5 style="color: #030f68; font-weight: 700; text-align: center; margin-bottom: 20px;">
                                <i class="bi bi-telephone-fill me-2" style="color: #ff6600;"></i>
                                Contact for Payment
                            </h5>

                            <div class="contact-info" style="font-size: 1rem; line-height: 1.8;">
                                <div class="mb-3">
                                    <i class="bi bi-telephone-fill text-success me-2"></i>
                                    <strong>Phone:</strong><br>
                                    <a href="tel:+1234567890" style="color: #ff6600; text-decoration: none; font-weight: 600;">(123) 456-7890</a>
                                </div>
                                <div class="mb-3">
                                    <i class="bi bi-envelope-fill text-success me-2"></i>
                                    <strong>Email:</strong><br>
                                    <a href="mailto:info@dabsbeautytouch.com" style="color: #ff6600; text-decoration: none; font-weight: 600;">info@dabsbeautytouch.com</a>
                                </div>
                                <div class="mb-3">
                                    <i class="bi bi-whatsapp text-success me-2"></i>
                                    <strong>WhatsApp:</strong><br>
                                    <a href="https://wa.me/1234567890" style="color: #ff6600; text-decoration: none; font-weight: 600;">Send Message</a>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-warning" style="font-weight: 600; padding: 12px 30px;" onclick="contactForPayment()">
                                    <i class="bi bi-telephone me-2"></i>
                                    Contact Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="important-notice mt-4">
                    <div class="alert alert-warning" style="border-left: 4px solid #ff6600;">
                        <i class="bi bi-exclamation-triangle-fill me-2" style="color: #ff6600;"></i>
                        <strong>Important:</strong> Your appointment will only be confirmed after deposit payment is received and verified.
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


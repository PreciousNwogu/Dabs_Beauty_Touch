<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dab's Beauty Touch - Professional Hair Braiding Services</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.ico.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon.ico.jpg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icon.ico.jpg') }}">
    <meta name="msapplication-TileImage" content="{{ asset('images/icon.ico.jpg') }}">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
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
            max-width: 90%;
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

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .hero-content {
                padding: 30px 20px;
                max-width: 95%;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                line-height: 1.1;
            }

            .hero-content p {
                font-size: 1.1rem;
                margin-bottom: 1.5rem;
            }

            .hero-section {
                min-height: 80vh;
                padding: 60px 0 40px;
            }
        }

        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .hero-content {
                padding: 25px 15px;
            }
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

        /* Fix for dropdown issues */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 16px 12px !important;
            cursor: pointer !important;
            pointer-events: auto !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            position: relative !important;
            z-index: 1 !important;
        }

        .form-select:focus {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        .form-select option {
            padding: 8px 12px !important;
            cursor: pointer !important;
            background-color: white !important;
            color: #212529 !important;
        }

        /* About Section Styles */
        .about-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .about-section {
                padding: 60px 0;
            }

            .about-section .card {
                flex-direction: column !important;
                margin: 0 15px;
            }

            .about-section .col-md-7,
            .about-section .col-md-5 {
                width: 100% !important;
                max-width: 100% !important;
                flex: none !important;
            }

            .about-section .col-md-7 {
                padding: 2rem 1.5rem !important;
            }

            .about-section .col-md-5 {
                padding: 1.5rem !important;
            }

            .about-section h2.section-title {
                font-size: 2rem !important;
                text-align: center;
            }

            .about-section .lead {
                font-size: 1.1rem !important;
                text-align: center;
            }

            .about-section img {
                max-width: 280px !important;
                margin: 0 auto;
                display: block;
            }
        }

        @media (max-width: 576px) {
            .about-section h2.section-title {
                font-size: 1.8rem !important;
            }

            .about-section .col-md-7 {
                padding: 1.5rem 1rem !important;
            }

            .about-section img {
                max-width: 250px !important;
            }
        }

        /* Contact Section Styles */
        .contact-section {
            padding: 80px 0;
            background-color: #fff;
        }

        @media (max-width: 768px) {
            .contact-section {
                padding: 60px 0;
            }

            .contact-section .card {
                flex-direction: column !important;
                margin: 0 15px;
            }

            .contact-section .col-md-6 {
                width: 100% !important;
                max-width: 100% !important;
                flex: none !important;
                border-right: none !important;
            }

            .contact-section .col-md-6:first-child {
                border-bottom: 1px solid #e3eafc !important;
            }

            .contact-section .col-md-6 {
                padding: 2rem 1.5rem !important;
            }

            .contact-section h2.section-title {
                font-size: 1.8rem !important;
                text-align: center;
            }

            .contact-section .social-links {
                text-align: center;
                margin-top: 1.5rem;
            }

            .contact-section .social-links .btn {
                margin-bottom: 0.5rem;
                width: auto;
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .contact-section .col-md-6 {
                padding: 1.5rem 1rem !important;
            }

            .contact-section h2.section-title {
                font-size: 1.6rem !important;
            }

            .contact-section .social-links .btn {
                display: block;
                width: 100%;
                margin-bottom: 0.5rem;
                margin-right: 0 !important;
            }
        }

        .services-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        /* Services Section Mobile Styles */
        @media (max-width: 768px) {
            .services-section {
                padding: 60px 0;
            }

            .services-section .container {
                padding: 0 15px;
            }

            .services-section h2 {
                font-size: 2rem;
                text-align: center;
            }

            .services-section .lead {
                font-size: 1.1rem;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .services-section h2 {
                font-size: 1.8rem;
            }
        }

        /* Navigation Mobile Improvements */
        @media (max-width: 991px) {
            .navbar-nav .nav-link {
                padding: 0.8rem 1rem;
                text-align: center;
            }

            .navbar-collapse {
                background: rgba(255, 255, 255, 0.98);
                margin-top: 1rem;
                border-radius: 8px;
                padding: 1rem;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            }
        }

        /* General Mobile Layout Improvements */
        @media (max-width: 768px) {
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .section-title {
                font-size: 1.8rem !important;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .lead {
                font-size: 1.1rem;
                text-align: center;
            }

            /* Card responsive improvements */
            .card {
                border-radius: 16px;
                margin: 0 10px;
            }
        }

        @media (max-width: 576px) {
            .section-title {
                font-size: 1.6rem !important;
            }

            .card {
                margin: 0 5px;
            }
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

        /* Service Card Mobile Improvements */
        @media (max-width: 768px) {
            .service-card {
                margin-bottom: 20px;
                padding: 24px 16px 20px 16px;
            }

            .service-card img {
                width: 180px;
                height: 180px;
            }

            .service-card h4 {
                font-size: 1.3rem;
            }

            .service-card p {
                font-size: 1rem;
                margin-bottom: 6px;
            }
        }

        @media (max-width: 576px) {
            .service-card {
                padding: 20px 14px 18px 14px;
            }

            .service-card img {
                width: 160px;
                height: 160px;
            }

            .service-card h4 {
                font-size: 1.2rem;
            }

            .service-card p {
                font-size: 0.95rem;
            }
        }

        /* Image Slider Mobile Improvements */
        @media (max-width: 768px) {
            .image-slider-section {
                padding: 60px 0 !important;
            }

            .carousel-inner .row {
                flex-direction: column;
            }

            .carousel-inner .col-lg-6 {
                width: 100%;
                max-width: 100%;
            }

            .slide-content {
                padding: 20px !important;
                text-align: center;
            }

            .slide-content h3 {
                font-size: 1.6rem !important;
                margin-bottom: 15px !important;
            }

            .slide-content p {
                font-size: 1rem !important;
                margin-bottom: 20px !important;
            }

            .feature-item {
                justify-content: center;
                margin-bottom: 10px !important;
            }

            .carousel-item img {
                max-height: 300px;
                object-fit: cover;
                border-radius: 12px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .slide-content h3 {
                font-size: 1.4rem !important;
            }

            .slide-content {
                padding: 15px !important;
            }

            .carousel-item img {
                max-height: 250px;
            }
        }

        /* Important Information Section Mobile Styles */
        @media (max-width: 768px) {
            .important-info-content .row {
                flex-direction: column-reverse;
            }

            .important-info-content .col-lg-8,
            .important-info-content .col-lg-4 {
                width: 100%;
                max-width: 100%;
            }

            .equipment-image {
                width: 280px !important;
                height: 280px !important;
                margin-bottom: 2rem;
            }

            .contact-info-grid {
                grid-template-columns: 1fr !important;
                gap: 10px !important;
            }

            .info-item h5 {
                font-size: 1.1rem;
                text-align: center;
                margin-bottom: 10px !important;
            }

            .info-item p {
                font-size: 1rem !important;
                text-align: center;
            }

            .contact-item {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .equipment-image {
                width: 250px !important;
                height: 250px !important;
            }

            .info-item h5 {
                font-size: 1rem;
            }

            .info-item p {
                font-size: 0.9rem !important;
            }

            .contact-item {
                padding: 12px !important;
            }

            .contact-item a {
                font-size: 1rem !important;
            }
        }

        /* Terms and Conditions Mobile Styles */
        @media (max-width: 768px) {
            .terms-section .card {
                margin-bottom: 1.5rem;
            }

            .terms-section h4 {
                font-size: 1.4rem;
            }

            .terms-section .card-body {
                padding: 1.5rem !important;
            }

            .terms-section i {
                font-size: 2.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .terms-section h4 {
                font-size: 1.2rem;
            }

            .terms-section .card-body {
                padding: 1rem !important;
            }

            .terms-section i {
                font-size: 2rem !important;
            }
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

        /* File input styling */
        .booking-form input[type="file"] {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 12px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .booking-form input[type="file"]:hover {
            border-color: #ff6600;
            background-color: #fff5f0;
        }

        .booking-form input[type="file"]:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
            outline: none;
            background-color: #fff;
        }

        /* Image preview styling */
        #imagePreview {
            margin-top: 12px;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        #imagePreview img {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            width: 100%;
            box-sizing: border-box;
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
            opacity: 0.7;
            position: relative;
            pointer-events: none;
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
            pointer-events: none;
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

        /* Calendar grid alignment: use CSS Grid to force 7 equal columns so dates align under weekday headers */
        .calendar-grid {
            /* keep existing spacing but switch to grid layout for consistent columns */
            padding: 18px 0 0 0;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        /* Make the .row wrappers transparent so their .col children become direct grid items */
        .calendar-grid .row {
            display: contents;
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
            padding: 12px 15px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
            text-align: center;
            min-height: 65px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .service-quick-btn .small {
            font-size: 0.75rem;
            margin-top: 4px;
            opacity: 0.8;
            font-weight: 400;
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

    <!-- CRITICAL: INLINE JAVASCRIPT TO ENSURE FUNCTIONS LOAD FIRST -->
    <script>
        console.log('Booking functions loading...');

        // CSRF Token Management
        window.refreshCSRFToken = function() {
            return fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    // Update meta tag
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    // Update form token
                    const tokenInput = document.querySelector('input[name="_token"]');
                    if (tokenInput) {
                        tokenInput.value = data.token;
                    }
                    console.log('CSRF token refreshed');
                    return data.token;
                } else {
                    throw new Error('No token received');
                }
            })
            .catch(error => {
                console.error('Error refreshing CSRF token:', error);
                return null;
            });
        };

        // Auto-refresh CSRF token every 30 minutes
        setInterval(function() {
            window.refreshCSRFToken();
        }, 30 * 60 * 1000); // 30 minutes

        // Clear form function
        window.clearBookingForm = function() {
            var form = document.getElementById('bookingForm');
            if (form) {
                form.reset();
                // Clear all inputs except CSRF token
                var inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(function(input) {
                    if (input.name !== '_token') {
                        input.value = '';
                    }
                });
                console.log('Booking form cleared');
            }
        };

        // Main booking modal function
        window.openBookingModal = function(serviceName, serviceType) {
            console.log('Opening booking modal for:', serviceName);

            // Clear form first
            if (window.clearBookingForm) {
                window.clearBookingForm();
            }

            // Wait for DOM to be ready if called early
            function showModal() {
                var modal = document.getElementById('bookingModal');
                if (!modal) {
                    console.error('Booking modal not found');
                    return;
                }

                // Set service information
                var serviceInput = document.getElementById('selectedService');
                if (serviceInput) {
                    serviceInput.value = serviceName;
                }

                var serviceDisplay = document.getElementById('serviceDisplay');
                if (serviceDisplay) {
                    serviceDisplay.value = serviceName;
                }

                var modalTitle = document.getElementById('bookingModalLabel');
                if (modalTitle) {
                    modalTitle.textContent = 'Book ' + serviceName;
                }

                // Show modal using Bootstrap if available, otherwise fallback
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    try {
                        var modalInstance = new bootstrap.Modal(modal);
                        modalInstance.show();
                        console.log('Modal shown with Bootstrap');
                    } catch (error) {
                        console.error('Bootstrap modal error:', error);
                        showModalFallback();
                    }
                } else {
                    showModalFallback();
                }

                function showModalFallback() {
                    modal.style.display = 'block';
                    modal.classList.add('show');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('modal-open');
                    console.log('Modal shown with fallback');
                }
            }

            // If DOM is ready, show immediately, otherwise wait
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', showModal);
            } else {
                showModal();
            }
        };

        // Calendar Integration Variables
        let calendarCurrentDate = new Date();
        let selectedCalendarDate = null;
        let selectedCalendarTime = null;
    let bookedDatesCache = []; // Cache for booked dates
    let blockedDatesCache = []; // Cache for admin blocked dates (objects {date,title,slot_id})

        // Hardcoded test dates for August 2025 (for immediate testing)
        const testBookedDates = [
            '2025-08-18', '2025-08-24', '2025-08-25', '2025-08-26',
            '2025-08-28', '2025-08-29', '2025-08-30', '2025-08-31'
        ];

        console.log('Test booked dates loaded:', testBookedDates);

        // Calendar Modal Functions
        window.openCalendarModal = function() {
            console.log('🚀 openCalendarModal() called');
                // Ensure the calendar modal is a child of <body> so it can overlay other modals
                const modalEl = document.getElementById('calendarModal');
                if(modalEl && modalEl.parentNode !== document.body){
                    try{ document.body.appendChild(modalEl); }catch(e){ /* noop */ }
                }

                // Use a high z-index so calendar appears above other modals/backdrops
                const forcedZ = 2050; // Bootstrap default modal z-index is 1050; pick higher to be safe
                if(modalEl){
                    modalEl.style.zIndex = forcedZ;
                    // Ensure dialog inside modal also accepts pointer events
                    const dialog = modalEl.querySelector('.modal-dialog'); if(dialog) dialog.style.pointerEvents = 'auto';
                }

                const calendarModal = new bootstrap.Modal(modalEl);
                calendarModal.show();

                // Set calendar to current month
                calendarCurrentDate = new Date(); // Current date

                // Always fetch fresh data when calendar opens
                console.log('🔄 Fetching fresh booked dates...');
                fetchRealBookedDates();

                // After modal is shown, adjust backdrop z-index so it's behind the calendar but above other content
                setTimeout(() => {
                    try{
                        // Find the most recent backdrop inserted by Bootstrap for this modal
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        if(backdrops && backdrops.length){
                            const lastBackdrop = backdrops[backdrops.length - 1];
                            // Place backdrop slightly below modal z-index so clicks reach modal
                            lastBackdrop.style.zIndex = (forcedZ - 5).toString();
                            lastBackdrop.style.pointerEvents = 'auto';
                        }

                        // ensure modal element keeps highest z
                        if(modalEl) modalEl.style.zIndex = forcedZ;
                    }catch(e){ console.warn('Failed to adjust calendar modal/backdrop z-index', e); }
                }, 50);

                // Render calendar with loading state first
                setTimeout(() => {
                    console.log('🎨 Starting renderCalendarModal()');
                    renderCalendarModal();
                }, 100);
        };

        // Fetch real booked dates from API
        function fetchRealBookedDates() {
            const year = calendarCurrentDate.getFullYear();
            const month = calendarCurrentDate.getMonth() + 1;

            const bookedPromise = fetch('/api/booked-dates').then(r => r.json()).catch(e => { console.error('Booked-dates fetch failed', e); return null; });
            const blockedPromise = fetch(`/schedules/blocked-dates?year=${year}&month=${month}`).then(r => r.json()).catch(e => { console.error('Blocked-dates fetch failed', e); return null; });

            Promise.all([bookedPromise, blockedPromise]).then(([bookedResp, blockedResp]) => {
                if (bookedResp && bookedResp.success) {
                    const realBookedDates = bookedResp.booked_dates.filter(booking => booking.disabled).map(booking => booking.date);
                    bookedDatesCache = realBookedDates;
                    console.log('Real booked dates from API:', realBookedDates);
                }

                if (blockedResp && blockedResp.success) {
                    blockedDatesCache = blockedResp.blocked_dates || [];
                    console.log('Blocked dates from API:', blockedDatesCache);
                }

                // Re-render calendar with combined data
                renderCalendarModal();
            }).catch(error => {
                console.error('Error loading real calendar data:', error);
            });
        }

        // Fetch and render a simple public list of upcoming blocked ranges
        function fetchBlockedList() {
            fetch('/schedules/blocked-list')
                .then(r => r.json())
                .then(resp => {
                    const container = document.getElementById('publicBlockedList');
                    if (!container) return;
                    container.innerHTML = '';

                    if (resp && resp.success && resp.blocked && resp.blocked.length) {
                        const list = document.createElement('ul');
                        list.className = 'list-unstyled mb-0';

                        resp.blocked.forEach(b => {
                            const li = document.createElement('li');
                            li.className = 'mb-1';
                            const title = document.createElement('strong');
                            title.textContent = b.title || 'Blocked';
                            const span = document.createElement('span');
                            span.className = 'ms-2 text-muted';
                            // If end equals start, show single day
                            let text;
                            if (b.start === b.end) {
                                text = b.start;
                            } else {
                                text = b.start + ' — ' + b.end;
                            }
                            span.textContent = text;
                            li.appendChild(title);
                            li.appendChild(span);
                            list.appendChild(li);
                        });

                        container.appendChild(list);
                    } else {
                        container.innerHTML = '<div class="alert alert-success mb-0">No upcoming closures or blocked dates.</div>';
                    }
                }).catch(e => {
                    console.error('Failed to fetch blocked list', e);
                    const container = document.getElementById('publicBlockedList');
                    if (container) container.innerHTML = '<div class="text-muted">Unable to load closures.</div>';
                });
        }

        // Run on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fetchBlockedList);
        } else {
            fetchBlockedList();
        }

        function renderCalendarModal() {
            console.log('🎨 renderCalendarModal() started');
            console.log('📊 Current bookedDatesCache:', bookedDatesCache);
            console.log('📅 Current calendarCurrentDate:', calendarCurrentDate);

            const year = calendarCurrentDate.getFullYear();
            const month = calendarCurrentDate.getMonth();
            console.log(`📅 Rendering calendar for: ${year}-${month + 1} (${year} ${new Date(year, month).toLocaleDateString('en-US', { month: 'long' })})`);

            document.getElementById('calendarMonth').textContent =
                new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            // Render calendar days
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);
                const dateString = date.toISOString().split('T')[0];

                const dayDiv = document.createElement('div');
                dayDiv.className = 'col calendar-day';
                dayDiv.textContent = date.getDate();

                // Debug logging for first few dates
                if (i < 10) {
                    console.log(`Checking date: ${dateString}, in bookedDatesCache: ${bookedDatesCache.includes(dateString)}, bookedDatesCache:`, bookedDatesCache);
                }

                if (date.getMonth() !== month) {
                    dayDiv.classList.add('other-month');
                } else if (date < new Date().setHours(0, 0, 0, 0)) {
                    dayDiv.classList.add('past');
                } else {
                    // Determine blocked or booked or available
                    // Check blocked first
                    const blockedIndex = (blockedDatesCache || []).reduce((acc, b) => { acc[b.date] = b; return acc; }, {});

                    if (bookedDatesCache.includes(dateString)) {
                        // Date is fully booked - FORCE RED STYLING
                        dayDiv.classList.add('booked');
                        dayDiv.title = 'This date is fully booked - pending or confirmed appointment exists';

                        // Force inline styles to override any other styling
                        dayDiv.style.backgroundColor = '#ff0000 !important';
                        dayDiv.style.borderColor = '#cc0000 !important';
                        dayDiv.style.color = '#ffffff !important';
                        dayDiv.style.cursor = 'not-allowed';
                        dayDiv.style.opacity = '1';
                        dayDiv.style.position = 'relative';
                        dayDiv.style.pointerEvents = 'none';

                        dayDiv.innerHTML = date.getDate() + '<span style="position:absolute;top:2px;right:4px;color:#ffffff;font-weight:bold;font-size:12px;">×</span>';
                        console.log(`🔴 FORCED RED STYLING for date ${dateString}`);
                        // Don't add click event for booked dates

                    } else if (blockedIndex[dateString]) {
                        // Blocked day: show dark styling and small title text
                        dayDiv.classList.add('blocked-range');
                        dayDiv.title = blockedIndex[dateString].title || 'Blocked';
                        const textDiv = document.createElement('div');
                        textDiv.className = 'blocked-text';
                        textDiv.textContent = blockedIndex[dateString].title || 'Blocked';
                        dayDiv.appendChild(textDiv);
                        console.log(`⛔ Marked ${dateString} as BLOCKED (${blockedIndex[dateString].title})`);

                    } else {
                        dayDiv.classList.add('available');
                        dayDiv.style.backgroundColor = '#d4edda';
                        dayDiv.style.borderColor = '#c3e6cb';
                        dayDiv.onclick = () => selectCalendarDate(date);
                        console.log(`🟢 Date ${dateString} marked as AVAILABLE (green)`);
                    }
                }

                calendarDays.appendChild(dayDiv);
            }
        }

        function selectCalendarDate(date) {
            // Check if the clicked day is booked
            if (event.target.classList.contains('booked')) {
                alert('This date is already booked with a pending or confirmed appointment. Please select another date.');
                return;
            }

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
            fetch(`/bookings/slots?date=${date.toISOString().split('T')[0]}`)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    timeSlotsContainer.style.display = 'block';

                    if (data.success) {
                        if (data.message) {
                            // Date is booked, show message
                            timeSlots.innerHTML = `<div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>${data.message}</div>`;
                            document.getElementById('confirmDateTimeBtn').disabled = true;
                        } else if (data.slots && data.slots.length > 0) {
                            renderTimeSlotsInModal(data.slots);
                        } else {
                            // Use default slots if no slots returned
                            renderTimeSlotsInModal(defaultSlots);
                        }
                    } else {
                        // Use default slots if API returns error
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

        window.selectCalendarTime = function(time, formattedTime) {
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
        };

        window.confirmDateTime = function() {
            if (selectedCalendarDate && selectedCalendarTime) {
                // Format date for display (readable format)
                const formattedDate = selectedCalendarDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                // Set the values in the main booking form if present
                try{
                    const bd = document.getElementById('bookingDate'); if(bd) bd.value = formattedDate;
                    const apptDate = document.getElementById('appointment_date'); if(apptDate) apptDate.value = selectedCalendarDate.toISOString().split('T')[0];
                    const apptTimeHidden = document.getElementById('appointment_time_hidden'); if(apptTimeHidden) apptTimeHidden.value = selectedCalendarTime.time;
                    const timeInput = document.getElementById('timeInput'); if(timeInput) timeInput.value = selectedCalendarTime.formattedTime;
                }catch(e){ console.warn('Failed to populate main booking inputs', e); }

                // Also populate kids booking inputs if the kids modal is present
                try{
                    const kbd = document.getElementById('kidsBookingDate'); if(kbd) kbd.value = formattedDate;
                    const kbt = document.getElementById('kidsBookingTime'); if(kbt) kbt.value = selectedCalendarTime.formattedTime;
                    // hidden inputs inside kids booking form (by name)
                    const kidsForm = document.getElementById('kidsBookingForm');
                    if(kidsForm){
                        const hiddenDate = kidsForm.querySelector('input[name="appointment_date"]'); if(hiddenDate) hiddenDate.value = selectedCalendarDate.toISOString().split('T')[0];
                        const hiddenTime = kidsForm.querySelector('input[name="appointment_time"]'); if(hiddenTime) hiddenTime.value = selectedCalendarTime.time;
                    }

                    // Ensure selector-derived hidden fields are populated in the kids booking form
                    try{
                        const kidsForm2 = document.getElementById('kidsBookingForm');
                        if(kidsForm2){
                            // Prefer global selector payload if available
                            const sel = window.__kidsSelectorData || {};
                            const btInput = document.getElementById('kids_braid_type_input');
                            const finInput = document.getElementById('kids_finish_input');
                            const lenInput = document.getElementById('kids_length_input');
                            const exInput = document.getElementById('kids_extras_input');
                            const priceInput = document.getElementById('kids_price_input');

                            if(sel && (sel.kb_braid_type || sel.braid_type)) btInput.value = sel.kb_braid_type || sel.braid_type;
                            if(sel && (sel.kb_finish || sel.finish)) finInput.value = sel.kb_finish || sel.finish;
                            if(sel && (sel.kb_length || sel.length)) lenInput.value = (sel.kb_length || sel.length).replace(/-/g,'_');
                            // fallback to mirrors if sel not present
                            try{
                                const mirrorLen = document.getElementById('kb_length_hidden'); if(!lenInput.value && mirrorLen && mirrorLen.value) lenInput.value = mirrorLen.value;
                                const mirrorFin = document.getElementById('kb_finish_hidden'); if(!finInput.value && mirrorFin && mirrorFin.value) finInput.value = mirrorFin.value;
                                const mirrorExtras = document.getElementById('kb_extras_input'); if(!exInput.value && mirrorExtras && mirrorExtras.value) exInput.value = mirrorExtras.value;
                                const mirrorPrice = document.getElementById('kb_price_input'); if(!priceInput.value && mirrorPrice && mirrorPrice.value) priceInput.value = mirrorPrice.value;
                            }catch(e){}
                        }
                    }catch(e){ console.warn('populate kids hidden selector fields failed', e); }

                    // Update visible labels in kids modal (if present)
                    try{
                        const dateLabel = document.getElementById('kidsSelectedDateLabel'); if(dateLabel) dateLabel.textContent = formattedDate;
                        const timeLabel = document.getElementById('kidsSelectedTimeLabel'); if(timeLabel) timeLabel.textContent = selectedCalendarTime.formattedTime;
                    }catch(e){ /* noop */ }
                }catch(e){ console.warn('Failed to populate kids booking inputs', e); }

                // Close calendar modal
                try{
                    const calendarModal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
                    if(calendarModal) calendarModal.hide();
                }catch(e){ console.warn('Failed to hide calendar modal', e); }

                // After closing calendar, ensure the booking modal (kids or main) regains focus
                setTimeout(function(){
                    try{
                        const kidsModalEl = document.getElementById('kidsBookingModal');
                        if(kidsModalEl && kidsModalEl.classList.contains('show')){
                            const nameField = document.getElementById('kids_name'); if(nameField) nameField.focus();
                        } else {
                            const bookingModalEl = document.getElementById('bookingModal');
                            if(bookingModalEl && bookingModalEl.classList.contains('show')){
                                const nameField = document.getElementById('name'); if(nameField) nameField.focus();
                            }
                        }
                    }catch(e){ /* noop */ }
                }, 150);
            }
        };

        window.previousMonth = function() {
            calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() - 1);
            renderCalendarModal();
        };

        window.nextMonth = function() {
            calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() + 1);
            renderCalendarModal();
        };

        console.log('Booking and calendar functions loaded successfully');
    </script>
</head>
<body>


    @if(session('booking_error'))
    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert" style="border-radius: 0; border: none; background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%); color: white; box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3); z-index: 1050; position: relative;">
        <div class="container text-center py-3">
            <h4 class="alert-heading mb-2">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Booking Error
            </h4>
            <p class="mb-2">{{ session('error_message', 'There was an issue processing your booking.') }}</p>
            <p class="mb-0">
                <i class="bi bi-telephone-fill me-2"></i>
                Please try again or call us at <strong>(647) 834-8549</strong>
            </p>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close" style="position: absolute; top: 15px; right: 15px;"></button>
        </div>
    </div>
    @endif

    @include('partials.site-header')

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

            {{-- Prices are stored in config/service_prices.php --}}
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.small_knotless', 170),0) }}</p>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.smedium_knotless', 150),0) }}</p>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.wig_installation', 150),0) }}</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Wig Installation', 'wig-installation')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/wig installation.jpg') }}" alt="Wig Installation" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px #00000026;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Medium Knotless Braids -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Medium Knotless Braids</h3>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.medium_knotless', 130),0) }}</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="openBookingModal('Medium Knotless Braids', 'medium-knotless')" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Now
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/large braid.jpg') }}" alt="Medium Knotless Braids" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.jumbo_knotless', 100),0) }}</p>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.kids_braids', 80),0) }}</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="window.location='{{ route('kids.selector') }}'" style="font-weight: 600; padding: 12px 30px;">
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
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">8 Rows Stitch Braids</h3>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.stitch_braids', 120),0) }}</p>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.hair_mask', 50),0) }}</p>
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
                                        <p class="price" style="margin: 0; color: #030f68; font-weight: 700; font-size: 1.2rem;">Starting at ${{ number_format(config('service_prices.boho_braids', 150),0) }}</p>
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
                                    <button class="btn btn-warning mt-3" onclick="openOtherServicesModal()" style="font-weight: 600; padding: 12px 30px;">
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

    <!-- Terms and Conditions Section -->
    <section id="terms" class="section section-xl" style="padding: 80px 0; background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #030f68;">Terms & Conditions</h2>
                        <div style="display:inline-block; max-width:820px; margin-top:18px; text-align:left;">
                            <div style="background: linear-gradient(90deg, rgba(255,102,0,0.06), rgba(3,15,104,0.03)); border-left: 6px solid #ff6600; padding: 18px 20px; border-radius: 12px; box-shadow: 0 6px 18px rgba(3,15,104,0.06);">
                                <div style="display:flex; align-items:flex-start; gap:12px;">
                                    <div style="font-size:1.6rem; color:#ff6600; line-height:1; margin-top:2px;"><i class="bi bi-exclamation-triangle-fill"></i></div>
                                    <div>
                                        <div style="font-size:1.05rem; color:#03253f; font-weight:700; margin-bottom:6px;">Before booking, please review our terms and conditions</div>                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Important Hair Preparation Notice -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div style="background: linear-gradient(135deg, rgba(255, 193, 7, 0.15), rgba(255, 152, 0, 0.1)); border-left: 6px solid #ff6600; border-top: 2px solid rgba(255, 102, 0, 0.3); padding: 20px 24px; border-radius: 12px; box-shadow: 0 4px 12px rgba(255, 102, 0, 0.1);">
                                <p style="margin: 0; color: #ff6600; font-size: 1.1rem; line-height: 1.6;">
                                    <strong style="font-weight: 700;">Important:</strong> Hair must come washed and blow dried/detangled for optimal styling results.
                                </p>
                            </div>
                        </div>
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
                                            <a href="tel:+13432458848" style="color: #ff6600; text-decoration: none;">(+1)343-245-8848</a>
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
                <h2 class="section-title" style="font-weight: 700;">Our Services</h2>
                <p class="lead">Professional hair braiding and styling services</p>
            </div>
                        <!-- length guide removed from services section (moved into booking form) -->

                        <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Small Knotless Braids', 'small-knotless')">
                        <img src="{{ asset('images/small braid.jpg') }}" alt="Small Knotless Braids">
                        <h4>Small Knotless Braids</h4>
                        <p>Ultra-fine knotless braids that blend seamlessly with your natural hair. Perfect for a sleek, professional look with minimal tension and maximum comfort.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.small_knotless', 170),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Smedium Knotless Braids', 'smedium-knotless')">
                        <img src="{{ asset('images/webbraids2.jpg') }}" alt="Smedium Knotless Braids">
                        <h4>Smedium Knotless Braids</h4>
                        <p>Perfect balance between small and medium braids for a versatile, everyday style. Offers excellent durability while maintaining a natural, lightweight feel.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.smedium_knotless', 150),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Wig Installation', 'wig-installation')">
                        <img src="{{ asset('images/wig installation.jpg') }}" alt="Smedium Knotless Braids">
                        <h4>Wig Installation</h4>
                        <p>Professional wig installation with custom fitting and styling. Sleek natural hairline blending, and personalized styling to match your desired look.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.wig_installation', 150),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Medium Knotless Braids', 'medium-knotless')">
                        <img src="{{ asset('images/large braid.jpg') }}" alt="Medium Knotless Braids">
                        <h4>Medium Knotless Braids</h4>
                        <p>Bold, statement-making braids that create a dramatic, eye-catching look. Perfect for those who want to make a strong fashion statement with their hair.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.medium_knotless', 130),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Jumbo Knotless Braids', 'jumbo-knotless')">
                        <img src="{{ asset('images/jumbo braid.jpg') }}" alt="Jumbo Knotless Braids">
                        <h4>Jumbo Knotless Braids</h4>
                        <p>Extra large, voluminous braids for maximum impact and style. Creates a bold, confident look that's perfect for special occasions and fashion-forward individuals.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.jumbo_knotless', 100),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="window.location='{{ route('kids.selector') }}'">
                        <img src="{{ asset('images/kids hair style.webp') }}" alt="Kids Braids">
                        <h4>Kids Braids(3-8yrs)</h4>
                        <p>Specialized braiding services for children with gentle, age-appropriate techniques. Creates adorable, manageable styles that are comfortable and long-lasting for active kids.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.kids_braids', 80),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('8 Rows Stitch Braids', 'stitch-braids')">
                        <img src="{{ asset('images/stitch braid.jpg') }}" alt="8 Rows Stitch Braids">
                        <h4>8 Rows Stitch Braids</h4>
                        <p>Unique stitch pattern braids that create a distinctive, textured look. Features a special weaving technique that adds dimension and style to your braided hairstyle.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.stitch_braids', 120),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Hair Mask/Relaxing', 'hair-mask')">
                        <img src="{{ asset('images/hair_mask.png') }}" alt="Hair Mask/Relaxing">
                        <h4>Hair Mask/Relaxing</h4>
                        <p>Professional hair mask treatment and relaxing services to restore moisture, shine, and manageability.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.hair_mask', 50),0) }}</strong></p>
                        <button class="btn btn-warning mt-3">Book Now</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100" onclick="openBookingModal('Smedium Boho Braids', 'boho-braids')">
                        <img src="{{ asset('images/boho braid.jpg') }}" alt="Smedium Boho Braids">
                        <h4>Smedium Boho Braids</h4>
                        <p>Bohemian-inspired braids with a free-spirited, artistic touch. Features unique styling elements and accessories for a trendy, fashion-forward look.</p>
                        <p class="price"><strong>Starting at ${{ number_format(config('service_prices.boho_braids', 150),0) }}</strong></p>
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
                    <button type="button" class="btn btn-outline-primary btn-lg px-5" onclick="openOtherServicesModal()" style="font-weight: 600; border-radius: 25px; box-shadow: 0 4px 12px rgba(3, 15, 104, 0.2);">
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
    <!-- Success Modal -->
    @if(session('booking_success'))
    <div class="modal fade show d-block" id="successModal" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header text-center border-0 pb-0" style="display: flex; flex-direction: column; align-items: center;">
                    <div style="background: #28a745; border-radius: 8px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        <span style="font-size: 2.5rem; color: #fff;">&#10004;</span>
                    </div>
                    <h4 class="modal-title text-success mb-0" style="font-weight: bold; color: #218838; margin-top: 8px;">Appointment Booked<br>Successfully!</h4>
                </div>
                <div class="modal-body text-center px-4">
                    <div class="row mb-3 justify-content-center" style="gap: 0.5rem;">
                        <!-- Booking ID and confirmation code intentionally omitted from UI; available in confirmation email only -->
                        <div class="col-12 text-center mt-2">
                            <p class="mb-0" style="color: #6c757d;">Your booking was received — our admin will contact you to arrange the deposit and confirm details. For urgent enqueries, email <a href="mailto:info@dabsbeautytouch.com">info@dabsbeautytouch.com</a>.</p>
                        </div>
                    </div>
                    <div class="alert alert-warning border-0 mb-3" style="background-color: #fff3cd; border-radius: 8px;">
                        <div class="d-flex align-items-center justify-content-center">
                            <span style="font-size: 1.3rem; margin-right: 8px;">&#9888;</span>
                            <span style="font-size: 1.1rem;">Please contact us to arrange the $20 deposit payment.</span>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center" style="gap: 0.5rem;">
                        <div class="col-auto text-start">
                            <span style="font-size: 1.2rem; margin-right: 4px;">&#128222;</span>
                            <span style="font-weight: bold; color: #001f3f;">Phone:</span>
                            <a href="tel:+13432458848" style="color: #007bff; text-decoration: underline;">(+1)343-245-8848</a>
                        </div>
                        <div class="col-auto text-start">
                            <span style="font-size: 1.2rem; margin-right: 4px;">&#128231;</span>
                            <span style="font-weight: bold; color: #001f3f;">Email:</span>
                            <a href="mailto:info@dabsbeautytouch.com" style="color: #007bff; text-decoration: underline;">info@dabsbeautytouch.com</a>
                        </div>
                    </div>
                    <p class="text-muted mb-3" style="font-size: 1rem;">We'll confirm your appointment once payment is received!</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-info px-4 py-2" onclick="closeSuccessModal()" style="background: linear-gradient(90deg, #17a2b8 0%, #20c997 100%); border: none; color: #fff; font-weight: bold; border-radius: 24px; width: 120px;">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Other Services Success Modal -->
    @if(session('success'))
    <div class="modal fade show d-block" id="otherServicesSuccessModal" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header text-center border-0 pb-0" style="display: flex; flex-direction: column; align-items: center;">
                    <div style="background: #28a745; border-radius: 8px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                        <span style="font-size: 2.5rem; color: #fff;">&#10004;</span>
                    </div>
                    <h4 class="modal-title text-success mb-0" style="font-weight: bold; color: #218838; margin-top: 8px;">Service Request Sent<br>Successfully!</h4>
                </div>
                <div class="modal-body text-center px-4">
                    <div class="row mb-3 justify-content-center">
                        <div class="col-12 text-center mt-2">
                            <p class="mb-3" style="color: #6c757d; font-size: 1.1rem;">{{ session('success') }}</p>
                            <div class="alert alert-info border-0 mb-3" style="background-color: #e3f2fd; border-radius: 8px;">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span style="font-size: 1.3rem; margin-right: 8px;">ℹ️</span>
                                    <span style="font-size: 1rem; color: #1976d2;">We'll review your request and contact you within 24 hours to discuss details and pricing.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center" style="gap: 0.5rem;">
                        <div class="col-auto text-start">
                            <span style="font-size: 1.2rem; margin-right: 4px;">📞</span>
                            <span style="font-weight: bold; color: #001f3f;">Phone:</span>
                            <a href="tel:+13432458848" style="color: #007bff; text-decoration: underline;">(+1)343-245-8848</a>
                        </div>
                        <div class="col-auto text-start">
                            <span style="font-size: 1.2rem; margin-right: 4px;">📧</span>
                            <span style="font-weight: bold; color: #001f3f;">Email:</span>
                            <a href="mailto:info@dabsbeautytouch.com" style="color: #007bff; text-decoration: underline;">info@dabsbeautytouch.com</a>
                        </div>
                    </div>
                    <p class="text-muted mb-3" style="font-size: 1rem;">Need urgent assistance? Feel free to contact us directly!</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-success px-4 py-2" onclick="closeOtherServicesSuccessModal()" style="background: linear-gradient(90deg, #28a745 0%, #20c997 100%); border: none; color: #fff; font-weight: bold; border-radius: 24px; width: 120px;">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif

                    <!-- Booking Modal (contains Single Booking Form) -->
                    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 12px;">
                                <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white; border-radius: 12px 12px 0 0;">
                                    <h5 class="modal-title" id="bookingModalLabel">Book Service</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                    <!-- Single Booking Form -->
                    <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST" autocomplete="on" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="appointment_date" name="appointment_date">
                        <input type="hidden" id="appointment_time_hidden" name="appointment_time">
                        <input type="hidden" id="selectedService" name="service">
                        <input type="hidden" id="selectedServiceType" name="service_type">
                        <input type="hidden" id="selectedPrice" name="price">
                        <input type="hidden" id="selectedHairMaskOption" name="hair_mask_option" value="mask-only">

                        <!-- Pricing Information (detailed boxes like screenshot) -->
                            <div id="bookingDetailedInfo" class="mb-3">
                                <div style="background:#fff7e0;border-radius:12px;padding:18px;border-left:6px solid #ff6600;">
                                <h5 style="color:#0b3a66;font-weight:700;margin-bottom:8px;">Pricing Information</h5>
                                <p style="margin:0 0 12px 0;color:#0b3a66;font-weight:600;">💰 <span style="font-weight:700;">Default Pricing:</span> All service prices shown are for <strong>mid-back length</strong>.</p>

                                <div style="background:#ffeacc;border-radius:10px;padding:12px;border:1px solid rgba(0,0,0,0.03);margin-bottom:12px;">
                                    <h6 style="margin:0 0 8px 0;color:#0b3a66;font-weight:700;">📏 Length Adjustments:</h6>
                                    <ul style="margin:0;padding-left:18px;color:#0b3a66;">
                                        <li><strong>+ $20</strong> for longer length (waist length and beyond)</li>
                                        <li><strong>- $20</strong> for shorter length (shoulder length and above)</li>
                                    </ul>
                                </div>

                                <!-- Kids booking summary (shown only for kids-braids) -->
                                <div id="kidsBookingSummary" style="display:none; margin-top:12px;">
                                    <div style="background:#fff;border-radius:10px;padding:12px;border-left:6px solid #ff6600;">
                                        <h6 style="margin:0 0 8px 0;color:#0b3a66;font-weight:700;">Price Summary</h6>
                                        <div id="kbs_base">Base: <strong>$--</strong></div>
                                        <div id="kbs_adjustments">Adjustments: <strong>$0</strong></div>
                                        <div id="kbs_total" style="margin-top:6px;"><strong>Total: $--</strong></div>
                                    </div>
                                </div>

                                <div style="background:#f0efe9;border-radius:10px;padding:14px;margin-bottom:12px;">
                                    <p style="margin:0;color:#0b3a66;"><strong>💡 Example:</strong> Small Knotless Braids (<strong>$150</strong>) + Waist Length (+<strong>$20</strong>) = <strong style="color:#0b3a66;">$170 total</strong></p>
                                </div>

                                <div style="background:#ffe6e0;border-radius:10px;padding:14px;border-left:6px solid #e35a4a;">
                                    <p style="margin:0;color:#b93a36;font-weight:700;">⚠️ Stitch Braids Special: <span style="font-weight:700;color:#b93a36;">+ $20</span> for more than 10 rows. Additional length charges apply based on your hair length.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Visible Price Display + hidden price input -->
                        <div class="mb-3">
                            <div style="display:flex; align-items:center; justify-content:space-between; background:#fff; border-radius:10px; padding:12px; border-left:6px solid #ff6600;">
                                <div>
                                    <div style="font-weight:700; color:#0b3a66;">Estimated Price</div>
                                    <div id="priceDisplay" style="font-size:1.4rem; font-weight:800; color:#030f68;">--</div>
                                </div>
                                <div style="text-align:right;">
                                    <small style="color:#6c757d; display:block;">Default is mid-back pricing. Final price computed on submit.</small>
                                </div>

                            </div>
                            <!-- Braid Length Guide + Selection (inside booking form so it is submitted) -->
                            <div class="col-12" id="lengthGuideBlock">
                                <div class="mb-3">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-5 text-center mb-3 mb-md-0">
                                            <img src="{{ asset('images/braids-length-guide.jpg') }}" alt="Braid length guide" class="img-fluid" style="max-width: 100%; border-radius: 8px; border: 1px solid #e9ecef;">
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <label class="form-label">Select Braid Length *</label>
                                            <div class="d-flex flex-column" role="radiogroup" aria-label="Braid length options">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_neck" value="neck">
                                                    <label class="form-check-label" for="length_neck">Neck length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_shoulder" value="shoulder">
                                                    <label class="form-check-label" for="length_shoulder">Shoulder length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_armpit" value="armpit">
                                                    <label class="form-check-label" for="length_armpit">Armpit length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_bracstrap" value="bra-strap">
                                                    <label class="form-check-label" for="length_bracstrap">Bra-Strap length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_midback" value="mid-back" checked>
                                                    <label class="form-check-label" for="length_midback">Mid-back length (default)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_waist" value="waist">
                                                    <label class="form-check-label" for="length_waist">Waist length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_hip" value="hip">
                                                    <label class="form-check-label" for="length_hip">Hip length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_tailbone" value="tailbone">
                                                    <label class="form-check-label" for="length_tailbone">Tailbone length</label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="length_classic" value="classic">
                                                    <label class="form-check-label" for="length_classic">Classic length</label>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted d-block mt-2">Default: Mid-back. Length adjustment affects pricing(+$20 long / -$20 short).</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hair Mask Options - shown only for Hair Mask/Relaxing service -->
                            <div class="col-12 mt-3" id="hairMaskOptions" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label">Hair Mask/Relaxing Options *</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hair_mask_option" id="mask_only" value="mask-only" checked>
                                        <label class="form-check-label" for="mask_only">Mask / Relaxing only (Starting at $50)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hair_mask_option" id="mask_with_weave" value="mask-with-weave">
                                        <label class="form-check-label" for="mask_with_weave">With Weaving (+$30 estimate, total ≈ $80)</label>
                                    </div>
                                    <small class="form-text text-muted d-block mt-2">Choose whether you want mask/relaxing only or with weave added. Final price computed on submit.</small>
                                </div>
                            </div>

                            <!-- Price hidden input removed: server now computes authoritative price -->
                        </div>

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
                                    <input type="text" class="form-control" id="bookingDate" placeholder="Click calendar to select date" readonly required style="background-color: #f8f9fa; cursor: pointer;" onclick="openCalendarModal()">
                                    <button class="btn btn-outline-secondary" type="button" onclick="openCalendarModal()">
                                        <i class="bi bi-calendar"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-calendar me-1"></i>
                                    Click the calendar button to select your preferred date and time
                                </small>
                            </div>

                            <!-- Time Selection -->
                            <div class="col-md-6">
                                <label class="form-label">Appointment Time *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="timeInput" placeholder="Click calendar to select time" readonly required style="background-color: #f8f9fa; cursor: pointer;" onclick="openCalendarModal()">
                                    <button class="btn btn-outline-secondary" type="button" onclick="openCalendarModal()">
                                        <i class="bi bi-calendar"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-calendar me-1"></i>
                                    Click the calendar button to select your preferred date and time
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="form-label">Home Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message" class="form-label">Special Requests or Notes</label>
                                    <textarea class="form-control" id="message" name="message" placeholder="Any special requests or additional information..." rows="3" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="sample_picture" class="form-label">
                                        <i class="bi bi-image me-2"></i>Upload Reference Image (Optional)
                                    </label>
                                    <input type="file" class="form-control" id="sample_picture" name="sample_picture" accept="image/*" autocomplete="off">
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Upload a reference image of the hairstyle you want. Accepted formats: JPG, PNG, GIF (Max: 5MB)
                                    </small>
                                    <div class="mt-2" id="imagePreview" style="display: none;">
                                        <div class="d-flex align-items-center">
                                            <img id="previewImg" src="" alt="Preview" style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 2px solid #dee2e6;">
                                            <div class="ms-3">
                                                <small class="text-muted d-block" id="fileName"></small>
                                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="clearImagePreview()">
                                                    <i class="bi bi-trash me-1"></i>Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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
                                       <div class="small text-muted">Starting at $80</div>
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Single Crotchet')">
                                        Single Crotchet
                                        <div class="small text-muted">Starting at $100</div>
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Natural Hair Twist')">
                                        Natural Hair Twist
                                        <div class="small text-muted">Starting at $50</div>
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Weaving No-Extension')">
                                        Weaving No-Extension
                                        <div class="small text-muted">Starting at $30</div>
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Kinky Twist')">
                                        Kinky Twist
                                        <div class="small text-muted">Starting at $90</div>
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Twist Braids')">
                                        Twist Braids
                                        <div class="small text-muted">Starting at $100</div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Service Input -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold mb-3">Custom Service</h6>
                            <div class="alert alert-info mb-3" style="border-left: 4px solid #17a2b8;">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-info-circle me-2"></i>Custom Service Pricing
                                </h6>
                                <p class="mb-1">
                                    <i class="bi bi-info-circle me-2"></i>Prices for custom services may vary based on hair length, thickness, and design complexity.
                                </p>

                            </div>
                            <div class="form-group">
                                <label for="customServiceInput" class="form-label">Enter your desired service</label>
                                <input type="text" class="form-control" id="customServiceInput" placeholder="e.g., Goddess Braids, Box Braids, Passion Twists, etc." maxlength="255">
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Describe the service you want if it's not listed above. Final pricing will be confirmed during consultation.
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

    <!-- Kids Booking Modal moved to end of file -->

    <!-- Important Information Section -->
    <script>
        // Ensure the kids booking modal is a direct child of <body>
        // This prevents the modal from enclosing or visually attaching subsequent page sections.
        (function(){
            try{
                function moveKidsModal(){
                    var el = document.getElementById('kidsBookingModal');
                    if(!el) return;
                    if(el.parentNode !== document.body){
                        document.body.appendChild(el);
                        // also ensure it is hidden by default
                        el.style.display = 'none';
                        el.classList.remove('show');
                    }
                }
                if(document.readyState === 'loading') document.addEventListener('DOMContentLoaded', moveKidsModal); else moveKidsModal();
            }catch(e){ console.warn('moveKidsModal failed', e); }
        })();
    </script>
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
                                                    <a href="https://wa.me/13432548848" target="_blank" rel="noopener noreferrer" style="color: #ff6600; text-decoration: none; font-weight: 600; font-size: 1.1rem;">
                                                        <i class="bi bi-whatsapp" aria-hidden="true" style="font-size:1.4rem; vertical-align:middle;"></i>
                                                         (+1) 343-254-8848</span>
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

    <!-- Contact Section -->
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
    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container" style="padding-top: 60px; padding-bottom: 60px;">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10">
                    <div class="card flex-row shadow-lg border-0" style="border-radius: 24px; overflow: hidden; background: #fff;">
                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center" style="border-right:1px solid #e3eafc;">
                            <h2 class="section-title mb-3" style="font-size:2.2rem; font-weight:700;">Contact Information</h2>
                            <ul class="list-unstyled mb-4" style="font-size:1.08rem;">
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-primary me-2"></i><strong>Phone:</strong> <a href="tel:+13432458848" style="color:#030f68; text-decoration:none;">(+1)343-245-8848</a></li>
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-warning me-2"></i><strong>Email:</strong> <a href="mailto:info@dabsbeautytouch.com" style="color:#ff6600; text-decoration:none;">info@dabsbeautytouch.com</a></li>
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-danger me-2"></i><strong>Address:</strong> Ottawa</li>
                                <li class="mb-3"><i class="bi bi-arrow-right-circle-fill text-success me-2"></i><strong>Hours:</strong>
                                    <ul class="ps-4 mb-0" style="font-size:0.98rem;">
                                        <li>Monday - Friday: 9:00 AM - 7:00 PM</li>
                                        <li>Saturday: 10:00 AM - 6:00 PM</li>
                                        <li>Sunday: 1:00 PM - 6:00 PM</li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="social-links mt-3">
                                <a href="#" class="btn btn-outline-primary me-2"><i class="bi bi-facebook me-1"></i>Facebook</a>
                                <a href="https://www.instagram.com/dabs_beauty_touch?igsh=MXYycGNraGxwem5tZw%3D%3D&utm_source=qr" class="btn btn-outline-info me-2" target="_blank" rel="noopener noreferrer"><i class="bi bi-instagram me-1"></i>Instagram</a>
                                <a href="https://wa.me/13432548848" class="btn btn-outline-success" target="_blank" rel="noopener noreferrer"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a>
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

    @include('partials.site-footer')



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
    alert('Please contact us at:\n\nPhone: (+1)343-245-8848\nEmail: info@dabsbeautytouch.com\nWhatsApp: https://wa.me/13432548848\n\nWe will provide you with payment details and confirm your appointment once payment is received.');
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Additional JavaScript -->
<script>
// MINIMAL WORKING SOLUTION - FORCE OVERRIDE ALL CONFLICTS
console.log('=== LOADING BOOKING FUNCTIONS ===');

// Force define functions immediately when this script loads
(function() {
    'use strict';

    // Test function
    window.testFunction = function() {
        alert('Test function works!');
        console.log('Test function called');
    };

    // Main booking modal function
    window.openBookingModal = function(serviceName, serviceType) {
        console.log('openBookingModal called:', serviceName);

        try {
            // Find the modal element
            var modalEl = document.getElementById('bookingModal');
            if (!modalEl) {
                alert('Booking modal not found on page');
                return;
            }

            // Set service name in form
            var serviceInput = document.getElementById('selectedService');
            if (serviceInput) {
                serviceInput.value = serviceName;
            }

            var serviceDisplay = document.getElementById('serviceDisplay');
            if (serviceDisplay) {
                serviceDisplay.value = serviceName;
            }

            // Set modal title
            var modalTitle = document.getElementById('bookingModalLabel');
            if (modalTitle) {
                modalTitle.textContent = 'Book ' + serviceName;
            }

            // Show modal using Bootstrap
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
                console.log('Modal shown successfully');
            } else {
                // Fallback - show modal manually
                modalEl.style.display = 'block';
                modalEl.classList.add('show');
                modalEl.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
                console.log('Modal shown with fallback method');
            }

        } catch (error) {
            console.error('Error in openBookingModal:', error);
            alert('Error opening booking modal: ' + error.message);
        }
    };

    // Clear form function
    window.clearBookingForm = function() {
        var form = document.getElementById('bookingForm');
        if (form) {
            form.reset();
            console.log('Form cleared');
        }
    };

    // Other Services Modal function
    window.openOtherServicesModal = function() {
        console.log('openOtherServicesModal called');

        try {
            // Find the modal element
            var modalEl = document.getElementById('otherServicesModal');
            if (!modalEl) {
                console.warn('Other services modal not found on page — falling back to service selection modal');
                if (typeof openServiceSelectionModal === 'function') {
                    try { openServiceSelectionModal(); } catch(e){ console.warn('Fallback to openServiceSelectionModal failed', e); }
                }
                return;
            }

            // Show modal using Bootstrap
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var modal = new bootstrap.Modal(modalEl);
                modal.show();
                console.log('Other services modal shown successfully');
            } else {
                // Fallback - show modal manually
                modalEl.style.display = 'block';
                modalEl.classList.add('show');
                modalEl.setAttribute('aria-hidden', 'false');
                document.body.classList.add('modal-open');
                console.log('Other services modal shown with fallback method');
            }

        } catch (error) {
            console.error('Error in openOtherServicesModal:', error);
            alert('Error opening other services modal: ' + error.message);
        }
    };

    console.log('=== BOOKING FUNCTIONS LOADED ===');
    console.log('testFunction:', typeof window.testFunction);
    console.log('openBookingModal:', typeof window.openBookingModal);

})();

// IMMEDIATE BUTTON TEST - runs as soon as script loads
    console.log('=== BUTTON DEBUG TEST ===');
    console.log('Script loading...');

    // Test function to check button status
    function testButtonAndForm() {
        console.log('Testing button and form...');

        // Test button
        const btn = document.getElementById('bookAppointmentBtn');
        console.log('Button found:', !!btn);
        if (btn) {
            console.log('Button details:', {
                id: btn.id,
                disabled: btn.disabled,
                type: btn.type,
                form: btn.form ? btn.form.id : 'no form',
                display: window.getComputedStyle(btn).display,
                visibility: window.getComputedStyle(btn).visibility,
                pointerEvents: window.getComputedStyle(btn).pointerEvents
            });
        }

        // Test form
        const form = document.getElementById('bookingForm');
        console.log('Form found:', !!form);
        if (form) {
            console.log('Form details:', {
                id: form.id,
                action: form.action,
                method: form.method,
                elements: form.elements.length
            });
        }

        // Add simple click handler if both exist
        if (btn && form) {
            console.log('Adding simple click handler...');
            btn.onclick = function(e) {
                console.log('=== BUTTON CLICKED! ===');

                // Validate form before submission
                if (!form.checkValidity()) {
                    e.preventDefault();
                    form.reportValidity();
                    return false;
                }

                // Allow normal form submission to proceed
                console.log('Form validation passed - submitting normally');
                return true;
            };
            console.log('Simple click handler added successfully');
        }
    }

    // Test multiple times to catch dynamic loading
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', testButtonAndForm);
    } else {
        testButtonAndForm();
    }

    setTimeout(testButtonAndForm, 500);
    setTimeout(testButtonAndForm, 2000);

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

    // Function to open service selection modal
    function openServiceSelectionModal() {
        const serviceModal = new bootstrap.Modal(document.getElementById('serviceSelectionModal'));
        serviceModal.show();
    }

    // Close kids modal and open service selection modal
    function backToServiceSelection(){
        try{
            const kidsEl = document.getElementById('kidsBookingModal');
            const kidsModalInstance = bootstrap.Modal.getInstance(kidsEl);
            if(kidsModalInstance){
                kidsModalInstance.hide();
            } else if(kidsEl){
                // fallback: remove show class
                kidsEl.classList.remove('show');
                kidsEl.style.display = 'none';
                document.body.classList.remove('modal-open');
            }

            // small delay to allow modal hide animation then open service selection
            setTimeout(function(){
                try{ openServiceSelectionModal(); }catch(e){ console.warn('openServiceSelectionModal failed', e); }
            }, 260);
        }catch(e){ console.warn('backToServiceSelection failed', e); }
    }

    // Open the kids-only booking modal (does not redirect to main booking modal)
    function openKidsBookingModal(serviceName, serviceType){
        try{
            // populate basic hidden fields in the kids modal
            const svc = document.getElementById('kids_service_input'); if(svc) svc.value = serviceName || 'Kids Braids';
            const st = document.getElementById('kids_service_type_input'); if(st) st.value = serviceType || 'kids-braids';
                // Prefill price preview from selector data if available, otherwise fall back to configured base
            try{
                const sel = (typeof window !== 'undefined') ? window.__kidsSelectorData : null;
                const baseConfigured = {{ (int) config('service_prices.kids_braids', 80) }};

                // Helper maps
                const typeAdj = { protective: -20, cornrows: -40, knotless_small: 20, knotless_med: 0, box_small: 10, box_med: 0, stitch: 20 };
                const lengthAdj = { shoulder: 0, armpit: 10, mid_back: 20, waist: 30 };
                const finishAdj = { curled: -10, plain: 0 };

                let base = baseConfigured;
                let adjustments = 0;
                let addons = 0;
                let total = 0;

                if(sel){
                    // type adj
                    const bt = sel.braid_type || sel.kb_braid_type || sel.braidType || '';
                    adjustments += (typeAdj[bt] || 0);

                    // length adj
                    const hl = sel.hair_length || sel.kb_length || sel.hairLength || '';
                    adjustments += (lengthAdj[hl] || 0);

                    // finish adj
                    const f = sel.finish || sel.kb_finish || sel.finishType || '';
                    adjustments += (finishAdj[f] || 0);

                    // try parse extras (accept JSON array, numeric CSV or names)
                    try{
                        if(sel.extras){
                            if(typeof sel.extras === 'string' && sel.extras.trim().startsWith('[')){
                                const parsed = JSON.parse(sel.extras);
                                if(Array.isArray(parsed)){
                                    parsed.forEach(it => { if(typeof it === 'number') addons += it; else if(typeof it === 'object' && it.value) addons += Number(it.value) || 0; else if(!isNaN(Number(it))) addons += Number(it); });
                                }
                            } else if(typeof sel.extras === 'string' && sel.extras.indexOf(',')>-1){
                                sel.extras.split(',').forEach(t => { const n = Number(t.trim()); if(!isNaN(n)) addons += n; });
                            } else if(typeof sel.extras === 'number'){
                                addons += Number(sel.extras);
                            }
                        }
                    }catch(e){ console.warn('Failed to parse selector extras', e); }

                    // computed total
                    total = base + adjustments + addons;

                    // if payload included authoritative price, prefer it for total display
                    if(sel.price && !isNaN(Number(sel.price))){ total = Number(sel.price); }
                } else {
                    // no selector payload — fallback
                    total = baseConfigured;
                }

                // populate hidden price input and visible preview elements
                const kp = document.getElementById('kids_price_input'); if(kp) kp.value = total;
                // also populate mapping hidden fields so the booking POST includes selector choices
                try{
                    const bt = sel ? (sel.braid_type || sel.kb_braid_type || '') : '';
                    const fin = sel ? (sel.finish || sel.kb_finish || '') : '';
                    const ln = sel ? (sel.hair_length || sel.kb_length || '') : '';
                    const ex = sel ? (sel.extras || '') : '';
                    const ibt = document.getElementById('kids_braid_type_input'); if(ibt) ibt.value = bt;
                    const ifin = document.getElementById('kids_finish_input'); if(ifin) ifin.value = fin;
                    const iln = document.getElementById('kids_length_input'); if(iln) iln.value = ln;
                    const iex = document.getElementById('kids_extras_input'); if(iex) iex.value = ex;
                }catch(e){ /* noop */ }
                const kb = document.getElementById('kidsModal_base'); if(kb) kb.innerHTML = 'Base: <strong>$' + base + '</strong>';
                const ka = document.getElementById('kidsModal_adjustments'); if(ka) ka.innerHTML = 'Adjustments: <strong>$' + (adjustments >=0 ? '+' : '-') + Math.abs(adjustments) + '</strong>';
                const kadd = document.getElementById('kidsModal_addons'); if(kadd) kadd.innerHTML = 'Add-ons: <strong>$' + addons + '</strong>';
                const kt = document.getElementById('kidsModal_total'); if(kt) kt.innerHTML = '<strong>Total: $' + (total ? Number(total).toFixed(0) : '--') + '</strong>';
            }catch(e){ console.warn('Kids price preview compute failed', e); }

            // show modal
            const m = new bootstrap.Modal(document.getElementById('kidsBookingModal'));
            m.show();

            // ensure we show the booking panel (hide selector panel) when opening via this function
            try{
                const selectorPanel = document.getElementById('kidsSelectorPanel');
                const bookingPanel = document.getElementById('kidsBookingPanel');
                if(selectorPanel) selectorPanel.style.display = 'none';
                if(bookingPanel) bookingPanel.style.display = '';
            }catch(e){ /* noop */ }

            // accessibility: focus first input when modal shown
            try{
                const modalEl = document.getElementById('kidsBookingModal');
                modalEl.addEventListener('shown.bs.modal', function(){
                    const nameField = document.getElementById('kids_name'); if(nameField) nameField.focus();
                }, { once: true });
            }catch(e){ /* noop */ }
        }catch(e){ console.warn('openKidsBookingModal failed', e); }
    }

    // Show the booking panel inside the kids modal (used when selector is embedded)
    window.showKidsBookingPanel = function(sel){
        try{
            if(sel) try{ window.__kidsSelectorData = sel; }catch(e){}
            // Use openKidsBookingModal to compute preview and ensure hidden inputs are set
            if(typeof openKidsBookingModal === 'function'){
                openKidsBookingModal('Kids Braids','kids-braids');
            }
            // toggle panels
            const selectorPanel = document.getElementById('kidsSelectorPanel');
            const bookingPanel = document.getElementById('kidsBookingPanel');
            if(selectorPanel) selectorPanel.style.display = 'none';
            if(bookingPanel) bookingPanel.style.display = '';
            // focus name input
            setTimeout(function(){ const nf = document.getElementById('kids_name'); if(nf) nf.focus(); }, 200);
        }catch(e){ console.warn('showKidsBookingPanel failed', e); }
    };

    // Function to select a quick service
    function selectQuickService(serviceName) {
        const selectedServiceInput = document.getElementById('selectedService');
        const serviceDisplayInput = document.getElementById('serviceDisplay');

        // Map common services to their base prices (USD)
        const priceMap = {
            'Weaving Crotchet': '80',
            'Single Crotchet': '100',
            'Natural Hair Twist': '50',
            'Weaving No-Extension': '30',
            'Kinky Twist': '90',
            'Twist Braids': '100'
        };

        // Set the hidden price input if we know the base price
        const selectedPriceInput = document.getElementById('selectedPrice');
        if (selectedPriceInput) {
            selectedPriceInput.value = priceMap[serviceName] || '';
        }

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

        // Clear price for custom services so owner can confirm pricing later
        const selectedPriceInput = document.getElementById('selectedPrice');
        if (selectedPriceInput) {
            selectedPriceInput.value = '';
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

            // Clear image preview
            clearImagePreview();

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
    // Add event listener for time input
    document.addEventListener('DOMContentLoaded', function() {
        // Time input is now read-only and uses modal for selection
        console.log('Time input is read-only - users must use calendar modal');
    });

    // Handle booking form submission
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - Setting up form submission handler');

        const bookingForm = document.getElementById('bookingForm');
        if (!bookingForm) {
            console.error('Booking form not found!');
            return;
        }

        bookingForm.addEventListener('submit', function(e) {
            // Minimal submit handler: basic validation + keep hair-mask hidden-field behavior.
            const requiredFields = ['name', 'phone', 'bookingDate', 'timeInput'];
            const missingFields = [];

            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                const fieldValue = field ? field.value.trim() : '';
                if (!field || !fieldValue) missingFields.push(fieldId);
            });

            if (missingFields.length > 0) {
                e.preventDefault();
                alert('Please fill in all required fields: ' + missingFields.join(', '));
                return;
            }

            // Basic email & phone validation (non-blocking if empty email)
            const emailField = document.getElementById('email');
            if (emailField && emailField.value.trim()) {
                const emailValue = emailField.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailValue)) {
                    e.preventDefault();
                    alert('Please enter a valid email address');
                    return;
                }
            }

            const phoneField = document.getElementById('phone');
            if (!phoneField || !phoneField.value.trim()) {
                e.preventDefault();
                alert('Phone number is required');
                return;
            }

            // Ensure hidden 'length' follows hair_length radios unless hair mask is selected
            let selectedLengthInput = this.querySelector('input[name="length"]');
            const selectedHairLength = (function(){
                const r = document.getElementsByName('hair_length');
                for (let i=0;i<r.length;i++) if (r[i].checked) return r[i].value;
                return null;
            })();
            if (!selectedLengthInput) {
                selectedLengthInput = document.createElement('input');
                selectedLengthInput.type = 'hidden';
                selectedLengthInput.name = 'length';
                selectedLengthInput.id = 'length_hidden_field';
                this.appendChild(selectedLengthInput);
            }

            const serviceTypeHidden = this.querySelector('input[name="service_type"]')?.value || document.getElementById('selectedServiceType')?.value || document.getElementById('selectedService')?.value || '';
            const isHairMaskForm = (serviceTypeHidden && (serviceTypeHidden.toLowerCase().includes('hair-mask') || serviceTypeHidden.toLowerCase().includes('relax')));

            if (isHairMaskForm) {
                // clear length to avoid server applying length-based adjustments
                selectedLengthInput.value = '';
                // ensure hair_mask_option is set from the selected radio into the hidden field
                const maskRadio = document.querySelector('input[name="hair_mask_option"]:checked');
                const hiddenMask = document.getElementById('selectedHairMaskOption');
                if (maskRadio && hiddenMask) hiddenMask.value = maskRadio.value;
            } else {
                if (selectedHairLength) selectedLengthInput.value = selectedHairLength.replace(/-/g, '_');
            }

            // Allow normal form submission to proceed (server is authoritative)
        });
    }); // End of DOMContentLoaded for form submission

    // SIMPLE FORM HANDLER FOR TESTING - DISABLED
    /* document.addEventListener('DOMContentLoaded', function() {
        console.log('=== SIMPLE FORM HANDLER SETUP ===');

        const form = document.getElementById('bookingForm');
        const button = document.getElementById('bookAppointmentBtn');

        console.log('Form found:', !!form);
        console.log('Button found:', !!button);

        if (form && button) {
            // Simple form validation only - let browser handle submission
            form.addEventListener('submit', function(e) {
                console.log('=== FORM SUBMIT EVENT CAPTURED ===');

                // Basic validation check
                if (!this.checkValidity()) {
                    e.preventDefault();
                    console.log('Form validation failed');
                    this.reportValidity();
                    return false;
                }

                console.log('Form validation passed - allowing normal submission');
                // Let the form submit normally - don't prevent default
            });

            // Additional file input debugging (outside of submit handler)
            const fileInput = document.getElementById('samplePicture');
            console.log('=== FILE INPUT DEBUG ===');
            console.log('File input element:', fileInput);
            console.log('File input exists:', !!fileInput);

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    console.log('File input changed');
                    console.log('File input files property:', this.files);
                    console.log('Files length:', this.files.length);
                    console.log('Files array:', Array.from(this.files));

                    if (this.files && this.files.length > 0 && this.files[0]) {
                        const file = this.files[0];
                        console.log('File selected - Name:', file.name);
                        console.log('File selected - Size:', file.size);
                        console.log('File selected - Type:', file.type);
                        console.log('✅ File ready for upload');
                    } else {
                        console.log('❌ No file selected');
                    }
                });
            } else {
                console.log('❌ File input element not found');
            }

            button.addEventListener('click', function(e) {
                console.log('=== BUTTON CLICK EVENT CAPTURED ===');
                console.log('Button click detected!');
                // Don't prevent default here - let it trigger form submission
            });

            console.log('Simple handlers attached successfully');
        } else {
            console.error('Missing form or button for simple handler');
        }
    }); */

    // Add click event listener to test button functionality - SEPARATE DOM READY HANDLER
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded - Setting up button handlers');

        const bookBtn = document.getElementById('bookAppointmentBtn');
        if (bookBtn) {
            console.log('Book Appointment button found and ready');
            console.log('Button element:', bookBtn);
            console.log('Button disabled state:', bookBtn.disabled);
            console.log('Button style display:', window.getComputedStyle(bookBtn).display);
            console.log('Button style pointer-events:', window.getComputedStyle(bookBtn).pointerEvents);

            // Add click handler for better user feedback
            bookBtn.addEventListener('click', function(e) {
                console.log('Book Appointment button clicked!');
                console.log('Event:', e);

                // Check if form is valid before submission
                const form = document.getElementById('bookingForm');
                if (form) {
                    console.log('Form found:', form);
                    // Trigger form validation
                    if (form.checkValidity()) {
                        console.log('Form is valid, proceeding with submission');
                        // The form submit event listener will handle the actual submission
                    } else {
                        console.log('Form validation failed');
                        // Show validation messages
                        form.reportValidity();
                    }
                } else {
                    console.error('Form not found!');
                }
            });
        } else {
            console.error('Book Appointment button not found!');
            // Try to find all buttons in the document
            const allButtons = document.querySelectorAll('button');
            console.log('All buttons found:', allButtons.length);
            allButtons.forEach((btn, index) => {
                console.log(`Button ${index}:`, btn.id, btn.className, btn.textContent.substring(0, 30));
            });
        }

        // Check if form exists
        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            console.log('Booking form found and ready for submission');
        } else {
            console.error('Booking form not found!');
        }
    });

    const contactForm = document.querySelector('form[action*="contact.store"], form[action*="custom-service.store"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // You can add client-side validation here if needed
            console.log('Contact or Custom-Service form submitted');
        });
    }

    // Test function for file input debugging
    function testFileInput() {
        console.log('=== FILE INPUT TEST ===');
        const fileInput = document.getElementById('samplePicture');
        console.log('File input element:', fileInput);

        if (!fileInput) {
            alert('❌ File input not found!');
            return;
        }

        console.log('Files:', fileInput.files);
        console.log('Files length:', fileInput.files.length);

        if (fileInput.files.length === 0) {
            alert('❌ No file selected. Please select a file first.');
            return;
        }

        const file = fileInput.files[0];
        console.log('Selected file:', file);
        console.log('File name:', file.name);
        console.log('File size:', file.size);
        console.log('File type:', file.type);

        alert(`✅ File detected!\nName: ${file.name}\nSize: ${file.size} bytes\nType: ${file.type}`);
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
                                <h3 style="font-weight: 700; margin: 0; font-size: 2rem;">$20.00</h3>
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
                                    <a href="https://wa.me/13432548848" style="color: #ff6600; text-decoration: none; font-weight: 600;" target="_blank" rel="noopener noreferrer">Send Message</a>
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

<!-- Success Modal -->
<div class="modal fade" id="ajaxSuccessModal" tabindex="-1" aria-labelledby="ajaxSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:540px;">
        <div class="modal-content" style="border-radius:14px; overflow:hidden;">
            <!-- Top Check -->
            <div style="background:#fff; padding-top:18px; display:flex; justify-content:center;">
                <div style="width:78px; height:78px; border-radius:16px; background:linear-gradient(180deg,#16a34a,#059669); display:flex; align-items:center; justify-content:center; box-shadow:0 10px 20px rgba(5,104,44,0.12); margin-top:6px;">
                    <span style="font-size:38px; color:#fff;">&#10004;</span>
                </div>
            </div>

            <div class="modal-body" style="background:#fff; padding:22px 24px 18px; text-align:center; color:#05204a;">
                <h2 style="color:#0f5132; font-weight:800; margin-bottom:14px; font-size:1.6rem;">Appointment Booked<br>Successfully!</h2>

                <!-- Two-column Booking ID and Confirmation Code -->
                <div class="row align-items-center" style="margin-bottom:14px;">
                    <div class="col-6 text-center" style="border-right:1px solid #f1f5f9; padding:0 12px;">
                        <div style="color:#6b7280; font-size:14px; margin-bottom:6px;">📋 Booking ID:</div>
                        <a href="#" id="successBookingId" style="font-weight:800; color:#007bff; text-decoration:underline; font-size:18px;">BK000000</a>
                    </div>

                <!-- Price row -->
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-12 text-center">
                        <div style="color:#6b7280; font-size:14px; margin-bottom:6px;">💲 Price:</div>
                        <div id="successPrice" style="font-weight:800; color:#007bff; font-size:18px;">$0.00</div>
                    </div>
                </div>
                    <div class="col-6 text-center" style="padding:0 12px;">
                        <div style="color:#6b7280; font-size:14px; margin-bottom:6px;">🔐 Confirmation Code:</div>
                        <a href="#" id="successConfirmationCode" style="font-weight:800; color:#007bff; text-decoration:underline; font-size:18px;">CONFXXXXXXXX</a>
                    </div>
                </div>

                <!-- Deposit Notice (full width) -->
                <div class="mb-3" style="margin:12px -12px 18px -12px;">
                    <div style="background:#fff3cd; border-radius:12px; padding:14px 16px; display:flex; align-items:center; justify-content:center; gap:12px; border-left:6px solid #f59e0b;">
                        <span style="font-size:1.4rem; color:#b45309;">&#9888;</span>
                        <div style="font-weight:700; color:#7c4a0a; font-size:1rem;">Please contact us to arrange the $20 deposit payment.</div>
                    </div>
                </div>

                <!-- Contact Info Row -->
                <div class="row" style="margin-bottom:14px;">
                    <div class="col-6 text-center" style="padding:0 12px;">
                        <div style="font-weight:700; color:#05204a; margin-bottom:6px;"><i class="bi bi-telephone-fill me-2" style="color:#111827;"></i>Phone:</div>
                        <a href="tel:+13432458848" style="color:#007bff; text-decoration:underline; font-size:16px;">(+1)343-245-8848</a>
                    </div>
                    <div class="col-6 text-center" style="padding:0 12px;">
                        <div style="font-weight:700; color:#05204a; margin-bottom:6px;"><i class="bi bi-envelope-fill me-2" style="color:#111827;"></i>Email:</div>
                        <a href="mailto:info@dabsbeautytouch.com" style="color:#007bff; text-decoration:underline; font-size:16px;">info@dabsbeautytouch.com</a>
                    </div>
                </div>

                <p class="text-muted" style="font-size:0.98rem; margin-bottom:18px;">We'll confirm your appointment once payment is received!</p>

                <div class="text-center" style="margin-bottom:8px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: linear-gradient(90deg,#06b6d4 0%,#10b981 100%); border:none; color:#05204a; color:#fff; padding:12px 60px; border-radius:999px; font-weight:800; font-size:16px;">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to enhance booking success message visibility -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a booking success message
    const successAlert = document.querySelector('.alert-success');

    if (successAlert) {
        // Scroll to top to ensure message is visible
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Add a subtle animation to draw attention
        successAlert.style.animation = 'slideDown 0.5s ease-out';

        // Prevent auto-dismiss for a longer time
        successAlert.style.zIndex = '9999';

        // Add a gentle pulse effect to make it more noticeable
        setTimeout(() => {
            successAlert.style.animation = 'pulse 2s infinite';
        }, 1000);

        // Optional: Auto-scroll to booking section after user reads the message
        const closeButton = successAlert.querySelector('.btn-close');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                // Scroll to booking section when message is dismissed
                const bookingSection = document.getElementById('booking');
                if (bookingSection) {
                    setTimeout(() => {
                        bookingSection.scrollIntoView({ behavior: 'smooth' });
                    }, 300);
                }
            });
        }
    }
});
</script>

<style>
@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes pulse {
    0% {
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }
    50% {
        box-shadow: 0 4px 16px rgba(40, 167, 69, 0.5);
    }
    100% {
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }
}

/* Make the success alert more prominent */
.alert-success {
    position: sticky !important;
    top: 0 !important;
    z-index: 9999 !important;
}
</style>

<script>
// Handle booking success modal
document.addEventListener('DOMContentLoaded', function() {
    const successModal = document.getElementById('successModal');

    if (successModal) {
        // Show modal with animation
        successModal.style.display = 'block';
        setTimeout(() => {
            successModal.classList.add('show');
        }, 100);

        // Function to clear session data
        function clearSessionData() {
            fetch('/clear-session', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function() {
                // Update URL to remove any flash data indicators
                if (window.history && window.history.replaceState) {
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }).catch(function(error) {
                console.log('Session clear request failed:', error);
            });
        }

        // Auto close modal after 5 seconds and clear session data
        setTimeout(function() {
            closeSuccessModal();
        .accessible-kids-modal .form-label { font-size: 1.02rem; color: #03253f; }
        .accessible-kids-modal .form-control { font-size: 1.03rem; padding: .65rem .8rem; border-radius: 8px; }
        .accessible-kids-modal .btn { min-height: 44px; padding: .6rem 1rem; font-size: 1rem; }
        .accessible-kids-modal .modal-header .btn { min-height: 38px; }
        .accessible-kids-modal .modal-title { font-size: 1.15rem; font-weight: 800; color: #ffffff; }
        .visually-hidden { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }
        .accessible-kids-modal #kidsPricePreview { box-shadow: 0 6px 18px rgba(3,15,104,0.06); }
        .accessible-kids-modal [role="status"]:focus { outline: 3px solid #ffb703; }
            try {
                clearSessionData();
            } catch (e) {
                console.warn('Failed to call clearSessionData:', e);
            }
        }, 5000);

        // Also clear session data when modal becomes visible to avoid stale flash keys
        setTimeout(function() {
            try {
                clearSessionData();
            } catch (e) {
                console.warn('Failed to call clearSessionData on show:', e);
            }
        }, 200);
    }
});

// Function to close success modal
function closeSuccessModal() {
    console.log('closeSuccessModal called'); // Debug log
    const successModal = document.getElementById('successModal');
    if (successModal) {
        console.log('Success modal found, hiding it'); // Debug log
        successModal.style.display = 'none';

        // Remove modal from DOM after animation
        setTimeout(function() {
            if (successModal.parentNode) {
                successModal.parentNode.removeChild(successModal);
            }
        }, 300);

        // Clear session data
        fetch('/clear-session', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function() {
            console.log('Session cleared successfully'); // Debug log
            if (window.history && window.history.replaceState) {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }).catch(function(error) {
            console.log('Session clear request failed:', error);
        });
    } else {
        console.log('Success modal not found'); // Debug log
    }
}

// Function to close Other Services success modal
function closeOtherServicesSuccessModal() {
    console.log('closeOtherServicesSuccessModal called');
    const successModal = document.getElementById('otherServicesSuccessModal');
    if (successModal) {
        console.log('Other Services success modal found, hiding it');
        successModal.style.display = 'none';

        // Remove modal from DOM after animation
        setTimeout(function() {
            if (successModal.parentNode) {
                successModal.parentNode.removeChild(successModal);
            }
        }, 300);

        // Clear session data
        fetch('/clear-session', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function() {
            console.log('Other Services session cleared successfully');
            if (window.history && window.history.replaceState) {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }).catch(function(error) {
            console.log('Other Services session clear request failed:', error);
        });
    } else {
        console.log('Other Services success modal not found');
    }
}

// Additional event listener for the OK button (backup in case onclick doesn't work)
document.addEventListener('DOMContentLoaded', function() {
    // Wait for modal to be rendered
    setTimeout(function() {
        const okButton = document.querySelector('#successModal .btn-info');
        if (okButton) {
            console.log('OK button found, adding event listener');
            okButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('OK button clicked via event listener');
                closeSuccessModal();
            });
        }

        // Also add event listener for Other Services success modal OK button
        const otherServicesOkButton = document.querySelector('#otherServicesSuccessModal .btn-success');
        if (otherServicesOkButton) {
            console.log('Other Services OK button found, adding event listener');
            otherServicesOkButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Other Services OK button clicked via event listener');
                closeOtherServicesSuccessModal();
            });
        }
    }, 100);

    // Image preview functionality
    const samplePictureInput = document.getElementById('sample_picture');
    if (samplePictureInput) {
        samplePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const fileName = document.getElementById('fileName');

            if (file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, PNG, or GIF)');
                    e.target.value = '';
                    return;
                }

                // Validate file size (5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB');
                    e.target.value = '';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                clearImagePreview();
            }
        });
    }
});

// Function to clear image preview
function clearImagePreview() {
    const samplePictureInput = document.getElementById('sample_picture');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const fileName = document.getElementById('fileName');

    if (samplePictureInput) samplePictureInput.value = '';
    if (imagePreview) imagePreview.style.display = 'none';
    if (previewImg) previewImg.src = '';
    if (fileName) fileName.textContent = '';
}
</script>
    <!-- Kids Booking Modal (placed at end to ensure it is top-level) -->
    <div class="modal fade" id="kidsBookingModal" tabindex="-1" aria-labelledby="kidsBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title" id="kidsBookingModalLabel">Kids Booking</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="kidsBookingForm" action="{{ route('bookings.store') }}" method="POST" autocomplete="on" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="kids_service_input" name="service" value="">
                        <input type="hidden" id="kids_service_type_input" name="service_type" value="kids-braids">
                        <input type="hidden" id="kids_braid_type_input" name="kb_braid_type" value="">
                        <input type="hidden" id="kids_finish_input" name="kb_finish" value="">
                        <input type="hidden" id="kids_length_input" name="kb_length" value="">
                        <input type="hidden" id="kids_extras_input" name="kb_extras" value="">
                        <input type="hidden" id="kids_price_input" name="price" value="">
                        <input type="hidden" name="appointment_date" value="" />
                        <input type="hidden" name="appointment_time" value="" />

                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Child's Name *</label>
                                    <input id="kids_name" name="name" type="text" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Parent / Guardian Email</label>
                                    <input id="kids_email" name="email" type="email" class="form-control" placeholder="you@example.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Parent / Guardian Phone *</label>
                                    <input id="kids_phone" name="phone" type="tel" class="form-control" required pattern="[0-9+()\s\-]{7,}" placeholder="+1 555 555 5555">
                                    <div class="form-text small text-muted">Include country code, e.g. <code>+1</code></div>
                                </div>
                                <div class="mb-3 d-flex gap-2 align-items-center">
                                    <div>
                                        <label class="form-label mb-1">Selected Date</label>
                                        <div id="kidsSelectedDateLabel" class="form-control-plaintext">--</div>
                                    </div>
                                    <div>
                                        <label class="form-label mb-1">Selected Time</label>
                                        <div id="kidsSelectedTimeLabel" class="form-control-plaintext">--</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date (opens calendar)</label>
                                    <input id="kidsBookingDate" type="text" class="form-control" readonly onclick="openCalendarModal(); return false;" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Time</label>
                                    <input id="kidsBookingTime" type="text" class="form-control" readonly />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Sample Picture (optional)</label>
                                    <input id="kids_sample_picture" name="sample_picture" type="file" accept="image/*" class="form-control">
                                    <div id="kids_imagePreview" class="mt-2" style="display:none;">
                                        <img id="kids_previewImg" src="" alt="Sample preview" style="max-width:120px; border-radius:8px; display:block;" />
                                        <div id="kids_fileName" class="small text-muted mt-1"></div>
                                        <button type="button" id="kids_removeSampleBtn" class="btn btn-sm btn-outline-secondary mt-2">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div style="background:#fff7e0;border-radius:10px;padding:14px;border-left:6px solid #ff6600;">
                                    <h6 style="color:#0b3a66;font-weight:700;margin-bottom:8px;">Price Summary</h6>
                                    <div id="kidsModal_base">Base: <strong>$--</strong></div>
                                    <div id="kidsModal_adjustments">Adjustments: <strong>$0</strong></div>
                                    <div id="kidsModal_total" style="margin-top:6px;"><strong>Total: $--</strong></div>
                                </div>
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-warning" style="font-weight:600;">Confirm Booking</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<script>
// Dynamic price preview and form wiring
(function() {
    const priceMap = {
        'small-knotless': 170,
        'smedium-knotless': 150,
        'wig-installation': 150,
        'medium-knotless': 130,
        'jumbo-knotless': 100,
        'kids-braids': 80,
        'stitch-braids': 120,
        'hair-mask': 50,
        'boho-braids': 150,
        'custom': 100
    };

    function lengthAdjustment(lengthValue) {
        // Normalize incoming value (accept hyphen or underscore)
        const key = (lengthValue || '').toString().replace(/-/g, '_');
        console.log('Length adjustment for:', lengthValue, '-> key:', key);

        // Ordered lengths from shortest -> longest (must match server)
        const ordered = ['neck','shoulder','armpit','bra_strap','mid_back','waist','hip','tailbone','classic'];
        const midIndex = ordered.indexOf('mid_back');
        const idx = ordered.indexOf(key);

        if (idx === -1 || midIndex === -1) {
            console.warn('Unknown length key:', key, 'defaulting to 0 adjustment');
            return 0;
        }

        // Per-step rule: each single step away from mid_back changes price by $20.
        // This makes waist = +20, bra_strap = -20, and two steps away = +/-40, etc.
        const d = idx - midIndex;
        const adjustment = d * 20;
        console.log('Length adjustment amount (per-step $20):', adjustment, {d});
        return adjustment;
    }

    function getSelectedLength() {
        // Prefer a checked radio with a non-empty value. If the checked input has
        // an empty value (unexpected), fall back to deriving the length from the
        // element id (e.g. "length_midback") or from its label text.
        const radios = Array.from(document.querySelectorAll('input[name="hair_length"]'));
        for (let i = 0; i < radios.length; i++) {
            const r = radios[i];
            try {
                if (r.checked) {
                    const v = (r.value || '').toString().trim();
                    if (v !== '') {
                        console.log('Selected length (value):', v);
                        return v;
                    }
                    // fallback: derive from id after the first underscore, e.g. length_midback -> midback
                    if (r.id) {
                        const parts = r.id.split('_');
                        if (parts.length > 1) {
                            const derived = parts.slice(1).join('_').replace(/_/g, '-');
                            console.log('Selected length derived from id:', derived, r.id);
                            return derived;
                        }
                    }
                    // fallback: try to find a label[for] or closest label and extract text
                    try {
                        const label = document.querySelector('label[for="' + (r.id || '') + '"]') || r.closest('label');
                        if (label) {
                            const txt = (label.textContent || '').trim().toLowerCase();
                            // take first word that looks like a length (e.g. 'mid-back' or 'waist')
                            const match = txt.match(/(neck|shoulder|armpit|bra-strap|mid-back|waist|hip|tailbone|classic)/i);
                            if (match) {
                                console.log('Selected length derived from label:', match[0]);
                                return match[0].toLowerCase();
                            }
                        }
                    } catch (e) { /* ignore */ }
                    // if we reach here, checked input exists but we couldn't derive a value
                    console.warn('Checked hair_length input has empty value and no id/label fallback', r);
                    return '';
                }
            } catch (e) { /* ignore per-input failures */ }
        }
        console.log('No length selected, defaulting to mid-back');
        return 'mid-back';
    }

    function updatePriceDisplay(basePrice) {
        const serviceType = window.currentServiceInfo.serviceType || document.getElementById('selectedServiceType')?.value || 'custom';
        const serviceNameDisplay = (window.currentServiceInfo && window.currentServiceInfo.serviceName) || document.getElementById('serviceDisplay')?.value || '';
        const isHairMask = (serviceType === 'hair-mask') || (''+serviceNameDisplay).toLowerCase().includes('mask');

        // Resolve authoritative base price when caller didn't pass a number
        let base = (typeof basePrice === 'number') ? basePrice : null;
        if (base === null) {
            // try hidden input
            const hiddenBaseEl = document.getElementById('selectedPrice');
            if (hiddenBaseEl && hiddenBaseEl.value && !isNaN(parseFloat(hiddenBaseEl.value))) {
                base = parseFloat(hiddenBaseEl.value);
            } else if (window.currentServiceInfo && typeof window.currentServiceInfo.basePrice === 'number') {
                base = window.currentServiceInfo.basePrice;
            } else {
                base = priceMap[serviceType] || priceMap['custom'];
            }
        }

        // For hair-mask we show mask options and compute addon (+30 for weave)
        if (isHairMask) {
            // read selected mask option (only consider actual radio inputs)
            const maskRadio = document.querySelector('input[type="radio"][name="hair_mask_option"]:checked');
            // log snapshot of all mask radio inputs for debugging
            try {
                const maskInputs = Array.from(document.querySelectorAll('input[type="radio"][name="hair_mask_option"]'));
                const maskSnapshot = maskInputs.map((m, idx) => ({ idx, id: m.id || null, type: m.type, value: m.value, checked: !!m.checked }));
                console.log('Mask radios snapshot:', maskSnapshot);
            } catch (e) { /* ignore */ }

            // Derive maskVal robustly: prefer radio.value; if empty, derive from id or label text; finally fallback to hidden field or 'mask-only'
            let maskVal = '';
            if (maskRadio) {
                maskVal = (maskRadio.value || '').toString().trim();
                if (!maskVal) {
                    // try from id (mask_with_weave -> mask-with-weave)
                    if (maskRadio.id) {
                        const derived = maskRadio.id.replace(/_/g, '-');
                        if (derived.includes('weav') || derived.includes('weave')) maskVal = 'mask-with-weave';
                        else if (derived.includes('mask')) maskVal = 'mask-only';
                        else maskVal = derived;
                        console.log('Derived maskVal from id:', derived, '->', maskVal);
                    }
                    // try from label text
                    if (!maskVal) {
                        try {
                            const label = document.querySelector('label[for="' + (maskRadio.id || '') + '"]') || maskRadio.closest('label');
                            if (label) {
                                const txt = (label.textContent || '').toLowerCase();
                                if (txt.includes('weav')) maskVal = 'mask-with-weave';
                                else if (txt.includes('mask') || txt.includes('relax')) maskVal = 'mask-only';
                                console.log('Derived maskVal from label text:', txt, '->', maskVal);
                            }
                        } catch (e) { /* ignore */ }
                    }
                }
            }
            if (!maskVal) maskVal = document.getElementById('selectedHairMaskOption')?.value || 'mask-only';
            const addon = (maskVal === 'mask-with-weave') ? 30 : 0;
            const finalPrice = (typeof basePrice === 'number' ? basePrice : 0) + addon;

            console.log('Hair-mask price calc', { basePrice, maskVal, addon, finalPrice });

            const disp = document.getElementById('priceDisplay');
            const hidden = document.getElementById('selectedPrice');
            const hiddenMask = document.getElementById('selectedHairMaskOption');

            if (disp) disp.textContent = finalPrice ? ('$' + finalPrice) : '--';
            if (hidden) hidden.value = (typeof basePrice === 'number') ? basePrice : (parseFloat(basePrice) || '');
            if (hiddenMask) hiddenMask.value = maskVal;

            return finalPrice;
        }

        // default flow for braided services uses length adjustment
        // collect diagnostics about the hair_length radios to help debug empty selections
        const radios = document.getElementsByName('hair_length');
        let checkedVal = '';
        let checkedIndex = -1;
        const radiosSnapshot = [];
        for (let i = 0; i < radios.length; i++) {
            try {
                const v = radios[i].value || '';
                const c = !!radios[i].checked;
                radiosSnapshot.push({ idx: i, value: v, checked: c, id: radios[i].id || null });
                if (c) { checkedVal = v; checkedIndex = i; break; }
            } catch(e) {
                radiosSnapshot.push({ idx: i, value: '', checked: false, id: null });
            }
        }
        const length = checkedVal || getSelectedLength();
        console.log('Radios snapshot:', radiosSnapshot, 'resolved length:', length, 'checkedIndex:', checkedIndex);
        const adj = lengthAdjustment(length);
        const finalPrice = base + adj;

        console.log('Price calculation:', {
            basePrice: base,
            length: length,
            adjustment: adj,
            finalPrice: finalPrice
        });

        const disp = document.getElementById('priceDisplay');
        const hidden = document.getElementById('selectedPrice');

        if (disp) {
            const newText = finalPrice ? ('$' + finalPrice) : '--';
            if (disp.textContent !== newText) { disp.textContent = newText; animatePriceChange(disp); } else { disp.textContent = newText; }
            console.log('Updated price display to:', disp.textContent);
        }
        // debug badge removed: no-op
        if (hidden) {
            // Store only the authoritative base price in the hidden input (do NOT post client-side adjusted finalPrice)
            hidden.value = base;
            console.log('Updated hidden price input to base price (client will not post adjusted final):', hidden.value);
        }
        return finalPrice;
    }

    // Store current service info globally for easy access
    window.currentServiceInfo = { serviceName: '', serviceType: '', basePrice: 0 };

    // Wrap existing openBookingModal
    const prevOpen = window.openBookingModal;
    window.openBookingModal = function(serviceName, serviceType) {
        console.log('Opening booking modal for:', serviceName, serviceType);

        // Store service info globally
        window.currentServiceInfo = {
            serviceName: serviceName,
            serviceType: serviceType,
            basePrice: (serviceType && priceMap[serviceType]) ? priceMap[serviceType] : priceMap['custom']
        };

        // Call original modal opener first (it may clear the form)
        if (typeof prevOpen === 'function') {
            try {
                prevOpen(serviceName, serviceType);
            } catch(e) {
                console.error('openBookingModal inner error', e);
            }
        }

        // Now set/restore hidden inputs and update UI (do this after prevOpen which may reset the form)
        try {
            const st = document.getElementById('selectedServiceType');
            if (st) st.value = serviceType || '';

            const sd = document.getElementById('selectedService');
            if (sd) sd.value = serviceName || '';

            const serviceDisplayEl = document.getElementById('serviceDisplay');
            if (serviceDisplayEl) serviceDisplayEl.value = serviceName || '';

            const base = window.currentServiceInfo.basePrice;

            // If we have kids selector data and this is the kids-braids flow,
            // show a compact kids-only booking summary and hide the detailed info.
            try {
                const kidsData = (typeof window !== 'undefined') ? window.__kidsSelectorData : null;
                const kidsSummaryDiv = document.getElementById('kidsBookingSummary');
                const detailedDiv = document.getElementById('bookingDetailedInfo');
                if (serviceType === 'kids-braids' && kidsData && kidsSummaryDiv) {
                    const selPrice = parseFloat(kidsData.price) || 0;
                    const basePrice = parseFloat(base) || 0;
                    const adjustments = selPrice - basePrice;

                    const kbs_base = document.getElementById('kbs_base');
                    const kbs_adjustments = document.getElementById('kbs_adjustments');
                    const kbs_total = document.getElementById('kbs_total');

                    if (kbs_base) kbs_base.innerHTML = 'Base: <strong>$' + (basePrice ? basePrice.toFixed(0) : '--') + '</strong>';
                    if (kbs_adjustments) kbs_adjustments.innerHTML = 'Adjustments: <strong>' + (adjustments >= 0 ? '+' : '-') + '$' + Math.abs(adjustments).toFixed(0) + '</strong>';
                    if (kbs_total) kbs_total.innerHTML = '<strong>Total: $' + (selPrice ? selPrice.toFixed(0) : '--') + '</strong>';

                    // update visible price to the selector's total and ensure hidden base remains set via updatePriceDisplay
                    const priceDisplay = document.getElementById('priceDisplay');
                    if (priceDisplay) priceDisplay.textContent = selPrice ? ('$' + selPrice.toFixed(0)) : '--';

                    if (detailedDiv) detailedDiv.style.display = 'none';
                    // hide the braid length guide (image + radios) for kids bookings
                    try{
                        const lengthGuide = document.getElementById('lengthGuideBlock');
                        if(lengthGuide) lengthGuide.style.display = 'none';
                    }catch(e){ /* noop */ }

                    kidsSummaryDiv.style.display = 'block';
                } else {
                    if (kidsSummaryDiv) kidsSummaryDiv.style.display = 'none';
                    if (detailedDiv) detailedDiv.style.display = '';
                    try{
                        const lengthGuide = document.getElementById('lengthGuideBlock');
                        if(lengthGuide) lengthGuide.style.display = '';
                    }catch(e){ /* noop */ }
                }
            } catch (e) {
                console.warn('Kids summary render failed', e);
            }

            // For hair-mask show mask options. For hair-mask OR retouching disable length radios.
            const maskOptionsDiv = document.getElementById('hairMaskOptions');
            const lengthRadios = document.getElementsByName('hair_length');
            // accept either slug or display name containing 'mask'
            const isHairMaskLocal = (serviceType === 'hair-mask') || (''+serviceName).toLowerCase().includes('mask');
            const disableLengths = (isHairMaskLocal || serviceType === 'retouching');

            // hair-mask specific UI (only hair-mask shows mask options)
            if (serviceType === 'hair-mask') {
                if (maskOptionsDiv) maskOptionsDiv.style.display = 'block';
                // ensure default mask option selected
                const defaultMask = document.getElementById('mask_only');
                if (defaultMask) defaultMask.checked = true;
            } else {
                if (maskOptionsDiv) maskOptionsDiv.style.display = 'none';
            }

            // enable/disable length radios according to service; do NOT change kids flows here
            for (let i = 0; i < lengthRadios.length; i++) {
                try { lengthRadios[i].disabled = !!disableLengths; } catch (e) { /* ignore */ }
            }

            // Attach change listeners to any mask option radios inside the modal
            try {
                const maskRadiosModal = document.querySelectorAll('input[type="radio"][name="hair_mask_option"]');
                for (let i = 0; i < maskRadiosModal.length; i++) {
                    const el = maskRadiosModal[i];
                    // avoid attaching multiple times
                    if (el.dataset && el.dataset.maskListenerAttached) continue;
                    el.addEventListener('change', function() {
                        const selVal = this.value;
                        setTimeout(function(){
                            // update hidden input for submission
                            const hiddenMask = document.getElementById('selectedHairMaskOption');
                            if (hiddenMask) hiddenMask.value = selVal;
                            // resolve base price
                            const selectedPriceEl = document.getElementById('selectedPrice');
                            let base = null;
                            if (selectedPriceEl && selectedPriceEl.value && !isNaN(parseFloat(selectedPriceEl.value))) {
                                base = parseFloat(selectedPriceEl.value);
                            } else if (window.currentServiceInfo && typeof window.currentServiceInfo.basePrice === 'number') {
                                base = window.currentServiceInfo.basePrice;
                            } else {
                                base = priceMap[serviceType] || priceMap['custom'];
                            }
                            updatePriceDisplay(base);
                        }, 0);
                    });
                    try { el.dataset.maskListenerAttached = '1'; } catch(e) { /* ignore */ }
                }
            } catch (e) { /* ignore modal mask radio attach errors */ }

            // Ensure hidden mask option reflects default before computing price
            try {
                const hiddenMask = document.getElementById('selectedHairMaskOption');
                const checkedMask = document.querySelector('input[name="hair_mask_option"]:checked');
                if (hiddenMask) {
                    hiddenMask.value = (checkedMask && checkedMask.value) ? checkedMask.value : (hiddenMask.value || 'mask-only');
                }
            } catch (e) { /* ignore */ }

            // Now that modal UI is set up (radios, defaults, hidden inputs), update the price display using authoritative base
            try { updatePriceDisplay(base); } catch (e) { console.warn('updatePriceDisplay failed after modal setup', e); }
        } catch (e) {
            console.warn('Error toggling hair mask UI:', e);
        }
    };

    // Update price when length changes
    function handleLengthChange(e) {
        if (e.target && e.target.name === 'hair_length') {
            console.log('Length changed to:', e.target.value);
            const serviceType = window.currentServiceInfo.serviceType || document.getElementById('selectedServiceType')?.value || 'custom';
            const base = priceMap[serviceType] || priceMap['custom'];
            // Defer price update to ensure the radio's checked state has been applied
            setTimeout(function(){
                console.log('Deferred updatePriceDisplay after click/change for:', e.target.value);
                updatePriceDisplay(base);
            }, 0);
        }
    }

    // Add event listeners for length changes
    document.addEventListener('change', handleLengthChange);
    // For click events, defer handling so the input checked state is reliable
    document.addEventListener('click', function(e){ if (e.target && e.target.name === 'hair_length') { setTimeout(function(){ handleLengthChange(e); }, 0); } });

    // Init on load
    document.addEventListener('DOMContentLoaded', function(){
        console.log('Initializing price display system');

        // Set up initial price display
        const serviceType = document.getElementById('selectedServiceType')?.value || 'custom';
        const base = priceMap[serviceType] || priceMap['custom'];
        updatePriceDisplay(base);

        // Add individual event listeners to each radio button for better reliability
        const lengthRadios = document.getElementsByName('hair_length');
        for (let i = 0; i < lengthRadios.length; i++) {
            lengthRadios[i].addEventListener('change', function() {
                console.log('Radio button changed directly (raw):', this.value);
                // Defer to ensure checked state is fully applied
                setTimeout(function(){
                    const sel = getSelectedLength();
                    console.log('Radio selected length (deferred):', sel);
                    const selectedPriceEl = document.getElementById('selectedPrice');
                    let base = null;
                    if (selectedPriceEl && selectedPriceEl.value && !isNaN(parseFloat(selectedPriceEl.value))) {
                        base = parseFloat(selectedPriceEl.value);
                    } else {
                        const serviceType = window.currentServiceInfo.serviceType || document.getElementById('selectedServiceType')?.value || 'custom';
                        base = priceMap[serviceType] || priceMap['custom'];
                    }
                    updatePriceDisplay(base);
                }, 0);
            });
        }

        // hair_mask_option listeners (for hair mask service)
        const maskRadios = document.querySelectorAll('input[type="radio"][name="hair_mask_option"]');
        for (let i = 0; i < maskRadios.length; i++) {
            maskRadios[i].addEventListener('change', function() {
                console.log('Hair mask option changed (radio):', this.value);
                // Defer to ensure the checked state and any form hidden inputs are updated
                const selVal = this.value;
                setTimeout(function(){
                    // Resolve authoritative base: prefer hidden selectedPrice, then currentServiceInfo, then priceMap
                    const selectedPriceEl = document.getElementById('selectedPrice');
                    let base = null;
                    if (selectedPriceEl && selectedPriceEl.value && !isNaN(parseFloat(selectedPriceEl.value))) {
                        base = parseFloat(selectedPriceEl.value);
                    } else if (window.currentServiceInfo && typeof window.currentServiceInfo.basePrice === 'number') {
                        base = window.currentServiceInfo.basePrice;
                    } else {
                        const serviceType = window.currentServiceInfo.serviceType || document.getElementById('selectedServiceType')?.value || 'custom';
                        base = priceMap[serviceType] || priceMap['custom'];
                    }
                    // Ensure hidden mask option input updated for form submission
                    const hiddenMask = document.getElementById('selectedHairMaskOption');
                    if (hiddenMask) hiddenMask.value = selVal;
                    // Update the visible price using the resolved base so hair-mask branch uses correct base
                    updatePriceDisplay(base);
                }, 0);
            });
        }

        // Fetch booked dates on initial page load so calendar is up-to-date
        try {
            if (typeof fetchRealBookedDates === 'function') {
                console.log('Fetching booked dates on page load');
                fetchRealBookedDates();
            } else {
                console.warn('fetchRealBookedDates not defined on page load');
            }
        } catch (e) {
            console.warn('Error calling fetchRealBookedDates on load:', e);
        }
    });

    // Other Services Form - Use AJAX with popup success modal
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Setting up Other Services form handler...');
        const otherServicesForm = document.getElementById('otherServicesForm');

        if (otherServicesForm) {
            console.log('Other Services form found:', otherServicesForm);

            // Add click handler to the submit button as backup
            const submitButton = otherServicesForm.querySelector('button[type="submit"]');
            if (submitButton) {
                console.log('Submit button found:', submitButton);

                // Test button clickability
                submitButton.style.cursor = 'pointer';
                submitButton.style.pointerEvents = 'auto';

                submitButton.addEventListener('click', function(event) {
                    console.log('Other Services submit button clicked directly!');

                    // Manual form validation and submission if needed
                    if (!otherServicesForm.checkValidity()) {
                        console.log('Form invalid, showing validation');
                        otherServicesForm.classList.add('was-validated');
                        event.preventDefault();
                        return false;
                    }

                    // Let the form submit event handle the actual submission
                    console.log('Button click complete, form should submit...');
                });

                // Add mousedown event for testing
                submitButton.addEventListener('mousedown', function(event) {
                    console.log('Submit button mousedown detected!');
                });

                // Add a professional confirmation alert on click with form clearing and page refresh
                submitButton.onclick = function(event) {
                    console.log('Submit button onclick fired!');

                    // Clear the form before showing success message
                    clearOtherServicesForm();

                    alert('Thank you for your service inquiry! Your request has been received and we will contact you within 24 hours to discuss your requirements and provide a personalized quote.');

                    // Refresh the page after user clicks OK on the alert
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                };

            } else {
                console.error('Submit button not found in Other Services form!');
            }

            otherServicesForm.addEventListener('submit', function(event) {
                console.log('Other Services form submit event triggered!');
                event.preventDefault();
                event.stopPropagation();

                // Validate form
                if (!otherServicesForm.checkValidity()) {
                    console.log('Form validation failed');
                    otherServicesForm.classList.add('was-validated');
                    return false;
                }

                console.log('Form validation passed, processing submission...');

                // Prepare form data
                const formData = new FormData(otherServicesForm);

                // Get selected radio button values
                const hairLengthRadio = document.querySelector('input[name="hair_length"]:checked');
                const budgetRangeRadio = document.querySelector('input[name="budget_range"]:checked');
                const preferredContactRadio = document.querySelector('input[name="preferred_contact"]:checked');

                const serviceDescription = document.getElementById('service_description').value;
                const additionalInfo = document.getElementById('additional_info').value;
                const hairLength = hairLengthRadio ? hairLengthRadio.value : '';
                const budgetRange = budgetRangeRadio ? budgetRangeRadio.value : '';
                const preferredContact = preferredContactRadio ? preferredContactRadio.value : '';

                // Build combined message
                let message = `Service Request: ${serviceDescription}`;
                if (hairLength) message += `\n\nDesired Hair Length: ${hairLength}`;
                if (budgetRange) message += `\nBudget Range: ${budgetRange}`;
                if (preferredContact) message += `\nPreferred Contact: ${preferredContact}`;
                if (additionalInfo) message += `\n\nAdditional Information: ${additionalInfo}`;

                // Update form data with combined message
                formData.set('message', message);

                // Submit via AJAX
                fetch(otherServicesForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Success - show popup modal
                        showOtherServicesSuccessPopup();

                        // Close the form modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('otherServicesModal'));
                        if (modal) modal.hide();

                        // Clear form completely using our comprehensive clearing function
                        clearOtherServicesForm();

                        return response.text();
                    }
                    throw new Error('Network response was not ok');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error submitting your request. Please try again or contact us directly.');
                });
            });
        } else {
            console.error('Other Services form not found!');
        }
    });

    // Debug function to test Other Services button - can be called from console
    window.testOtherServicesButton = function() {
        console.log('=== TESTING OTHER SERVICES BUTTON ===');

        const form = document.getElementById('otherServicesForm');
        const button = document.getElementById('otherServicesSubmitBtn');

        console.log('Form found:', !!form);
        console.log('Button found:', !!button);

        if (button) {
            console.log('Button properties:', {
                type: button.type,
                disabled: button.disabled,
                form: button.form ? button.form.id : 'no form',
                display: window.getComputedStyle(button).display,
                visibility: window.getComputedStyle(button).visibility,
                pointerEvents: window.getComputedStyle(button).pointerEvents,
                zIndex: window.getComputedStyle(button).zIndex
            });

            // Try to manually trigger click
            console.log('Attempting to trigger click...');
            button.click();
        }

        if (form) {
            console.log('Form properties:', {
                id: form.id,
                action: form.action,
                method: form.method,
                elements: form.elements.length
            });
        }
    };

    // Function to clear Other Services form completely
    function clearOtherServicesForm() {
        console.log('Clearing Other Services form...');

        const form = document.getElementById('otherServicesForm');
        if (!form) {
            console.error('Other Services form not found for clearing');
            return;
        }

        // Reset the form using built-in method
        form.reset();

        // Remove validation classes
        form.classList.remove('was-validated');

        // Clear all radio buttons explicitly
        const radioButtons = form.querySelectorAll('input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.checked = false;
        });

        // Clear all text inputs and textareas explicitly
        const textInputs = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
        textInputs.forEach(input => {
            input.value = '';
        });

        // Clear any validation feedback
        const validationFeedback = form.querySelectorAll('.invalid-feedback, .valid-feedback');
        validationFeedback.forEach(feedback => {
            feedback.style.display = 'none';
        });

        // Remove any is-invalid/is-valid classes from form controls
        const formControls = form.querySelectorAll('.form-control, .form-check-input');
        formControls.forEach(control => {
            control.classList.remove('is-invalid', 'is-valid');
        });

        console.log('Other Services form cleared successfully');
    }

    // Function to show Other Services success popup modal
    function showOtherServicesSuccessPopup() {
        // Create modal HTML
        const modalHTML = `
            <div class="modal fade show d-block" id="otherServicesPopupModal" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 1060;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px; border: none;">
                        <div class="modal-header text-center border-0 pb-0" style="display: flex; flex-direction: column; align-items: center;">
                            <div style="background: #28a745; border-radius: 8px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                <span style="font-size: 2.5rem; color: #fff;">✓</span>
                            </div>
                            <h4 class="modal-title text-success mb-0" style="font-weight: bold; color: #218838; margin-top: 8px;">Service Request Sent<br>Successfully!</h4>
                        </div>
                        <div class="modal-body text-center px-4">
                            <div class="row mb-3 justify-content-center">
                                <div class="col-12 text-center mt-2">
                                    <p class="mb-3" style="color: #6c757d; font-size: 1.1rem;">Thank you for your request! We will get back to you soon.</p>
                                    <div class="alert alert-info border-0 mb-3" style="background-color: #e3f2fd; border-radius: 8px;">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <span style="font-size: 1.3rem; margin-right: 8px;">ℹ️</span>
                                            <span style="font-size: 1rem; color: #1976d2;">We'll review your request and contact you within 24 hours to discuss details and pricing.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center" style="gap: 0.5rem;">
                                <div class="col-auto text-start">
                                    <span style="font-size: 1.2rem; margin-right: 4px;">📞</span>
                                    <span style="font-weight: bold; color: #001f3f;">Phone:</span>
                                    <a href="tel:+13432458848" style="color: #007bff; text-decoration: underline;">(+1)343-245-8848</a>
                                </div>
                                <div class="col-auto text-start">
                                    <span style="font-size: 1.2rem; margin-right: 4px;">📧</span>
                                    <span style="font-weight: bold; color: #001f3f;">Email:</span>
                                    <a href="mailto:info@dabsbeautytouch.com" style="color: #007bff; text-decoration: underline;">info@dabsbeautytouch.com</a>
                                </div>
                            </div>
                            <p class="text-muted mb-3" style="font-size: 1rem;">Need urgent assistance? Feel free to contact us directly!</p>
                        </div>
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="button" class="btn btn-success px-4 py-2" onclick="closeOtherServicesPopupModal()" style="background: linear-gradient(90deg, #28a745 0%, #20c997 100%); border: none; color: #fff; font-weight: bold; border-radius: 24px; width: 120px;">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // Show modal with animation
        setTimeout(function() {
            const modalElement = document.getElementById('otherServicesPopupModal');
            if (modalElement) {
                modalElement.style.opacity = '0';
                modalElement.style.transition = 'opacity 0.3s ease';
                setTimeout(function() {
                    modalElement.style.opacity = '1';
                }, 10);
            }
        }, 10);
    }

    // Function to close the popup modal
    function closeOtherServicesPopupModal() {
        const modalElement = document.getElementById('otherServicesPopupModal');
        if (modalElement) {
            modalElement.style.opacity = '0';
            setTimeout(function() {
                modalElement.remove();
            }, 300);
        }
    }

})();
</script>

</script>

<script>
// If user was redirected from a selector page, pick up params and open booking modal
(function(){
    try{
        const params = new URLSearchParams(window.location.search);
        const serviceType = params.get('service_type');
        if(!serviceType) return;
        const serviceName = params.get('service') || '';
        const price = params.get('price');
        const hairLength = params.get('hair_length');
        const extras = params.get('extras');

        // Populate booking form hidden inputs if present
        const sd = document.getElementById('selectedService'); if(sd) sd.value = serviceName;
        const st = document.getElementById('selectedServiceType'); if(st) st.value = serviceType;
        const priceInput = document.getElementById('selectedPrice'); if(priceInput && price) priceInput.value = price;
        if(hairLength){
            const radio = document.querySelector('input[name="hair_length"][value="'+hairLength+'"]');
            if(radio) radio.checked = true;
        }
        if(extras){
            let ext = document.getElementById('selectedExtras');
            if(!ext){
                ext = document.createElement('input'); ext.type='hidden'; ext.id='selectedExtras'; ext.name='extras';
                const form = document.getElementById('bookingForm'); if(form) form.appendChild(ext);
            }
            if(ext) ext.value = extras;
        }

        // If this is a kids selector redirect, construct a small selector payload
        // and open the kids booking modal (preserves selector price summary).
        if(serviceType === 'kids-braids'){
            try{
                const sel = {
                    service: serviceName || 'Kids Braids',
                    service_type: serviceType,
                    price: price ? Number(price) : undefined,
                    hair_length: hairLength || params.get('hair_length') || params.get('kb_length') || '',
                    braid_type: params.get('braid_type') || params.get('kb_braid_type') || '',
                    finish: params.get('finish') || params.get('kb_finish') || '',
                    extras: extras || params.get('extras') || ''
                };
                try{ window.__kidsSelectorData = sel; }catch(e){}

                if(typeof openKidsBookingModal === 'function'){
                    setTimeout(function(){ try{ openKidsBookingModal(serviceName, serviceType); }catch(e){ console.warn('openKidsBookingModal failed', e); } }, 200);
                } else if(typeof openBookingModal === 'function'){
                    setTimeout(function(){ try{ openBookingModal(serviceName, serviceType); }catch(e){ console.warn('openBookingModal failed', e); } }, 200);
                }
            }catch(e){ console.warn('Failed to open kids booking modal from params', e); }
        } else {
            // Open booking modal for non-kids flows
            if(typeof openBookingModal === 'function'){
                setTimeout(function(){ try{ openBookingModal(serviceName, serviceType); }catch(e){ console.warn('openBookingModal failed', e); } }, 200);
            }
        }

        // Remove query params from URL
        if(window.history && window.history.replaceState){
            const clean = window.location.pathname + window.location.hash;
            window.history.replaceState({}, document.title, clean);
        }
    }catch(e){ console.warn('Selector redirect handler error', e); }
})();
</script>
@if(session('kids_selector'))
<script>
    // Open booking modal from server-side flashed kids selector data
    (function(){
        try{
            const sel = @json(session('kids_selector'));
            if(!sel || !sel.service_type) return;
            const serviceName = sel.service || '';
            const serviceType = sel.service_type;
            const price = sel.price;
            const hairLength = sel.hair_length;
            const extras = sel.extras;

            const sd = document.getElementById('selectedService'); if(sd) sd.value = serviceName;
            const st = document.getElementById('selectedServiceType'); if(st) st.value = serviceType;
            const priceInput = document.getElementById('selectedPrice'); if(priceInput && price) priceInput.value = price;
            if(hairLength){
                const radio = document.querySelector('input[name="hair_length"][value="'+hairLength+'"]');
                if(radio) radio.checked = true;
            }
            if(extras){
                let ext = document.getElementById('selectedExtras');
                if(!ext){
                    ext = document.createElement('input'); ext.type='hidden'; ext.id='selectedExtras'; ext.name='extras';
                    const form = document.getElementById('bookingForm'); if(form) form.appendChild(ext);
                }
                if(ext) ext.value = extras;
            }
            // (Session selector) -- populate basic booking fields (no adjustments UI)
            // Note: keep this block minimal so the booking modal behavior remains unchanged.

            // expose the selector payload for client-side summary rendering
            try{ window.__kidsSelectorData = sel || null; }catch(e){ window.__kidsSelectorData = null; }
            // If this is the kids flow, open the dedicated kids booking modal instead of the main booking modal
            if(serviceType === 'kids-braids' && typeof openKidsBookingModal === 'function'){
                setTimeout(function(){ try{ openKidsBookingModal(serviceName, serviceType); }catch(e){ console.warn('openKidsBookingModal failed', e); } }, 200);
            } else if(typeof openBookingModal === 'function'){
                setTimeout(function(){ try{ openBookingModal(serviceName, serviceType); }catch(e){ console.warn('openBookingModal failed', e); } }, 200);
            }
        }catch(e){ console.warn('Failed to open booking modal from session selector', e); }
    })();
</script>
@endif

<script>
// Client-side phone formatter for kids booking phone input
(function(){
    function formatPhoneForDisplay(raw){
        if(!raw) return '';
        const s = raw.toString().trim();
        const leadingPlus = s.startsWith('+') ? '+' : '';
        const digits = s.replace(/[^0-9]/g,'');
        if(!digits) return leadingPlus;
        // If looks like +1... format as +1 234 567 8901
        if(leadingPlus === '+' && digits.length >= 11 && digits.startsWith('1')){
            const rest = digits.slice(1);
            return '+1 ' + rest.replace(/(\d{3})(\d{3})(\d{0,4})/, function(_,a,b,c){
                return [a,b,c].filter(Boolean).join(' ');
            }).trim();
        }
        // Generic grouping: groups of 3
        return leadingPlus + digits.replace(/(\d{3})(?=\d)/g, '$1 ').trim();
    }

    function normalizePhoneForSubmit(raw){
        if(!raw) return '';
        const s = raw.toString().trim();
        const plus = s.startsWith('+') ? '+' : '';
        const digits = s.replace(/[^0-9]/g,'');
        return plus + digits;
    }

    document.addEventListener('DOMContentLoaded', function(){
        const input = document.getElementById('kids_phone');
        if(!input) return;

        input.addEventListener('input', function(e){
            // remember cursor position loosely
            const raw = input.value;
            const formatted = formatPhoneForDisplay(raw);
            input.value = formatted;
            input.setSelectionRange(input.value.length, input.value.length);
        });

        input.addEventListener('blur', function(e){
            input.value = normalizePhoneForSubmit(input.value);
        });

        const kidsForm = document.getElementById('kidsBookingForm');
        if(kidsForm){
            kidsForm.addEventListener('submit', function(){
                try{
                    const el = document.getElementById('kids_phone');
                    if(el) el.value = normalizePhoneForSubmit(el.value);
                }catch(err){/* noop */}
            });
        }
    });
})();
</script>

</body>
</html>


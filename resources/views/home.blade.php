<script>
function selectQuickService(serviceName) {
    const selectedServiceInput = document.getElementById('selectedService');
    const serviceDisplayInput = document.getElementById('serviceDisplay');
    if (selectedServiceInput) {
        selectedServiceInput.value = serviceName;
    }
    if (serviceDisplayInput) {
        serviceDisplayInput.value = serviceName;
    }
    document.querySelectorAll('.service-quick-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    const buttons = Array.from(document.querySelectorAll('.service-quick-btn'));
    const selectedBtn = buttons.find(btn => btn.textContent.trim().startsWith(serviceName));
    if (selectedBtn) {
        selectedBtn.classList.add('active');
    }
    document.getElementById('bookingModalLabel').textContent = `Book ${serviceName}`;
    const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
    if (serviceModal) serviceModal.hide();
    console.log('Quick service selected:', serviceName);
}

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
    document.querySelectorAll('.service-quick-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.getElementById('bookingModalLabel').textContent = `Book ${customService}`;
    const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
    if (serviceModal) serviceModal.hide();
    customInput.value = '';
    console.log('Custom service selected:', customService);
}
</script>
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

        // Hardcoded test dates for August 2025 (for immediate testing)
        const testBookedDates = [
            '2025-08-18', '2025-08-24', '2025-08-25', '2025-08-26',
            '2025-08-28', '2025-08-29', '2025-08-30', '2025-08-31'
        ];

        console.log('Test booked dates loaded:', testBookedDates);

        // Calendar Modal Functions
        window.openCalendarModal = function() {
            console.log('🚀 openCalendarModal() called');

            const calendarModal = new bootstrap.Modal(document.getElementById('calendarModal'));
            calendarModal.show();

            // Set calendar to current month
            calendarCurrentDate = new Date(); // Current date

            // Always fetch fresh data when calendar opens
            console.log('🔄 Fetching fresh booked dates...');
            fetchRealBookedDates();

            // Render calendar with loading state first
            setTimeout(() => {
                console.log('🎨 Starting renderCalendarModal()');
                renderCalendarModal();
            }, 100);
        };

        // Fetch real booked dates from API
        function fetchRealBookedDates() {
            fetch('/api/booked-dates')
                .then(response => response.json())
                .then(data => {
                    console.log('Real API Response:', data);
                    if (data.success) {
                        const realBookedDates = data.booked_dates.filter(booking => booking.disabled).map(booking => booking.date);
                        console.log('Real booked dates from API:', realBookedDates);

                        // Update cache with real data
                        bookedDatesCache = realBookedDates;
                        // Re-render calendar with real data
                        renderCalendarModal();
                    }
                })
                .catch(error => {
                    console.error('Error loading real booked dates:', error);
                    // Keep using test dates if API fails
                });
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
                } else if (bookedDatesCache.includes(dateString)) {
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
                } else {
                    dayDiv.classList.add('available');
                    dayDiv.style.backgroundColor = '#d4edda';
                    dayDiv.style.borderColor = '#c3e6cb';
                    dayDiv.onclick = () => selectCalendarDate(date);
                    console.log(`🟢 Date ${dateString} marked as AVAILABLE (green)`);
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

                // Set the values in the booking form
                document.getElementById('bookingDate').value = formattedDate;
                document.getElementById('appointment_date').value = selectedCalendarDate.toISOString().split('T')[0];
                document.getElementById('appointment_time_hidden').value = selectedCalendarTime.time;

                // Set the time input with the formatted time from modal
                document.getElementById('timeInput').value = selectedCalendarTime.formattedTime;

                // Close calendar modal
                const calendarModal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
                calendarModal.hide();
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
    <!-- Success Modal -->
    @if(session('booking_success'))
    <div class="modal fade show d-block" id="successModal" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 1050; position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                <div class="modal-header text-center border-0 pb-0">
                    <div class="w-100">
                        <div class="text-success mb-3" style="font-size: 4rem; animation: bounce 0.6s ease-in-out;">
                            ✅
                        </div>
                        <h4 class="modal-title text-success mb-0" style="font-weight: 700; font-size: 1.5rem;">Appointment Booked Successfully!</h4>
                    </div>
                </div>
                <div class="modal-body text-center px-4 py-4">
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block mb-1">📋 Booking ID:</small>
                                    <strong class="text-primary">{{ session('booking_details.booking_id') }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light p-3 rounded">
                                    <small class="text-muted d-block mb-1">🔐 Confirmation Code:</small>
                                    <strong class="text-primary">{{ session('booking_details.confirmation_code') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 mb-4" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-left: 4px solid #ffc107;">
                        <div class="d-flex align-items-center justify-content-center">
                            <span style="font-size: 1.2rem; margin-right: 8px;">⚠️</span>
                            <span style="font-weight: 600;">Please contact us to arrange the $20 deposit payment.</span>
                        </div>
                    </div>

                    <div class="contact-info mb-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0"><span style="margin-right: 8px;">📞</span><strong>Phone:</strong><br>(343) 254-8848</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0"><span style="margin-right: 8px;">📧</span><strong>Email:</strong><br>info@dabsbeautytouch.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-muted mb-0" style="font-size: 0.95rem;">We'll confirm your appointment once payment is received!</p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-info px-5 py-2" onclick="closeSuccessModal()" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border: none; border-radius: 25px; font-weight: 600; font-size: 1.1rem; cursor: pointer; z-index: 1051; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">OK</button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        #successModal .modal-content {
            animation: slideInDown 0.5s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @endif

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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white" style="margin-bottom: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); min-height: 80px;">
        <div class="container-fluid py-3">
            <a class="navbar-brand d-flex align-items-center" href="#home">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 60px; margin-right: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <span style="font-weight: bold; font-size: 1.4rem; color: #ff6600;">Dab's Beauty Touch</span>
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
                    <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST" autocomplete="on" novalidate enctype="multipart/form-data">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Additional JavaScript -->
<script>
// MINIMAL WORKING SOLUTION - FORCE OVERRIDE ALL CONFLICTS
                // Show custom floating card success message
                if (!document.getElementById('floatingSuccessCard')) {
                    const card = document.createElement('div');
                    card.id = 'floatingSuccessCard';
                    card.innerHTML = `
                        <div style="position: fixed; top: 40px; right: 40px; z-index: 9999; background: linear-gradient(135deg, #10b981 0%, #20c997 100%); color: white; box-shadow: 0 8px 32px rgba(16,185,129,0.25); border-radius: 18px; padding: 32px 36px 28px 36px; min-width: 320px; max-width: 90vw; display: flex; flex-direction: column; align-items: center; animation: fadeInDown 0.7s;">
                            <div style="background: white; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; box-shadow: 0 2px 8px rgba(16,185,129,0.15);">
                                <i class='bi bi-check2-circle' style='color: #10b981; font-size: 2rem;'></i>
                            </div>
                            <h4 style="margin-bottom: 10px; font-weight: 700; letter-spacing: 0.5px;">Appointment Booked!</h4>
                            <div style="font-size: 1.1rem; margin-bottom: 8px;">Thank you for booking with Dab's Beauty Touch.</div>
                            <div style="font-size: 0.98rem; color: #e0f7ef; margin-bottom: 10px;">We'll confirm your appointment once payment is received.</div>
                            <button id="closeSuccessCardBtn" style="margin-top: 10px; background: #fff; color: #10b981; border: none; border-radius: 8px; padding: 8px 22px; font-weight: 600; font-size: 1rem; cursor: pointer; box-shadow: 0 2px 8px rgba(16,185,129,0.10); transition: background 0.2s;">OK</button>
                        </div>
                        <style>
                        @keyframes fadeInDown {
                            from { opacity: 0; transform: translateY(-40px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                        </style>
                    `;
                    document.body.appendChild(card);
                    document.getElementById('closeSuccessCardBtn').onclick = function() {
                        card.remove();
                    };
                    setTimeout(() => { if (document.getElementById('floatingSuccessCard')) card.remove(); }, 7000);
                }
        if (form) {
            form.reset();
            console.log('Form cleared');
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
            console.log('=== SUBMIT EVENT HANDLER TRIGGERED ===');
            console.log('Event object:', e);
            console.log('Calling preventDefault()...');
            e.preventDefault();
            console.log('Calling stopPropagation()...');
            e.stopPropagation();
            console.log('Event prevention complete - form should NOT submit normally');

            console.log('=== FORM SUBMISSION STARTED ===');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);

            // Log all form field values for debugging
            const debugFormData = new FormData(this);
            console.log('=== FORM DATA ===');
            for (let [key, value] of debugFormData.entries()) {
                console.log(`${key}: ${value}`);
            }

            // Log all field values specifically
            console.log('=== FIELD VALUES ===');
            console.log('name:', document.getElementById('name')?.value);
            console.log('phone:', document.getElementById('phone')?.value);
            console.log('email:', document.getElementById('email')?.value);
            console.log('bookingDate:', document.getElementById('bookingDate')?.value);
            console.log('timeInput:', document.getElementById('timeInput')?.value);
            console.log('appointment_date (hidden):', document.getElementById('appointment_date')?.value);
            console.log('appointment_time (hidden):', document.getElementById('appointment_time_hidden')?.value);
            console.log('selectedService:', document.getElementById('selectedService')?.value);

        // Basic form validation
        console.log('=== STARTING VALIDATION ===');
        const requiredFields = ['name', 'phone', 'bookingDate', 'timeInput'];
        const missingFields = [];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            const fieldValue = field ? field.value.trim() : '';
            console.log(`Checking field ${fieldId}: "${fieldValue}"`);
            if (!field || !fieldValue) {
                missingFields.push(fieldId);
                console.log(`❌ Field ${fieldId} is missing or empty`);
            } else {
                console.log(`✅ Field ${fieldId} is valid`);
            }
        });

        if (missingFields.length > 0) {
            console.log('❌ Validation failed - missing fields:', missingFields);
            alert('Please fill in all required fields: ' + missingFields.join(', '));
            return;
        }
        console.log('✅ Required fields validation passed');

        // Validate email format if provided
        console.log('=== EMAIL VALIDATION ===');
        const emailField = document.getElementById('email');
        if (emailField && emailField.value.trim()) {
            const emailValue = emailField.value.trim();
            console.log('Email value:', emailValue);
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailValue)) {
                console.log('❌ Email validation failed');
                alert('Please enter a valid email address');
                return;
            }
            console.log('✅ Email validation passed');
        } else {
            console.log('✅ Email field empty or not found - skipping validation');
        }

        // Validate phone format
        console.log('=== PHONE VALIDATION ===');
        const phoneField = document.getElementById('phone');
        if (phoneField && phoneField.value.trim()) {
            const phoneValue = phoneField.value.trim();
            console.log('Phone value:', phoneValue);
            const phoneRegex = /^[\d\s\-\(\)\+]{10,}$/;
            if (!phoneRegex.test(phoneValue)) {
                console.log('❌ Phone validation failed');
                alert('Please enter a valid phone number (at least 10 digits)');
                return;
            }
            console.log('✅ Phone validation passed');
        } else {
            console.log('❌ Phone field is required but empty');
            alert('Phone number is required');
            return;
        }

        // Check if date is not in the past
        console.log('=== DATE VALIDATION ===');
        const bookingDate = document.getElementById('bookingDate');
        const appointmentDate = document.getElementById('appointment_date');
        const selectedDate = appointmentDate ? appointmentDate.value : null;
        console.log('bookingDate field value:', bookingDate?.value);
        console.log('appointment_date hidden field value:', selectedDate);

        if (selectedDate) {
            const selected = new Date(selectedDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            console.log('Selected date:', selected);
            console.log('Today:', today);

            if (selected < today) {
                console.log('❌ Date validation failed - date is in the past');
                alert('Please select a future date for your appointment');
                return;
            }
            console.log('✅ Date validation passed');
        } else {
            console.log('❌ Date validation failed - no date selected');
            alert('Please select an appointment date');
            return;
        }

        // Validate time format
        console.log('=== TIME VALIDATION ===');
        const timeHidden = document.getElementById('appointment_time_hidden');
        const timeValue = timeHidden ? timeHidden.value : null;
        console.log('appointment_time_hidden value:', timeValue);

        if (timeValue) {
            const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
            if (!timeRegex.test(timeValue)) {
                console.log('❌ Time validation failed - invalid format');
                alert('Invalid time format. Please select a time from the calendar modal.');
                return;
            }
            console.log('✅ Time validation passed');
        } else {
            console.log('❌ Time validation failed - no time selected');
            alert('Please select an appointment time');
            return;
        }

        // Check if time and date were selected via modal
        const timeInput = document.getElementById('timeInput');
        // timeHidden already declared above
        // bookingDate already declared above
        // appointmentDate already declared above

        if (!timeInput || !timeInput.value) {
            alert('Please select appointment time using the calendar modal');
            return;
        }

        if (!bookingDate || !bookingDate.value) {
            alert('Please select appointment date using the calendar modal');
            return;
        }

        // Values should already be set by the modal, just ensure they're in the hidden fields
        if (timeHidden && !timeHidden.value) {
            timeHidden.value = timeInput.value; // This should already be in 24-hour format from modal
        }

        if (appointmentDate && !appointmentDate.value) {
            appointmentDate.value = bookingDate.value;
        }

        console.log('Date set:', bookingDate.value);
        console.log('Time set:', timeInput.value);

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
        submitBtn.disabled = true;

        // Get form data
        const formData = new FormData(this);

        // Log form data for debugging
        console.log('Form data being sent:');
        console.log('Name:', formData.get('name'));
        console.log('Email:', formData.get('email'));
        console.log('Phone:', formData.get('phone'));
        console.log('Service:', formData.get('service'));
        console.log('Appointment Date:', formData.get('appointment_date'));
        console.log('Appointment Time:', formData.get('appointment_time'));
        console.log('Notes:', formData.get('notes'));
        console.log('CSRF Token:', formData.get('_token'));
        console.log('Sample Picture File:', formData.get('sample_picture'));
        console.log('Sample Picture File Name:', formData.get('sample_picture') ? formData.get('sample_picture').name : 'No file');

        // Validate critical fields before sending
        if (!formData.get('appointment_date')) {
            // Set default date if none selected, but warn user
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const defaultDate = tomorrow.toISOString().split('T')[0];

            // Update the hidden field
            document.getElementById('appointment_date').value = defaultDate;
            formData.set('appointment_date', defaultDate);

            console.warn('No appointment date selected, using default:', defaultDate);
        }

        if (!formData.get('appointment_time')) {
            // Set default time if none selected
            const defaultTime = '09:00';
            document.getElementById('appointment_time_hidden').value = defaultTime;
            formData.set('appointment_time', defaultTime);

            console.warn('No appointment time selected, using default:', defaultTime);
        }

        if (!formData.get('_token')) {
            alert('Missing security token. Please refresh the page and try again.');
            return;
        }

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

        // Submit via AJAX with improved error handling
        console.log('=== PREPARING AJAX SUBMISSION ===');
        const csrfToken = getCSRFToken();
        console.log('CSRF Token:', csrfToken);

        // Ensure the form action uses HTTPS in production
        let actionUrl = this.action;
        if (window.location.protocol === 'https:' && actionUrl.startsWith('http:')) {
            actionUrl = actionUrl.replace('http:', 'https:');
        }
        console.log('Action URL:', actionUrl);

        // Add a timeout to the fetch request
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout

        console.log('=== STARTING FETCH REQUEST ===');
        console.log('Method: POST');
        console.log('URL:', actionUrl);
        console.log('Has FormData:', formData instanceof FormData);
        console.log('About to call fetch()...');

        fetch(actionUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Cache-Control': 'no-cache'
            },
            signal: controller.signal,
            credentials: 'same-origin'
        })
        .then(response => {
            clearTimeout(timeoutId); // Clear the timeout
            console.log('=== FETCH RESPONSE RECEIVED ===');
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            console.log('Response headers:', response.headers);

            // For debugging - log the raw response text
            return response.text().then(text => {
                console.log('Raw response:', text);
                try {
                    const data = JSON.parse(text);
                    return { ok: response.ok, status: response.status, data: data };
                } catch (e) {
                    console.error('Failed to parse JSON response:', e);
                    throw new Error(`Server returned invalid JSON. Status: ${response.status}, Response: ${text.substring(0, 200)}...`);
                }
            });
        })
        .then(({ ok, status, data }) => {
            console.log('Parsed response data:', data);

            if (!ok) {
                // Handle different HTTP status codes
                if (status === 422) {
                    // Validation errors
                    let errorMessage = 'Validation failed:\n\n';
                    if (data.errors) {
                        // Laravel validation errors format
                        Object.keys(data.errors).forEach(field => {
                            const fieldErrors = data.errors[field];
                            errorMessage += `• ${field}: ${fieldErrors.join(', ')}\n`;
                        });
                    } else if (data.message) {
                        errorMessage += data.message;
                    } else {
                        errorMessage += 'Please check your form data and try again.';
                    }
                    throw new Error(errorMessage);
                } else if (status === 419) {
                    // Token expired - try to refresh and retry
                    throw new Error('CSRF_TOKEN_EXPIRED');
                } else if (status === 500) {
                    throw new Error(data.message || 'Server error occurred. Please try again later.');
                } else {
                    throw new Error(data.message || `HTTP error! status: ${status}`);
                }
            }

            return data;
        })
        .then(data => {
            console.log('=== RESPONSE RECEIVED ===');
            console.log('Response data:', data);
            console.log('data.success value:', data.success);
            console.log('typeof data.success:', typeof data.success);

            if (data.success) {
                console.log('=== SUCCESS CONDITION MET ===');
                console.log('Full data object:', data);
                console.log('Data.appointment:', data.appointment);
                
                // Show styled success modal
                const bookingId = data.appointment ? data.appointment.booking_id : 'N/A';
                const confirmationCode = data.appointment ? data.appointment.confirmation_code : 'N/A';
                const service = data.appointment ? data.appointment.service : 'General Service';
                const appointmentDate = data.appointment ? data.appointment.appointment_date : 'N/A';
                const appointmentTime = data.appointment ? data.appointment.appointment_time : 'N/A';

                // Update modal content with actual booking data
                console.log('=== UPDATING SUCCESS MODAL ===');
                console.log('Booking ID:', bookingId);
                console.log('Confirmation Code:', confirmationCode);
                console.log('Service:', service);
                console.log('Date:', appointmentDate);
                console.log('Time:', appointmentTime);

                // Show the AJAX success modal using Bootstrap's JS API
                let successModalElement = document.getElementById('ajaxSuccessModal');
                if (successModalElement) {
                    console.log('Found ajaxSuccessModal, updating content...');
                    
                    // Update modal content with booking details
                    const bookingIdElement = document.getElementById('successBookingId');
                    const confirmationCodeElement = document.getElementById('successConfirmationCode');
                    const serviceElement = document.getElementById('successService');
                    const dateElement = document.getElementById('successAppointmentDate');
                    const timeElement = document.getElementById('successAppointmentTime');
                    
                    // Update content immediately
                    if (bookingIdElement) {
                        bookingIdElement.textContent = bookingId;
                        console.log('Updated booking ID to:', bookingId);
                    }
                    if (confirmationCodeElement) {
                        confirmationCodeElement.textContent = confirmationCode;
                        console.log('Updated confirmation code to:', confirmationCode);
                    }
                    if (serviceElement) {
                        serviceElement.textContent = service;
                        console.log('Updated service to:', service);
                    }
                    if (dateElement) {
                        dateElement.textContent = appointmentDate;
                        console.log('Updated date to:', appointmentDate);
                    }
                    if (timeElement) {
                        timeElement.textContent = appointmentTime;
                        console.log('Updated time to:', appointmentTime);
                    }
                    
                    // Show modal using Bootstrap 5
                    let modalInstance = bootstrap.Modal.getOrCreateInstance(successModalElement);
                    modalInstance.show();
                    // Force modal to be visible for debugging
                    successModalElement.style.display = 'block';
                    successModalElement.classList.add('show');
                    successModalElement.style.opacity = '1';
                    successModalElement.style.zIndex = '9999';
                    // Add a temporary debug message
                    let debugMsg = document.createElement('div');
                    debugMsg.innerHTML = '<div style="background: #ff0; color: #000; padding: 12px; font-size: 18px; text-align: center; border: 2px solid #f00; margin-bottom: 10px;">DEBUG: Success Modal is now forced visible!</div>';
                    debugMsg.id = 'modalDebugMsg';
                    let modalBody = successModalElement.querySelector('.modal-body');
                    if (modalBody && !document.getElementById('modalDebugMsg')) {
                        modalBody.prepend(debugMsg);
                    }
                    
                    // Add event listener to ensure content is updated after modal is shown
                    const modalShownHandler = function() {
                        console.log('Modal shown, ensuring content is updated...');
                        // Double-check content is set
                        if (bookingIdElement) bookingIdElement.textContent = bookingId;
                        if (confirmationCodeElement) confirmationCodeElement.textContent = confirmationCode;
                        if (serviceElement) serviceElement.textContent = service;
                        if (dateElement) dateElement.textContent = appointmentDate;
                        if (timeElement) timeElement.textContent = appointmentTime;
                        
                        // Remove the event listener to prevent multiple calls
                        successModalElement.removeEventListener('shown.bs.modal', modalShownHandler);
                    };
                    
                    successModalElement.addEventListener('shown.bs.modal', modalShownHandler);
                    
                    // Add a fallback timeout to ensure content is set
                    setTimeout(() => {
                        if (bookingIdElement) bookingIdElement.textContent = bookingId;
                        if (confirmationCodeElement) confirmationCodeElement.textContent = confirmationCode;
                        if (serviceElement) serviceElement.textContent = service;
                        if (dateElement) dateElement.textContent = appointmentDate;
                        if (timeElement) timeElement.textContent = appointmentTime;
                        console.log('Fallback content update completed');
                    }, 300);
                    
                    console.log('AJAX Success modal shown!');
                } else {
                    console.error('CRITICAL: ajaxSuccessModal not found!');
                    // Fallback: show a simple success message
                    alert('Appointment booked successfully! Booking ID: ' + bookingId);
                }
                // Refresh the calendar data since a new booking was added
                console.log('🔄 Refreshing calendar data after successful booking');
                setTimeout(() => {
                    fetchRealBookedDates();
                }, 500); // Small delay to ensure booking is saved

                // Clear the form completely
                this.reset();

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
                if (bookingModal) {
                    bookingModal.hide();
                }
                
                // Also close any other open modals
                const serviceSelectionModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
                if (serviceSelectionModal) {
                    serviceSelectionModal.hide();
                }
                
                const calendarModal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
                if (calendarModal) {
                    calendarModal.hide();
                }

                // Force browser to clear form cache
                this.setAttribute('autocomplete', 'off');
            } else {
                // Show error message without page reload
                let errorMessage = 'Something went wrong. Please try again.';
                if (data.message) {
                    errorMessage = data.message;
                } else if (data.errors) {
                    errorMessage = Object.values(data.errors).flat().join(', ');
                }
                
                // Show error in a more user-friendly way
                showErrorMessage(errorMessage);
            }
        })
        .catch(error => {
            clearTimeout(timeoutId); // Clear the timeout
            console.log('=== FETCH ERROR OCCURRED ===');
            console.error('Network or parsing error:', error);
            console.log('Error type:', error.constructor.name);
            console.log('Error message:', error.message);
            console.log('Error stack:', error.stack);

            // Handle CSRF token expiration
            if (error.message === 'CSRF_TOKEN_EXPIRED') {
                console.log('CSRF token expired, attempting to refresh and retry...');

                // Reset button state temporarily
                submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Refreshing...';

                // Refresh CSRF token and retry
                window.refreshCSRFToken()
                    .then(newToken => {
                        if (newToken) {
                            console.log('Token refreshed, retrying submission...');
                            submitBtn.innerHTML = originalText;
                            // Retry the form submission
                            e.target.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
                        } else {
                            throw new Error('Failed to refresh CSRF token');
                        }
                    })
                    .catch(refreshError => {
                        console.error('Token refresh failed:', refreshError);
                        alert('Session expired. Please refresh the page and try again.');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
                return; // Exit early for token refresh
            }

            let errorMessage = 'An error occurred while submitting your appointment:';

            if (error.name === 'AbortError') {
                errorMessage += '\n\nRequest timed out. This may be due to a slow connection.';
            } else if (error.message && error.message.includes('Failed to fetch')) {
                errorMessage += '\n\nUnable to connect to the server. This may be due to:';
                errorMessage += '\n• Network connectivity issues';
                errorMessage += '\n• Server maintenance';
                errorMessage += '\n• Firewall or security software blocking the request';
            } else if (error.message) {
                errorMessage += '\n\n' + error.message;
            } else {
                errorMessage += '\n\nPlease check your internet connection and try again.';
            }

            // Add helpful suggestions
            errorMessage += '\n\nTips:\n• Make sure all required fields are filled\n• Check that your email format is valid\n• Ensure your phone number is complete\n• Try refreshing the page if the issue persists';
            errorMessage += '\n\nIf the problem continues, please call us at (647) 834-8549';

            alert(errorMessage);

            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
        }); // End of form.addEventListener('submit')
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

    const contactForm = document.querySelector('form[action*="contact.store"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // You can add client-side validation here if needed
            console.log('Contact form submitted');
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

<!-- AJAX Success Modal -->
<div class="modal fade" id="ajaxSuccessModal" tabindex="-1" aria-labelledby="ajaxSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 550px;">
        <div class="modal-content" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%); color: white; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <!-- Header -->
            <div class="modal-header border-0 text-center pb-0" style="background: transparent;">
                <div class="w-100">
                    <div class="text-success mb-3" style="font-size: 4rem; animation: bounce 0.6s ease-in-out;">
                        ✅
                    </div>
                    <h4 class="modal-title text-success mb-0" style="font-weight: 700; font-size: 1.5rem;">Appointment Booked Successfully!</h4>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 20px; opacity: 0.8;"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center px-4 py-4">

                <!-- Booking Details -->
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <small class="text-muted d-block mb-1" style="color: #cbd5e0 !important;">📋 Booking ID:</small>
                                <strong class="text-primary" id="successBookingId" style="color: #60a5fa !important;">BK000024</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <small class="text-muted d-block mb-1" style="color: #cbd5e0 !important;">🔐 Confirmation Code:</small>
                                <strong class="text-primary" id="successConfirmationCode" style="color: #34d399 !important;">CONFEAB923BD</strong>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <small class="text-muted d-block mb-1" style="color: #cbd5e0 !important;">✂️ Service:</small>
                                <strong class="text-primary" id="successService" style="color: #f87171 !important;">Hair Styling</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <small class="text-muted d-block mb-1" style="color: #cbd5e0 !important;">📅 Date:</small>
                                <strong class="text-primary" id="successAppointmentDate" style="color: #a78bfa !important;">August 18, 2025</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <small class="text-muted d-block mb-1" style="color: #cbd5e0 !important;">🕐 Time:</small>
                                <strong class="text-primary" id="successAppointmentTime" style="color: #fbbf24 !important;">2:00 PM</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deposit Warning -->
                <div class="alert alert-warning border-0 mb-4" style="background: linear-gradient(135deg, rgba(251, 146, 60, 0.2) 0%, rgba(245, 158, 11, 0.2) 100%); border-left: 4px solid #f59e0b;">
                    <div class="d-flex align-items-center justify-content-center">
                        <span style="font-size: 1.2rem; margin-right: 8px;">⚠️</span>
                        <span style="font-weight: 600; color: #fed7aa;">Please contact us to arrange the $20 deposit payment.</span>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="contact-info mb-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <p class="mb-0"><span style="margin-right: 8px;">📞</span><strong>Phone:</strong><br>(343) 254-8848</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-3 rounded" style="background: rgba(255, 255, 255, 0.1) !important;">
                                <p class="mb-0"><span style="margin-right: 8px;">📧</span><strong>Email:</strong><br>info@dabsbeautytouch.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-muted mb-0" style="font-size: 0.95rem; color: #cbd5e0;">We'll confirm your appointment once payment is received!</p>

            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-info px-5 py-2" data-bs-dismiss="modal" onclick="handleSuccessModalClose()" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); border: none; border-radius: 25px; font-weight: 600; font-size: 1.1rem; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to enhance booking success message visibility -->
<script>
        // Function to show error messages in a user-friendly way
        function showErrorMessage(message) {
            // Create a temporary error alert
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
            errorAlert.innerHTML = `
                <strong>Booking Error</strong><br>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(errorAlert);
            
            // Auto-remove after 8 seconds
            setTimeout(() => {
                if (errorAlert.parentNode) {
                    errorAlert.remove();
                }
            }, 8000);
        }

        // Function to handle success modal close
        function handleSuccessModalClose() {
            const successModal = document.getElementById('ajaxSuccessModal');
            if (successModal) {
                const modalInstance = bootstrap.Modal.getInstance(successModal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }
            
            // Optionally, you can add logic here to reset the form or show the booking modal again
            // For example, to allow users to make another booking:
            // setTimeout(() => {
            //     const bookingModal = document.getElementById('bookingModal');
            //     if (bookingModal) {
            //         const modalInstance = bootstrap.Modal.getOrCreateInstance(bookingModal);
            //         modalInstance.show();
            //     }
            // }, 500);
        }

        // Test function to manually trigger the success modal
        window.testSuccessModal = function() {
    console.log('Testing success modal...');
    const successModalElement = document.getElementById('ajaxSuccessModal');
    if (successModalElement) {
        console.log('Modal found, updating with test data...');
        
        // Update with test data
        const bookingIdElement = document.getElementById('successBookingId');
        const confirmationCodeElement = document.getElementById('successConfirmationCode');
        const serviceElement = document.getElementById('successService');
        const dateElement = document.getElementById('successAppointmentDate');
        const timeElement = document.getElementById('successAppointmentTime');
        
        if (bookingIdElement) bookingIdElement.textContent = 'TEST-BK-001';
        if (confirmationCodeElement) confirmationCodeElement.textContent = 'TEST-CONF-123';
        if (serviceElement) serviceElement.textContent = 'Test Service';
        if (dateElement) dateElement.textContent = 'Test Date';
        if (timeElement) timeElement.textContent = 'Test Time';
        
        // Show modal
        const modalInstance = bootstrap.Modal.getOrCreateInstance(successModalElement);
        modalInstance.show();
        console.log('Test modal should be visible now');
    } else {
        console.error('Modal not found!');
    }
};

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

        // Auto close modal after 5 seconds
        setTimeout(function() {
            console.log('Auto-closing success modal after timeout');
            closeSuccessModal();
        }, 10000); // 10 seconds
    }
});

// Function to close success modal
function closeSuccessModal() {
    console.log('closeSuccessModal called'); // Debug log
    const successModal = document.getElementById('successModal');
    if (successModal) {
        console.log('Success modal found, hiding it'); // Debug log
        
        // Add fade-out effect
        successModal.style.opacity = '0';
        successModal.style.transition = 'opacity 0.3s ease';
        
        // Hide modal after fade animation
        setTimeout(function() {
            successModal.style.display = 'none';
            
            // Remove modal from DOM
            if (successModal.parentNode) {
                successModal.parentNode.removeChild(successModal);
            }
            
            // Clear session data
            fetch('/clear-session', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(function(response) {
                if (response.ok) {
                    console.log('Session cleared successfully'); // Debug log
                    // Update URL to remove any query parameters
                    if (window.history && window.history.replaceState) {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                } else {
                    console.log('Session clear request failed with status:', response.status);
                }
            }).catch(function(error) {
                console.log('Session clear request failed:', error);
            });
        }, 300);
    } else {
        console.log('Success modal not found'); // Debug log
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
        
        // Add click outside modal to close functionality
        const successModal = document.getElementById('successModal');
        if (successModal) {
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    console.log('Modal background clicked, closing modal');
                    closeSuccessModal();
                }
            });
        }
        
        // Add escape key functionality
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && successModal && successModal.style.display !== 'none') {
                console.log('Escape key pressed, closing modal');
                closeSuccessModal();
            }
        });
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
<script>
// Make openServiceSelectionModal globally available
function openServiceSelectionModal() {
    const serviceModal = new bootstrap.Modal(document.getElementById('serviceSelectionModal'));
    serviceModal.show();
}
</script>
</body>
</html>


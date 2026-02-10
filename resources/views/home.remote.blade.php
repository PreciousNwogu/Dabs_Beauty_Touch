<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>Dab's Beauty Touch - Professional Hair Braiding Services | Ottawa</title>
    <meta name="title" content="Dab's Beauty Touch - Professional Hair Braiding Services | Ottawa">
    <meta name="description" content="Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, cornrow styles, and custom braiding services. Book your appointment today for flawless, long-lasting results.">
    <meta name="keywords" content="hair braiding Ottawa, knotless braids, box braids, cornrow braids, hair styling, professional braiding services, Ottawa hair salon, braiding salon">
    <meta name="author" content="Dab's Beauty Touch">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Dab's Beauty Touch - Professional Hair Braiding Services | Ottawa">
    <meta property="og:description" content="Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, cornrow styles, and custom braiding services. Book your appointment today.">
    <meta property="og:image" content="{{ asset('images/logo.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Dab's Beauty Touch">
    <meta property="og:locale" content="en_CA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="Dab's Beauty Touch - Professional Hair Braiding Services">
    <meta name="twitter:description" content="Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, cornrow styles, and custom braiding services.">
    <meta name="twitter:image" content="{{ asset('images/logo.jpg') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon.ico.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon.ico.jpg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/icon.ico.jpg') }}">
    <meta name="msapplication-TileImage" content="{{ asset('images/icon.ico.jpg') }}">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BeautySalon",
        "name": "Dab's Beauty Touch",
        "description": "Professional hair braiding services in Ottawa. Expert stylists specializing in knotless braids, box braids, cornrow styles, and custom braiding services.",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.jpg') }}",
        "image": "{{ asset('images/logo.jpg') }}",
        "telephone": "(647) 834-8549",
        "priceRange": "$$",
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "Ottawa",
            "addressRegion": "ON",
            "addressCountry": "CA"
        },
        "geo": {
            "@@type": "GeoCoordinates",
            "latitude": "45.4215",
            "longitude": "-75.6972"
        },
        "openingHoursSpecification": [
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens": "08:00",
                "closes": "20:00"
            },
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": "Saturday",
                "opens": "10:00",
                "closes": "20:00"
            },
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": "Sunday",
                "opens": "13:00",
                "closes": "20:00"
            }
        ],
        "sameAs": [],
        "aggregateRating": {
            "@@type": "AggregateRating",
            "ratingValue": "5",
            "reviewCount": "4"
        },
        "review": [
            {
                "@@type": "Review",
                "author": {
                    "@@type": "Person",
                    "name": "Client 1"
                },
                "reviewRating": {
                    "@@type": "Rating",
                    "ratingValue": "5"
                },
                "reviewBody": "DBT offers great services and she delivers excellently."
            },
            {
                "@@type": "Review",
                "author": {
                    "@@type": "Person",
                    "name": "Client 2"
                },
                "reviewRating": {
                    "@@type": "Rating",
                    "ratingValue": "5"
                },
                "reviewBody": "Excellent service and attention to detail."
            },
            {
                "@@type": "Review",
                "author": {
                    "@@type": "Person",
                    "name": "Client 3"
                },
                "reviewRating": {
                    "@@type": "Rating",
                    "ratingValue": "5"
                },
                "reviewBody": "Amazing work! Highly recommend."
            },
            {
                "@@type": "Review",
                "author": {
                    "@@type": "Person",
                    "name": "Client 4"
                },
                "reviewRating": {
                    "@@type": "Rating",
                    "ratingValue": "5"
                },
                "reviewBody": "Best braiding service in Ottawa!"
            }
        ],
        "hasOfferCatalog": {
            "@@type": "OfferCatalog",
            "name": "Hair Braiding Services",
            "itemListElement": [
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Small Knotless Braids",
                        "description": "Ultra-fine knotless braids that blend seamlessly with your natural hair. Perfect for a sleek, professional look."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Smedium Knotless Braids",
                        "description": "Medium-sized knotless braids offering the perfect balance between style and manageability."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Medium Knotless Braids",
                        "description": "Classic medium-sized knotless braids for a timeless look."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Jumbo Knotless Braids",
                        "description": "Bold, statement-making jumbo knotless braids for a dramatic look."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Kids Braids",
                        "description": "Specialized braiding services for children with gentle techniques."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Stitch Braids",
                        "description": "Elegant 8-row stitch braids for a sophisticated style."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Hair Mask/Relaxing",
                        "description": "Deep conditioning and relaxing treatments for healthy, manageable hair."
                    }
                },
                {
                    "@@type": "Offer",
                    "itemOffered": {
                        "@@type": "Service",
                        "name": "Boho Braids",
                        "description": "Trendy boho-style braids for a free-spirited, bohemian look."
                    }
                }
            ]
        }
    }
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <!-- Bootstrap CDN (backup) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .about-section {
                padding: 40px 0;
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
            padding: 50px 0;
            background-color: #fff;
        }

        @media (max-width: 768px) {
            .contact-section {
                padding: 40px 0;
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
            padding: 50px 0;
            background-color: #f8f9fa;
        }

        /* Services Section Mobile Styles */
        @media (max-width: 768px) {
            .services-section {
                padding: 40px 0;
            }

            .services-section .container {
                padding: 0 15px;
            }

            .services-section h2 {
                font-size: 2rem;
                text-align: center;
                margin-bottom: 1.5rem;
            }

            .services-section .lead {
                font-size: 1.1rem;
                text-align: center;
                margin-bottom: 2rem;
            }

            .services-section .row {
                margin-left: -6px;
                margin-right: -6px;
            }

            .services-section .row > * {
                padding-left: 6px;
                padding-right: 6px;
            }
            
            /* Hide extra services on mobile initially */
            .services-section .service-item.hidden-mobile {
                display: none !important;
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

        /* Filter Chip Styles */
        .filter-chip {
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 2px solid #030f68;
            color: #030f68;
        }
        .filter-chip:hover {
            background-color: #030f68;
            color: white;
        }
        .filter-chip.active {
            background-color: #030f68;
            color: white;
            border-color: #030f68;
        }

        /* Service Item Animation */
        .service-item {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .service-item.hidden {
            display: none !important;
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

        /* Service Card Mobile Improvements - Two Column Layout */
        @media (max-width: 768px) {
            .service-card {
                margin-bottom: 16px;
                padding: 20px 12px 18px 12px;
                border-radius: 14px;
                box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            }

            .service-card:hover {
                transform: translateY(-2px) scale(1.01);
            }

            .service-card img {
                width: 100%;
                max-width: 140px;
                height: 140px;
                margin-bottom: 12px;
                border: 3px solid #fff;
            }

            .service-card h4 {
                font-size: 1.1rem;
                margin-bottom: 8px;
                line-height: 1.3;
            }

            .service-card p {
                font-size: 0.85rem;
                margin-bottom: 8px;
                line-height: 1.4;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .service-card .price {
                font-size: 0.95rem;
                margin-top: 8px;
                margin-bottom: 10px;
            }

            .service-card .btn {
                width: 100%;
                padding: 8px 16px;
                font-size: 0.9rem;
                font-weight: 600;
                border-radius: 6px;
            }
        }

        @media (max-width: 576px) {
            .service-card {
                padding: 18px 10px 16px 10px;
                margin-bottom: 12px;
                border-radius: 12px;
            }

            .service-card img {
                max-width: 120px;
                height: 120px;
                margin-bottom: 10px;
            }

            .service-card h4 {
                font-size: 1rem;
                margin-bottom: 6px;
            }

            .service-card p {
                font-size: 0.8rem;
                margin-bottom: 6px;
                -webkit-line-clamp: 2;
            }

            .service-card .price {
                font-size: 0.9rem;
                margin-top: 6px;
                margin-bottom: 8px;
            }

            .service-card .btn {
                padding: 7px 14px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 400px) {
            .service-card {
                padding: 16px 8px 14px 8px;
            }

            .service-card img {
                max-width: 100px;
                height: 100px;
                margin-bottom: 8px;
            }

            .service-card h4 {
                font-size: 0.95rem;
            }

            .service-card p {
                font-size: 0.75rem;
                -webkit-line-clamp: 2;
            }

            .service-card .price {
                font-size: 0.85rem;
            }

            .service-card .btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
        }

        /* Image Slider Mobile Improvements */
        @media (max-width: 768px) {
            .image-slider-section {
                padding: 40px 0 !important;
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
            background: linear-gradient(180deg, #dc3545 0%, #c82333 100%) !important;
            color: #ffffff !important;
            cursor: not-allowed !important;
            opacity: 1 !important;
            position: relative;
            pointer-events: none !important;
            border: 2px solid #a71e2a !important;
            font-weight: 600;
        }

        .calendar-day .blocked-text {
            font-size: 0.65rem;
            margin-top: 4px;
            line-height: 1.1;
            max-width: 100%;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            color: #ffffff;
            font-weight: 500;
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

        /* Mobile responsive styles for calendar */
        @media (max-width: 767.98px) {
            #calendarModal .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
                max-height: calc(100vh - 1rem);
            }

            #calendarModal .modal-content {
                border-radius: 12px;
                max-height: calc(100vh - 1rem);
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            #calendarModal .modal-body {
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            #calendarModal .modal-header {
                padding: 1rem;
            }

            #calendarModal .modal-header .modal-title {
                font-size: 1rem;
            }

            #calendarModal .modal-body {
                padding: 1rem;
            }

            /* Calendar navigation - stack buttons on mobile */
            #calendarModal .row.align-items-center {
                flex-direction: column;
                gap: 0.5rem;
            }

            #calendarModal .row.align-items-center .col-md-4 {
                width: 100%;
                text-align: center;
            }

            #calendarModal .row.align-items-center .col-md-4:first-child {
                order: 2;
            }

            #calendarModal .row.align-items-center .col-md-4:nth-child(2) {
                order: 1;
            }

            #calendarModal .row.align-items-center .col-md-4:last-child {
                order: 3;
            }

            #calendarModal .row.align-items-center .btn {
                width: 100%;
                max-width: 200px;
                padding: 0.5rem 1rem;
            }

            #calendarModal #calendarMonth {
                font-size: 1.1rem;
                margin: 0.5rem 0;
            }

            /* Calendar grid - smaller gaps and padding on mobile */
            .calendar-grid {
                padding: 12px 0 0 0;
                gap: 4px;
            }

            /* Calendar day cells - smaller on mobile */
            .calendar-day {
                min-height: 40px;
                padding: 6px 4px;
                font-size: 0.75rem;
            }

            .calendar-day .blocked-text {
                font-size: 0.55rem;
                margin-top: 2px;
            }

            /* Time slots container */
            #timeSlotsContainer {
                margin-top: 1rem;
            }

            #timeSlotsContainer h6 {
                font-size: 0.95rem;
                margin-bottom: 0.75rem;
            }

            .time-slot-btn {
                min-height: 50px;
                font-size: 0.875rem;
                padding: 0.5rem;
            }

            /* Modal footer buttons on mobile */
            #calendarModal .modal-footer {
                flex-direction: column;
                gap: 0.5rem;
                padding: 1rem;
            }

            #calendarModal .modal-footer .btn {
                width: 100%;
                margin: 0;
            }
        }

        /* Extra small devices */
        @media (max-width: 575.98px) {
            .calendar-day {
                min-height: 35px;
                padding: 4px 2px;
                font-size: 0.7rem;
            }

            .calendar-grid {
                gap: 2px;
            }

            #calendarModal .modal-body {
                padding: 0.75rem;
            }
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

        /* Fix checkbox/label overlap when using Bootstrap .form-check with flex */
        #bookingModal .form-check.d-flex,
        #kidsBookingModal .form-check.d-flex {
            padding-left: 0 !important;
        }
        #bookingModal .form-check.d-flex .form-check-input,
        #kidsBookingModal .form-check.d-flex .form-check-input {
            margin-left: 0 !important;
            margin-right: 10px !important;
            margin-top: 0.2rem;
            flex: 0 0 auto;
        }

        /* Terms checkbox row: grid layout to guarantee no overlap */
        #bookingModal .dbt-terms-consent,
        #kidsBookingModal .dbt-terms-consent {
            display: grid;
            grid-template-columns: 22px 1fr;
            column-gap: 12px;
            align-items: start;
            width: 100%;
            max-width: 100%;
            justify-content: start;
            padding: 0 10px;
            box-sizing: border-box;
        }
        #bookingModal .dbt-terms-consent input[type="checkbox"],
        #kidsBookingModal .dbt-terms-consent input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 0.25rem 0 0 0 !important;
            float: none !important;
        }
        #bookingModal .dbt-terms-consent label,
        #kidsBookingModal .dbt-terms-consent label {
            display: block;
            margin: 0 !important;
            line-height: 1.4;
            word-break: normal;
            overflow-wrap: normal;
        }

        /* Force Terms copy into exactly 2 lines for the kids modal */
        #kidsBookingModal .dbt-terms-consent label {
            white-space: normal;
        }
        #kidsBookingModal .dbt-terms-consent .dbt-terms-line2 {
            white-space: nowrap;
            display: inline-block;
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

        #customServiceInput, #customSpecialRequirements, #customReferenceImage {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        #customServiceInput:focus, #customSpecialRequirements:focus {
            border-color: #030f68;
            box-shadow: 0 0 0 0.2rem rgba(3, 15, 104, 0.1);
            outline: none;
        }

        /* Radio button group containers */
        .radio-group-container {
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            min-height: 50px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 0;
        }

        .radio-group-container:hover {
            border-color: #ced4da;
        }

        /* Highlight container when radio is checked */
        .radio-group-container.radio-selected {
            border-color: #030f68;
            box-shadow: 0 0 0 0.2rem rgba(3, 15, 104, 0.1);
            background-color: #f8f9ff;
        }

        /* Ensure proper spacing between form groups */
        #customServiceForm .col-md-6 {
            margin-bottom: 1rem;
        }

        #customServiceForm .form-label {
            margin-bottom: 8px;
            display: block;
        }

        #customServiceForm .form-check-input {
            border-radius: 4px;
            border: 2px solid #dee2e6;
            transition: all 0.2s ease;
        }

        #customServiceForm .form-check-input:checked {
            background-color: #030f68;
            border-color: #030f68;
        }

        #customServiceForm .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(3, 15, 104, 0.25);
        }

        #customServiceForm .form-check-label {
            cursor: pointer;
            user-select: none;
        }


        #customServiceForm .form-label {
            color: #0b3a66;
            font-weight: 600;
            margin-bottom: 8px;
        }

        /* Contact Information Modal Styling */
        #customServiceRequestModal .form-control:focus {
            border-color: #030f68 !important;
            box-shadow: 0 0 0 0.2rem rgba(3, 15, 104, 0.25) !important;
            outline: none !important;
        }

        #customServiceRequestModal .form-label {
            color: #030f68;
            font-weight: 600;
            margin-bottom: 8px;
        }

        #customServiceRequestModal .form-text {
            font-size: 0.875rem;
            margin-top: 4px;
            color: #6c757d;
        }

        /* Custom service request modal z-index - only applied via JavaScript when needed */

        #customServiceForm .form-select-lg, #customServiceForm .form-control-lg {
            font-size: 1rem;
            padding: 0.75rem 1rem;
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
                // Check if terms were already accepted before resetting
                const KEY = 'dbt_terms_accepted_v1';
                const hasAccepted = () => {
                    try { return window.localStorage && localStorage.getItem(KEY) === '1'; } catch(e) { return false; }
                };
                const termsWereAccepted = hasAccepted();
                
                form.reset();
                // Clear all inputs except CSRF token
                var inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(function(input) {
                    if (input.name !== '_token') {
                        // IMPORTANT: do not overwrite checkbox/radio values (breaks terms_accepted='accepted' validation)
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = '';
                        }
                    }
                });
                
                // Restore terms checkbox if terms were already accepted
                if (termsWereAccepted) {
                    const termsCheckbox = document.getElementById('termsAcceptedMain');
                    if (termsCheckbox) {
                        termsCheckbox.checked = true;
                    }
                }
                
                // Reset appointment type to in-studio and hide address field
                var inStudioRadio = document.getElementById('appointment_type_in_studio');
                if (inStudioRadio) {
                    inStudioRadio.checked = true;
                }
                
                // Hide address field
                var addressContainer = document.getElementById('addressFieldContainer');
                if (addressContainer) {
                    addressContainer.classList.add('d-none');
                    addressContainer.style.display = 'none';
                }
                
                // Clear address input
                var addressInput = document.getElementById('address');
                if (addressInput) {
                    addressInput.value = '';
                    addressInput.required = false;
                }
                
                console.log('Booking form cleared');
                
                // Call toggle function to ensure proper state
                if (typeof toggleAddressField === 'function') {
                    toggleAddressField();
                }
            }
        };

        // Size & Length Selection Modal Functions
        window.serviceSizeData = {
            selectedSize: null,
            selectedLength: 'mid-back',
            basePrice: 0,
            lengthAdjustment: 0,
            serviceCategory: '',
            serviceName: '',
            serviceType: ''
        };

        // Service categories and their available sizes
        window.serviceSizesMap = {
            'knotless': {
                category: 'Knotless Braids',
                sizes: [
                    { name: 'Small Knotless Braids', slug: 'small-knotless', price: {{ (int) config('service_prices.small_knotless', 170) }}, time: '6–7 hrs' },
                    { name: 'Smedium Knotless Braids', slug: 'smedium-knotless', price: {{ (int) config('service_prices.smedium_knotless', 150) }}, time: '5–6 hrs' },
                    { name: 'Medium Knotless Braids', slug: 'medium-knotless', price: {{ (int) config('service_prices.medium_knotless', 130) }}, time: '4–4.5 hrs' },
                    { name: 'Jumbo Knotless Braids', slug: 'jumbo-knotless', price: {{ (int) config('service_prices.jumbo_knotless', 100) }}, time: '2–3 hrs' }
                ]
            },
            'boho': {
                category: 'Boho Braids',
                sizes: [
                    { name: 'Small Boho Braids', slug: 'small-boho', price: 180, time: '6–7 hrs' },
                    { name: 'Smedium Boho Braids', slug: 'smedium-boho', price: {{ (int) config('service_prices.boho_braids', 150) }}, time: '5–6 hrs' },
                    { name: 'Medium Boho Braids', slug: 'medium-boho', price: 130, time: '4–5 hrs' },
                    { name: 'Jumbo/Large Boho Braids', slug: 'jumbo-boho', price: 100, time: '3–4 hrs' }
                ]
            },
            'twist': {
                category: 'Twist Styles',
                sizes: [
                    { name: 'Small Twists', slug: 'small-twist', price: 150, time: '5–6 hrs' },
                    { name: 'Medium Twists', slug: 'medium-twist', price: 120, time: '4–5 hrs' },
                    { name: 'Jumbo/Large Twists', slug: 'jumbo-twist', price: 100, time: '3–4 hrs' },
                    { name: 'Small Natural Hair Twist', slug: 'small-natural-hair-twist', price: 80, time: '2–3 hrs', noLength: true },
                    { name: 'Medium Natural Hair Twist', slug: 'medium-natural-hair-twist', price: 60, time: '2–3 hrs', noLength: true }
                ]
            },
            'cornrow': {
                category: 'Cornrow/Feed-in Braids',
                sizes: [
                    { name: 'Stitch Weave', slug: 'stitch-weave', price: 100, time: '4–5 hrs', hasRowOptions: true },
                    { name: 'Cornrow Weave', slug: 'cornrow-weave', price: 100, time: '4–5 hrs', hasRowOptions: true },
                    { name: 'Under-wig Weave', slug: 'under-wig-weave', price: 30, time: '30 min–1 hr', hasRowOptions: false, noLength: true },
                    { name: 'Weave&Braid Mixed', slug: 'weave-braid-mixed', price: 150, time: '4–5 hrs', hasRowOptions: false }
                ]
            },
            'french-curl': {
                category: 'French Curl Braids',
                sizes: [
                    { name: 'Small French Curl Braids', slug: 'small-french-curl', price: 200, time: '6–7 hrs' },
                    { name: 'Smedium French Curl Braids', slug: 'smedium-french-curl', price: 170, time: '5–6 hrs' },
                    { name: 'Medium French Curl Braids', slug: 'medium-french-curl', price: 150, time: '4–5 hrs' },
                    { name: 'Large French Curl Braids', slug: 'large-french-curl', price: 120, time: '3–4 hrs' }
                ]
            },
            'crotchet': {
                category: 'Crotchet Styles',
                sizes: [
                    { name: '2/3 Line Single', slug: 'line-single', price: 100, time: '2–3 hrs', hasFrontBackAddon: true, noLength: true },
                    { name: 'Afro Crotchet', slug: 'afro-crotchet', price: 120, time: '3–4 hrs', hasFrontBackAddon: false, noLength: true },
                    { name: 'Individual Loc', slug: 'individual-loc', price: 150, time: '4–5 hrs', hasFrontBackAddon: false, noLength: true },
                    { name: 'Butterfly Locks', slug: 'butterfly-locks', price: 150, time: '3–4 hrs', hasFrontBackAddon: false, noLength: true },
                    { name: 'Weave Crotchet', slug: 'weave-crotchet', price: 80, time: '1.5–2 hrs', hasFrontBackAddon: false, noLength: true }
                ]
            },
            'hair-treatment': {
                category: 'Hair Treatment Services',
                sizes: [
                    { name: 'Natural Hair Treatment/Mask', slug: 'natural-hair-treatment', price: {{ (int) config('service_prices.hair_mask', 50) }}, time: '45 min–1 hr', hasWeaveAddon: true },
                    { name: 'Chemical Relaxer', slug: 'chemical-relaxer', price: 50, time: '1.5–2 hrs', hasWeaveAddon: true }
                ]
            }
        };

        // Open size selection modal
        window.openServiceSizeModal = function(serviceCategory) {
            console.log('Opening size selection modal for:', serviceCategory);
            
            const categoryData = window.serviceSizesMap[serviceCategory];
            if (!categoryData) {
                console.error('Unknown service category:', serviceCategory);
                return;
            }

            // Update modal title
            const modalTitle = document.getElementById('serviceCategory');
            if (modalTitle) {
                modalTitle.textContent = categoryData.category;
            }

            // Store category
            window.serviceSizeData.serviceCategory = serviceCategory;
            
            // Populate size options
            populateSizeOptions(categoryData.sizes);
            
            // Reset selections
            window.serviceSizeData.selectedSize = null;
            window.serviceSizeData.selectedLength = 'mid-back';
            
            // Show/hide length selection based on service type
            const lengthSection = document.getElementById('lengthSelectionSection');
            if (lengthSection) {
                if (serviceCategory === 'crotchet' || serviceCategory === 'hair-treatment') {
                    lengthSection.style.display = 'none';
                    window.serviceSizeData.selectedLength = 'none'; // Crotchet and hair treatment don't need length
                } else {
                    lengthSection.style.display = 'block';
                    // Reset length selection to mid-back
                    const lengthRadios = document.querySelectorAll('input[name="size_length"]');
                    lengthRadios.forEach(radio => {
                        radio.checked = (radio.value === 'mid-back');
                    });
                }
            }
            
            // Show modal
            const modalEl = document.getElementById('serviceSizeLengthModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        };

        // Populate size options dynamically
        function populateSizeOptions(sizes) {
            const container = document.getElementById('sizeOptionsContainer');
            if (!container) return;
            
            container.innerHTML = '';
            
            sizes.forEach(size => {
                const sizeCard = document.createElement('div');
                sizeCard.className = 'col-6 col-md-3';
                const sizeImage = getSizeImage(size.name);
                const hasWeaveAddon = size.hasWeaveAddon || false;
                const hasRowOptions = size.hasRowOptions || false;
                const hasFrontBackAddon = size.hasFrontBackAddon || false;
                const noLength = size.noLength || false;
                const sizeName = getSizeName(size.name);
                const sizeDesc = getSizeDescription(sizeName);
                sizeCard.innerHTML = `
                    <div class="size-option-card" onclick="selectSize('${size.slug}', '${size.name}', ${size.price}, ${hasWeaveAddon}, ${hasRowOptions}, ${hasFrontBackAddon}, ${noLength})" style="cursor: pointer; padding: 12px; border: 2px solid #e9ecef; border-radius: 12px; text-align: center; transition: all 0.3s; background: #fff;" data-size-slug="${size.slug}">
                        <div style="margin-bottom: 8px; overflow: hidden; border-radius: 8px; height: 120px;">
                            <img src="${sizeImage}" alt="${sizeName} size" style="width: 100%; height: 100%; object-fit: cover; object-position: top;">
                        </div>
                        <div style="font-weight: 700; color: #030f68; font-size: 0.9rem; margin-bottom: 4px;">${sizeName}</div>
                        ${sizeDesc ? `<div style="font-size: 0.7rem; color: #6c757d; margin-bottom: 6px; line-height: 1.2;">${sizeDesc}</div>` : ''}
                        <div style="font-size: 1.2rem; font-weight: 800; color: #ff6600;">$${size.price}</div>
                        <div style="font-size: 0.75rem; color: #999; margin-top: 4px;">${size.time}</div>
                    </div>
                `;
                container.appendChild(sizeCard);
            });
        }

        // Helper to get image for braid size
        function getSizeImage(name) {
            // Knotless Braids
            if (name.includes('Knotless')) {
                if (name.includes('Small') && !name.includes('Smedium')) return '{{ asset("images/small braid.jpg") }}';
                if (name.includes('Smedium')) return '{{ asset("images/smedium-braids.jpg") }}';
                if (name.includes('Medium') && !name.includes('Smedium')) return '{{ asset("images/medium-knotless.jpg") }}';
                if (name.includes('Jumbo')) return '{{ asset("images/jumbo braid.jpg") }}';
            }
            // Boho Braids
            if (name.includes('Boho')) {
                if (name.includes('Small')) return '{{ asset("images/boho braid.jpg") }}';
                if (name.includes('Smedium')) return '{{ asset("images/smedium-braids.jpg") }}';
                if (name.includes('Medium') && !name.includes('Jumbo')) return '{{ asset("images/medium boho.png") }}';
                if (name.includes('Jumbo') || name.includes('Large')) return '{{ asset("images/jumbo boho.png") }}';
            }
            // Twist Styles
            if (name.includes('Twist')) {
                if (name.includes('Natural Hair')) {
                    if (name.includes('Small')) return '{{ asset("images/natural-hair-twist.jpg") }}';
                    if (name.includes('Medium')) return '{{ asset("images/medium-natural-twist.png") }}';
                }
                if (name.includes('Small')) return '{{ asset("images/small-twist.jpg") }}';
                if (name.includes('Medium')) return '{{ asset("images/medium-twist.jpg") }}';
                if (name.includes('Jumbo') || name.includes('Large')) return '{{ asset("images/jumbo-twist.jpg") }}';
            }
            // Cornrow/Feed-in Braids
            if (name.includes('Weave') || name.includes('Cornrow')) {
                if (name.includes('Stitch Weave')) return '{{ asset("images/stitch braid.jpg") }}';
                if (name.includes('Cornrow Weave')) return '{{ asset("images/cornrow-weave.jpg") }}';
                if (name.includes('Under-wig')) return '{{ asset("images/under-wig-weave.jpg") }}';
                if (name.includes('Half Weave') || name.includes('Weave&Braid Mixed')) return '{{ asset("images/weave & braid (mixed).avif") }}';
            }
            // French Curl Braids
            if (name.includes('French Curl')) {
                if (name.includes('Small')) return '{{ asset("images/french curl braid.jpg") }}';
                if (name.includes('Smedium')) return '{{ asset("images/medium size french curl.png") }}';
                if (name.includes('Medium')) return '{{ asset("images/french braid.avif") }}';
                if (name.includes('Large')) return '{{ asset("images/large-french-curl.jpg") }}';
            }
            // Crotchet Styles
            if (name.includes('Crotchet') || name.includes('Lock') || name.includes('Line Single') || name.includes('Loc')) {
                if (name.includes('2/3 Line Single')) return '{{ asset("images/Screenshot 2026-02-05 132501.png") }}';
                if (name.includes('Weave Crotchet')) return '{{ asset("images/weave-crotchet.jpg") }}';
                if (name.includes('Afro Crotchet')) return '{{ asset("images/kinky crotchet.png") }}';
                if (name.includes('Individual Loc')) return '{{ asset("images/individual_crotchet.png") }}';
                if (name.includes('Butterfly')) return '{{ asset("images/butterfly loc.jpg") }}';
                if (name.includes('Front & Back')) return '{{ asset("images/yanky twist crotchet.jpg") }}';
            }
            // Hair Treatment Services
            if (name.includes('Treatment') || name.includes('Mask') || name.includes('Relaxer')) {
                if (name.includes('Natural Hair') || name.includes('Treatment/Mask')) return '{{ asset("images/hair_mask.png") }}';
                if (name.includes('Relaxer')) return '{{ asset("images/relaxer.png") }}';
            }
            return '{{ asset("images/smedium braid.jpg") }}'; // fallback
        }

        // Helper to get size name (e.g., "Small" from "Small Knotless Braids")
        function getSizeName(fullName) {
            if (fullName.includes('Small')) return 'Small';
            if (fullName.includes('Smedium')) return 'Smedium';
            if (fullName.includes('Medium')) return 'Medium';
            if (fullName.includes('Jumbo') || fullName.includes('Large')) return 'Large/Jumbo';
            return fullName.split(' ')[0];
        }
        
        // Helper to get full size description for tooltips
        function getSizeDescription(sizeName) {
            const descriptions = {
                'Small': 'Very thin braids (4-6 packs hair)',
                'Smedium': 'Small-Medium size (3-4 packs hair)',
                'Medium': 'Standard medium size (2-3 packs hair)',
                'Large/Jumbo': 'Extra large/thick braids (1-2 packs hair)'
            };
            return descriptions[sizeName] || '';
        }

        // Select a size
        window.selectSize = function(slug, name, price, hasWeaveAddon, hasRowOptions, hasFrontBackAddon, noLength) {
            // Remove selection from all cards
            document.querySelectorAll('.size-option-card').forEach(card => {
                card.style.border = '2px solid #e9ecef';
                card.style.background = '#fff';
                card.style.transform = 'scale(1)';
            });
            
            // Highlight selected card
            const selectedCard = document.querySelector(`[data-size-slug="${slug}"]`);
            if (selectedCard) {
                selectedCard.style.border = '2px solid #ff6600';
                selectedCard.style.background = '#fff7e0';
                selectedCard.style.transform = 'scale(1.05)';
            }
            
            // Store selection
            window.serviceSizeData.selectedSize = slug;
            window.serviceSizeData.serviceName = name;
            window.serviceSizeData.serviceType = slug;
            window.serviceSizeData.basePrice = price;
            window.serviceSizeData.weaveAddon = false; // Reset weave addon
            window.serviceSizeData.rowOption = '8-10'; // Reset row option to default
            window.serviceSizeData.frontBackAddon = false; // Reset front/back addon
            window.serviceSizeData.noLength = noLength || false; // Track if length should be hidden
            
            // Show/hide weave add-on section based on service
            const weaveSection = document.getElementById('weaveAddonSection');
            if (weaveSection) {
                if (hasWeaveAddon) {
                    weaveSection.style.display = 'block';
                    // Reset weave selection to "no"
                    const noWeaveRadio = document.getElementById('weave_no');
                    if (noWeaveRadio) noWeaveRadio.checked = true;
                } else {
                    weaveSection.style.display = 'none';
                }
            }
            
            // Show/hide row options section based on service
            const rowSection = document.getElementById('rowOptionsSection');
            if (rowSection) {
                if (hasRowOptions) {
                    rowSection.style.display = 'block';
                    // Reset row selection to "8-10"
                    const row810Radio = document.getElementById('row_8_10');
                    if (row810Radio) row810Radio.checked = true;
                } else {
                    rowSection.style.display = 'none';
                }
            }
            
            // Show/hide front/back add-on section based on service
            const frontBackSection = document.getElementById('frontBackAddonSection');
            if (frontBackSection) {
                if (hasFrontBackAddon) {
                    frontBackSection.style.display = 'block';
                    // Reset front/back selection to "no"
                    const frontOnlyRadio = document.getElementById('frontback_no');
                    if (frontOnlyRadio) frontOnlyRadio.checked = true;
                } else {
                    frontBackSection.style.display = 'none';
                }
            }
            
            // Show/hide length selection based on service
            const lengthSection = document.getElementById('lengthSelectionSection');
            if (lengthSection) {
                if (noLength) {
                    lengthSection.style.display = 'none';
                    window.serviceSizeData.selectedLength = 'none';
                } else {
                    lengthSection.style.display = 'block';
                    if (!window.serviceSizeData.selectedLength || window.serviceSizeData.selectedLength === 'none') {
                        window.serviceSizeData.selectedLength = 'mid-back';
                    }
                }
            }
            
            // Display selected service info
            const selectedServiceDisplay = document.getElementById('selectedServiceDisplay');
            const selectedServiceName = document.getElementById('selectedServiceName');
            const selectedServicePrice = document.getElementById('selectedServicePrice');
            
            if (selectedServiceDisplay && selectedServiceName && selectedServicePrice) {
                selectedServiceDisplay.style.display = 'block';
                selectedServiceName.textContent = name;
                selectedServicePrice.textContent = '$' + price;
            }
            
            // Update price display
            updateSizeLengthPrice();
        };

        // Toggle weave add-on
        window.toggleWeaveAddon = function(addWeave) {
            window.serviceSizeData.weaveAddon = addWeave;
            
            // Update radio selection
            const weaveRadio = document.getElementById(addWeave ? 'weave_yes' : 'weave_no');
            if (weaveRadio) weaveRadio.checked = true;
            
            // Update visual selection
            const noWeaveOption = document.getElementById('weave_no')?.closest('.form-check');
            const yesWeaveOption = document.getElementById('weave_yes')?.closest('.form-check');
            
            if (noWeaveOption && yesWeaveOption) {
                if (addWeave) {
                    noWeaveOption.style.border = '2px solid #e9ecef';
                    yesWeaveOption.style.border = '2px solid #28a745';
                    yesWeaveOption.style.background = '#f0f9f4';
                } else {
                    noWeaveOption.style.border = '2px solid #ff6600';
                    noWeaveOption.style.background = '#fff7e0';
                    yesWeaveOption.style.border = '2px solid #e9ecef';
                    yesWeaveOption.style.background = '#fff';
                }
            }
            
            // Update price
            updateSizeLengthPrice();
        };

        // Toggle row option
        window.toggleRowOption = function(rowOption) {
            window.serviceSizeData.rowOption = rowOption;
            
            // Update radio selection
            const rowRadio = document.getElementById(rowOption === '8-10' ? 'row_8_10' : 'row_10_plus');
            if (rowRadio) rowRadio.checked = true;
            
            // Update visual selection
            const row810Option = document.getElementById('row_8_10')?.closest('.form-check');
            const row10PlusOption = document.getElementById('row_10_plus')?.closest('.form-check');
            
            if (row810Option && row10PlusOption) {
                if (rowOption === '10+') {
                    row810Option.style.border = '2px solid #e9ecef';
                    row810Option.style.background = '#fff';
                    row10PlusOption.style.border = '2px solid #17a2b8';
                    row10PlusOption.style.background = '#e7f3ff';
                } else {
                    row810Option.style.border = '2px solid #ff6600';
                    row810Option.style.background = '#fff7e0';
                    row10PlusOption.style.border = '2px solid #e9ecef';
                    row10PlusOption.style.background = '#fff';
                }
            }
            
            // Update price
            updateSizeLengthPrice();
        };

        // Toggle front/back add-on
        window.toggleFrontBackAddon = function(addBack) {
            window.serviceSizeData.frontBackAddon = addBack;
            
            // Update radio selection
            const frontBackRadio = document.getElementById(addBack ? 'frontback_yes' : 'frontback_no');
            if (frontBackRadio) frontBackRadio.checked = true;
            
            // Update visual selection
            const frontOnlyOption = document.getElementById('frontback_no')?.closest('.form-check');
            const frontBackOption = document.getElementById('frontback_yes')?.closest('.form-check');
            
            if (frontOnlyOption && frontBackOption) {
                if (addBack) {
                    frontOnlyOption.style.border = '2px solid #e9ecef';
                    frontOnlyOption.style.background = '#fff';
                    frontBackOption.style.border = '2px solid #28a745';
                    frontBackOption.style.background = '#f0f9f4';
                } else {
                    frontOnlyOption.style.border = '2px solid #ff6600';
                    frontOnlyOption.style.background = '#fff7e0';
                    frontBackOption.style.border = '2px solid #e9ecef';
                    frontBackOption.style.background = '#fff';
                }
            }
            
            // Update price
            updateSizeLengthPrice();
        };

        // Select a length
        window.selectSizeLength = function(length) {
            const radio = document.getElementById(`size_length_${length}`);
            if (radio) {
                radio.checked = true;
            }
            
            window.serviceSizeData.selectedLength = length;
            
            // Update visual selection
            document.querySelectorAll('#lengthOptionsContainer .form-check').forEach(option => {
                option.style.border = '2px solid transparent';
                option.style.background = '#f8f9fa';
            });
            
            const selectedOption = radio?.closest('.form-check');
            if (selectedOption) {
                selectedOption.style.border = '2px solid #ff6600';
                selectedOption.style.background = '#fff7e0';
            }
            
            // Update price display
            updateSizeLengthPrice();
        };

        // Update price display based on selections
        function updateSizeLengthPrice() {
            const length = window.serviceSizeData.selectedLength;
            const basePrice = window.serviceSizeData.basePrice;
            const serviceCategory = window.serviceSizeData.serviceCategory;
            const weaveAddon = window.serviceSizeData.weaveAddon || false;
            const rowOption = window.serviceSizeData.rowOption || '8-10';
            const frontBackAddon = window.serviceSizeData.frontBackAddon || false;
            
            let adjustment = 0;
            let weaveAddonCost = 0;
            let rowAddonCost = 0;
            let frontBackAddonCost = 0;
            
            // Only apply length adjustments for braid services (not crotchet or hair treatment)
            if (serviceCategory !== 'crotchet' && serviceCategory !== 'hair-treatment') {
                // Length adjustments
                const lengthAdjustments = {
                    'neck': -40,
                    'shoulder': -40,
                    'armpit': -40,
                    'bra-strap': 0,
                    'mid-back': 0,
                    'waist': 20,
                    'hip': 40,
                    'tailbone': 60
                };
                adjustment = lengthAdjustments[length] || 0;
            }
            
            // Add weave add-on cost if selected
            if (weaveAddon) {
                weaveAddonCost = 30;
            }
            
            // Add row add-on cost if 10+ rows selected
            if (rowOption === '10+') {
                rowAddonCost = 30;
            }
            
            // Add front/back add-on cost if selected
            if (frontBackAddon) {
                frontBackAddonCost = 20;
            }
            
            window.serviceSizeData.lengthAdjustment = adjustment;
            window.serviceSizeData.weaveAddonCost = weaveAddonCost;
            window.serviceSizeData.rowAddonCost = rowAddonCost;
            window.serviceSizeData.frontBackAddonCost = frontBackAddonCost;
            
            const totalPrice = basePrice + adjustment + weaveAddonCost + rowAddonCost + frontBackAddonCost;
            
            const priceDisplay = document.getElementById('sizeLengthPriceDisplay');
            if (priceDisplay) {
                priceDisplay.textContent = basePrice > 0 ? `$${totalPrice}` : '$--';
            }
            
            // Enable/disable continue button
            const continueBtn = document.getElementById('continueToBookingBtn');
            if (continueBtn) {
                continueBtn.disabled = !window.serviceSizeData.selectedSize;
            }
        }

        // Continue to booking modal
        window.continueToBooking = function() {
            if (!window.serviceSizeData.selectedSize) {
                alert('Please select a braid size first');
                return;
            }
            
            // Update service name with add-ons
            let serviceName = window.serviceSizeData.serviceName;
            if (window.serviceSizeData.weaveAddon) {
                serviceName += ' (With Weave)';
            }
            if (window.serviceSizeData.rowOption === '10+') {
                serviceName += ' (10+ Rows)';
            }
            if (window.serviceSizeData.frontBackAddon) {
                serviceName += ' (Front + Back)';
            }
            
            // Get the size modal element and instance
            const sizeModalEl = document.getElementById('serviceSizeLengthModal');
            const sizeModal = bootstrap.Modal.getInstance(sizeModalEl);
            
            // Listen for the modal to fully hide before opening booking modal
            const openBooking = () => {
                sizeModalEl.removeEventListener('hidden.bs.modal', openBooking);
                
                // Open booking modal with the selected service
                setTimeout(() => {
                    window.openBookingModal(
                        serviceName,
                        window.serviceSizeData.serviceType
                    );
                    
                    // Pre-select the length in booking form (skip for crotchet and hair treatment)
                    if (window.serviceSizeData.serviceCategory !== 'crotchet' && window.serviceSizeData.serviceCategory !== 'hair-treatment') {
                        const lengthRadio = document.getElementById(`length_${window.serviceSizeData.selectedLength.replace('-', '')}`);
                        if (lengthRadio) {
                            lengthRadio.checked = true;
                            // Trigger change event to update price
                            lengthRadio.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }
                }, 100);
            };
            
            // Add event listener and hide modal
            if (sizeModal) {
                sizeModalEl.addEventListener('hidden.bs.modal', openBooking);
                sizeModal.hide();
            } else {
                // Fallback if modal instance not found
                openBooking();
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

        // --- Booking draft (persist typed info across service flows / redirects) ---
        (function() {
            const KEY = 'dbt_booking_draft_v1';

            function safeParse(raw) {
                try { return raw ? (JSON.parse(raw) || {}) : {}; } catch (e) { return {}; }
            }

            function loadDraft() {
                try { return safeParse(sessionStorage.getItem(KEY)); } catch (e) { return {}; }
            }

            function saveDraft(partial) {
                try {
                    const cur = loadDraft();
                    const next = { ...cur };
                    Object.keys(partial || {}).forEach(k => {
                        const v = partial[k];
                        if (typeof v === 'string') {
                            const t = v.trim();
                            if (t) next[k] = t;
                        } else if (v !== null && v !== undefined) {
                            next[k] = v;
                        }
                    });
                    sessionStorage.setItem(KEY, JSON.stringify(next));
                } catch (e) { /* noop */ }
            }

            function fillIfEmpty(id, value) {
                try {
                    if (!value) return;
                    const el = document.getElementById(id);
                    if (!el) return;
                    if (el.value && el.value.trim()) return;
                    el.value = value;
                    // Make autofill behave like real user input (triggers validators/UI)
                    try { el.dispatchEvent(new Event('input', { bubbles: true })); } catch (e) {}
                    try { el.dispatchEvent(new Event('change', { bubbles: true })); } catch (e) {}
                } catch (e) { /* noop */ }
            }

            function clearDraft() {
                try { sessionStorage.removeItem(KEY); } catch (e) { /* noop */ }
            }

            // Expose for other code paths (e.g., submit handlers)
            window.__dbtClearBookingDraft = clearDraft;

            window.__dbtSaveBookingDraftFromMain = function() {
                try {
                    const name = (document.getElementById('name') || {}).value || '';
                    const phone = (document.getElementById('phone') || {}).value || '';
                    const email = (document.getElementById('email') || {}).value || '';
                    const address = (document.getElementById('address') || {}).value || '';
                    const message = (document.getElementById('message') || {}).value || '';
                    const bookingDateDisplay = (document.getElementById('bookingDate') || {}).value || '';
                    const timeDisplay = (document.getElementById('timeInput') || {}).value || '';
                    const appointment_date = (document.getElementById('appointment_date') || {}).value || '';
                    const appointment_time = (document.getElementById('appointment_time_hidden') || {}).value || '';
                    saveDraft({ name, phone, email, address, message, bookingDateDisplay, timeDisplay, appointment_date, appointment_time });
                } catch (e) { /* noop */ }
            };

            window.__dbtSaveBookingDraftFromKids = function() {
                try {
                    // Intentionally do NOT map main name -> kids_name (child name differs)
                    const phone = (document.getElementById('kids_phone') || {}).value || '';
                    const email = (document.getElementById('kids_email') || {}).value || '';
                    const bookingDateDisplay = (document.getElementById('kidsBookingDate') || {}).value || '';
                    const timeDisplay = (document.getElementById('kidsBookingTime') || {}).value || '';
                    const kidsForm = document.getElementById('kidsBookingForm');
                    const appointment_date = kidsForm ? ((kidsForm.querySelector('input[name="appointment_date"]') || {}).value || '') : '';
                    const appointment_time = kidsForm ? ((kidsForm.querySelector('input[name="appointment_time"]') || {}).value || '') : '';
                    saveDraft({ phone, email, bookingDateDisplay, timeDisplay, appointment_date, appointment_time });
                } catch (e) { /* noop */ }
            };

            window.__dbtApplyBookingDraftToMain = function() {
                const d = loadDraft();
                fillIfEmpty('name', d.name);
                fillIfEmpty('phone', d.phone);
                fillIfEmpty('email', d.email);
                fillIfEmpty('address', d.address);
                fillIfEmpty('message', d.message);
                // Date/time (visible + hidden submit fields)
                fillIfEmpty('bookingDate', d.bookingDateDisplay);
                fillIfEmpty('timeInput', d.timeDisplay);
                fillIfEmpty('appointment_date', d.appointment_date);
                fillIfEmpty('appointment_time_hidden', d.appointment_time);
            };

            window.__dbtApplyBookingDraftToKids = function() {
                const d = loadDraft();
                fillIfEmpty('kids_phone', d.phone);
                fillIfEmpty('kids_email', d.email);
                // Date/time (kids visible + hidden submit fields)
                fillIfEmpty('kidsBookingDate', d.bookingDateDisplay);
                fillIfEmpty('kidsBookingTime', d.timeDisplay);
                try {
                    const kidsForm = document.getElementById('kidsBookingForm');
                    if (kidsForm) {
                        const hd = kidsForm.querySelector('input[name="appointment_date"]');
                        const ht = kidsForm.querySelector('input[name="appointment_time"]');
                        if (hd && (!hd.value || !hd.value.trim()) && d.appointment_date) hd.value = d.appointment_date;
                        if (ht && (!ht.value || !ht.value.trim()) && d.appointment_time) ht.value = d.appointment_time;
                    }
                } catch (e) { /* noop */ }
                try {
                    const dateLabel = document.getElementById('kidsSelectedDateLabel'); if (dateLabel && (!dateLabel.textContent || !dateLabel.textContent.trim()) && d.bookingDateDisplay) dateLabel.textContent = d.bookingDateDisplay;
                    const timeLabel = document.getElementById('kidsSelectedTimeLabel'); if (timeLabel && (!timeLabel.textContent || !timeLabel.textContent.trim()) && d.timeDisplay) timeLabel.textContent = d.timeDisplay;
                } catch (e) { /* noop */ }
            };

            document.addEventListener('DOMContentLoaded', function() {
                // If user refreshed/reloaded the page, clear the draft (per request)
                try {
                    const navEntry = (performance && performance.getEntriesByType) ? performance.getEntriesByType('navigation')[0] : null;
                    const navType = navEntry ? navEntry.type : ((performance && performance.navigation) ? performance.navigation.type : null);
                    const isReload = (navType === 'reload') || (navType === 1);
                    if (isReload) {
                        clearDraft();
                        return; // don't apply draft on a refresh
                    }
                } catch (e) { /* noop */ }

                // If user arrives from calendar, restore into any visible form
                try { window.__dbtApplyBookingDraftToMain(); } catch (e) {}
                try { window.__dbtApplyBookingDraftToKids(); } catch (e) {}

                // Keep saving as user types (main booking form)
                try {
                    ['name','phone','email','address','message'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.addEventListener('input', window.__dbtSaveBookingDraftFromMain);
                    });
                } catch (e) {}

                // Keep saving as user types (kids modal)
                try {
                    ['kids_phone','kids_email'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.addEventListener('input', window.__dbtSaveBookingDraftFromKids);
                    });
                } catch (e) {}

                // Clear draft once either form is submitted
                try {
                    const bookingForm = document.getElementById('bookingForm');
                    if (bookingForm) bookingForm.addEventListener('submit', function () { clearDraft(); });
                } catch (e) {}
                try {
                    const kidsForm = document.getElementById('kidsBookingForm');
                    if (kidsForm) kidsForm.addEventListener('submit', function () { clearDraft(); });
                } catch (e) {}
            });
        })();

        // Deep link support: /?openBooking=1&service=Service%20Name
        document.addEventListener('DOMContentLoaded', function () {
            try {
                const url = new URL(window.location.href);
                const shouldOpen = url.searchParams.get('openBooking') === '1';
                const serviceName = url.searchParams.get('service');
                if (shouldOpen && serviceName && typeof window.openBookingModal === 'function') {
                    // Mark this booking as originating from the calendar page flow
                    window.__bookingOrigin = 'calendar';
                    window.openBookingModal(serviceName, null);

                    // Clean the URL so refresh doesn't re-open the modal
                    url.searchParams.delete('openBooking');
                    url.searchParams.delete('service');
                    window.history.replaceState({}, document.title, url.pathname + (url.search ? url.search : '') + (url.hash ? url.hash : ''));
                }
            } catch (e) {
                // no-op
            }
        });

        // Calendar Integration Variables
        let calendarCurrentDate = new Date();
        let selectedCalendarDate = null;
        let selectedCalendarTime = null;

    // Stitch rows selector (used for stitch-braids pricing)
    window.selectStitchRowsOption = function(option) {
        try {
            const el = document.getElementById('stitch_rows_option');
            if (el) el.value = option || '';
        } catch (e) {}

        // Hide modal
        try {
            const inst = bootstrap.Modal.getInstance(document.getElementById('stitchRowsModal'));
            if (inst) inst.hide();
        } catch (e) {}

        // Recompute estimated price immediately
        try {
            const selectedPriceEl = document.getElementById('selectedPrice');
            let base = null;
            if (selectedPriceEl && selectedPriceEl.value && !isNaN(parseFloat(selectedPriceEl.value))) {
                base = parseFloat(selectedPriceEl.value);
            } else if (window.currentServiceInfo && typeof window.currentServiceInfo.basePrice === 'number') {
                base = window.currentServiceInfo.basePrice;
            }
            if (typeof updatePriceDisplay === 'function') updatePriceDisplay(base);
        } catch (e) {}
    };

        // Helper: format a Date as local YYYY-MM-DD (avoids timezone shifts from toISOString())
        function formatYMD(d){
            // Extract date components directly to avoid timezone conversion
            if (!d || !(d instanceof Date)) {
                try {
                    // Try to parse if it's a string or other format
                    d = new Date(d);
                    if (isNaN(d.getTime())) return '';
                } catch(e) {
                    return '';
                }
            }
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
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
            const month = calendarCurrentDate.getMonth() + 1; // 1-based month for API
            
            console.log(`📅 Fetching blocked dates for ${year}-${month}`);

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
                    console.log('✅ Blocked dates from API:', blockedDatesCache);
                    console.log('📊 Blocked dates count:', blockedDatesCache.length);
                    if (blockedDatesCache.length > 0) {
                        console.log('📋 All blocked dates:', blockedDatesCache.map(b => `${b.date} (${b.title || 'Blocked'})`).join(', '));
                        console.log('📋 Sample blocked date:', blockedDatesCache[0]);
                    } else {
                        console.log('⚠️ No blocked dates returned for this month');
                    }
                } else {
                    console.warn('❌ Blocked dates API response failed:', blockedResp);
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
                // Create a new date by adding i days to startDate
                const date = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() + i);
                const dateString = formatYMD(date);
                
                // Ensure dateString is in YYYY-MM-DD format for consistent matching
                if (!/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
                    console.warn('Invalid dateString format:', dateString, 'from date:', date);
                }

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
                    const blockedIndex = (blockedDatesCache || []).reduce((acc, b) => { 
                        if (b && b.date) {
                            // Normalize date string to YYYY-MM-DD format for consistent matching
                            const normalizedDate = b.date.trim();
                            if (/^\d{4}-\d{2}-\d{2}$/.test(normalizedDate)) {
                                acc[normalizedDate] = b;
                            } else {
                                console.warn('⚠️ Invalid blocked date format:', b.date, 'from blocked date object:', b);
                            }
                        }
                        return acc; 
                    }, {});
                    
                    // Debug: log blocked dates
                    if (blockedIndex[dateString]) {
                        console.log(`⛔ Date ${dateString} is BLOCKED:`, blockedIndex[dateString]);
                    }
                    // Log all blocked dates once at the start
                    if (i === 0 && Object.keys(blockedIndex).length > 0) {
                        console.log('📋 All blocked dates in cache:', Object.keys(blockedIndex).sort());
                        console.log('📋 Blocked dates full details:', blockedDatesCache);
                    }

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
                        const blockedInfo = blockedIndex[dateString];
                        const isFullDay = blockedInfo.full_day === true || blockedInfo.full_day === 1;
                        
                        if (isFullDay) {
                            // Full day blocked: show dark styling and small title text
                            dayDiv.classList.add('blocked-range');
                            dayDiv.title = (blockedInfo.title || 'Blocked') + ' - This date is not available for booking';
                            
                            // Force inline styles to ensure visibility
                            dayDiv.style.background = 'linear-gradient(180deg, #dc3545 0%, #c82333 100%)';
                            dayDiv.style.backgroundColor = '#dc3545';
                            dayDiv.style.borderColor = '#a71e2a';
                            dayDiv.style.borderWidth = '2px';
                            dayDiv.style.borderStyle = 'solid';
                            dayDiv.style.color = '#ffffff';
                            dayDiv.style.cursor = 'not-allowed';
                            dayDiv.style.opacity = '1';
                            dayDiv.style.pointerEvents = 'none';
                            dayDiv.style.fontWeight = '600';
                            dayDiv.style.position = 'relative';
                            
                            dayDiv.innerHTML = date.getDate() + '<div class="blocked-text" style="color:#ffffff;font-size:0.65rem;margin-top:4px;line-height:1.1;">' + (blockedInfo.title || 'Blocked') + '</div>';
                            console.log(`⛔ Marked ${dateString} as FULLY BLOCKED (${blockedInfo.title})`);
                            // Don't add click event for fully blocked dates
                        } else {
                            // Time-specific block: date is available but some times are blocked
                            dayDiv.classList.add('available');
                            dayDiv.style.backgroundColor = '#d4edda';
                            dayDiv.style.borderColor = '#c3e6cb';
                            // Add a visual indicator that some times are blocked
                            const blockedTimes = blockedInfo.start_time && blockedInfo.end_time 
                                ? `${blockedInfo.start_time}-${blockedInfo.end_time}` 
                                : 'some times';
                            dayDiv.title = (blockedInfo.title || 'Blocked') + ` (${blockedTimes} blocked) - Click to see available times`;
                            dayDiv.onclick = (e) => selectCalendarDate(date, e);
                            console.log(`🟡 Date ${dateString} marked as AVAILABLE with time-specific blocks (${blockedInfo.start_time}-${blockedInfo.end_time})`);
                        }

                    } else {
                        dayDiv.classList.add('available');
                        dayDiv.style.backgroundColor = '#d4edda';
                        dayDiv.style.borderColor = '#c3e6cb';
                        dayDiv.onclick = (e) => selectCalendarDate(date, e);
                        console.log(`🟢 Date ${dateString} marked as AVAILABLE (green)`);
                    }
                }

                calendarDays.appendChild(dayDiv);
            }
        }

        function selectCalendarDate(date) {
            const dateString = formatYMD(date);
            
            // Check if the clicked day is booked
            if (event && event.target && event.target.classList.contains('booked')) {
                alert('This date is already booked with a pending or confirmed appointment. Please select another date.');
                return;
            }
            
            // Check if the clicked day is fully blocked (not time-specific)
            const blockedIndex = (blockedDatesCache || []).reduce((acc, b) => { acc[b.date] = b; return acc; }, {});
            if (blockedIndex[dateString]) {
                const blockedInfo = blockedIndex[dateString];
                const isFullDay = blockedInfo.full_day === true || blockedInfo.full_day === 1;
                
                if (isFullDay) {
                    const blockedTitle = blockedInfo.title || 'Blocked';
                    alert(`This date is blocked: "${blockedTitle}". Please select another date.`);
                    return;
                }
                // If it's a time-specific block, continue - user can still select the date
            }
            
            if (event && event.target && event.target.classList.contains('blocked-range')) {
                alert('This date is blocked. Please select another date.');
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
            const selectedDateText = documebased on day of week
            const selectedDate = new Date(date);
            const dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday
            
            let defaultSlots;
            if (dayOfWeek === 0) {
                // Sunday: 1:00 PM to 8:00 PM
                defaultSlots = [
                    { time: '13:00', available: true, formatted_time: '1:00 PM' },
                    { time: '14:00', available: true, formatted_time: '2:00 PM' },
                    { time: '15:00', available: true, formatted_time: '3:00 PM' },
                    { time: '16:00', available: true, formatted_time: '4:00 PM' },
                    { time: '17:00', available: true, formatted_time: '5:00 PM' },
                    { time: '18:00', available: true, formatted_time: '6:00 PM' },
                    { time: '19:00', available: true, formatted_time: '7:00 PM' },
                    { time: '20:00', available: true, formatted_time: '8:00 PM' }
                ];
            } else if (dayOfWeek === 6) {
                // Saturday: 10:00 AM to 8:00 PM
                defaultSlots = [
                    { time: '10:00', available: true, formatted_time: '10:00 AM' },
                    { time: '11:00', available: true, formatted_time: '11:00 AM' },
                    { time: '12:00', available: true, formatted_time: '12:00 PM' },
                    { time: '13:00', available: true, formatted_time: '1:00 PM' },
                    { time: '14:00', available: true, formatted_time: '2:00 PM' },
                    { time: '15:00', available: true, formatted_time: '3:00 PM' },
                    { time: '16:00', available: true, formatted_time: '4:00 PM' },
                    { time: '17:00', available: true, formatted_time: '5:00 PM' },
                    { time: '18:00', available: true, formatted_time: '6:00 PM' },
                    { time: '19:00', available: true, formatted_time: '7:00 PM' },
                    { time: '20:00', available: true, formatted_time: '8:00 PM' }
                ];
            } else {
                // Monday-Friday: 8:00 AM to 8:00 PM
                defaultSlots = [
                    { time: '08:00', available: true, formatted_time: '8:00 AM' },
                    { time: '09:00', available: true, formatted_time: '9:00 AM' },
                    { time: '10:00', available: true, formatted_time: '10:00 AM' },
                    { time: '11:00', available: true, formatted_time: '11:00 AM' },
                    { time: '12:00', available: true, formatted_time: '12:00 PM' },
                    { time: '13:00', available: true, formatted_time: '1:00 PM' },
                    { time: '14:00', available: true, formatted_time: '2:00 PM' },
                    { time: '15:00', available: true, formatted_time: '3:00 PM' },
                    { time: '16:00', available: true, formatted_time: '4:00 PM' },
                    { time: '17:00', available: true, formatted_time: '5:00 PM' },
                    { time: '18:00', available: true, formatted_time: '6:00 PM' },
                    { time: '19:00', available: true, formatted_time: '7:00 PM' },
                    { time: '20:00', available: true, formatted_time: '8:00 PM' }
                ];
            }

            // Use unified calendar API - both kids and regular bookings see same availability
            // Calendar uses 4-hour blocks by default to prevent conflicts
            const apiUrl = `/bookings/slots?date=${formatYMD(date)}`;

            // Try to fetch from API first, but fallback to default slots
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    timeSlotsContainer.style.display = 'block';

                    if (data.success) {
                        if (data.message) {
                            // Date is booked or blocked, show message
                            timeSlots.innerHTML = `<div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>${data.message}</div>`;
                            document.getElementById('confirmDateTimeBtn').disabled = true;
                        } else if (data.slots && data.slots.length > 0) {
                            // Show available slots from API
                            renderTimeSlotsInModal(data.slots);
                        } else {
                            // Empty slots means day is fully booked or no availability
                            timeSlots.innerHTML = `<div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>No available time slots for this date. Please select another date.</div>`;
                            document.getElementById('confirmDateTimeBtn').disabled = true;
                        }
                    } else {
                        // API error - show error message instead of default slots
                        timeSlots.innerHTML = `<div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i>Unable to load availability. Please try again.</div>`;
                        document.getElementById('confirmDateTimeBtn').disabled = true;
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
            const instructionDiv = document.getElementById('timeSlotsInstruction');
            timeSlots.innerHTML = '';

            if (slots.length === 0) {
                if (instructionDiv) instructionDiv.style.display = 'none';
                timeSlots.innerHTML = '<div class="col-12"><div class="alert alert-warning"><i class="bi bi-exclamation-triangle me-2"></i>No available slots for this date. Please select another date.</div></div>';
                return;
            }

            // Show instruction message
            if (instructionDiv) instructionDiv.style.display = 'block';

            slots.forEach(slot => {
                const slotDiv = document.createElement('div');
                slotDiv.className = `col-6 col-md-4 col-lg-3 mb-2`;
                slotDiv.innerHTML = `
                    <button class="btn btn-outline-primary w-100 time-slot-btn ${slot.available ? 'available' : 'booked'}"
                            ${slot.available ? `onclick="selectCalendarTime('${slot.time}', '${slot.formatted_time}')"` : 'disabled'}
                            data-time="${slot.time}"
                            data-formatted="${slot.formatted_time}">
                        <span class="time-display" style="font-size: 1rem; font-weight: 600;">${slot.formatted_time}</span>
                        <br><small class="status-text" style="font-size: 0.75rem; opacity: 0.8;">${slot.available ? 'Available' : 'Booked'}</small>
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
                    const apptDate = document.getElementById('appointment_date'); if(apptDate) apptDate.value = formatYMD(selectedCalendarDate);
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
                        const hiddenDate = kidsForm.querySelector('input[name="appointment_date"]'); if(hiddenDate) hiddenDate.value = formatYMD(selectedCalendarDate);
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

                    // Clear validation errors for date and time when calendar updates them
                    try{
                        const dateErrorDiv = document.getElementById('kidsBookingDate_error');
                        const timeErrorDiv = document.getElementById('kidsBookingTime_error');
                        if(dateErrorDiv) {
                            dateErrorDiv.style.display = 'none';
                            dateErrorDiv.textContent = '';
                            const dateField = document.getElementById('kidsBookingDate');
                            if(dateField) dateField.classList.remove('is-invalid');
                        }
                        if(timeErrorDiv) {
                            timeErrorDiv.style.display = 'none';
                            timeErrorDiv.textContent = '';
                            const timeField = document.getElementById('kidsBookingTime');
                            if(timeField) timeField.classList.remove('is-invalid');
                        }
                    }catch(e){ /* noop */ }
                }catch(e){ console.warn('Failed to populate kids booking inputs', e); }

            // Persist chosen date/time so switching service flows keeps it
            try { window.__dbtSaveBookingDraftFromMain?.(); } catch (e) {}
            try { window.__dbtSaveBookingDraftFromKids?.(); } catch (e) {}

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
            console.log('⬅️ Previous month clicked, new date:', calendarCurrentDate);
            // Fetch blocked dates for the new month
            fetchRealBookedDates();
        };

        window.nextMonth = function() {
            calendarCurrentDate.setMonth(calendarCurrentDate.getMonth() + 1);
            console.log('➡️ Next month clicked, new date:', calendarCurrentDate);
            // Fetch blocked dates for the new month
            fetchRealBookedDates();
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

    @include('partials.cookie-consent')
    @include('partials.site-header')

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container" style="padding-top: 120px; padding-bottom: 80px;">
            <div class="hero-content">
                <h1>Dab's Beauty Touch</h1>
                <p style="margin-bottom: 1.5rem;">Flawless Results - Looking for a stylist who delivers neat, long-lasting braids? Experience the expert touch at Dab's Beauty Touch today!</p>
                <div class="text-center">
                    <a href="{{ route('calendar') }}" class="btn btn-warning btn-lg px-5 py-3" style="font-weight: 700; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); font-size: 1.2rem;">
                        <i class="bi bi-calendar-check me-2"></i>Book Appointment
                    </a>
                </div>
                <div class="mt-3 small text-white-50">
                    Choose a date/time → confirm your style → get instant confirmation.
                    <br>
                    <a href="javascript:void(0)" onclick="(window.openCalendarModal ? window.openCalendarModal() : window.location.assign('{{ route('calendar') }}'))" style="color: rgba(255,255,255,0.8); text-decoration: underline; font-weight: 500;">View Availability</a>
                </div>
                <p style="font-size: 0.95rem; opacity: 0.9; font-weight: 500; margin-top: 1rem;">
                    <i class="bi bi-geo-alt-fill me-2"></i>Ottawa
                    <span class="mx-2">•</span>
                    <i class="bi bi-telephone-fill me-2"></i><a href="tel:+13432548848" style="color: #fff; text-decoration: none;">343-254-8848</a>
                    <span class="mx-2">•</span>
                    By Appointment Only
                </p>
            </div>
        </div>
    </section>

    <!-- Image Slider Section -->
    <section class="image-slider-section" style="padding: 50px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #030f68;">Why DBT</h2>
                <p class="lead" style="color: #666; font-size: 1.2rem;">Your Trusted Hair Care Experience in Ottawa</p>
            </div>

            {{-- Prices are stored in config/service_prices.php --}}
            <div id="workSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    <button type="button" data-bs-target="#workSlider" data-bs-slide-to="5" aria-label="Slide 6"></button>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <!-- Slide 1: Why Choose DBT -->
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Why Clients Choose DBT</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Dab's Beauty Touch is where Ottawa clients come for braids and protective styles that look flawless on day one—and still look neat weeks later. With 10+ years of hands-on experience, we focus on clean parts, consistent tension, and a finish that suits your face, lifestyle, and hair goals. You'll get honest guidance, a comfortable appointment, and results you can feel confident wearing.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-award-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Expert stylists with 10+ years experience</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-heart-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Hair health focused techniques</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-shield-check" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Premium products & sanitized tools</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="document.getElementById('services').scrollIntoView({behavior: 'smooth'});" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-eye me-2"></i>View Our Services
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/why-choose-us.png') }}" alt="Why Choose Us? - Stand out from the crowd" style="width: 100%; max-width: 500px; height: 400px; object-fit: contain; border-radius: 20px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: What to Expect -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Your Appointment Experience</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        From booking to your finished style, everything at DBT is set up to be simple, comfortable, and stress-free. Here's what your visit looks like:
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 18px;">
                                            <div style="background: #ff6600; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 12px; flex-shrink: 0;">1</div>
                                            <div>
                                                <strong style="color: #030f68;">Book in Minutes</strong>
                                                <p style="margin: 5px 0 0 0; color: #666; font-size: 0.95rem;">Choose your style, select a date/time, and receive instant confirmation.</p>
                                            </div>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 18px;">
                                            <div style="background: #ff6600; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 12px; flex-shrink: 0;">2</div>
                                            <div>
                                                <strong style="color: #030f68;">Quick Style Check-In</strong>
                                                <p style="margin: 5px 0 0 0; color: #666; font-size: 0.95rem;">We confirm your inspo, hair condition, and the right size/length so you get the look you want—without unnecessary tension.</p>
                                            </div>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 18px;">
                                            <div style="background: #ff6600; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 12px; flex-shrink: 0;">3</div>
                                            <div>
                                                <strong style="color: #030f68;">Relax & Get Styled</strong>
                                                <p style="margin: 5px 0 0 0; color: #666; font-size: 0.95rem;">Clean parting, consistent technique, and a comfortable, professional appointment from start to finish.</p>
                                            </div>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 18px;">
                                            <div style="background: #ff6600; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 12px; flex-shrink: 0;">4</div>
                                            <div>
                                                <strong style="color: #030f68;">Leave With a Plan</strong>
                                                <p style="margin: 5px 0 0 0; color: #666; font-size: 0.95rem;">You'll get personalized aftercare tips (and product guidance if needed) to keep your braids neat and long-lasting.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Your Appointment
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/easy-booking.png') }}" alt="Easy Online Booking System" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Hair Care Tips -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Keep Your Braids Looking Fresh</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        The right routine helps your style stay neat longer—and keeps your natural hair and edges healthy underneath. Here are our go-to tips:
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 15px;">
                                            <i class="bi bi-droplet-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.2rem; margin-top: 3px;"></i>
                                            <div>
                                                <strong style="color: #030f68;">Moisturize (lightly, consistently)</strong>
                                                <p style="margin: 3px 0 0 0; color: #666; font-size: 0.95rem;">Use a braid spray or light oil on the scalp <strong>2–3x per week</strong>. Avoid heavy buildup.</p>
                                            </div>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 15px;">
                                            <i class="bi bi-moon-stars-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.2rem; margin-top: 3px;"></i>
                                            <div>
                                                <strong style="color: #030f68;">Protect at night</strong>
                                                <p style="margin: 3px 0 0 0; color: #666; font-size: 0.95rem;">Sleep in a <strong>satin bonnet/scarf</strong> or use a satin pillowcase to reduce frizz and preserve shine.</p>
                                            </div>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 15px;">
                                            <i class="bi bi-water" style="color: #ff6600; margin-right: 10px; font-size: 1.2rem; margin-top: 3px;"></i>
                                            <div>
                                                <strong style="color: #030f68;">Cleanse your scalp gently</strong>
                                                <p style="margin: 3px 0 0 0; color: #666; font-size: 0.95rem;">Wash <strong>weekly or as needed</strong> using diluted shampoo or a scalp cleanser. Focus on the scalp, then rinse well.</p>
                                            </div>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: start; margin-bottom: 15px;">
                                            <i class="bi bi-calendar2-check" style="color: #ff6600; margin-right: 10px; font-size: 1.2rem; margin-top: 3px;"></i>
                                            <div>
                                                <strong style="color: #030f68;">Know when it's time to take them down</strong>
                                                <p style="margin: 3px 0 0 0; color: #666; font-size: 0.95rem;">Most styles should be worn <strong>4–8 weeks max</strong> (sooner if there's tension, itching, or thinning).</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4" style="background: rgba(255, 102, 0, 0.1); padding: 15px; border-radius: 10px; border-left: 4px solid #ff6600; margin-bottom: 15px;">
                                        <p style="margin: 0; color: #030f68; font-size: 0.95rem;"><i class="bi bi-info-circle-fill me-2"></i><strong>Pro Tip:</strong> Book a refresh/touch-up around <strong>6 weeks</strong> to keep your parts tidy and protect your edges.</p>
                                    </div>
                                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%); padding: 15px; border-radius: 10px;">
                                        <p style="margin: 0; color: #030f68; font-size: 0.9rem; line-height: 1.6;"><strong style="color: #ff6600;">Hair Care Tools & Products:</strong> Satin bonnet/scarf • Scalp cleanser • Braid spray/leave-in • Light oil (jojoba/argan) • Edge-safe brush (soft bristles)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/hair-care-tools.png') }}" alt="Hair Care Tools and Products" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Real Transformations -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Real Clients. Real Results.</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Browse real transformations from DBT—neat parts, clean finishing, and styles that hold up beautifully. Whether you're booking knotless braids, box braids, or a special-occasion look, we focus on precision, comfort, and hair health so you leave feeling confident.
                                    </p>
                                    <div class="slide-features">
                                        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%); border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <div style="color: #ff6600; font-size: 1.8rem; margin-right: 15px;"><i class="bi bi-chat-quote-fill"></i></div>
                                                <div>
                                                    <div style="color: #666; font-style: italic; font-size: 0.95rem;">"The best braiding experience in Ottawa. My knotless braids stayed neat for weeks."</div>
                                                    <div style="color: #030f68; font-weight: 600; font-size: 0.9rem; margin-top: 8px;">— <strong>Sarah M.</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%); border-radius: 12px; padding: 20px; margin-bottom: 15px;">
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <div style="color: #ff6600; font-size: 1.8rem; margin-right: 15px;"><i class="bi bi-chat-quote-fill"></i></div>
                                                <div>
                                                    <div style="color: #666; font-style: italic; font-size: 0.95rem;">"Professional, clean, and so talented. My daughter's hair turned out perfect."</div>
                                                    <div style="color: #030f68; font-weight: 600; font-size: 0.9rem; margin-top: 8px;">— <strong>Jennifer T.</strong></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3" style="background: linear-gradient(135deg, rgba(255,102,0,0.08) 0%, rgba(3,15,104,0.05) 100%); padding: 18px; border-radius: 12px;">
                                        <div style="display: flex; gap: 10px; align-items: center; color: #ff6600; font-size: 1.3rem; margin-bottom: 10px;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <span style="color: #030f68; font-weight: 700; font-size: 1.1rem; margin-left: 10px;">4.9/5 Average Rating</span>
                                        </div>
                                        <p style="margin: 0; color: #030f68; font-size: 0.95rem; font-weight: 500;"><strong style="color: #ff6600;">Client Testimonials</strong> — Don't just take our word for it. See what clients are saying.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/client-testimonials.png') }}" alt="Client Testimonials - Don't just listen to us... listen to them" style="width: 100%; max-width: 500px; height: 400px; object-fit: cover; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15);">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5: Mobile Service -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">We Come to You!</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Can't make it to us? No problem! We offer mobile braiding services throughout Ottawa. Enjoy professional hair styling in the comfort of your own home.
                                    </p>
                                    <div class="slide-features">
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-house-heart-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Convenient at-home service</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-clock-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Flexible scheduling options</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-geo-alt-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Serving all of Ottawa</span>
                                        </div>
                                        <div class="feature-item" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <i class="bi bi-people-fill" style="color: #ff6600; margin-right: 10px; font-size: 1.3rem;"></i>
                                            <span style="color: #333; font-weight: 500;">Great for groups & parties</span>
                                        </div>
                                    </div>
                                    <div class="mt-4" style="background: linear-gradient(135deg, rgba(255,102,0,0.1) 0%, rgba(3,15,104,0.05) 100%); padding: 18px; border-radius: 12px; border-left: 4px solid #ff6600;">
                                        <p style="margin: 0; color: #030f68; font-weight: 600; font-size: 1rem;">Select "Mobile Service" when booking to have us come to your location!</p>
                                    </div>
                                    <button class="btn btn-warning mt-3" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" style="font-weight: 600; padding: 12px 30px;">
                                        <i class="bi bi-calendar-check me-2"></i>Book Mobile Service
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center;">
                                    <img src="{{ asset('images/mobile-home-service.png') }}" alt="Mobile Home Service - Beauty Services Anywhere, Anytime" style="width: 100%; max-width: 500px; height: 400px; object-fit: contain; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.15); background: white; padding: 20px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 6: Ready to Book CTA -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="slide-content" style="padding: 40px;">
                                    <h3 style="color: #030f68; font-weight: 700; font-size: 2rem; margin-bottom: 20px;">Ready for Your Transformation?</h3>
                                    <p style="color: #666; font-size: 1.1rem; line-height: 1.6; margin-bottom: 25px;">
                                        Book your appointment now and experience the DBT difference. We're here to make you look and feel amazing!
                                    </p>
                                    <div class="slide-features">
                                        <div style="background: linear-gradient(135deg, #030f68 0%, #ff6600 100%); border-radius: 15px; padding: 25px; color: white; margin-bottom: 20px;">
                                            <h4 style="color: white; font-weight: 700; margin-bottom: 15px; font-size: 1.4rem;">What You Get:</h4>
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span>Expert consultation & styling advice</span>
                                            </div>
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span>Premium quality hair extensions</span>
                                            </div>
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span>Comfortable, relaxing atmosphere</span>
                                            </div>
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span>Aftercare tips & product recommendations</span>
                                            </div>
                                            <div style="display: flex; align-items: center;">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span>100% satisfaction guarantee</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        <button class="btn btn-warning" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" style="font-weight: 600; padding: 12px 30px;">
                                            <i class="bi bi-calendar-check me-2"></i>Book Now
                                        </button>
                                        <button class="btn btn-outline-primary" onclick="document.getElementById('services').scrollIntoView({behavior: 'smooth'});" style="font-weight: 600; padding: 12px 30px; border: 2px solid #030f68; color: #030f68;">
                                            <i class="bi bi-grid me-2"></i>View Services
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="slide-image" style="text-align: center; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #030f68 0%, #ff6600 100%); border-radius: 20px; height: 400px; position: relative; overflow: hidden;">
                                    <div style="position: absolute; inset: 0; background: url('{{ asset('images/stitch braid.jpg') }}') center/cover; opacity: 0.2;"></div>
                                    <div class="text-center" style="position: relative; z-index: 1; color: white; padding: 40px;">
                                        <i class="bi bi-stars" style="font-size: 4rem; margin-bottom: 20px;"></i>
                                        <h4 style="font-weight: 700; margin-bottom: 15px; font-size: 1.8rem;">Your Hair Deserves the Best</h4>
                                        <p style="font-size: 1.2rem; margin-bottom: 0;">Professional. Caring. Exceptional.</p>
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

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="text-center mb-5">
                <h2 class="section-title" style="font-weight: 700;">Our Services</h2>
                <p class="lead">Professional hair braiding and styling services</p>
            </div>

            <!-- Quick Pick Filter -->
            <div class="mb-4 text-center">
                <div class="d-inline-flex flex-wrap gap-2 justify-content-center" role="group" aria-label="Service filter">
                    <button class="btn btn-sm btn-outline-primary filter-chip active" data-filter="all" onclick="filterServices('all')">
                        All Services
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="knotless" onclick="filterServices('knotless')">
                        Knotless Braids
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="box" onclick="filterServices('box')">
                        Box Braids
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="french" onclick="filterServices('french')">
                        French Curl
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="twist" onclick="filterServices('twist')">
                        Twists
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="kids" onclick="filterServices('kids')">
                        Kids
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="cornrow" onclick="filterServices('cornrow')">
                        Cornrow/Feed-in
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="crotchet" onclick="filterServices('crotchet')">
                        Crotchet
                    </button>
                    <button class="btn btn-sm btn-outline-primary filter-chip" data-filter="other" onclick="filterServices('other')">
                        Other
                    </button>
                </div>
            </div>
                        <!-- length guide removed from services section (moved into booking form) -->

                        <div class="row g-4" id="servicesGrid">
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="knotless" data-index="0">
                    <div class="service-card h-100" onclick="openServiceSizeModal('knotless')">
                        <img src="{{ asset('images/webbraids2.jpg') }}" alt="Knotless Braids">
                        <h4>Knotless Braids</h4>
                        <p class="mb-2">Versatile protective style available in multiple sizes—from ultra-fine to jumbo.</p>
                        <p class="mb-1"><strong>Time:</strong> 2–7 hrs • <strong>Sizes:</strong> Small, Smedium, Medium, Jumbo</p>
                        <p class="mb-3"><strong>Hair:</strong> Not included</p>
                        <p class="price"><strong>From ${{ number_format(config('service_prices.jumbo_knotless', 100),0) }}</strong> <small class="text-muted">(varies by size & length)</small></p>
                        <button class="btn btn-warning mt-3">Select Size & Book</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="french" data-index="1">
                    <div class="service-card h-100" onclick="openServiceSizeModal('french-curl')">
                        <img src="{{ asset('images/french curl braid.jpg') }}" alt="French Curl Braids">
                        <h4>French Curl Braids</h4>
                        <p class="mb-2">Elegant braids with beautiful curly ends for a sophisticated, romantic look.</p>
                        <p class="mb-1"><strong>Time:</strong> 3–7 hrs • <strong>Sizes:</strong> Small, Smedium, Medium, Large</p>
                        <p class="mb-3"><strong>Hair:</strong> Not included</p>
                        <p class="price"><strong>From $120</strong> <small class="text-muted">(varies by size & length)</small></p>
                        <button class="btn btn-warning mt-3">Select Size & Book</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="twist" data-index="2">
                    <div class="service-card h-100" onclick="openServiceSizeModal('twist')">
                        <img src="{{ asset('images/twist-main.jpg') }}" alt="Twist Styles">
                        <h4>Twist Styles</h4>
                        <p class="mb-2">Protective two-strand twists in various sizes—low-tension, versatile styling.</p>
                        <p class="mb-1"><strong>Time:</strong> 2–6 hrs • <strong>Sizes:</strong> Small, Medium, Jumbo/Large, Natural Hair (S/M)</p>
                        <p class="mb-3"><strong>Hair:</strong> Not included • <strong>Note:</strong> Natural Hair Twist - Small: $80, Medium: $60 (no length)</p>
                        <p class="price"><strong>From $60</strong> <small class="text-muted">(varies by size & length)</small></p>
                        <button class="btn btn-warning mt-3">Select Size & Book</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="crotchet" data-index="3">
                    <div class="service-card h-100" onclick="openServiceSizeModal('crotchet')">
                        <img src="{{ asset('images/kinky crotchet.png') }}" alt="Crotchet Styles">
                        <h4>Crotchet Styles</h4>
                        <p class="mb-2">Quick protective styles with various crotchet options—versatile and low-maintenance.</p>
                        <p class="mb-1"><strong>Time:</strong> 1.5–5 hrs • <strong>Types:</strong> 2/3 Line Single, Afro, Individual Loc, Butterfly, Weave Crotchet</p>
                        <p class="mb-3"><strong>Hair:</strong> Not included • <strong>Note:</strong> No length adjustment needed</p>
                        <p class="price"><strong>From $80</strong> <small class="text-muted">(varies by type)</small></p>
                        <button class="btn btn-warning mt-3">Select Type & Book</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="kids" data-index="4">
                    <div class="service-card h-100" onclick="window.location='{{ route('kids.selector') }}'">
                        <img src="{{ asset('images/kids hair style.webp') }}" alt="Kids Braids">
                        <h4>Kids Braids (3–8 yrs)</h4>
                        <p class="mb-2">Gentle, age-appropriate styles with adorable results.</p>
                        <p class="mb-1"><strong>Time:</strong> 2–4 hrs • <strong>Length:</strong> Choose in booking</p>
                        <p class="mb-3"><strong>Hair:</strong> Not included • <strong>Note:</strong> Parent/guardian must stay</p>
                        <p class="price"><strong>From ${{ number_format(config('service_prices.kids_braids', 80),0) }}</strong> <small class="text-muted">(varies by style/complexity)</small></p>
                        <button class="btn btn-warning mt-3">Book this style</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="cornrow" data-index="5">
                    <div class="service-card h-100" onclick="openServiceSizeModal('cornrow')">
                        <img src="{{ asset('images/stitch braid.jpg') }}" alt="Cornrow/Feed-in Braids">
                        <h4>Cornrow/Feed-in Braids</h4>
                        <p class="mb-2">Classic cornrows and feed-in styles with or without weave extensions.</p>
                        <p class="mb-1"><strong>Time:</strong> 1–5 hrs • <strong>Types:</strong> Stitch Weave, Cornrow Weave, Under-wig Weave, Weave&Braid Mixed</p>
                        <p class="mb-2"><strong>Hair:</strong> Not included</p>
                        <p class="mb-3" style="font-size: 0.9rem;"><strong>Note:</strong> Stitch/Cornrow: 8-10 rows $100, 10+ rows $130. Under-wig: $30 (no length). Mixed: $150</p>
                        <p class="price"><strong>From $30</strong> <small class="text-muted">(varies by type)</small></p>
                        <button class="btn btn-warning mt-3">Select Type & Book</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="other">
                    <div class="service-card h-100" onclick="openServiceSizeModal('hair-treatment')">
                        <img src="{{ asset('images/hair_mask.png') }}" alt="Hair Treatment Services">
                        <h4>Hair Treatment Services</h4>
                        <p class="mb-2">Professional hair care treatments for natural and relaxed hair.</p>
                        <p class="mb-1"><strong>Time:</strong> 45 min–2 hrs • <strong>Options:</strong> Natural Hair Mask, Chemical Relaxer</p>
                        <p class="mb-3"><strong>Note:</strong> Optional weave treatment adds $30 to any service</p>
                        <p class="price"><strong>From ${{ number_format(config('service_prices.hair_mask', 50),0) }}</strong> <small class="text-muted">(all treatments $50-$80)</small></p>
                        <button class="btn btn-warning mt-3">Select Treatment & Book</button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6 service-item" data-category="other" data-index="7">
                    <div class="service-card h-100" onclick="openServiceSizeModal('boho')">
                        <img src="{{ asset('images/boho braid.jpg') }}" alt="Boho Braids">
                        <h4>Boho Braids</h4>
                        <p class="mb-2">Knotless braids with curly ends left out for a free-spirited, bohemian look.</p>
                        <p class="mb-1"><strong>Time:</strong> 3–7 hrs • <strong>Sizes:</strong> Small, Smedium, Medium, Jumbo/Large</p>
                        <p class="mb-3"><strong>Hair:</strong> Not included</p>
                        <p class="price"><strong>From $100</strong> <small class="text-muted">(varies by size & length)</small></p>
                        <button class="btn btn-warning mt-3">Select Size & Book</button>
                    </div>
                </div>
            </div>
            
            <!-- See More/Less Button for Mobile -->
            <div class="text-center mt-4 d-md-none" id="seeMoreContainer">
                <button class="btn btn-primary" id="seeMoreBtn" onclick="toggleServices()">
                    <span id="seeMoreText">See More Services</span>
                    <i class="bi bi-chevron-down ms-1" id="seeMoreIcon"></i>
                </button>
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
                    <button type="button" class="btn btn-outline-primary btn-lg px-5" onclick="openCustomServiceModal()" style="font-weight: 600; border-radius: 25px; box-shadow: 0 4px 12px rgba(3, 15, 104, 0.2);">
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

    <!-- Reviews Section -->
    <div class="section section-lg bg-gray-150" style="padding: 50px 0; background: #f8f9fa;">
        <div class="text-center mb-5">
            <p class="subtitle" style="font-size:1.5rem; color:#ff6600; font-weight:600;">Our customers love DBT</p>
            <div class="subtitle-box" style="display:inline-block; margin-bottom:18px;">
                <div class="subtitle-box-text" style="font-size:2rem; color:#030f68; font-weight:700;">Reviews</div>
            </div>
        </div>
        <div class="owl-carousel owl-theme-1" data-items="1" data-sm-items="1" data-md-items="1" data-lg-items="1" data-xl-items="2" data-xxl-items="3" data-margin="15px" data-nav="false" data-dots="true" data-autoplay="5000">
            <div class="testimonial-box" style="background:linear-gradient(135deg,#e3eafc 0%,#f8f9fa 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Cool!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="5 Star Rating" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">"DBT offers great services and she delivers excellently. </div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 1</div>
            </div>
            <div class="testimonial-box" style="background:linear-gradient(135deg,#fff6e3 0%,#ffe3e3 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Excellent!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="5 Star Rating" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">"Very patient and time conscious. She follows up and ensures customer comfortability. I always leave happy!"</div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 2</div>
            </div>
            <div class="testimonial-box" style="background:linear-gradient(135deg,#e3ffe3 0%,#e3f8ff 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Amazing!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="5 Star Rating" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">"DBT braided my child's hair and my child was very comfortable. Her braids don't hurt much and last long!"</div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 3</div>
            </div>
            <div class="testimonial-box" style="background:linear-gradient(135deg,#f8e3ff 0%,#e3eaff 100%); border-radius:18px; box-shadow:0 8px 32px rgba(0,0,0,0.12); padding:38px 28px; margin:0 12px; position:relative;">
                <div class="testimonial-title" style="font-size:1.3rem; color:#ff6600; font-weight:700; margin-top:32px;">Excellent!</div>
                <div class="testimonial-rate"><img src="{{ asset('images/star-ratings.webp') }}" alt="5 Star Rating" width="120" height="22"/></div>
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;"> "Customer relationship is amazing. Very professional and very affordable service. Highly recommend DBT!"</div>
                <div class="testimonial-name" style="font-size:1rem; color:#030f68; font-weight:500;">Client 4</div>
            </div>
        </div>
    </div>


    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
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

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
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
                                        <li>Monday - Friday: 8:00 AM - 8:00 PM</li>
                                        <li>Saturday: 10:00 AM - 8:00 PM</li>
                                        <li>Sunday: 1:00 PM - 8:00 PM</li>
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
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border-left: 4px solid #28a745;">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border-left: 4px solid #dc3545;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" id="contactForm" class="bg-white p-4 rounded shadow-sm" style="border-radius:18px;">
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

    <!-- Booking Modal -->
    <!-- Primary success modal omitted: show deposit modal/banner instead when a booking completes -->

    <!-- Other Services Success Modal removed per request -->

    <!-- Size & Length Selection Modal (Step 1 before booking form) -->
    <div class="modal fade" id="serviceSizeLengthModal" tabindex="-1" aria-labelledby="serviceSizeLengthModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #05137c 100%); color: white; border-radius: 16px 16px 0 0; padding: 20px 30px;">
                    <h5 class="modal-title" id="serviceSizeLengthModalLabel" style="font-weight: 700; font-size: 1.5rem;">
                        <i class="bi bi-card-checklist me-2"></i><span id="serviceCategory">Knotless Braids</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <!-- Step indicator -->
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <div class="d-flex align-items-center" style="background: #030f68; color: white; padding: 8px 16px; border-radius: 50px; font-weight: 600;">
                                <span class="me-2">1</span>
                                <span>Select Size & Length</span>
                            </div>
                            <i class="bi bi-arrow-right" style="color: #ccc;"></i>
                            <div class="d-flex align-items-center" style="background: #e9ecef; color: #666; padding: 8px 16px; border-radius: 50px; font-weight: 600;">
                                <span class="me-2">2</span>
                                <span>Booking Details</span>
                            </div>
                        </div>
                    </div>

                    <!-- Size Selection -->
                    <div class="mb-4">
                        <h6 style="font-weight: 700; color: #030f68; margin-bottom: 15px;">
                            <i class="bi bi-grid-3x3 me-2"></i>Choose Braid Size
                        </h6>
                        <div class="row g-3" id="sizeOptionsContainer">
                            <!-- Size options will be dynamically populated -->
                        </div>
                        
                        <!-- Selected Service Display -->
                        <div id="selectedServiceDisplay" style="display: none; margin-top: 20px; padding: 15px; background: linear-gradient(135deg, #e7f3ff 0%, #cce5ff 100%); border-left: 6px solid #17a2b8; border-radius: 10px;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div>
                                    <div style="font-size: 0.85rem; color: #6c757d; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">
                                        Selected Service
                                    </div>
                                    <div id="selectedServiceName" style="font-size: 1.1rem; font-weight: 700; color: #030f68;"></div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.85rem; color: #6c757d; margin-bottom: 3px;">Base Price</div>
                                    <div id="selectedServicePrice" style="font-size: 1.3rem; font-weight: 800; color: #ff6600;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Weave Add-on (shown for Hair Treatment Services) -->
                    <div class="mb-4" id="weaveAddonSection" style="display: none;">
                        <div class="alert" style="background: linear-gradient(135deg, #fff7e0 0%, #ffe8cc 100%); border-left: 6px solid #ff6600; border-radius: 12px; padding: 20px;">
                            <h6 style="font-weight: 700; color: #030f68; margin-bottom: 15px;">
                                <i class="bi bi-plus-circle me-2"></i>Add Weave Treatment
                            </h6>
                            <p style="margin-bottom: 15px; color: #555; font-size: 0.95rem;">
                                Do you have a weave/extension installed that needs treatment?
                            </p>
                            <div class="d-flex gap-3">
                                <div class="form-check flex-fill" style="background: #fff; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; cursor: pointer;" onclick="toggleWeaveAddon(false)">
                                    <input class="form-check-input" type="radio" name="weave_addon" id="weave_no" value="no" checked>
                                    <label class="form-check-label w-100" for="weave_no" style="cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-x-circle me-2"></i>No Weave
                                        <span class="float-end text-muted">+$0</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill" style="background: #fff; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; cursor: pointer;" onclick="toggleWeaveAddon(true)">
                                    <input class="form-check-input" type="radio" name="weave_addon" id="weave_yes" value="yes">
                                    <label class="form-check-label w-100" for="weave_yes" style="cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-check-circle me-2"></i>Add Weave
                                        <span class="float-end text-success">+$30</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row Options (shown for Stitch and Cornrow Weave) -->
                    <div class="mb-4" id="rowOptionsSection" style="display: none;">
                        <div class="alert" style="background: linear-gradient(135deg, #e7f3ff 0%, #cce5ff 100%); border-left: 6px solid #17a2b8; border-radius: 12px; padding: 20px;">
                            <h6 style="font-weight: 700; color: #030f68; margin-bottom: 15px;">
                                <i class="bi bi-sliders me-2"></i>Choose Number of Rows
                            </h6>
                            <p style="margin-bottom: 15px; color: #555; font-size: 0.95rem;">
                                <strong>Note:</strong> More than 10 rows (tiny braids) attracts an extra $30.
                            </p>
                            <div class="d-flex gap-3">
                                <div class="form-check flex-fill" style="background: #fff; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; cursor: pointer;" onclick="toggleRowOption('8-10')">
                                    <input class="form-check-input" type="radio" name="row_option" id="row_8_10" value="8-10" checked>
                                    <label class="form-check-label w-100" for="row_8_10" style="cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-grid-3x2 me-2"></i>8-10 Rows
                                        <span class="float-end text-muted">+$0</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill" style="background: #fff; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; cursor: pointer;" onclick="toggleRowOption('10+')">
                                    <input class="form-check-input" type="radio" name="row_option" id="row_10_plus" value="10+">
                                    <label class="form-check-label w-100" for="row_10_plus" style="cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-grid-fill me-2"></i>10+ Rows (Tiny)
                                        <span class="float-end text-info">+$30</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Front/Back Add-on (shown for 2/3 Line Single Crotchet) -->
                    <div class="mb-4" id="frontBackAddonSection" style="display: none;">
                        <div class="alert" style="background: linear-gradient(135deg, #fff7e0 0%, #ffe8cc 100%); border-left: 6px solid #ff6600; border-radius: 12px; padding: 20px;">
                            <h6 style="font-weight: 700; color: #030f68; margin-bottom: 15px;">
                                <i class="bi bi-plus-circle me-2"></i>Add Back Coverage
                            </h6>
                            <p style="margin-bottom: 15px; color: #555; font-size: 0.95rem;">
                                Would you like a single crotchet at back too?
                            </p>
                            <div class="d-flex gap-3">
                                <div class="form-check flex-fill" style="background: #fff; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; cursor: pointer;" onclick="toggleFrontBackAddon(false)">
                                    <input class="form-check-input" type="radio" name="frontback_addon" id="frontback_no" value="no" checked>
                                    <label class="form-check-label w-100" for="frontback_no" style="cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-x-circle me-2"></i>Front Only
                                        <span class="float-end text-muted">+$0</span>
                                    </label>
                                </div>
                                <div class="form-check flex-fill" style="background: #fff; padding: 15px; border-radius: 10px; border: 2px solid #e9ecef; cursor: pointer;" onclick="toggleFrontBackAddon(true)">
                                    <input class="form-check-input" type="radio" name="frontback_addon" id="frontback_yes" value="yes">
                                    <label class="form-check-label w-100" for="frontback_yes" style="cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-check-circle me-2"></i>Front + Back
                                        <span class="float-end text-success">+$20</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Length Selection with Guide -->
                    <div class="mb-4" id="lengthSelectionSection">
                        <h6 style="font-weight: 700; color: #030f68; margin-bottom: 15px;">
                            <i class="bi bi-rulers me-2"></i>Choose Hair Length
                        </h6>
                        <div class="row align-items-center">
                            <div class="col-12 col-md-5 text-center mb-3 mb-md-0">
                                <img src="{{ asset('images/braids-length-guide.jpg') }}" alt="Length guide" class="img-fluid" style="max-width: 100%; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="d-flex flex-column gap-2" id="lengthOptionsContainer">
                                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 8px; border: 2px solid transparent; cursor: pointer;" onclick="selectSizeLength('neck')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_neck" value="neck">
                                        <label class="form-check-label w-100" for="size_length_neck" style="cursor: pointer;">
                                            <strong>Neck length</strong> <span class="text-muted float-end">-$40</span>
                                        </label>
                                    </div>
                                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 8px; border: 2px solid transparent; cursor: pointer;" onclick="selectSizeLength('shoulder')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_shoulder" value="shoulder">
                                        <label class="form-check-label w-100" for="size_length_shoulder" style="cursor: pointer;">
                                            <strong>Shoulder length</strong> <span class="text-muted float-end">-$40</span>
                                        </label>
                                    </div>
                                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 8px; border: 2px solid transparent; cursor: pointer;" onclick="selectSizeLength('armpit')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_armpit" value="armpit">
                                        <label class="form-check-label w-100" for="size_length_armpit" style="cursor: pointer;">
                                            <strong>Armpit length</strong> <span class="text-muted float-end">-$40</span>
                                        </label>
                                    </div>
                                    <div class="form-check p-3" style="background: #fff7e0; border-radius: 8px; border: 2px solid #ff6600; cursor: pointer;" onclick="selectSizeLength('mid-back')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_midback" value="mid-back" checked>
                                        <label class="form-check-label w-100" for="size_length_midback" style="cursor: pointer;">
                                            <strong>Mid-back length</strong> <span class="badge bg-warning text-dark float-end">Base Price</span>
                                        </label>
                                    </div>
                                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 8px; border: 2px solid transparent; cursor: pointer;" onclick="selectSizeLength('waist')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_waist" value="waist">
                                        <label class="form-check-label w-100" for="size_length_waist" style="cursor: pointer;">
                                            <strong>Waist length</strong> <span class="text-muted float-end">+$20</span>
                                        </label>
                                    </div>
                                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 8px; border: 2px solid transparent; cursor: pointer;" onclick="selectSizeLength('hip')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_hip" value="hip">
                                        <label class="form-check-label w-100" for="size_length_hip" style="cursor: pointer;">
                                            <strong>Hip length</strong> <span class="text-muted float-end">+$40</span>
                                        </label>
                                    </div>
                                    <div class="form-check p-3" style="background: #f8f9fa; border-radius: 8px; border: 2px solid transparent; cursor: pointer;" onclick="selectSizeLength('tailbone')">
                                        <input class="form-check-input" type="radio" name="size_length" id="size_length_tailbone" value="tailbone">
                                        <label class="form-check-label w-100" for="size_length_tailbone" style="cursor: pointer;">
                                            <strong>Tailbone / Classic length</strong> <span class="text-muted float-end">+$60</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Price Display -->
                    <div class="alert" style="background: linear-gradient(135deg, #fff7e0 0%, #ffe8cc 100%); border-left: 6px solid #ff6600; border-radius: 12px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size: 0.9rem; color: #666; font-weight: 500;">Estimated Total</div>
                                <div id="sizeLengthPriceDisplay" style="font-size: 2rem; font-weight: 800; color: #030f68;">$--</div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Base + Length adjustment</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 2px solid #e9ecef; padding: 20px 30px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 8px;">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-warning" id="continueToBookingBtn" onclick="continueToBooking()" style="padding: 10px 30px; border-radius: 8px; font-weight: 700; background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); border: none;">
                        <i class="bi bi-arrow-right-circle me-2"></i>Continue to Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

                    <!-- Booking Modal (contains Single Booking Form) -->
                    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 12px;">
                                <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white; border-radius: 12px 12px 0 0;">
                                    <button type="button" class="btn btn-link text-white p-0 me-2" id="backToServiceSelectionBtn" onclick="backToServiceSelection()" style="display: none; text-decoration: none; font-size: 1.2rem;" title="Back to Service Selection">
                                        <i class="bi bi-arrow-left"></i>
                                    </button>
                                    <h5 class="modal-title" id="bookingModalLabel" style="flex: 1;">Book Service</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                    <!-- Single Booking Form -->
                    <form id="bookingForm" action="/bookings" method="POST" autocomplete="on" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="appointment_date" name="appointment_date">
                        <input type="hidden" id="appointment_time_hidden" name="appointment_time">
                        <input type="hidden" id="selectedService" name="service">
                        <input type="hidden" id="selectedServiceType" name="service_type">
                        <input type="hidden" id="selectedPrice" name="price">
                        <input type="hidden" id="final_price_input" name="final_price" value="">
                        <input type="hidden" id="stitch_rows_option" name="stitch_rows_option" value="">

                        <div class="row g-4">
                            <!-- Service Selection -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="serviceSelection" class="form-label">Service *</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="serviceDisplay" name="service_display" readonly style="background-color: #f8f9fa;">
                                        <button class="btn btn-outline-secondary" type="button" onclick="openNonKidsServicesModal()">
                                            <i class="bi bi-pencil"></i> Change
                                        </button>
                                    </div>
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Selected service. Click "Change" to select a different service.
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
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" autocomplete="off" required>
                                </div>
                            </div>

                            <!-- Appointment Type -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Appointment Type *</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="appointment_type" id="appointment_type_in_studio" value="in-studio" checked>
                                            <label class="form-check-label" for="appointment_type_in_studio">
                                                <i class="bi bi-house-door me-1"></i>Stylist address
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="appointment_type" id="appointment_type_mobile" value="mobile">
                                            <label class="form-check-label" for="appointment_type_mobile">
                                                <i class="bi bi-truck me-1"></i>Mobile (I want you to come to me)
                                            </label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-info-circle me-1"></i>Mobile service available in Ottawa/Gatineau. Travel fee may apply based on distance.
                                    </small>
                                </div>
                            </div>

                            <!-- Service Address (conditional) -->
                            <div class="col-12 d-none" id="addressFieldContainer">
                                <div class="form-group">
                                    <label for="address" class="form-label">Mobile Service Address (Ottawa) *</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter your complete address" autocomplete="off">
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-geo-alt me-1"></i>Required for mobile appointments so we can confirm travel availability and any travel fee.
                                    </small>
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
                            <!-- Terms acceptance (required) -->
                            <input type="hidden" name="terms_accepted" value="0">
                            <div class="dbt-terms-consent mb-3">
                                <input class="form-check-input" type="checkbox" id="termsAcceptedMain" name="terms_accepted" value="1" required autocomplete="off">
                                <div>
                                    <label for="termsAcceptedMain" style="text-align:left;">
                                        I agree to the <a href="#terms" style="color:#030f68; font-weight:600; text-decoration:none;" onclick="closeModalAndGoToTerms(event)">Terms &amp; Conditions</a>.
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning" id="bookAppointmentBtn" style="font-size:1.1rem; padding:12px 40px; font-weight:600; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);">
                                <i class="bi bi-calendar-check me-2"></i>Book Appointment
                            </button>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    A $20 deposit is required to confirm your appointment. Mobile appointments are confirmed after deposit + address verification.
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
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
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
                        <h6 class="mb-3" style="font-weight: 600; color: #0b3a66;">Available Time Slots for <span id="selectedDateText"></span></h6>
                        <div id="timeSlotsInstruction" class="alert alert-info mb-3" style="display: none; background: #e7f3ff; border-left: 4px solid #17a2b8; border-radius: 8px;">
                            <i class="bi bi-info-circle me-2"></i>Click a time slot to select it.
                        </div>
                        <div id="timeSlots" class="row g-2 row-cols-2 row-cols-md-3 row-cols-lg-4"></div>
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

    <!-- Custom Service Request Modal -->
    <div class="modal fade" id="customServiceRequestModal" tabindex="-1" aria-labelledby="customServiceRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title" id="customServiceRequestModalLabel">
                        <i class="bi bi-person-lines-fill me-2"></i>Contact Information
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="customServiceRequestForm">
                        <div class="row g-3">
                            <!-- Name Field - Full Width -->
                            <div class="col-12">
                                <label for="csrName" class="form-label fw-semibold">
                                    <i class="bi bi-person me-1"></i>Your Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-lg" id="csrName" name="name" placeholder="Enter your full name" maxlength="255" required style="border-radius: 8px; border: 2px solid #e9ecef; transition: border-color 0.3s ease;">
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Please enter your first and last name
                                </small>
                            </div>
                            
                            <!-- Phone Number - Full Width on Mobile, Half on Desktop -->
                            <div class="col-12 col-md-6">
                                <label for="csrPhone" class="form-label fw-semibold">
                                    <i class="bi bi-phone me-1"></i>Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control form-control-lg" id="csrPhone" name="phone" placeholder="Enter your phone number" maxlength="20" required style="border-radius: 8px; border: 2px solid #e9ecef; transition: border-color 0.3s ease;">
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Include area code
                                </small>
                            </div>
                            
                            <!-- Email - Full Width on Mobile, Half on Desktop -->
                            <div class="col-12 col-md-6">
                                <label for="csrEmail" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1"></i>Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control form-control-lg" id="csrEmail" name="email" placeholder="Enter your email address" maxlength="255" required style="border-radius: 8px; border: 2px solid #e9ecef; transition: border-color 0.3s ease;">
                                <small class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>We'll send confirmation to this email
                                </small>
                            </div>
                            
                            <!-- Information Box -->
                            <div class="col-12">
                                <div class="alert alert-info mb-0" style="border-radius: 8px; border-left: 4px solid #030f68;">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>What happens next?</strong><br>
                                    We'll review your custom service request and contact you within 24-48 hours to discuss pricing and availability.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-lg" onclick="submitCustomServiceRequestFromModal()" style="border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-send me-2"></i>Submit Request
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
                                        <div class="small text-muted">Starting at $150</div>
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
                                        <div class="small text-muted">Starting at $120</div>
                                    </button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100 service-quick-btn" onclick="selectQuickService('Twist Braids')">
                                        Twist Braids
                                        <div class="small text-muted">Starting at $130</div>
                                    </button>
                                </div>
                            </div>
                            <div class="alert alert-info mt-3 mb-0" style="background: #e7f3ff; border-left: 4px solid #17a2b8; border-radius: 8px;">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-info-circle me-2" style="font-size: 1.2rem; color: #17a2b8; margin-top: 2px;"></i>
                                    <div>
                                        <strong style="color: #0b3a66;">Note:</strong>
                                        <p class="mb-0" style="color: #0b3a66; font-size: 0.9rem;">
                                            <strong>Kinky Twist</strong> and <strong>Twist Braids</strong> prices shown are for <strong>mid-back length</strong>. You can select a different length during booking, and the price will adjust automatically. Other popular services use fixed mid-back pricing.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Service Input -->
                        <div class="col-12 mt-4">
                            <div class="border-top pt-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-stars me-2" style="color: #ff6600;"></i>Custom Service Request
                                </h6>
                                <div class="alert alert-warning mb-3" style="background: #fff7e0; border-left: 4px solid #ff6600; border-radius: 8px;">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-info-circle me-2" style="font-size: 1.2rem; color: #ff6600; margin-top: 2px;"></i>
                                        <div>
                                            <strong style="color: #0b3a66;">Custom Service Information</strong>
                                            <ul class="mb-0 mt-2" style="color: #0b3a66; font-size: 0.9rem; padding-left: 20px;">
                                                <li>Prices vary based on <strong>hair length, thickness, and design complexity</strong></li>
                                                <li>Length adjustments apply: <strong>+$20 for longer, -$40 for shorter</strong> than mid-back</li>
                                                <li>Final pricing will be <strong>confirmed during consultation</strong> before service</li>
                                                <li>You'll receive email confirmation with estimated pricing</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Custom Service Form -->
                                <form id="customServiceForm">
                                    <div class="row g-3">
                                        <!-- Service Name -->
                                        <div class="col-12">
                                            <label for="customServiceInput" class="form-label fw-semibold">
                                                <i class="bi bi-pencil-square me-1"></i>Service Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="customServiceInput" name="service_name" placeholder="e.g., Goddess Braids, Box Braids, Passion Twists, Feed-in Braids, etc." maxlength="255" required style="border-radius: 8px;">
                                            <small class="form-text text-muted d-block mt-1">
                                                <i class="bi bi-lightbulb me-1"></i>
                                                Be specific about the style you want
                                            </small>
                            </div>

                                        <!-- Service Category -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-tags me-1"></i>Service Category
                                            </label>
                                            <div class="radio-group-container">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_braids" value="braids">
                                                    <label class="form-check-label" for="cat_braids">Braids</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_twists" value="twists">
                                                    <label class="form-check-label" for="cat_twists">Twists</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_locs" value="locs">
                                                    <label class="form-check-label" for="cat_locs">Locs/Dreadlocks</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_weave" value="weave">
                                                    <label class="form-check-label" for="cat_weave">Weave/Extensions</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_natural" value="natural">
                                                    <label class="form-check-label" for="cat_natural">Natural Hair Styling</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_color" value="color">
                                                    <label class="form-check-label" for="cat_color">Hair Coloring</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_treatment" value="treatment">
                                                    <label class="form-check-label" for="cat_treatment">Hair Treatment</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="service_category" id="cat_other" value="other">
                                                    <label class="form-check-label" for="cat_other">Other</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Braid Size Preference -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-rulers me-1"></i>Braid/Twist Size
                                            </label>
                                            <div class="radio-group-container">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_micro" value="micro">
                                                    <label class="form-check-label" for="size_micro">Micro (Very Small)</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_small" value="small">
                                                    <label class="form-check-label" for="size_small">Small</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_medium" value="medium">
                                                    <label class="form-check-label" for="size_medium">Medium</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_large" value="large">
                                                    <label class="form-check-label" for="size_large">Large</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_jumbo" value="jumbo">
                                                    <label class="form-check-label" for="size_jumbo">Jumbo (Very Large)</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_mixed" value="mixed">
                                                    <label class="form-check-label" for="size_mixed">Mixed Sizes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="braid_size" id="size_na" value="not-applicable">
                                                    <label class="form-check-label" for="size_na">Not Applicable</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hair Length -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-scissors me-1"></i>Current Hair Length
                                            </label>
                                            <div class="radio-group-container" style="max-height: 250px; overflow-y: auto;">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_neck" value="neck">
                                                    <label class="form-check-label" for="len_neck">Neck Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_shoulder" value="shoulder">
                                                    <label class="form-check-label" for="len_shoulder">Shoulder Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_armpit" value="armpit">
                                                    <label class="form-check-label" for="len_armpit">Armpit Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_bra_strap" value="bra_strap">
                                                    <label class="form-check-label" for="len_bra_strap">Bra Strap Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_mid_back" value="mid_back">
                                                    <label class="form-check-label" for="len_mid_back">Mid-Back Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_waist" value="waist">
                                                    <label class="form-check-label" for="len_waist">Waist Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_hip" value="hip">
                                                    <label class="form-check-label" for="len_hip">Hip Length</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_tailbone" value="tailbone">
                                                    <label class="form-check-label" for="len_tailbone">Tailbone Length</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hair_length" id="len_classic" value="classic">
                                                    <label class="form-check-label" for="len_classic">Classic Length</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Estimated Budget Range -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-currency-dollar me-1"></i>Estimated Budget Range
                                            </label>
                                            <div class="radio-group-container">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_under100" value="under-100">
                                                    <label class="form-check-label" for="budget_under100">Under $100</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_100_150" value="100-150">
                                                    <label class="form-check-label" for="budget_100_150">$100 - $150</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_150_200" value="150-200">
                                                    <label class="form-check-label" for="budget_150_200">$150 - $200</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_200_250" value="200-250">
                                                    <label class="form-check-label" for="budget_200_250">$200 - $250</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_250_300" value="250-300">
                                                    <label class="form-check-label" for="budget_250_300">$250 - $300</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_300_400" value="300-400">
                                                    <label class="form-check-label" for="budget_300_400">$300 - $400</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_400_500" value="400-500">
                                                    <label class="form-check-label" for="budget_400_500">$400 - $500</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_over500" value="over-500">
                                                    <label class="form-check-label" for="budget_over500">Over $500</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="budget_range" id="budget_flexible" value="flexible">
                                                    <label class="form-check-label" for="budget_flexible">Flexible</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Style Preferences -->
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-palette me-1"></i>Style Preferences (Select all that apply)
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="prefProtective" name="style_preferences[]" value="protective">
                                                        <label class="form-check-label" for="prefProtective">Protective Style</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="prefLowMaintenance" name="style_preferences[]" value="low-maintenance">
                                                        <label class="form-check-label" for="prefLowMaintenance">Low Maintenance</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="prefLongLasting" name="style_preferences[]" value="long-lasting">
                                                        <label class="form-check-label" for="prefLongLasting">Long Lasting</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="prefWithExtensions" name="style_preferences[]" value="with-extensions">
                                                        <label class="form-check-label" for="prefWithExtensions">With Extensions</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="prefWithBeads" name="style_preferences[]" value="with-beads">
                                                        <label class="form-check-label" for="prefWithBeads">With Beads/Accessories</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="prefWithColor" name="style_preferences[]" value="with-color">
                                                        <label class="form-check-label" for="prefWithColor">With Color/Highlights</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Special Requirements -->
                                        <div class="col-12">
                                            <label for="customSpecialRequirements" class="form-label fw-semibold">
                                                <i class="bi bi-clipboard-check me-1"></i>Special Requirements or Notes
                                            </label>
                                            <textarea class="form-control" id="customSpecialRequirements" name="special_requirements" rows="3" placeholder="Any specific requirements, allergies, previous service history, or additional details..." style="border-radius: 8px;"></textarea>
                                            <small class="form-text text-muted d-block mt-1">
                                                Include any important information that will help us provide the best service
                                </small>
                            </div>

                                        <!-- Urgency/Timeline -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-clock me-1"></i>When do you need this service?
                                            </label>
                                            <div class="radio-group-container">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="urgency" id="urgent_asap" value="asap">
                                                    <label class="form-check-label" for="urgent_asap">As Soon As Possible</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="urgency" id="urgent_week" value="within-week">
                                                    <label class="form-check-label" for="urgent_week">Within a Week</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="urgency" id="urgent_month" value="within-month">
                                                    <label class="form-check-label" for="urgent_month">Within a Month</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="urgency" id="urgent_flexible" value="flexible">
                                                    <label class="form-check-label" for="urgent_flexible">Flexible</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="urgency" id="urgent_specific" value="specific-date">
                                                    <label class="form-check-label" for="urgent_specific">I have a specific date in mind</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reference Image Upload -->
                                        <div class="col-md-6">
                                            <label for="customReferenceImage" class="form-label fw-semibold">
                                                <i class="bi bi-image me-1"></i>Reference Image (Optional)
                                            </label>
                                            <input type="file" class="form-control form-control-lg" id="customReferenceImage" name="reference_image" accept="image/*" style="border-radius: 8px;">
                                            <small class="form-text text-muted d-block mt-1">
                                                Upload a photo of the style you want (max 5MB)
                                            </small>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="button" class="btn btn-primary btn-lg w-100" onclick="openCustomServiceRequestModal()" style="border-radius: 8px; font-weight: 600;">
                                            <i class="bi bi-send me-2"></i>Submit Request
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Who is this service for? Modal -->
    <div class="modal fade" id="serviceForWhoModal" tabindex="-1" aria-labelledby="serviceForWhoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 18px; border: none; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="serviceForWhoModalLabel" style="font-weight: 700;">
                        <i class="bi bi-question-circle me-2"></i>Who is this service for?
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3" style="color:#0b3a66; font-weight: 600;">Select one option:</p>
                    <div class="d-grid gap-3">
                        <button type="button" class="btn btn-outline-primary btn-lg" onclick="chooseServiceForKids()"
                                style="border-radius: 14px; font-weight: 700; padding: 14px 16px;">
                            <i class="bi bi-emoji-smile me-2"></i>Kid (0–8 years)
                        </button>
                        <button type="button" class="btn btn-primary btn-lg" onclick="chooseServiceForNotKids()"
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

    <!-- Non-kids service picker (excludes Kids Braids) -->
    <div class="modal fade" id="nonKidsServicesModal" tabindex="-1" aria-labelledby="nonKidsServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 18px; border: none; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="nonKidsServicesModalLabel" style="font-weight: 700;">
                        <i class="bi bi-scissors me-2"></i>Select a service
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info" style="background:#e7f3ff; border-left: 4px solid #17a2b8; border-radius: 10px;">
                        <i class="bi bi-info-circle me-2"></i>These are all services (excluding Kids Braids). Choose one to continue booking.
                    </div>
                    <div id="nonKidsServicesList" class="row g-2"></div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stitch Braids rows selector (8–10 vs >10 rows) -->
    <div class="modal fade" id="stitchRowsModal" tabindex="-1" aria-labelledby="stitchRowsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 18px; border: none; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="stitchRowsModalLabel" style="font-weight: 800;">
                        <i class="bi bi-sliders me-2"></i>Stitch Braids — choose rows
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info" style="background:#e7f3ff; border-left: 4px solid #17a2b8; border-radius: 10px;">
                        <strong>Note:</strong> Tiny Stitch Braids (more than 10 rows) attracts an extra <strong>$30</strong>.
                    </div>
                    <div class="d-grid gap-3">
                        <button type="button" class="btn btn-primary btn-lg"
                                onclick="window.selectStitchRowsOption('ten_or_less')"
                                style="border-radius: 14px; font-weight: 800; padding: 14px 16px;">
                            8–10 rows (base price)
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-lg"
                                onclick="window.selectStitchRowsOption('more_than_ten')"
                                style="border-radius: 14px; font-weight: 800; padding: 14px 16px;">
                            More than 10 rows (tiny) +$30
                        </button>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Kids Booking Modal moved to end of file -->

    <!-- FAQ Section -->
    <div id="faq" class="section section-xl" style="padding: 80px 0; background-color: #f8f9fa;">
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
                                Yes, we offer home services for your convenience! Please note, we do not charge differently for home service fee, our clients are responsible for covering the cost of fueling the stylist's transportation. Fees vary based on the distance to the service location.
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
    <div class="section section-xl" style="padding: 50px 0; background-color: #fff;">
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

    <!-- Terms and Conditions Section -->
    <section id="terms" class="section section-xl" style="padding: 50px 0; background-color: #f8f9fa;">
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
                                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                            <strong>No Show:</strong> No-shows will result in full charge and may affect future bookings
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-arrow-clockwise text-success me-2"></i>
                                            <strong>Rescheduling:</strong> Rescheduling is allowed with 48 hours notice
                                        </li>
                                        <li class="mb-3">
                                            <i class="bi bi-calendar2-week-fill text-primary me-2"></i>
                                            <strong>Reschedule Window:</strong> Reschedules must be within 1 month of the initial appointment date
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
                                            <strong>Transportation:</strong> Clients are responsible for covering the cost of fueling the stylist's transportation. Fees vary based on the distance to the service location.
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
                                                <li class="mb-3">
                                                    <i class="bi bi-exclamation-circle-fill text-warning me-2"></i>
                                                    <strong>Style Changes:</strong> No style changes allowed on the day of appointment or after confirmation, as a time window is reserved for your service
                                                </li>
                                                <li class="mb-3">
                                                    <i class="bi bi-calendar-check-fill text-info me-2"></i>
                                                    <strong>Time Reservation:</strong> Once confirmed, your appointment slot is exclusively reserved, preventing other bookings
                                                </li>
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
                // Hide back button when modal is closed
                const backBtn = document.getElementById('backToServiceSelectionBtn');
                if (backBtn) {
                    backBtn.style.display = 'none';
                }
                // Reset the flag
                window.cameFromServiceSelection = false;
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
        if(depositModal) depositModal.hide();

        // Show contact information
        alert('Please contact us at:\n\nPhone: (343) 254-8848\nEmail: info@dabsbeautytouch.com\nWhatsApp: https://wa.me/13432548848\n\nWe will provide you with payment details and confirm your appointment once payment is received.');
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

        // Intercept navbar "Services" click to launch the guided flow (kids vs not kids)
        document.addEventListener('DOMContentLoaded', function() {
            const navServicesLink = document.getElementById('navServicesLink');
            if (navServicesLink) {
                navServicesLink.addEventListener('click', function(e) {
                    // Only intercept when we're on the home page and the modal exists
                    const modalEl = document.getElementById('serviceForWhoModal');
                    if (modalEl && typeof window.openServiceForWhoModal === 'function') {
                        e.preventDefault();
                        window.openServiceForWhoModal();
                    }
                });
            }
        });
    }

    // Calendar modal: close then scroll to services section
    function closeCalendarAndGoToServices(event) {
        event.preventDefault();

        const calendarModal = bootstrap.Modal.getInstance(document.getElementById('calendarModal'));
        if (calendarModal) {
            calendarModal.hide();
        }

        // Wait for modal to close then scroll
        setTimeout(function() {
            scrollToServices();
        }, 300);
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
<script src="{{ asset('js/core.min.js') }}?v={{ @filemtime(public_path('js/core.min.js')) }}"></script>
<script src="{{ asset('js/script.js') }}?v={{ @filemtime(public_path('js/script.js')) }}"></script>

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

            // Hide back button when opening from service cards (not from service selection)
            window.cameFromServiceSelection = false;
            const backBtn = document.getElementById('backToServiceSelectionBtn');
            if (backBtn) {
                backBtn.style.display = 'none';
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
            // Check if terms were already accepted before resetting
            const KEY = 'dbt_terms_accepted_v1';
            const hasAccepted = () => {
                try { return window.localStorage && localStorage.getItem(KEY) === '1'; } catch(e) { return false; }
            };
            const termsWereAccepted = hasAccepted();
            
            form.reset();
            
            // Restore terms checkbox if terms were already accepted
            if (termsWereAccepted) {
                const termsCheckbox = document.getElementById('termsAcceptedMain');
                if (termsCheckbox) {
                    termsCheckbox.checked = true;
                }
            }
            
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
    window.openServiceSelectionModal = function() {
        // New guided flow: ask who the service is for first
        if (typeof window.openServiceForWhoModal === 'function') {
            window.openServiceForWhoModal();
            return;
        }
        // Fallback to old modal if needed
        const modalEl = document.getElementById('serviceSelectionModal');
        if (!modalEl) {
            console.error('Service selection modal not found');
            return;
        }
        const serviceModal = new bootstrap.Modal(modalEl);
        serviceModal.show();
    };

    // Always open the "Select Service" modal (Popular Services + Custom Service Request)
    // This bypasses the kids-vs-not-kids prompt.
    window.openSelectServiceModal = function() {
        const modalEl = document.getElementById('serviceSelectionModal');
        if (!modalEl) {
            console.error('serviceSelectionModal not found');
            return;
        }
        try {
            const m = new bootstrap.Modal(modalEl);
            m.show();
        } catch (e) {
            // fallback
            modalEl.style.display = 'block';
            modalEl.classList.add('show');
            modalEl.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
        }
    };
    
    // Also define as regular function for backward compatibility
    function openServiceSelectionModal() {
        window.openServiceSelectionModal();
    }

    // Function to open custom service modal directly (skips popular services list)
    window.openCustomServiceModal = function() {
        const modalEl = document.getElementById('serviceSelectionModal');
        if (!modalEl) {
            console.error('Service selection modal not found');
            return;
        }
        
        // Hide the popular services section
        const popularServicesSection = modalEl.querySelector('.row.g-2');
        if (popularServicesSection && popularServicesSection.parentElement) {
            popularServicesSection.parentElement.style.display = 'none';
        }
        
        // Show the modal
        const serviceModal = new bootstrap.Modal(modalEl);
        serviceModal.show();
        
        // After modal is shown, scroll to and focus on the custom service input
        modalEl.addEventListener('shown.bs.modal', function() {
            const customServiceInput = document.getElementById('customServiceInput');
            if (customServiceInput) {
                // Scroll to the custom service section
                customServiceInput.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Focus on the input
                setTimeout(() => customServiceInput.focus(), 300);
            }
        }, { once: true });
        
        // When modal is hidden, restore popular services visibility for other uses
        modalEl.addEventListener('hidden.bs.modal', function() {
            if (popularServicesSection && popularServicesSection.parentElement) {
                popularServicesSection.parentElement.style.display = '';
            }
        }, { once: true });
    };

    // Guided service flow: Who is this service for?
    window.openServiceForWhoModal = function() {
        const modalEl = document.getElementById('serviceForWhoModal');
        if (!modalEl) {
            console.warn('serviceForWhoModal not found; falling back to serviceSelectionModal');
            return window.openServiceSelectionModal?.();
        }
        const m = new bootstrap.Modal(modalEl);
        m.show();
    };

    window.chooseServiceForKids = function() {
        try {
            const whoModal = bootstrap.Modal.getInstance(document.getElementById('serviceForWhoModal'));
            if (whoModal) whoModal.hide();
        } catch (e) {}

        // Redirect to the kids selector page
        try { window.__dbtSaveBookingDraftFromMain?.(); } catch (e) {}
        window.location.href = '/kids-selector';
    };

    window.chooseServiceForNotKids = function() {
        // From the booking modal "Change service" flow, go to the Select Service modal (popular + custom request)
        const bookingVisible = (function(){
            try {
                const bm = document.getElementById('bookingModal');
                return !!(bm && bm.classList.contains('show'));
            } catch (e) { return false; }
        })();

        if (window.__serviceChangeFlow === true || bookingVisible) {
            window.__serviceChangeFlow = false;

            const openSelect = function() {
                try { window.openSelectServiceModal?.(); } catch (e) {}
            };

            try {
                const whoEl = document.getElementById('serviceForWhoModal');
                const whoModal = bootstrap.Modal.getInstance(whoEl);
                if (whoEl && whoModal) {
                    // Wait until the "who for" modal is fully hidden before opening another modal
                    whoEl.addEventListener('hidden.bs.modal', function() {
                        openSelect();
                    }, { once: true });
                    whoModal.hide();
                    // Fallback in case the event doesn't fire (safety)
                    setTimeout(openSelect, 450);
                    return;
                }
            } catch (e) {}

            // If we couldn't access the modal instance, try opening immediately
            openSelect();
            return;
        }

        // Default flow (navbar Services): show non-kids list
        try {
            const whoModal = bootstrap.Modal.getInstance(document.getElementById('serviceForWhoModal'));
            if (whoModal) whoModal.hide();
        } catch (e) {}
        window.openNonKidsServicesModal();
    };

    window.openNonKidsServicesModal = function() {
        const modalEl = document.getElementById('nonKidsServicesModal');
        if (!modalEl) {
            console.warn('nonKidsServicesModal not found; falling back to serviceSelectionModal');
            return window.openServiceSelectionModal?.();
        }

        window.populateNonKidsServicesList();
        const m = new bootstrap.Modal(modalEl);
        m.show();
    };

    window.populateNonKidsServicesList = function() {
        const container = document.getElementById('nonKidsServicesList');
        if (!container) return;
        container.innerHTML = '';

        // Base prices (single source of truth: config/service_prices.php + popular services)
        @php
            $basePriceByServiceName = [
                // Knotless Braids
                'Small Knotless Braids' => (int) config('service_prices.small_knotless', 170),
                'Smedium Knotless Braids' => (int) config('service_prices.smedium_knotless', 150),
                'Medium Knotless Braids' => (int) config('service_prices.medium_knotless', 130),
                'Jumbo Knotless Braids' => (int) config('service_prices.jumbo_knotless', 100),
                
                // Boho Braids
                'Small Boho Braids' => 180,
                'Smedium Boho Braids' => (int) config('service_prices.boho_braids', 150),
                'Medium Boho Braids' => 130,
                'Jumbo/Large Boho Braids' => 100,
                
                // Twist Styles
                'Small Twists' => 150,
                'Medium Twists' => 120,
                'Jumbo/Large Twists' => 100,
                'Small Natural Hair Twist' => 80,
                'Medium Natural Hair Twist' => 60,
                
                // French Curl Braids
                'Small French Curl Braids' => 200,
                'Smedium French Curl Braids' => 170,
                'Medium French Curl Braids' => 150,
                'Large French Curl Braids' => 120,
                
                // Crotchet Styles
                '2/3 Line Single' => 100,
                'Afro Crotchet' => 120,
                'Individual Loc' => 150,
                'Butterfly Locks' => 150,
                'Weave Crotchet' => (int) config('service_prices.weaving_crotchet', 80),
                
                // Cornrow/Feed-in Braids
                'Stitch Weave' => 100,
                'Cornrow Weave' => 100,
                'Under-wig Weave' => 30,
                'Weave&Braid Mixed' => 150,
                
                // Hair Treatment Services
                'Natural Hair Treatment/Mask' => (int) config('service_prices.hair_mask', 50),
                'Chemical Relaxer' => 50,
            ];
        @endphp
        const basePriceByServiceName = @json($basePriceByServiceName);

        // Source of truth: if a service dropdown exists, use it; otherwise use the configured base-price map.
        const select = document.querySelector('#bookingModal select[name="service"]') || document.getElementById('serviceSelection');
        const options = select ? Array.from(select.querySelectorAll('option')) : [];

        let services = options
            .map(o => (o.value || '').trim())
            .filter(v => v.length > 0);

        if (!services.length) {
            try {
                services = Object.keys(basePriceByServiceName || {});
            } catch (e) { services = []; }
        }

        // Exclude kids services + deduplicate
        const unique = Array.from(new Set(services.filter(v => !/kids/i.test(v))));

        if (!unique.length) {
            container.innerHTML = '<div class="col-12"><div class="alert alert-warning mb-0">No services found.</div></div>';
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
                window.selectNonKidsService(serviceName);
            });
            col.appendChild(btn);

            // Price hint (pulled from same config as Services section)
            try {
                const p = basePriceByServiceName[serviceName];
                if (typeof p === 'number' && !isNaN(p) && p > 0) {
                    const priceEl = document.createElement('div');
                    priceEl.className = 'small text-muted mt-1 text-center';
                    priceEl.textContent = 'Starting at $' + p;
                    col.appendChild(priceEl);
                }
            } catch (e) {}
            container.appendChild(col);
        });
    };

    window.selectNonKidsService = function(serviceName) {
        console.log('selectNonKidsService called with:', serviceName);
        try {
            const nonKidsModal = bootstrap.Modal.getInstance(document.getElementById('nonKidsServicesModal'));
            if (nonKidsModal) nonKidsModal.hide();
        } catch (e) {}

        // Open main booking modal with selected service - the wrapper will handle pricing
        if (typeof window.openBookingModal === 'function') {
            window.openBookingModal(serviceName, null);
        } else {
            console.warn('openBookingModal not found');
        }
    };

    // Close booking/kids modal and open service selection modal
    function backToServiceSelection(){
        try{
            // Close main booking modal if open
            const bookingEl = document.getElementById('bookingModal');
            const bookingModalInstance = bootstrap.Modal.getInstance(bookingEl);
            if(bookingModalInstance){
                bookingModalInstance.hide();
            } else if(bookingEl && bookingEl.classList.contains('show')){
                // fallback: remove show class
                bookingEl.classList.remove('show');
                bookingEl.style.display = 'none';
                document.body.classList.remove('modal-open');
            }

            // Close kids booking modal if open
            const kidsEl = document.getElementById('kidsBookingModal');
            const kidsModalInstance = bootstrap.Modal.getInstance(kidsEl);
            if(kidsModalInstance){
                kidsModalInstance.hide();
            } else if(kidsEl && kidsEl.classList.contains('show')){
                // fallback: remove show class
                kidsEl.classList.remove('show');
                kidsEl.style.display = 'none';
                document.body.classList.remove('modal-open');
            }

            // Reset the flag
            window.cameFromServiceSelection = false;
            
            // Hide back button
            const backBtn = document.getElementById('backToServiceSelectionBtn');
            if (backBtn) {
                backBtn.style.display = 'none';
            }

            // small delay to allow modal hide animation then open the appropriate chooser
            setTimeout(function(){
                try{ 
                    // Calendar-origin flow: go to kids selector page (not another modal).
                    // Everything else: go straight to the "Other Services" modal.
                    if (window.__bookingOrigin === 'calendar') {
                        // Persist any typed draft before redirecting
                        try { window.__dbtSaveBookingDraftFromMain?.(); } catch (e) {}
                        window.location.href = '/kids-selector';
                        return;
                    }

                    // For "Change service" we want: Not a kid => Select Service (popular+custom), Kid => kids booking modal
                    window.__serviceChangeFlow = true;
                    if (typeof window.openServiceForWhoModal === 'function') {
                        window.openServiceForWhoModal();
                    } else if (typeof openServiceForWhoModal === 'function') {
                        openServiceForWhoModal();
                    } else if (typeof window.openOtherServicesModal === 'function') {
                        // fallback: at least open the Select Service modal
                        window.openOtherServicesModal();
                    }
                }catch(e){ console.warn('openServiceSelectionModal failed', e); }
            }, 260);
        }catch(e){ console.warn('backToServiceSelection failed', e); }
    }

    // Open the kids-only booking modal (does not redirect to main booking modal)
    function openKidsBookingModal(serviceName, serviceType){
        try{
            // populate basic hidden fields in the kids modal
            const svc = document.getElementById('kids_service_input'); if(svc) svc.value = serviceName || 'Kids Braids';
            const st = document.getElementById('kids_service_type_input'); if(st) st.value = serviceType || 'kids-braids';
            // Restore saved draft (parent phone/email) when switching from main flow/calendar
            try { window.__dbtApplyBookingDraftToKids?.(); } catch (e) {}
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

                    // try parse extras (accept JSON array, numeric CSV, names or known selector addon ids)
                    try{
                        if(sel.extras){
                            // map of known selector addon ids to numeric values
                            const selectorAddonMap = {'kb_add_detangle':15,'kb_add_beads':10,'kb_add_beads_full':15,'kb_add_extension':20,'kb_add_rest':5};

                            if(typeof sel.extras === 'string' && sel.extras.trim().startsWith('[')){
                                const parsed = JSON.parse(sel.extras);
                                if(Array.isArray(parsed)){
                                    parsed.forEach(it => {
                                        if(typeof it === 'number') addons += it;
                                        else if(typeof it === 'object' && it.value) addons += Number(it.value) || 0;
                                        else if(!isNaN(Number(it))) addons += Number(it);
                                        else if(selectorAddonMap[it]) addons += selectorAddonMap[it];
                                    });
                                }
                            } else if(typeof sel.extras === 'string' && sel.extras.indexOf(',')>-1){
                                sel.extras.split(',').forEach(t => {
                                    const token = t.trim();
                                    const n = Number(token);
                                    if(!isNaN(n)) addons += n;
                                    else if(selectorAddonMap[token]) addons += selectorAddonMap[token];
                                });
                            } else if(typeof sel.extras === 'string'){
                                const token = sel.extras.trim();
                                const n = Number(token);
                                if(!isNaN(n)) addons += n;
                                else if(selectorAddonMap[token]) addons += selectorAddonMap[token];
                            } else if(typeof sel.extras === 'number'){
                                addons += Number(sel.extras);
                            }
                        }
                    }catch(e){ console.warn('Failed to parse selector extras', e); }

                    // Fallback: if no extras were provided in selector payload, read checked addon boxes from the selector DOM
                    try{
                        if(!sel.extras || (addons === 0)){
                            document.querySelectorAll('#kb-addons input[type="checkbox"]:checked').forEach(function(cb){
                                try{
                                    var n = Number(cb.value);
                                    if(!isNaN(n) && n !== 0){ addons += n; }
                                    else {
                                        // map known addon ids to values
                                        var addonMap = {'kb_add_detangle':15,'kb_add_beads':10,'kb_add_beads_full':15,'kb_add_extension':20,'kb_add_rest':5};
                                        if(cb.id && addonMap[cb.id]) addons += addonMap[cb.id];
                                    }
                                }catch(e){}
                            });
                        }
                    }catch(e){ /* noop */ }

                    // computed total
                    // include addons into adjustments so modal mirrors selector summary
                    const adjustmentsWithAddons = adjustments + addons;
                    total = base + adjustmentsWithAddons;

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
                // Calculate adjustments total (length/type adjustments + addons) to match email format
                const adjustmentsTotal = adjustments + addons;
                const finalPrice = total;
                
                // Format with 2 decimal places to match email format
                const kb = document.getElementById('kidsModal_base'); if(kb) kb.innerHTML = '$' + Number(base).toFixed(2);
                const ka = document.getElementById('kidsModal_adjustments'); if(ka) ka.innerHTML = (adjustmentsTotal >= 0 ? '+' : '-') + '$' + Math.abs(Number(adjustmentsTotal)).toFixed(2);
                const kt = document.getElementById('kidsModal_total'); if(kt) kt.innerHTML = '$' + (finalPrice ? Number(finalPrice).toFixed(2) : '--');
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

            // Initialize address field state (ensure it's hidden by default for in-studio)
            try{
                const inStudioKids = document.getElementById('appointment_type_in_studio_kids');
                if(inStudioKids) inStudioKids.checked = true;
                
                const addressContainerKids = document.getElementById('addressFieldContainerKids');
                if(addressContainerKids) {
                    addressContainerKids.classList.add('d-none');
                    addressContainerKids.style.display = 'none';
                }
                
                const kidsAddress = document.getElementById('kids_address');
                if(kidsAddress) {
                    kidsAddress.value = '';
                    kidsAddress.required = false;
                }
                
                // Call toggle function to ensure proper state
                if (typeof toggleAddressFieldKids === 'function') {
                    toggleAddressFieldKids();
                }
            }catch(e){ console.warn('Kids address field init failed', e); }

            // accessibility: focus first input when modal shown
            try{
                const modalEl = document.getElementById('kidsBookingModal');
                modalEl.addEventListener('shown.bs.modal', function(){
                    const nameField = document.getElementById('kids_name'); if(nameField) nameField.focus();
                    // Ensure address field state is correct
                    if(typeof toggleAddressFieldKids === 'function') toggleAddressFieldKids();
                }, { once: true });
            }catch(e){ /* noop */ }
            
            // Also call immediately in case modal is already shown
            if(typeof toggleAddressFieldKids === 'function') {
                setTimeout(toggleAddressFieldKids, 100);
            }
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
    window.selectQuickService = function(serviceName) {
        const selectedServiceInput = document.getElementById('selectedService');
        const serviceDisplayInput = document.getElementById('serviceDisplay');

        // Map common services to their base prices (USD) (single source of truth: config/service_prices.php)
        const priceMap = {
            'Weaving Crotchet': {{ (int) config('service_prices.weaving_crotchet', 80) }},
            'Single Crotchet': {{ (int) config('service_prices.single_crotchet', 150) }},
            'Natural Hair Twist': {{ (int) config('service_prices.natural_hair_twist', 50) }},
            'Weaving No-Extension': {{ (int) config('service_prices.weaving_no_extension', 30) }},
            'Kinky Twist': {{ (int) config('service_prices.kinky_twist', 120) }},
            'Twist Braids': {{ (int) config('service_prices.twist_braids', 130) }}
        };

        // Get base price from the map
        const basePrice = parseFloat(priceMap[serviceName] || '100');

        // Set the hidden price input if we know the base price
        const selectedPriceInput = document.getElementById('selectedPrice');
        if (selectedPriceInput) {
            selectedPriceInput.value = basePrice;
        }

        // Convert service name to service type (slug format)
        const serviceType = serviceName.toString().toLowerCase().replace(/[^a-z0-9\s]/g, '').trim().replace(/\s+/g, '-');
        const serviceTypeInput = document.getElementById('selectedServiceType');
        if (serviceTypeInput) {
            serviceTypeInput.value = serviceType;
        }

        if (selectedServiceInput) {
            selectedServiceInput.value = serviceName;
        }

        if (serviceDisplayInput) {
            serviceDisplayInput.value = serviceName;
        }

        // Check if this service should allow length adjustments (Kinky Twist and Twist Braids only)
        const servicesWithLengthAdjustment = ['Kinky Twist', 'Twist Braids'];
        const allowsLengthAdjustment = servicesWithLengthAdjustment.includes(serviceName);

        // Show/hide and enable/disable length selection based on service
        const lengthGuideBlock = document.getElementById('lengthGuideBlock');
        if (lengthGuideBlock) {
            if (allowsLengthAdjustment) {
                lengthGuideBlock.style.display = 'block';
            } else {
                lengthGuideBlock.style.display = 'none';
            }
        }
        
        // Enable/disable length radio buttons based on service
        const lengthRadios = document.getElementsByName('hair_length');
        for (let i = 0; i < lengthRadios.length; i++) {
            if (allowsLengthAdjustment) {
                lengthRadios[i].disabled = false;
            } else {
                lengthRadios[i].disabled = true;
                if (lengthRadios[i].value === 'mid-back') {
                    lengthRadios[i].checked = true;
                }
            }
        }

        // Update window.currentServiceInfo for price calculations
        window.currentServiceInfo = window.currentServiceInfo || {};
        window.currentServiceInfo.serviceName = serviceName;
        window.currentServiceInfo.serviceType = serviceType;
        window.currentServiceInfo.basePrice = basePrice;
        // Only flag as popular service (skip length adjustments) if it's NOT Kinky Twist or Twist Braids
        window.currentServiceInfo.isPopularService = !allowsLengthAdjustment;

        // Update the visible price display
        if (typeof window.updatePriceDisplay === 'function') {
            window.updatePriceDisplay(basePrice);
        } else {
            // Fallback: directly update priceDisplay if updatePriceDisplay is not available
            const priceDisplay = document.getElementById('priceDisplay');
            if (priceDisplay) {
                priceDisplay.textContent = '$' + basePrice.toFixed(0);
            }
        }

        // Close the service selection modal
        const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
        if (serviceModal) {
            serviceModal.hide();
        }

        // Mark that user came from service selection modal
        window.cameFromServiceSelection = true;

        // Open the booking modal
        const bookingModalEl = document.getElementById('bookingModal');
        if (bookingModalEl) {
            const bookingModal = bootstrap.Modal.getInstance(bookingModalEl) || new bootstrap.Modal(bookingModalEl);
            bookingModal.show();
        }

        // Show back button in booking modal
        const backBtn = document.getElementById('backToServiceSelectionBtn');
        if (backBtn) {
            backBtn.style.display = 'block';
        }

        // Update booking modal title
        const bookingModalLabel = document.getElementById('bookingModalLabel');
        if (bookingModalLabel) {
            bookingModalLabel.textContent = `Book ${serviceName}`;
        }

        console.log('Quick service selected:', serviceName, 'Base price:', basePrice);
    };
    
    // Also define as regular function for backward compatibility
    function selectQuickService(serviceName) {
        if (window.selectQuickService) {
            window.selectQuickService(serviceName);
        }
    };
    
    // Also define as regular function for backward compatibility
    function selectQuickService(serviceName) {
        if (window.selectQuickService) {
            window.selectQuickService(serviceName);
        }
    }

    // Function to select a custom service
    function selectCustomService() {
        const customInput = document.getElementById('customServiceInput');
        const customService = customInput.value.trim();

        if (!customService) {
            alert('Please enter a service name');
            return;
        }

        // Collect all custom service form data
        const customForm = document.getElementById('customServiceForm');
        const formData = new FormData(customForm);
        
        // Build custom service details object
        const customServiceDetails = {
            service_name: customService,
            service_category: document.querySelector('input[name="service_category"]:checked')?.value || '',
            braid_size: document.querySelector('input[name="braid_size"]:checked')?.value || '',
            hair_length: document.querySelector('input[name="hair_length"]:checked')?.value || '',
            budget_range: document.querySelector('input[name="budget_range"]:checked')?.value || '',
            urgency: document.querySelector('input[name="urgency"]:checked')?.value || '',
            special_requirements: document.getElementById('customSpecialRequirements')?.value || '',
            style_preferences: Array.from(document.querySelectorAll('input[name="style_preferences[]"]:checked')).map(cb => cb.value),
            reference_image: document.getElementById('customReferenceImage')?.files[0] || null
        };

        // Store custom service details globally for later use in booking form
        window.customServiceDetails = customServiceDetails;

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

        // Re-enable length selection for custom services
        const lengthGuideBlock = document.getElementById('lengthGuideBlock');
        if (lengthGuideBlock) {
            lengthGuideBlock.style.display = '';
        }
        
        // Re-enable all length radio buttons
        const lengthRadios = document.getElementsByName('hair_length');
        for (let i = 0; i < lengthRadios.length; i++) {
            lengthRadios[i].disabled = false;
        }

        // If custom form has a hair length selected, set it as default
        if (customServiceDetails.hair_length) {
            const lengthRadio = document.querySelector(`input[name="hair_length"][value="${customServiceDetails.hair_length}"]`);
            if (lengthRadio) {
                lengthRadio.checked = true;
            }
        }

        // Update window.currentServiceInfo - custom services are not popular services
        window.currentServiceInfo = window.currentServiceInfo || {};
        window.currentServiceInfo.serviceName = customService;
        window.currentServiceInfo.serviceType = 'custom';
        window.currentServiceInfo.isPopularService = false;
        window.currentServiceInfo.customDetails = customServiceDetails;

        // Mark that user came from service selection modal
        window.cameFromServiceSelection = true;

        // Show back button in booking modal
        const backBtn = document.getElementById('backToServiceSelectionBtn');
        if (backBtn) {
            backBtn.style.display = 'block';
        }

        // Close the service selection modal
        const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
        if (serviceModal) {
            serviceModal.hide();
        }

        // Update booking modal title
        document.getElementById('bookingModalLabel').textContent = `Book ${customService}`;

        // Pre-fill booking form message with custom service details if message field exists
        const messageField = document.getElementById('message');
        if (messageField && window.customServiceDetails) {
            let messageText = `Custom Service Request:\n\n`;
            messageText += `Service: ${customService}\n`;
            if (customServiceDetails.service_category) {
                messageText += `Category: ${customServiceDetails.service_category}\n`;
            }
            if (customServiceDetails.braid_size) {
                messageText += `Braid/Twist Size: ${customServiceDetails.braid_size}\n`;
            }
            if (customServiceDetails.hair_length) {
                messageText += `Hair Length: ${customServiceDetails.hair_length}\n`;
            }
            if (customServiceDetails.budget_range) {
                messageText += `Budget Range: ${customServiceDetails.budget_range}\n`;
            }
            if (customServiceDetails.urgency) {
                messageText += `Timeline: ${customServiceDetails.urgency}\n`;
            }
            if (customServiceDetails.style_preferences && customServiceDetails.style_preferences.length > 0) {
                messageText += `Style Preferences: ${customServiceDetails.style_preferences.join(', ')}\n`;
            }
            if (customServiceDetails.special_requirements) {
                messageText += `\nSpecial Requirements:\n${customServiceDetails.special_requirements}\n`;
            }
            messageField.value = messageText;
        }

        console.log('Custom service selected:', customService);
        console.log('Custom service details:', customServiceDetails);
    }

    // Function to open custom service request modal
    function openCustomServiceRequestModal() {
        const customInput = document.getElementById('customServiceInput');
        const customService = customInput.value.trim();

        if (!customService) {
            alert('Please enter a service name');
            return;
        }

        // Store custom service details globally for submission
        const customForm = document.getElementById('customServiceForm');
        if (!customForm) {
            alert('Custom service form not found');
            return;
        }

        // Build custom service details object
        const customServiceDetails = {
            service_name: customService,
            service_category: document.querySelector('input[name="service_category"]:checked')?.value || '',
            braid_size: document.querySelector('input[name="braid_size"]:checked')?.value || '',
            hair_length: document.querySelector('input[name="hair_length"]:checked')?.value || '',
            budget_range: document.querySelector('input[name="budget_range"]:checked')?.value || '',
            urgency: document.querySelector('input[name="urgency"]:checked')?.value || '',
            special_requirements: document.getElementById('customSpecialRequirements')?.value || '',
            style_preferences: Array.from(document.querySelectorAll('input[name="style_preferences[]"]:checked')).map(cb => cb.value),
            reference_image: document.getElementById('customReferenceImage')?.files[0] || null
        };

        // Store globally for submission
        window.customServiceRequestDetails = customServiceDetails;

        // Open the custom service request modal
        const modalEl = document.getElementById('customServiceRequestModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl, {
                backdrop: true,
                keyboard: true
            });
            
            // Set z-index before showing to ensure it's on top
            modalEl.style.zIndex = '1060';
            
            modal.show();
            
            // After modal is shown, ensure it stays on top
            modalEl.addEventListener('shown.bs.modal', function() {
                // Set z-index again after Bootstrap applies its own
                modalEl.style.zIndex = '1060';
                
                // Find and adjust only the backdrop for this modal
                const backdrops = document.querySelectorAll('.modal-backdrop');
                if (backdrops.length > 0) {
                    // Get the last backdrop (should be for this modal)
                    const lastBackdrop = backdrops[backdrops.length - 1];
                    // Only adjust if this modal is actually visible
                    if (modalEl.classList.contains('show')) {
                        lastBackdrop.style.zIndex = '1055';
                    }
                }
                
                // Focus on name field
                const nameField = document.getElementById('csrName');
                if (nameField) {
                    setTimeout(() => nameField.focus(), 100);
                }
            }, { once: true });
            
            // Clean up z-index when modal is hidden to not interfere with other modals
            modalEl.addEventListener('hidden.bs.modal', function() {
                // Reset z-index so it doesn't interfere with other modals
                modalEl.style.zIndex = '';
            }, { once: false });
        }
    }

    // Function to submit custom service request from the modal
    function submitCustomServiceRequestFromModal() {
        // Validate contact info
        const contactName = document.getElementById('csrName')?.value?.trim();
        const contactEmail = document.getElementById('csrEmail')?.value?.trim();
        const contactPhone = document.getElementById('csrPhone')?.value?.trim();

        if (!contactName || !contactPhone) {
            alert('Please fill in your name and phone number.');
            if (!contactName) {
                document.getElementById('csrName')?.focus();
            } else {
                document.getElementById('csrPhone')?.focus();
            }
            return;
        }

        // Get custom service details from global storage
        if (!window.customServiceRequestDetails) {
            alert('Custom service details not found. Please try again.');
            return;
        }

        const details = window.customServiceRequestDetails;

        // Build form data object
        const formData = new FormData();
        
        // Add required contact fields
        formData.append('name', contactName);
        formData.append('email', contactEmail || '');
        formData.append('phone', contactPhone);
        formData.append('service', details.service_name);
        // No appointment date/time for custom service requests
        
        // Add custom service details
        if (details.service_category) formData.append('service_category', details.service_category);
        if (details.braid_size) formData.append('braid_size', details.braid_size);
        if (details.hair_length) formData.append('hair_length', details.hair_length);
        if (details.budget_range) formData.append('budget_range', details.budget_range);
        if (details.urgency) formData.append('urgency', details.urgency);
        if (details.special_requirements) formData.append('special_requirements', details.special_requirements);
        if (details.style_preferences && details.style_preferences.length > 0) {
            details.style_preferences.forEach(pref => formData.append('style_preferences[]', pref));
        }
        if (details.reference_image) formData.append('reference_image', details.reference_image);

        // Build message with all details
        let messageText = `Custom Service Request:\n\n`;
        messageText += `Service: ${details.service_name}\n`;
        if (details.service_category) messageText += `Category: ${details.service_category}\n`;
        if (details.braid_size) messageText += `Braid/Twist Size: ${details.braid_size}\n`;
        if (details.hair_length) messageText += `Hair Length: ${details.hair_length}\n`;
        if (details.budget_range) messageText += `Budget Range: ${details.budget_range}\n`;
        if (details.urgency) messageText += `Timeline: ${details.urgency}\n`;
        if (details.style_preferences && details.style_preferences.length > 0) {
            messageText += `Style Preferences: ${details.style_preferences.join(', ')}\n`;
        }
        if (details.special_requirements) {
            messageText += `\nSpecial Requirements:\n${details.special_requirements}\n`;
        }
        formData.append('message', messageText);

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                         document.querySelector('input[name="_token"]')?.value;
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }

        // Ensure custom service modal stays on top during submission (only if it's actually visible)
        const modalEl = document.getElementById('customServiceRequestModal');
        if (modalEl && modalEl.classList.contains('show') && modalEl.offsetParent !== null) {
            // Only adjust if modal is actually visible
            modalEl.style.zIndex = '1060';
        }

        // Show loading state
        const submitBtn = document.querySelector('button[onclick="submitCustomServiceRequestFromModal()"]');
        const originalText = submitBtn?.innerHTML;
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';
        }

        // Submit to custom-service endpoint
        fetch('/custom-service', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Your custom service request has been submitted successfully! We will contact you within 24-48 hours.');
                // Close all modals
                const requestModal = bootstrap.Modal.getInstance(document.getElementById('customServiceRequestModal'));
                if (requestModal) requestModal.hide();
                const serviceModal = bootstrap.Modal.getInstance(document.getElementById('serviceSelectionModal'));
                if (serviceModal) serviceModal.hide();
                // Reset forms
                const customForm = document.getElementById('customServiceForm');
                if (customForm) customForm.reset();
                const requestForm = document.getElementById('customServiceRequestForm');
                if (requestForm) requestForm.reset();
                // Clear stored details
                window.customServiceRequestDetails = null;
            } else {
                alert('Failed to submit request: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error submitting custom service request:', error);
            alert('An error occurred while submitting your request. Please try again.');
        })
        .finally(() => {
            // Restore button state
            if (submitBtn) {
                submitBtn.disabled = false;
                if (originalText) submitBtn.innerHTML = originalText;
            }
        });
    }

    // Add visual feedback for radio button groups in custom service form
    document.addEventListener('DOMContentLoaded', function() {
        const customForm = document.getElementById('customServiceForm');
        if (customForm) {
            // Add event listeners to all radio buttons
            const radioGroups = ['service_category', 'braid_size', 'hair_length', 'budget_range', 'urgency'];
            
            radioGroups.forEach(groupName => {
                const radios = customForm.querySelectorAll(`input[name="${groupName}"]`);
                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        // Find the parent radio-group-container
                        const container = this.closest('.radio-group-container');
                        if (container) {
                            // Remove highlight from all containers in this group
                            const allRadios = customForm.querySelectorAll(`input[name="${groupName}"]`);
                            allRadios.forEach(r => {
                                const c = r.closest('.radio-group-container');
                                if (c) c.classList.remove('radio-selected');
                            });
                            // Add highlight to selected container
                            container.classList.add('radio-selected');
                        }
                    });
                });
            });
        }
    });

    // Function to clear the booking form
    function clearBookingForm() {
        const form = document.getElementById('bookingForm');
        if (form) {
            // Check if terms were already accepted before resetting
            const KEY = 'dbt_terms_accepted_v1';
            const hasAccepted = () => {
                try { return window.localStorage && localStorage.getItem(KEY) === '1'; } catch(e) { return false; }
            };
            const termsWereAccepted = hasAccepted();
            
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

            // Restore terms checkbox if terms were already accepted
            if (termsWereAccepted) {
                const termsCheckbox = document.getElementById('termsAcceptedMain');
                if (termsCheckbox) {
                    termsCheckbox.checked = true;
                }
            }

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
            // DEBUG: Log all pricing-related fields before submission
            console.log('=== FORM SUBMISSION DEBUG ===');
            console.log('selectedService:', document.getElementById('selectedService')?.value);
            console.log('selectedServiceType:', document.getElementById('selectedServiceType')?.value);
            console.log('selectedPrice:', document.getElementById('selectedPrice')?.value);
            console.log('final_price_input:', document.getElementById('final_price_input')?.value);
            const priceDisplayEl = document.getElementById('priceDisplay');
            console.log('priceDisplay text:', priceDisplayEl ? (priceDisplayEl.textContent || priceDisplayEl.innerText || 'empty') : 'element not found');
            console.log('window.currentServiceInfo:', window.currentServiceInfo);
            console.log('=== END DEBUG ===');
            
            // Minimal submit handler: basic validation + keep hair-mask hidden-field behavior.
            // Ensure terms checkbox posts a valid "accepted" value when checked (some resets previously blanked values)
            try {
                const terms = document.getElementById('termsAcceptedMain');
                if (terms) terms.value = '1';
            } catch(err) {}
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
            
            // Check if selected date is blocked (only block if it's a full-day block)
            const appointmentDateField = document.getElementById('appointment_date');
            const selectedDate = appointmentDateField ? appointmentDateField.value.trim() : '';
            if(selectedDate) {
                const blockedIndex = (blockedDatesCache || []).reduce((acc, b) => { acc[b.date] = b; return acc; }, {});
                if(blockedIndex[selectedDate]) {
                    const blockedInfo = blockedIndex[selectedDate];
                    const isFullDay = blockedInfo.full_day === true || blockedInfo.full_day === 1;
                    
                    // Only prevent booking if it's a full-day block
                    if (isFullDay) {
                        e.preventDefault();
                        const blockedTitle = blockedInfo.title || 'Blocked';
                        alert(`This date is blocked: "${blockedTitle}". Please select another date.`);
                        return;
                    }
                    // If it's a time-specific block, allow the booking (time validation happens on backend)
                }
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
            const serviceNameHidden = this.querySelector('input[name="service"]')?.value || document.getElementById('selectedService')?.value || document.getElementById('serviceDisplay')?.value || '';
            const serviceTypeLower = (serviceTypeHidden || '').toLowerCase();
            const serviceNameLower = (serviceNameHidden || '').toLowerCase();

            // Stitch braids rows choice is required and affects pricing (+$30 for >10 rows)
            const isStitch = serviceTypeLower.includes('stitch') || serviceNameLower.includes('stitch');
            if (isStitch) {
                const stitchOpt = (document.getElementById('stitch_rows_option') || {}).value || '';
                if (!stitchOpt) {
                    e.preventDefault();
                    try {
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            const m = new bootstrap.Modal(document.getElementById('stitchRowsModal'));
                            m.show();
                        }
                    } catch (e) {}
                    alert('Please select Stitch Braids rows (8–10 rows or more than 10 rows) to continue.');
                    return;
                }
            }
            const isHairMaskForm = (
                serviceTypeLower.includes('hair-mask') || 
                serviceTypeLower.includes('relax') ||
                serviceTypeLower.includes('retouch') ||
                serviceNameLower.includes('hair mask') ||
                serviceNameLower.includes('mask/relax') ||
                serviceNameLower.includes('relaxing') ||
                serviceNameLower.includes('retouch')
            );

            if (isHairMaskForm) {
                // clear length to avoid server applying length-based adjustments
                selectedLengthInput.value = '';
            } else {
                if (selectedHairLength) selectedLengthInput.value = selectedHairLength.replace(/-/g, '_');
            }

            // Include custom service details if available
            if (window.customServiceDetails) {
                const messageField = document.getElementById('message');
                if (messageField) {
                    let existingMessage = messageField.value.trim();
                    let customDetailsText = '';
                    
                    // Build custom service details text
                    const details = window.customServiceDetails;
                    if (details.service_category || details.braid_size || details.budget_range || 
                        details.urgency || details.style_preferences?.length > 0 || details.special_requirements) {
                        customDetailsText = '\n\n--- Custom Service Details ---\n';
                        if (details.service_category) {
                            customDetailsText += `Category: ${details.service_category}\n`;
                        }
                        if (details.braid_size) {
                            customDetailsText += `Braid/Twist Size: ${details.braid_size}\n`;
                        }
                        if (details.budget_range) {
                            customDetailsText += `Budget Range: ${details.budget_range}\n`;
                        }
                        if (details.urgency) {
                            customDetailsText += `Timeline: ${details.urgency}\n`;
                        }
                        if (details.style_preferences && details.style_preferences.length > 0) {
                            customDetailsText += `Style Preferences: ${details.style_preferences.join(', ')}\n`;
                        }
                        if (details.special_requirements) {
                            customDetailsText += `\nSpecial Requirements:\n${details.special_requirements}\n`;
                        }
                        
                        // Append to existing message if it doesn't already contain custom details
                        if (!existingMessage.includes('--- Custom Service Details ---')) {
                            messageField.value = existingMessage + customDetailsText;
                        }
                    }
                }
            }

            // Allow normal form submission to proceed (server is authoritative)

            // Show processing state on the submit button to give user feedback
            try {
                const submitBtn = this.querySelector('#bookAppointmentBtn') || document.getElementById('bookAppointmentBtn');
                if (submitBtn) {
                    // Save original content so we can restore if needed
                    if (!submitBtn.dataset.origHtml) submitBtn.dataset.origHtml = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('disabled');
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                }
            } catch (err) {
                console.warn('Failed to set processing state on submit button', err);
            }
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

    // Contact form submission handler
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn?.innerHTML;
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';
            }
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Submit via AJAX
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show mb-4';
                    successAlert.style.cssText = 'border-radius: 10px; border-left: 4px solid #28a745;';
                    successAlert.innerHTML = `
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong>Success!</strong> ${data.message || 'Thank you for your message! We will get back to you soon.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    // Insert before form
                    contactForm.parentNode.insertBefore(successAlert, contactForm);
                    
                    // Scroll to success message
                    successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    
                    // Reset form
                    contactForm.reset();
                    
                    // Auto-remove success message after 5 seconds
                    setTimeout(() => {
                        if (successAlert.parentNode) {
                            successAlert.remove();
                        }
                    }, 5000);
                } else {
                    // Show error message
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show mb-4';
                    errorAlert.style.cssText = 'border-radius: 10px; border-left: 4px solid #dc3545;';
                    errorAlert.innerHTML = `
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Error!</strong> ${data.message || 'Failed to send message. Please try again.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    contactForm.parentNode.insertBefore(errorAlert, contactForm);
                    errorAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            })
            .catch(error => {
                console.error('Contact form error:', error);
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show mb-4';
                errorAlert.style.cssText = 'border-radius: 10px; border-left: 4px solid #dc3545;';
                errorAlert.innerHTML = `
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error!</strong> An error occurred while sending your message. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                contactForm.parentNode.insertBefore(errorAlert, contactForm);
                errorAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    if (originalText) submitBtn.innerHTML = originalText;
                }
            });
        });
    }

    // Handle custom service form separately
    const customServiceForm = document.querySelector('form[action*="custom-service.store"]');
    if (customServiceForm && customServiceForm !== contactForm) {
        customServiceForm.addEventListener('submit', function(e) {
            console.log('Custom-Service form submitted');
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
                <!-- Booking success message removed (handled by the primary success modal) -->

                <div class="row">
                    <div class="col-lg-8">
                        <h4 style="color: #030f68; font-weight: 700; margin-bottom: 20px;">
                            <i class="bi bi-credit-card me-2" style="color: #ff6600;"></i>
                            Deposit Payment Instructions
                        </h4>

                        <div class="payment-methods mb-4">
                            <h5 style="color: #030f68; font-weight: 600; margin-bottom: 15px;">Payment Methods:</h5>
                            <div class="row g-3">
                                <div class="col-12">
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
                                    <a href="tel:+13432548848" style="color: #ff6600; text-decoration: none; font-weight: 600;">(343) 254-8848</a>
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

@if(session('booking_success'))
<script>
document.addEventListener('DOMContentLoaded', function(){
    try{
        var dEl = document.getElementById('depositModal');
        if(dEl && typeof bootstrap !== 'undefined' && bootstrap.Modal){
            try{ new bootstrap.Modal(dEl).show(); }catch(e){ dEl.style.display='block'; dEl.classList.add('show'); document.body.classList.add('modal-open'); }
        }
        // transient booking success flag (top-center) for ~5 seconds
        try{
            var flag = document.createElement('div');
            flag.id = 'bookingSuccessFlag';
            flag.style.position = 'fixed';
            flag.style.top = '20px';
            flag.style.left = '50%';
            flag.style.transform = 'translateX(-50%)';
            flag.style.zIndex = '1060';
            flag.style.background = '#28a745';
            flag.style.color = '#fff';
            flag.style.padding = '10px 18px';
            flag.style.borderRadius = '8px';
            flag.style.boxShadow = '0 6px 18px rgba(3,15,104,0.12)';
            flag.style.fontWeight = '700';
            flag.style.fontSize = '14px';
            flag.textContent = 'Booking submitted successfully';
            document.body.appendChild(flag);
            setTimeout(function(){ try{ flag.style.transition='opacity 0.4s'; flag.style.opacity='0'; setTimeout(function(){ try{ if(flag && flag.parentNode) flag.parentNode.removeChild(flag); }catch(e){} },400); }catch(e){} }, 5000);
        }catch(e){ /* noop */ }
    }catch(e){ console.warn('Failed to auto-show depositModal', e); }
});
</script>
@endif

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
</style>

<script>
// Persist current kids modal selector state and navigate back to selector page
function backToKidsSelector(){
    try{
        var sel = {};
        // collect current modal hidden inputs
        var bt = document.getElementById('kids_braid_type_input'); if(bt) sel.kb_braid_type = bt.value;
        var fin = document.getElementById('kids_finish_input'); if(fin) sel.kb_finish = fin.value;
        var ln = document.getElementById('kids_length_input'); if(ln) sel.kb_length = ln.value;
        var ex = document.getElementById('kids_extras_input'); if(ex) sel.kb_extras = ex.value;
        var price = document.getElementById('kids_price_input'); if(price) sel.price = price.value;
        
        // Also try to get from global selector data if available (more complete)
        try{
            if(window.__kidsSelectorData){
                if(!sel.kb_braid_type && window.__kidsSelectorData.kb_braid_type) sel.kb_braid_type = window.__kidsSelectorData.kb_braid_type;
                if(!sel.kb_braid_type && window.__kidsSelectorData.braid_type) sel.kb_braid_type = window.__kidsSelectorData.braid_type;
                if(!sel.kb_finish && window.__kidsSelectorData.kb_finish) sel.kb_finish = window.__kidsSelectorData.kb_finish;
                if(!sel.kb_finish && window.__kidsSelectorData.finish) sel.kb_finish = window.__kidsSelectorData.finish;
                if(!sel.kb_length && window.__kidsSelectorData.kb_length) sel.kb_length = window.__kidsSelectorData.kb_length;
                if(!sel.kb_length && window.__kidsSelectorData.length) sel.kb_length = window.__kidsSelectorData.length;
                if(!sel.kb_length && window.__kidsSelectorData.hair_length) sel.kb_length = window.__kidsSelectorData.hair_length;
                if(!sel.kb_extras && window.__kidsSelectorData.extras) sel.kb_extras = window.__kidsSelectorData.extras;
                if(!sel.price && window.__kidsSelectorData.price) sel.price = window.__kidsSelectorData.price;
            }
        }catch(e){ console.warn('Failed to merge global selector data', e); }

        // store to localStorage for selector page to read
        try{ localStorage.setItem('kb_selector', JSON.stringify(sel)); }catch(e){ console.warn('Failed to persist kb_selector', e); }

        // navigate to selector route
        window.location.href = "{{ route('kids.selector') }}";
    }catch(e){ console.warn('backToKidsSelector failed', e); window.location.href = "{{ route('kids.selector') }}"; }
}
// Also attach a safe click handler in case inline onclicks are blocked by overlays
document.addEventListener('DOMContentLoaded', function(){
    try{
        const btn = document.getElementById('kidsBackToSelectorBtn');
        if(btn && !btn._kb_attached){
            btn.addEventListener('click', function(e){ e.preventDefault(); e.stopPropagation(); backToKidsSelector(); });
            btn._kb_attached = true;
        }
    }catch(e){ console.warn('Failed to attach Back to selector listener', e); }
});

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
/* Accessible kids modal styles (moved out of JS) */
.accessible-kids-modal .form-label { font-size: 1.02rem; color: #03253f; }
.accessible-kids-modal .form-control { font-size: 1.03rem; padding: .65rem .8rem; border-radius: 8px; }
.accessible-kids-modal .btn { min-height: 44px; padding: .6rem 1rem; font-size: 1rem; }
.accessible-kids-modal .modal-header .btn { min-height: 38px; }
.accessible-kids-modal .modal-title { font-size: 1.15rem; font-weight: 800; color: #ffffff; }
#kids_email {
    overflow-x: auto !important;
    overflow-y: hidden !important;
    text-overflow: clip !important;
    white-space: nowrap !important;
    word-wrap: normal !important;
}
.visually-hidden { position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }
.accessible-kids-modal #kidsPricePreview { box-shadow: 0 6px 18px rgba(3,15,104,0.06); }
.accessible-kids-modal [role="status"]:focus { outline: 3px solid #ffb703; }
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
            // Redirect user to the main page after clearing session
            try {
                setTimeout(function(){ window.location.href = '/'; }, 250);
            } catch(e) { console.warn('Redirect to home failed', e); }
        }).catch(function(error) {
            console.log('Session clear request failed:', error);
        });
    } else {
        console.log('Success modal not found'); // Debug log
    }
}

// Other Services success modal logic removed

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
        // Other Services OK listener removed (modal removed)
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
}, 100);

// Attempt to attach success modal buttons immediately (in case DOMContentLoaded already fired)
(function attachSuccessButtonsNow() {
    setTimeout(function() {
        try {
            const okButton = document.getElementById('successModalOk') || document.querySelector('#successModal .btn-info');
            if (okButton && !okButton._attached) {
                okButton.addEventListener('click', function(e) {
                    e.preventDefault(); e.stopPropagation(); closeSuccessModal();
                });
                okButton._attached = true;
                console.log('Immediate OK button listener attached');
            }

            // Other Services OK immediate attachment removed (modal removed)
        } catch (err) {
            console.warn('attachSuccessButtonsNow error', err);
        }
    }, 50);
})();

// Fallback document-level listener: catches clicks even if button listeners fail to attach
document.addEventListener('click', function(e) {
    try {
        const ok = e.target.closest ? e.target.closest('#successModalOk') : null;
        if (ok) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Document-level OK click detected');
            if (typeof closeSuccessModal === 'function') closeSuccessModal();
        }
        // Other Services document-level handler removed (modal removed)
    } catch (err) {
        console.warn('Document-level success modal click handler error', err);
    }
});

// Capture-phase fallback: in case some overlay stops propagation, listen in capture phase
document.addEventListener('click', function(e){
    try{
        var target = e.target || window.event && window.event.srcElement;
        // Walk up the DOM if necessary
        while(target && target.nodeType === 3) target = target.parentNode; // text node fallback
        var found = null;
        var el = target;
        while(el){
            if(el.id === 'successModalOk') { found = el; break; }
            el = el.parentElement;
        }
        if(found){
            // Don't rely on stopPropagation here; just ensure modal closes
            if(typeof closeSuccessModal === 'function') closeSuccessModal();
        }
        var otherFound = null;
        el = target;
        // Other Services capture-phase handling removed (modal removed)
    }catch(err){ console.warn('Capture-phase success modal handler error', err); }
}, true);

// Keyboard support: Enter or Escape closes the modal when it's visible
document.addEventListener('keydown', function(e) {
    try {
        const successModal = document.getElementById('successModal');
        if (!successModal) return;
        const isVisible = window.getComputedStyle(successModal).display !== 'none' && successModal.classList.contains('show');
        if (!isVisible) return;
        if (e.key === 'Enter' || e.key === 'Escape') {
            console.log('Key close for success modal:', e.key);
            e.preventDefault();
            if (typeof closeSuccessModal === 'function') closeSuccessModal();
        }
    } catch (err) {
        console.warn('Success modal key handler error', err);
    }
});

// Function to toggle address field based on appointment type
function toggleAddressField() {
    console.log('toggleAddressField called');
    const mobileRadio = document.getElementById('appointment_type_mobile');
    const inStudioRadio = document.getElementById('appointment_type_in_studio');
    const addressContainer = document.getElementById('addressFieldContainer');
    const addressInput = document.getElementById('address');
    
    // Determine which is checked
    const isMobileSelected = mobileRadio && mobileRadio.checked;
    
    console.log('Elements found:', {
        mobileRadio: !!mobileRadio,
        inStudioRadio: !!inStudioRadio,
        addressContainer: !!addressContainer,
        addressInput: !!addressInput,
        mobileChecked: isMobileSelected
    });
    
    if (isMobileSelected) {
        console.log('Mobile selected - showing address field');
        if (addressContainer) {
            addressContainer.classList.remove('d-none');
            addressContainer.classList.add('d-block');
            addressContainer.style.setProperty('display', 'block', 'important');
            addressContainer.style.setProperty('visibility', 'visible', 'important');
            addressContainer.style.setProperty('opacity', '1', 'important');
            console.log('Address container shown with !important');
        }
        if (addressInput) {
            addressInput.required = true;
            addressInput.disabled = false;
        }
    } else {
        console.log('In-studio selected - hiding address field');
        if (addressContainer) {
            addressContainer.classList.remove('d-block');
            addressContainer.classList.add('d-none');
            addressContainer.style.setProperty('display', 'none', 'important');
            console.log('Address container hidden');
        }
        if (addressInput) {
            addressInput.required = false;
            addressInput.value = '';
            addressInput.disabled = false;
        }
    }
}

// Function to toggle address field for kids form
function toggleAddressFieldKids() {
    console.log('toggleAddressFieldKids called');
    const mobileRadio = document.getElementById('appointment_type_mobile_kids');
    const inStudioRadio = document.getElementById('appointment_type_in_studio_kids');
    const addressContainer = document.getElementById('addressFieldContainerKids');
    const addressInput = document.getElementById('kids_address');
    
    // Determine which is checked
    const isMobileSelected = mobileRadio && mobileRadio.checked;
    
    console.log('Kids elements found:', {
        mobileRadio: !!mobileRadio,
        inStudioRadio: !!inStudioRadio,
        addressContainer: !!addressContainer,
        addressInput: !!addressInput,
        mobileChecked: isMobileSelected
    });
    
    if (isMobileSelected) {
        console.log('Kids Mobile selected - showing address field');
        if (addressContainer) {
            addressContainer.classList.remove('d-none');
            addressContainer.classList.add('d-block');
            addressContainer.style.setProperty('display', 'block', 'important');
            addressContainer.style.setProperty('visibility', 'visible', 'important');
            addressContainer.style.setProperty('opacity', '1', 'important');
            console.log('Kids address container shown with !important');
        }
        if (addressInput) {
            addressInput.required = true;
            addressInput.disabled = false;
        }
    } else {
        console.log('Kids In-studio selected - hiding address field');
        if (addressContainer) {
            addressContainer.classList.remove('d-block');
            addressContainer.classList.add('d-none');
            addressContainer.style.setProperty('display', 'none', 'important');
            console.log('Kids address container hidden');
        }
        if (addressInput) {
            addressInput.required = false;
            addressInput.value = '';
            addressInput.disabled = false;
        }
    }
}

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

// Initialize address field visibility when modals open
document.addEventListener('DOMContentLoaded', function() {
    const bookingModal = document.getElementById('bookingModal');
    const kidsBookingModal = document.getElementById('kidsBookingModal');
    
    if (bookingModal) {
        bookingModal.addEventListener('shown.bs.modal', function() {
            toggleAddressField();
            
            // Ensure price is set correctly whenever modal is shown
            setTimeout(function() {
                if (window.currentServiceInfo && window.currentServiceInfo.basePrice) {
                    console.log('Modal shown - Ensuring price is set from currentServiceInfo:', window.currentServiceInfo.basePrice);
                    const selectedPriceEl = document.getElementById('selectedPrice');
                    if (selectedPriceEl && !selectedPriceEl.value) {
                        selectedPriceEl.value = window.currentServiceInfo.basePrice;
                        console.log('Modal shown - Set empty selectedPrice to:', selectedPriceEl.value);
                    }
                    // Trigger price display update
                    if (typeof window.updatePriceDisplay === 'function') {
                        window.updatePriceDisplay(window.currentServiceInfo.basePrice);
                    }
                }
            }, 50);
        });
    }
    
    if (kidsBookingModal) {
        kidsBookingModal.addEventListener('shown.bs.modal', function() {
            toggleAddressFieldKids();
        });
    }
    
    // Add change event listeners as backup to onclick handlers
    // Main booking form
    const mainInStudio = document.getElementById('appointment_type_in_studio');
    const mainMobile = document.getElementById('appointment_type_mobile');
    if (mainInStudio) {
        mainInStudio.addEventListener('change', function() {
            console.log('Main in-studio change event fired');
            toggleAddressField();
        });
        mainInStudio.addEventListener('click', function() {
            console.log('Main in-studio click event fired');
            setTimeout(toggleAddressField, 50);
        });
    }
    if (mainMobile) {
        mainMobile.addEventListener('change', function() {
            console.log('Main mobile change event fired');
            toggleAddressField();
        });
        mainMobile.addEventListener('click', function() {
            console.log('Main mobile click event fired');
            setTimeout(toggleAddressField, 50);
        });
    }
    
    // Kids booking form
    const kidsInStudio = document.getElementById('appointment_type_in_studio_kids');
    const kidsMobile = document.getElementById('appointment_type_mobile_kids');
    if (kidsInStudio) {
        kidsInStudio.addEventListener('change', function() {
            console.log('Kids in-studio change event fired');
            toggleAddressFieldKids();
        });
        kidsInStudio.addEventListener('click', function() {
            console.log('Kids in-studio click event fired');
            setTimeout(toggleAddressFieldKids, 50);
        });
    }
    if (kidsMobile) {
        kidsMobile.addEventListener('change', function() {
            console.log('Kids mobile change event fired');
            toggleAddressFieldKids();
        });
        kidsMobile.addEventListener('click', function() {
            console.log('Kids mobile click event fired');
            setTimeout(toggleAddressFieldKids, 50);
        });
    }
    
    // Initial call on page load
    setTimeout(function() {
        if (typeof toggleAddressField === 'function') {
            console.log('Calling toggleAddressField on page load');
            toggleAddressField();
        }
        if (typeof toggleAddressFieldKids === 'function') {
            console.log('Calling toggleAddressFieldKids on page load');
            toggleAddressFieldKids();
        }
    }, 500);
});
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
                    <form id="kidsBookingForm" action="/bookings" method="POST" autocomplete="on" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="kids_service_input" name="service" value="">
                        <input type="hidden" id="kids_service_type_input" name="service_type" value="kids-braids">
                        <input type="hidden" id="kids_braid_type_input" name="kb_braid_type" value="">
                        <input type="hidden" id="kids_finish_input" name="kb_finish" value="">
                        <input type="hidden" id="kids_length_input" name="kb_length" value="">
                        <input type="hidden" id="kids_extras_input" name="kb_extras" value="">
                        <input type="hidden" id="kids_price_input" name="price" value="">
                        <input type="hidden" id="kids_final_price_input" name="final_price" value="">
                        <input type="hidden" name="appointment_date" value="" />
                        <input type="hidden" name="appointment_time" value="" />

                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Child's Name *</label>
                                    <input id="kids_name" name="name" type="text" class="form-control" required>
                                    <div id="kids_name_error" class="text-danger small mt-1" style="display:none;"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Parent / Guardian Email *</label>
                                    <input id="kids_email" name="email" type="email" class="form-control" placeholder="you@example.com" required>
                                    <div id="kids_email_error" class="text-danger small mt-1" style="display:none;"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Parent / Guardian Phone *</label>
                                    <input id="kids_phone" name="phone" type="tel" class="form-control" required pattern="[0-9+()\s\-]{7,}" placeholder="+1 555 555 5555">
                                    <div class="form-text small text-muted">Include country code, e.g. <code>+1</code></div>
                                    <div id="kids_phone_error" class="text-danger small mt-1" style="display:none;"></div>
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
                                    <label class="form-label">Date (opens calendar) *</label>
                                    <input id="kidsBookingDate" type="text" class="form-control" readonly onclick="openCalendarModal(); return false;" />
                                    <div id="kidsBookingDate_error" class="text-danger small mt-1" style="display:none;"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Time *</label>
                                    <input id="kidsBookingTime" type="text" class="form-control" readonly />
                                    <div id="kidsBookingTime_error" class="text-danger small mt-1" style="display:none;"></div>
                                </div>

                                <!-- Appointment Type -->
                                <div class="mb-3">
                                    <label class="form-label">Appointment Type *</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="appointment_type" id="appointment_type_in_studio_kids" value="in-studio" checked>
                                            <label class="form-check-label" for="appointment_type_in_studio_kids">
                                                <i class="bi bi-house-door me-1"></i>Stylist address
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="appointment_type" id="appointment_type_mobile_kids" value="mobile">
                                            <label class="form-check-label" for="appointment_type_mobile_kids">
                                                <i class="bi bi-truck me-1"></i>Mobile (I want you to come to me)
                                            </label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-info-circle me-1"></i>Mobile service available in Ottawa/Gatineau. Travel fee may apply based on distance.
                                    </small>
                                </div>

                                <!-- Mobile Service Address (conditional) -->
                                <div class="mb-3 d-none" id="addressFieldContainerKids">
                                    <label for="kids_address" class="form-label">Mobile Service Address (Ottawa) *</label>
                                    <input type="text" class="form-control" id="kids_address" name="address" placeholder="Enter your complete address" autocomplete="off">
                                    <small class="form-text text-muted mt-2">
                                        <i class="bi bi-geo-alt me-1"></i>Required for mobile appointments so we can confirm travel availability and any travel fee.
                                    </small>
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
                                <div style="background:#ffffff;border-radius:12px;padding:20px;border:2px solid #ff6600;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                                    <h5 style="color:#0b3a66;font-weight:800;margin-bottom:16px;font-size:1.2rem;border-bottom:2px solid #ff6600;padding-bottom:8px;">Price Summary</h5>
                                    <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #e3e3e0;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <span style="color:#666;font-size:0.95rem;">Base Price:</span>
                                            <span id="kidsModal_base" style="font-size:1.1rem;font-weight:600;color:#0b3a66;">$--</span>
                                        </div>
                                    </div>
                                    <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #e3e3e0;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <span style="color:#666;font-size:0.95rem;">Adjustments:</span>
                                            <span id="kidsModal_adjustments" style="font-size:1.1rem;font-weight:600;color:#0b3a66;">+ $0.00</span>
                                        </div>
                                    </div>
                                    <div style="margin-top:16px;padding-top:16px;border-top:2px solid #ff6600;background:#fff7e0;border-radius:8px;padding:14px;">
                                        <div style="display:flex;justify-content:space-between;align-items:center;">
                                            <span style="color:#0b3a66;font-size:1.1rem;font-weight:700;">Total:</span>
                                            <span id="kidsModal_total" style="font-size:1.5rem;font-weight:800;color:#ff6600;">$--</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid mt-3">
                                        <!-- Terms acceptance (required) -->
                                        <input type="hidden" name="terms_accepted" value="0">
                                        <div class="dbt-terms-consent mb-2">
                                            <input class="form-check-input" type="checkbox" id="termsAcceptedKids" name="terms_accepted" value="1" required autocomplete="off">
                                            <div>
                                                <label for="termsAcceptedKids" style="font-size:0.95rem;">
                                                    I agree to the <a href="#terms" style="color:#030f68; font-weight:600; text-decoration:none;" onclick="closeModalAndGoToTerms(event)">Terms &amp; Conditions</a>.
                                                </label>
                                            </div>
                                        </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" id="kidsBackToSelectorBtn" class="btn btn-secondary" style="font-weight:600;" onclick="backToKidsSelector()">Back to selector</button>
                                        <button type="submit" class="btn btn-warning" id="kidsBookAppointmentBtn" style="font-weight:600;">Confirm Booking</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms Gate Modal (shown on first "Book Now" click) -->
    <div class="modal fade" id="termsGateModal" tabindex="-1" aria-labelledby="termsGateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 18px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%); color: white;">
                    <h5 class="modal-title" id="termsGateModalLabel" style="font-weight: 800;">
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
                            <li>Mobile appointments are confirmed after deposit + address verification.</li>
                            <li>No style changes allowed on the day of appointment or after confirmation (time window is reserved).</li>
                            <li>Minimum 48 hours notice is required for cancellations.</li>
                            <li>Rescheduling requires 48 hours notice and must be within 1 month of the initial appointment date.</li>
                            <li>No-shows may result in a full charge and may affect future bookings.</li>
                            <li>For home service: clients cover fueling for the stylist's transportation; fees vary by distance.</li>
                            <li>For mobile service: travel fee may apply based on distance in Ottawa/Gatineau area.</li>
                    </div>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="termsGateAgree">
                        <label class="form-check-label" for="termsGateAgree" style="font-weight: 700; color:#0b3a66;">
                            I agree to the Terms &amp; Conditions
                        </label>
                    </div>
                    <div class="mt-3">
                        <a href="#terms" onclick="try{document.getElementById('terms')?.scrollIntoView({behavior:'smooth'});}catch(e){}"
                           style="color:#030f68; font-weight:600; text-decoration:none;">
                            View full Terms &amp; Conditions
                        </a>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="termsGateContinueBtn" disabled>
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<script>
// Ensure Back-to-selector is reliably clickable and keep modal summary synced with selector
document.addEventListener('DOMContentLoaded', function(){
    try{
        // robustly attach Back button handler (capture + keyboard)
        const btn = document.getElementById('kidsBackToSelectorBtn');
        if(btn){
            try{ btn.style.pointerEvents = 'auto'; btn.tabIndex = 0; }catch(e){}
            // remove any duplicate handlers then attach a reliable one
            try{ btn.removeEventListener('click', backToKidsSelector); }catch(e){}
            btn.addEventListener('click', function(e){ e.preventDefault(); e.stopPropagation(); try{ backToKidsSelector(); }catch(err){ window.location.href = "{{ route('kids.selector') }}"; } }, {capture:true});
            btn.addEventListener('keydown', function(e){ if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); try{ backToKidsSelector(); }catch(err){ window.location.href = "{{ route('kids.selector') }}"; } } });
        }

        // copy selector price summary into modal when modal is shown (bootstrap event)
        var modal = document.getElementById('kidsBookingModal');
        function syncKidsModalFromSelector(){
            try{
                var selBaseEl = document.getElementById('kb_base_price');
                var selAdjustEl = document.getElementById('kb_adjustments');
                var selTotalEl = document.getElementById('kb_total_price');
                var kb_base = document.getElementById('kidsModal_base');
                var kb_adjust = document.getElementById('kidsModal_adjustments');
                var kb_total = document.getElementById('kidsModal_total');
                if(selBaseEl && selAdjustEl && selTotalEl && kb_base && kb_adjust && kb_total){
                    // Parse and reformat values to ensure 2 decimal places to match email format
                    var baseText = (selBaseEl.textContent || selBaseEl.innerText || selBaseEl.innerHTML).replace(/[^0-9.]/g, '');
                    var adjustText = (selAdjustEl.textContent || selAdjustEl.innerText || selAdjustEl.innerHTML).replace(/[^0-9.\-+]/g, '');
                    var totalText = (selTotalEl.textContent || selTotalEl.innerText || selTotalEl.innerHTML).replace(/[^0-9.]/g, '');
                    
                    var baseVal = parseFloat(baseText) || 0;
                    var adjustVal = parseFloat(adjustText.replace(/[+\-]/g, '')) || 0;
                    var adjustSign = (adjustText.indexOf('-') >= 0) ? '-' : '+';
                    var totalVal = parseFloat(totalText) || 0;
                    
                    kb_base.innerHTML = '$' + baseVal.toFixed(2);
                    kb_adjust.innerHTML = adjustSign + '$' + adjustVal.toFixed(2);
                    kb_total.innerHTML = '$' + totalVal.toFixed(2);
                    // set hidden inputs
                    var priceMatch = (selTotalEl.textContent||selTotalEl.innerText||'').match(/\$\s*([0-9,\.]+)/);
                    if(priceMatch){
                        var p = Number(priceMatch[1].replace(/,/g,''));
                        try{ var kidsPriceInput = document.getElementById('kids_price_input'); if(kidsPriceInput) kidsPriceInput.value = p; }catch(e){}
                        try{ var kidsFinalInput = document.getElementById('kids_final_price_input'); if(kidsFinalInput) kidsFinalInput.value = Number(p).toFixed(2); }catch(e){}
                        // also copy selected addons (ids) into kids_extras_input so modal compute includes addons
                        try{
                            var extrasParts = [];
                            document.querySelectorAll('#kb-addons input[type="checkbox"]').forEach(function(cb){ if(cb.checked) extrasParts.push(cb.id || cb.value); });
                            if(extrasParts.length){ var kidsExtrasEl = document.getElementById('kids_extras_input'); if(kidsExtrasEl) kidsExtrasEl.value = extrasParts.join(','); }
                        }catch(e){}
                        // copy braid type / finish / length hidden mirrors if present
                        try{
                            var bt = (document.querySelector('input[name="kb_braid_type"]:checked') || {}).value || '';
                            var fin = (document.querySelector('input[name="kb_finish"]:checked') || {}).value || '';
                            var ln = (document.querySelector('input[name="kb_length"]:checked') || {}).value || '';
                            var ibt = document.getElementById('kids_braid_type_input'); if(ibt) ibt.value = bt;
                            var ifin = document.getElementById('kids_finish_input'); if(ifin) ifin.value = fin;
                            var iln = document.getElementById('kids_length_input'); if(iln) iln.value = ln;
                        }catch(e){}
                    }
                }
            }catch(e){ /* noop */ }
        }

        if(modal){
            try{
                // Bootstrap 5 shown event
                modal.addEventListener('shown.bs.modal', syncKidsModalFromSelector);
            }catch(e){ /* ignore */ }
            // also sync immediately in case modal is already visible
            try{ syncKidsModalFromSelector(); }catch(e){}
        }
    }catch(e){ console.warn('KB modal attach failed', e); }
});

// Dynamic price preview and form wiring
(function() {
    const priceMap = {
        // Knotless Braids
        'small-knotless': {{ (int) config('service_prices.small_knotless', 170) }},
        'smedium-knotless': {{ (int) config('service_prices.smedium_knotless', 150) }},
        'medium-knotless': {{ (int) config('service_prices.medium_knotless', 130) }},
        'jumbo-knotless': {{ (int) config('service_prices.jumbo_knotless', 100) }},
        
        // Boho Braids
        'small-boho': 180,
        'smedium-boho': {{ (int) config('service_prices.boho_braids', 150) }},
        'medium-boho': 130,
        'jumbo-boho': 100,
        
        // Twist Styles
        'small-twist': 150,
        'medium-twist': 120,
        'jumbo-twist': 100,
        'small-natural-hair-twist': 80,
        'medium-natural-hair-twist': 60,
        
        // French Curl Braids
        'small-french-curl': 200,
        'smedium-french-curl': 170,
        'medium-french-curl': 150,
        'large-french-curl': 120,
        
        // Crotchet Styles
        'line-single': 100,
        'afro-crotchet': 120,
        'individual-loc': 150,
        'butterfly-locks': 150,
        'weave-crotchet': {{ (int) config('service_prices.weaving_crotchet', 80) }},
        
        // Cornrow/Feed-in Braids
        'stitch-weave': 100,
        'cornrow-weave': 100,
        'under-wig-weave': 30,
        'weave-braid-mixed': 150,
        
        // Hair Treatment Services
        'natural-hair-treatment': {{ (int) config('service_prices.hair_mask', 50) }},
        'chemical-relaxer': 50,
        
        // Other Services
        'kids-braids': {{ (int) config('service_prices.kids_braids', 80) }},
        'stitch-braids': {{ (int) config('service_prices.stitch_braids', 120) }},
        'hair-mask': {{ (int) config('service_prices.hair_mask', 50) }},
        'retouching': {{ (int) config('service_prices.hair_mask', 50) }},
        'custom': 100
    };

    // Name → base price (used when we only have a serviceName, not a serviceType)
    const priceByServiceName = {
        // Knotless Braids
        'Small Knotless Braids': {{ (int) config('service_prices.small_knotless', 170) }},
        'Smedium Knotless Braids': {{ (int) config('service_prices.smedium_knotless', 150) }},
        'Medium Knotless Braids': {{ (int) config('service_prices.medium_knotless', 130) }},
        'Jumbo Knotless Braids': {{ (int) config('service_prices.jumbo_knotless', 100) }},
        
        // Boho Braids
        'Small Boho Braids': 180,
        'Smedium Boho Braids': {{ (int) config('service_prices.boho_braids', 150) }},
        'Medium Boho Braids': 130,
        'Jumbo/Large Boho Braids': 100,
        
        // Twist Styles
        'Small Twists': 150,
        'Medium Twists': 120,
        'Jumbo/Large Twists': 100,
        'Small Natural Hair Twist': 80,
        'Medium Natural Hair Twist': 60,
        
        // French Curl Braids
        'Small French Curl Braids': 200,
        'Smedium French Curl Braids': 170,
        'Medium French Curl Braids': 150,
        'Large French Curl Braids': 120,
        
        // Crotchet Styles
        '2/3 Line Single': 100,
        'Afro Crotchet': 120,
        'Individual Loc': 150,
        'Butterfly Locks': 150,
        'Weave Crotchet': {{ (int) config('service_prices.weaving_crotchet', 80) }},
        
        // Cornrow/Feed-in Braids
        'Stitch Weave': 100,
        'Cornrow Weave': 100,
        'Under-wig Weave': 30,
        'Weave&Braid Mixed': 150,
        
        // Hair Treatment Services
        'Natural Hair Treatment/Mask': {{ (int) config('service_prices.hair_mask', 50) }},
        'Chemical Relaxer': 50,
        
        // Other Services
        'Kids Braids': {{ (int) config('service_prices.kids_braids', 80) }},
    };

    function lengthAdjustment(lengthValue) {
        // Normalize incoming value (accept hyphen, underscore, or compact forms like 'midback')
        let key = (lengthValue || '').toString().toLowerCase().trim();
        // unify separators
        key = key.replace(/[-\s]+/g, '_');
        // Handle common compact variants that miss the underscore
        if (key === 'midback' || key === 'midback' ) key = 'mid_back';
        if (key === 'brastrap' || key === 'brastrap') key = 'bra_strap';
        // final sanity: replace any double-underscores
        key = key.replace(/__+/g, '_');
        console.log('Length adjustment for:', lengthValue, '-> key:', key);

        // Length adjustment pricing with grouped lengths (must match server):
        // - neck, shoulder, armpit: same price (-$40)
        // - bra_strap, mid_back: base/default price ($0 adjustment)
        // - waist: +$20
        // - hip: +$40 (waist + $20)
        // - tailbone, classic: same price (+$60)
        const lengthAdjustmentMap = {
            'neck': -40,
            'shoulder': -40,
            'armpit': -40,
            'bra_strap': 0,
            'mid_back': 0,
            'waist': 20,
            'hip': 40,
            'tailbone': 60,
            'classic': 60,
        };

        if (!lengthAdjustmentMap.hasOwnProperty(key)) {
            console.warn('Unknown length key:', key, 'defaulting to 0 adjustment');
            return 0;
        }

        const adjustment = lengthAdjustmentMap[key];
        console.log('Length adjustment amount:', adjustment, {key});
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
        const stLower = (''+serviceType).toLowerCase();
        const snLower = (''+serviceNameDisplay).toLowerCase();
        const isHairMask = (
            stLower === 'hair-mask' ||
            stLower.includes('hair-mask') ||
            stLower.includes('mask') ||
            stLower.includes('relax') ||
            stLower.includes('retouch') ||
            snLower.includes('hair mask') ||
            snLower.includes('mask') ||
            snLower.includes('relax') ||
            snLower.includes('retouch')
        );

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

        // For hair-mask/relax/retouch: price is already set in the size selection modal
        // Check if weave addon is included in the service name from the size modal
        if (isHairMask) {
            const serviceNameEl = document.getElementById('selectedService');
            const serviceName = serviceNameEl ? serviceNameEl.value : '';
            const hasWeaveAddon = serviceName.toLowerCase().includes('with weave');
            
            const addon = hasWeaveAddon ? 30 : 0;
            const finalPrice = (typeof base === 'number' && !isNaN(base) ? base : 0) + addon;

            console.log('Hair treatment price calc', { basePrice, hasWeaveAddon, addon, finalPrice, serviceName });

            const disp = document.getElementById('priceDisplay');
            const hidden = document.getElementById('selectedPrice');

            if (disp) disp.textContent = finalPrice ? ('$' + finalPrice) : '--';
            // Keep hidden "price" as the base price; send final price via final_price_input
            if (hidden) hidden.value = (typeof base === 'number' && !isNaN(base)) ? Number(base).toFixed(2) : '';

            // Ensure final_price_input is set so server + emails reflect the correct total
            try {
                const finalInput = document.getElementById('final_price_input');
                if (finalInput) finalInput.value = (typeof finalPrice === 'number') ? Number(finalPrice).toFixed(2) : '';
            } catch (e) { /* noop */ }

            return finalPrice;
        }

        // Check if this is a popular service (no length adjustments)
        const isPopularService = window.currentServiceInfo?.isPopularService === true;
        
        let finalPrice = base;
        let length = 'mid-back';
        let adj = 0;
        
        if (!isPopularService) {
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
            length = checkedVal || getSelectedLength();
        console.log('Radios snapshot:', radiosSnapshot, 'resolved length:', length, 'checkedIndex:', checkedIndex);
            adj = lengthAdjustment(length);
            finalPrice = base + adj;
        } else {
            // Popular services: use base price only (mid-back length, no adjustments)
            console.log('Popular service detected - using base price only (mid-back length)');
        }

        // Stitch braids: tiny stitch (>10 rows) adds +$30
        try {
            const stLower = (''+serviceType).toLowerCase();
            const snLower = (''+serviceNameDisplay).toLowerCase();
            const isStitch = stLower.includes('stitch') || snLower.includes('stitch');
            const stitchOpt = (document.getElementById('stitch_rows_option') || {}).value || '';
            if (isStitch && stitchOpt === 'more_than_ten') {
                finalPrice = (typeof finalPrice === 'number' ? finalPrice : (parseFloat(finalPrice) || 0)) + 30;
            }
        } catch (e) { /* noop */ }

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
            // Store the BASE price in the hidden input
            const baseValue = (typeof base === 'number') ? base : (parseFloat(base) || 0);
            hidden.value = baseValue;
            console.log('updatePriceDisplay - Set selectedPrice to base:', baseValue);
        }
        // Also store the computed final price in the form hidden input so server can use client-calculated final_price
        try {
            const finalInput = document.getElementById('final_price_input');
            const finalValue = (typeof finalPrice === 'number') ? Number(finalPrice).toFixed(2) : (parseFloat(finalPrice) || 0).toFixed(2);
            if (finalInput) {
                finalInput.value = finalValue;
                console.log('updatePriceDisplay - Set final_price_input to:', finalValue);
            } else {
                // create hidden input in booking form if missing
                const form = document.getElementById('bookingForm');
                if (form) {
                    const inp = document.createElement('input');
                    inp.type = 'hidden'; inp.name = 'final_price'; inp.id = 'final_price_input';
                    inp.value = finalValue;
                    form.appendChild(inp);
                    console.log('updatePriceDisplay - Created final_price_input with value:', finalValue);
                }
            }
        } catch (e) { console.warn('Could not set final_price_input', e); }

        // Ensure a normalized 'length' hidden input is present so server receives canonical value
        try {
            const bookingForm = document.getElementById('bookingForm');
            if (bookingForm) {
                const lengthResolved = (typeof length === 'string') ? length.replace(/-/g, '_') : length;
                let lengthInput = bookingForm.querySelector('input[name="length"][type="hidden"]');
                if (!lengthInput) {
                    lengthInput = document.createElement('input');
                    lengthInput.type = 'hidden';
                    lengthInput.name = 'length';
                    bookingForm.appendChild(lengthInput);
                }
                lengthInput.value = lengthResolved;
                console.log('Set hidden booking form length to', lengthResolved);
            }
        } catch (e) { console.warn('Could not ensure hidden length input', e); }
        return finalPrice;
    }

    // Store current service info globally for easy access
    window.currentServiceInfo = { serviceName: '', serviceType: '', basePrice: 0 };

    // --- Terms gate (first "Book Now" click) ---
    (function(){
        const KEY = 'dbt_terms_accepted_v1';
        const hasAccepted = () => {
            try { return window.localStorage && localStorage.getItem(KEY) === '1'; } catch(e) { return false; }
        };
        const setAccepted = () => {
            try { window.localStorage && localStorage.setItem(KEY, '1'); } catch(e) {}
        };

        window.__dbtEnsureTermsAccepted = function(next){
            if (hasAccepted()) return next();

            const modalEl = document.getElementById('termsGateModal');
            const agreeEl = document.getElementById('termsGateAgree');
            const contBtn = document.getElementById('termsGateContinueBtn');
            if (!modalEl || !agreeEl || !contBtn) return next();

            const cleanupStrayBackdrops = () => {
                try {
                    const anyShownModal = document.querySelector('.modal.show');
                    if (!anyShownModal) {
                        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.removeProperty('padding-right');
                    }
                } catch (e) {}
            };

            agreeEl.checked = false;
            contBtn.disabled = true;
            const onAgreeChange = () => { contBtn.disabled = !agreeEl.checked; };
            try {
                agreeEl.removeEventListener('change', onAgreeChange);
                agreeEl.addEventListener('change', onAgreeChange);
            } catch(e) {}

            contBtn.onclick = function(){
                if (!agreeEl.checked) return;
                setAccepted();
                try { (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).hide(); } catch(e) {}
                setTimeout(cleanupStrayBackdrops, 50);
                if (typeof next === 'function') next();
            };

            try {
                cleanupStrayBackdrops();
                (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).show();

                // Watchdog: if backdrop appears but modal doesn't show, fail open and cleanup
                setTimeout(function(){
                    try {
                        if (modalEl.classList.contains('show')) return;
                        cleanupStrayBackdrops();
                        modalEl.classList.remove('show');
                        modalEl.style.display = 'none';
                        modalEl.setAttribute('aria-hidden', 'true');
                    } catch(e) {}
                    try { next(); } catch(e) {}
                }, 450);
            } catch(e) {
                cleanupStrayBackdrops();
                next();
            }
        };
    })();

    // Wrap existing openBookingModal
    const prevOpen = window.openBookingModal;
    window.openBookingModal = function(serviceName, serviceType) {
        const run = () => {
            console.log('Opening booking modal for:', serviceName, serviceType);

            // Track where the booking came from:
            // - service cards/carousel pass a non-null serviceType slug
            // - calendar page redirects are marked earlier via window.__bookingOrigin = 'calendar'
            try {
                // If serviceType is provided, this is a service-card/inline booking and should override any prior origin.
                // If serviceType is null, keep whatever origin we already have (e.g., calendar deep-link).
                window.__bookingOrigin = serviceType ? 'service-card' : (window.__bookingOrigin || 'other');
            } catch (e) { /* noop */ }

            // Store service info globally
            window.currentServiceInfo = {
                serviceName: serviceName,
                serviceType: serviceType,
                basePrice: (serviceType && priceMap[serviceType])
                    ? priceMap[serviceType]
                    : ((serviceName && priceByServiceName[serviceName]) ? priceByServiceName[serviceName] : priceMap['custom'])
            };
            
            console.log('openBookingModal - Set currentServiceInfo:', window.currentServiceInfo);

            // Call original modal opener first (it may clear the form)
            if (typeof prevOpen === 'function') {
                try {
                    prevOpen(serviceName, serviceType);
                } catch(e) {
                    console.error('openBookingModal inner error', e);
                }
            }
            // If the modal opener reset the form, re-sync Terms buttons (reset doesn't fire change)
            try { window.__dbtSyncTermsButtons && window.__dbtSyncTermsButtons(); } catch(e) {}

            // Restore terms checkbox if user already accepted terms (from calendar or previous interaction)
            try {
                const KEY = 'dbt_terms_accepted_v1';
                const hasAccepted = () => {
                    try { return window.localStorage && localStorage.getItem(KEY) === '1'; } catch(e) { return false; }
                };
                
                if (hasAccepted()) {
                    // Pre-check terms checkboxes if terms were already accepted
                    const termsMain = document.getElementById('termsAcceptedMain');
                    const termsKids = document.getElementById('termsAcceptedKids');
                    if (termsMain && !termsMain.checked) {
                        termsMain.checked = true;
                        termsMain.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    if (termsKids && !termsKids.checked) {
                        termsKids.checked = true;
                        termsKids.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    // Re-sync buttons after checking terms
                    try { window.__dbtSyncTermsButtons && window.__dbtSyncTermsButtons(); } catch(e) {}
                }
            } catch(e) {
                console.warn('Failed to restore terms acceptance state', e);
            }

            // Now set/restore hidden inputs and update UI (do this after prevOpen which may reset the form)
            try {
                const st = document.getElementById('selectedServiceType');
                if (st) st.value = serviceType || '';

            const sd = document.getElementById('selectedService');
            if (sd) sd.value = serviceName || '';

            const serviceDisplayEl = document.getElementById('serviceDisplay');
            if (serviceDisplayEl) serviceDisplayEl.value = serviceName || '';

            // Restore saved draft (name/phone/email/notes) after prevOpen clears the form
            try { window.__dbtApplyBookingDraftToMain?.(); } catch (e) {}

            const base = window.currentServiceInfo.basePrice;

            // Ensure hidden selectedPrice reflects the authoritative base for this modal
            try {
                const selectedPriceEl = document.getElementById('selectedPrice');
                if (selectedPriceEl) {
                    selectedPriceEl.value = (typeof base === 'number') ? String(base) : (base || '');
                    console.log('openBookingModal - Set selectedPrice to:', selectedPriceEl.value);
                }
            } catch (e) { console.warn('Failed to set selectedPrice hidden input', e); }

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

                    // Format with 2 decimal places to match email format
                    if (kbs_base) kbs_base.innerHTML = 'Base: <strong>$' + (basePrice ? basePrice.toFixed(2) : '--') + '</strong>';
                    if (kbs_adjustments) kbs_adjustments.innerHTML = 'Adjustments: <strong>' + (adjustments >= 0 ? '+' : '-') + '$' + Math.abs(adjustments).toFixed(2) + '</strong>';
                    if (kbs_total) kbs_total.innerHTML = '<strong>Total: $' + (selPrice ? selPrice.toFixed(2) : '--') + '</strong>';

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

            // Service-specific UI handling
            const lengthRadios = document.getElementsByName('hair_length');
            const lengthGuideBlock = document.getElementById('lengthGuideBlock');
            const serviceTypeLower = (serviceType || '').toLowerCase();
            const serviceNameLower = (''+serviceName).toLowerCase();

            // Stitch braids note (tiny stitch >10 rows +$20)
            try {
                const stitchNote = document.getElementById('stitchBraidTinyNote');
                const isStitch = serviceTypeLower.includes('stitch') || serviceNameLower.includes('stitch');
                if (stitchNote) stitchNote.style.display = isStitch ? 'block' : 'none';
            } catch (e) { /* noop */ }

            // Stitch braids rows selector popup (required to choose 8–10 vs >10)
            try {
                const isStitch = serviceTypeLower.includes('stitch') || serviceNameLower.includes('stitch');
                const stitchHidden = document.getElementById('stitch_rows_option');
                if (stitchHidden && !isStitch) {
                    stitchHidden.value = '';
                }
                if (isStitch && stitchHidden && !stitchHidden.value) {
                    // show selector modal on top
                    setTimeout(function () {
                        try {
                            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                const m = new bootstrap.Modal(document.getElementById('stitchRowsModal'));
                                m.show();
                            }
                        } catch (e) { /* noop */ }
                    }, 150);
                }
            } catch (e) { /* noop */ }

            // enable/disable length radios according to service; do NOT change kids flows here
            for (let i = 0; i < lengthRadios.length; i++) {
                try { lengthRadios[i].disabled = !!disableLengths; } catch (e) { /* ignore */ }
            }

                // Now that modal UI is set up (radios, defaults, hidden inputs), update the price display using authoritative base
                try { updatePriceDisplay(base); } catch (e) { console.warn('updatePriceDisplay failed after modal setup', e); }
            } catch (e) {
                console.warn('Error toggling hair mask UI:', e);
            }
        };

        // Gate on first-time visitors: show Terms modal before opening booking flow.
        if (typeof window.__dbtEnsureTermsAccepted === 'function') {
            return window.__dbtEnsureTermsAccepted(run);
        }
        return run();
    };

    // Disable submit until Terms is checked (main + kids)
    document.addEventListener('DOMContentLoaded', function(){
        const setup = (checkboxId, buttonId, formId) => {
            const cb = document.getElementById(checkboxId);
            const btn = document.getElementById(buttonId);
            if (!cb || !btn) return;
            const sync = () => { btn.disabled = !cb.checked; };
            cb.checked = false;
            sync();
            cb.addEventListener('change', sync);

            // Keep button state in sync after form.reset() (opening modal clears the form)
            try {
                const form = document.getElementById(formId);
                if (form && !form.__dbtTermsResetHooked) {
                    form.addEventListener('reset', function(){ setTimeout(sync, 0); });
                    form.__dbtTermsResetHooked = true;
                }
            } catch(e) {}
        };
        setup('termsAcceptedMain', 'bookAppointmentBtn', 'bookingForm');
        setup('termsAcceptedKids', 'kidsBookAppointmentBtn', 'kidsBookingForm');

        // Expose a manual sync hook so modal open flows can re-sync after they clear/reset.
        window.__dbtSyncTermsButtons = function(){
            try {
                const cb1 = document.getElementById('termsAcceptedMain');
                const b1 = document.getElementById('bookAppointmentBtn');
                if (cb1 && b1) b1.disabled = !cb1.checked;
            } catch(e) {}
            try {
                const cb2 = document.getElementById('termsAcceptedKids');
                const b2 = document.getElementById('kidsBookAppointmentBtn');
                if (cb2 && b2) b2.disabled = !cb2.checked;
            } catch(e) {}
        };
    });

    // Update price when length changes
    function handleLengthChange(e) {
        if (e.target && e.target.name === 'hair_length') {
            console.log('Length changed to:', e.target.value);
            // Defer price update to ensure the radio's checked state has been applied
            setTimeout(function(){
                console.log('Deferred updatePriceDisplay after click/change for:', e.target.value);
                // Use the same base price resolution logic as the radio button change handler
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
            // Function to show error message for a field
            function showFieldError(fieldId, message) {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(fieldId + '_error');
                if(field && errorDiv) {
                    errorDiv.textContent = message;
                    errorDiv.style.display = 'block';
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                }
            }

            // Function to clear error message for a field
            function clearFieldError(fieldId) {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(fieldId + '_error');
                if(field && errorDiv) {
                    errorDiv.textContent = '';
                    errorDiv.style.display = 'none';
                    field.classList.remove('is-invalid');
                }
            }

            // Clear errors when user starts typing/selecting
            const requiredFields = ['kids_name', 'kids_phone', 'kidsBookingDate', 'kidsBookingTime'];
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if(field) {
                    field.addEventListener('input', function() {
                        clearFieldError(fieldId);
                    });
                    field.addEventListener('change', function() {
                        clearFieldError(fieldId);
                    });
                }
            });
            
            // Also clear email errors when user types
            const emailField = document.getElementById('kids_email');
            if(emailField) {
                emailField.addEventListener('input', function() {
                    clearFieldError('kids_email');
                });
                emailField.addEventListener('change', function() {
                    clearFieldError('kids_email');
                });
            }

            // Validate kids booking form
            function validateKidsBookingForm() {
                let isValid = true;
                const errors = [];

                // Validate Child's Name
                const nameField = document.getElementById('kids_name');
                const nameValue = nameField ? nameField.value.trim() : '';
                if(!nameValue) {
                    showFieldError('kids_name', 'Please enter the child\'s name.');
                    isValid = false;
                    errors.push('Child\'s name');
                } else {
                    clearFieldError('kids_name');
                }

                // Validate Phone
                const phoneField = document.getElementById('kids_phone');
                const phoneValue = phoneField ? phoneField.value.trim() : '';
                const phonePattern = phoneField ? new RegExp(phoneField.getAttribute('pattern') || '[0-9+()\\s\\-]{7,}') : null;
                if(!phoneValue) {
                    showFieldError('kids_phone', 'Please enter a parent/guardian phone number.');
                    isValid = false;
                    errors.push('Phone number');
                } else if(phonePattern && !phonePattern.test(phoneValue)) {
                    showFieldError('kids_phone', 'Please enter a valid phone number format.');
                    isValid = false;
                    errors.push('Phone number');
                } else {
                    clearFieldError('kids_phone');
                }

                // Validate Email (required field)
                const emailField = document.getElementById('kids_email');
                const emailValue = emailField ? emailField.value.trim() : '';
                if(!emailValue) {
                    showFieldError('kids_email', 'Please enter parent/guardian email address.');
                    isValid = false;
                    errors.push('Email');
                } else {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if(!emailRegex.test(emailValue)) {
                        showFieldError('kids_email', 'Please enter a valid email address.');
                        isValid = false;
                        errors.push('Email');
                    } else {
                        clearFieldError('kids_email');
                    }
                }

                // Validate Date
                const dateField = document.getElementById('kidsBookingDate');
                const dateValue = dateField ? dateField.value.trim() : '';
                const appointmentDateField = document.querySelector('input[name="appointment_date"]');
                const appointmentDateValue = appointmentDateField ? appointmentDateField.value.trim() : '';
                const selectedDate = appointmentDateValue || dateValue;
                
                if(!dateValue && !appointmentDateValue) {
                    showFieldError('kidsBookingDate', 'Please select a date for the appointment.');
                    isValid = false;
                    errors.push('Date');
                } else if(selectedDate) {
                    // Check if the selected date is blocked (only block if it's a full-day block)
                    const blockedIndex = (blockedDatesCache || []).reduce((acc, b) => { acc[b.date] = b; return acc; }, {});
                    if(blockedIndex[selectedDate]) {
                        const blockedInfo = blockedIndex[selectedDate];
                        const isFullDay = blockedInfo.full_day === true || blockedInfo.full_day === 1;
                        
                        // Only show error if it's a full-day block
                        if (isFullDay) {
                            const blockedTitle = blockedInfo.title || 'Blocked';
                            showFieldError('kidsBookingDate', `This date is blocked: "${blockedTitle}". Please select another date.`);
                            isValid = false;
                            errors.push('Date');
                        } else {
                            // Time-specific block - allow date selection (time validation happens on backend)
                            clearFieldError('kidsBookingDate');
                        }
                    } else {
                        clearFieldError('kidsBookingDate');
                    }
                } else {
                    clearFieldError('kidsBookingDate');
                }

                // Validate Time
                const timeField = document.getElementById('kidsBookingTime');
                const timeValue = timeField ? timeField.value.trim() : '';
                const appointmentTimeField = document.querySelector('input[name="appointment_time"]');
                const appointmentTimeValue = appointmentTimeField ? appointmentTimeField.value.trim() : '';
                if(!timeValue && !appointmentTimeValue) {
                    showFieldError('kidsBookingTime', 'Please select a time for the appointment.');
                    isValid = false;
                    errors.push('Time');
                } else {
                    clearFieldError('kidsBookingTime');
                }

                return { isValid, errors };
            }

            kidsForm.addEventListener('submit', function(e){
                try{
                    // Normalize phone number
                    const el = document.getElementById('kids_phone');
                    if(el) el.value = normalizePhoneForSubmit(el.value);

                    // Validate form
                    const validation = validateKidsBookingForm();
                    if(!validation.isValid) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Scroll to first error field
                        const firstErrorField = document.querySelector('#kidsBookingForm .is-invalid');
                        if(firstErrorField) {
                            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstErrorField.focus();
                        }
                        return false;
                    }
                }catch(err){
                    console.warn('Kids booking form validation error:', err);
                    e.preventDefault();
                    return false;
                }
            });
        }
    });
})();
</script>

<script>
// Service Filter Functionality
function filterServices(category) {
    const serviceItems = document.querySelectorAll('.service-item');
    const filterChips = document.querySelectorAll('.filter-chip');
    
    // Update active chip
    filterChips.forEach(chip => {
        if (chip.dataset.filter === category) {
            chip.classList.add('active');
        } else {
            chip.classList.remove('active');
        }
    });
    
    // Filter service cards
    serviceItems.forEach(item => {
        if (category === 'all') {
            item.classList.remove('hidden');
        } else {
            if (item.dataset.category === category) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        }
    });
    
    // Reset mobile visibility after filter
    initializeMobileServices();
}

// Mobile See More/Less Functionality
let servicesExpanded = false;

function toggleServices() {
    const serviceItems = document.querySelectorAll('.service-item:not(.hidden)');
    const seeMoreBtn = document.getElementById('seeMoreBtn');
    const seeMoreText = document.getElementById('seeMoreText');
    const seeMoreIcon = document.getElementById('seeMoreIcon');
    
    servicesExpanded = !servicesExpanded;
    
    if (servicesExpanded) {
        // Show all services
        serviceItems.forEach(item => {
            item.classList.remove('hidden-mobile');
        });
        seeMoreText.textContent = 'See Less Services';
        seeMoreIcon.classList.remove('bi-chevron-down');
        seeMoreIcon.classList.add('bi-chevron-up');
    } else {
        // Show only first 4 services on mobile
        serviceItems.forEach((item, index) => {
            if (index >= 4) {
                item.classList.add('hidden-mobile');
            }
        });
        seeMoreText.textContent = 'See More Services';
        seeMoreIcon.classList.remove('bi-chevron-up');
        seeMoreIcon.classList.add('bi-chevron-down');
        
        // Scroll to services section smoothly
        document.getElementById('services').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

// Initialize mobile services visibility on load
function initializeMobileServices() {
    if (window.innerWidth <= 768) {
        const serviceItems = document.querySelectorAll('.service-item:not(.hidden)');
        servicesExpanded = false;
        
        serviceItems.forEach((item, index) => {
            if (index >= 4) {
                item.classList.add('hidden-mobile');
            } else {
                item.classList.remove('hidden-mobile');
            }
        });
        
        // Reset button state
        const seeMoreText = document.getElementById('seeMoreText');
        const seeMoreIcon = document.getElementById('seeMoreIcon');
        if (seeMoreText) seeMoreText.textContent = 'See More Services';
        if (seeMoreIcon) {
            seeMoreIcon.classList.remove('bi-chevron-up');
            seeMoreIcon.classList.add('bi-chevron-down');
        }
    } else {
        // On desktop, show all services
        document.querySelectorAll('.service-item').forEach(item => {
            item.classList.remove('hidden-mobile');
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeMobileServices();
});

// Re-initialize on window resize
window.addEventListener('resize', function() {
    initializeMobileServices();
});
</script>

</body>
</html>


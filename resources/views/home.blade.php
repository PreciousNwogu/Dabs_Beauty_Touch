<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dab's Beauty Touch - Professional Hair Braiding Services</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <!-- Bootstrap CDN (backup) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
            background-color: #ff6600;
            color: rgb(7, 10, 86);
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
        }
        .service-card img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            background: #fff;
            border-radius: 50%;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            display: block;
            margin-left: auto;
            margin-right: auto;
            border: 4px solid #fff;
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-bottom: 0;">
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
                </ul>
                <a class="btn btn-warning book-now-btn ms-auto px-4 py-2" href="#booking" style="font-weight:600; margin-left:auto;">Book Now</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container" style="padding-top: 120px; padding-bottom: 80px;">
            <div class="hero-content">
                <h1>Dab's Beauty Touch</h1>
                <p>Flawless Results - Looking for a stylist who delivers neat, long-lasting braids? Experience the expert touch at Dab's Beauty Touch today!</p>
                <a href="#booking" class="btn-book">Book Appointment</a>
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
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;">“Very patient and time conscious. She follows up and ensures customer comfortability. I always leave happy!”</div>
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
                <div class="testimonial-text" style="font-size:1.12rem; color:#222; margin:18px 0; font-style:italic;"> “Customer relationship is amazing. Very professional and very affordable service. Highly recommend DBT!”</div>
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
                            <p style="font-size:1.05rem; color:#444;">At Dab's Beauty Touch, we specialize in creating beautiful, long-lasting braided hairstyles that enhance your natural beauty. <br>We believe that confidence begins with feeling great about how you look. Known for our exceptional craftsmanship and creative hairstyle designs, we don’t just transform appearances—we help you radiate self-assurance. Whether it’s a fresh new look or a signature style, we’re here to be the touch that enhances your natural beauty and leaves you feeling confident.</p>
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
                    <div class="service-card h-100">
                        <img src="{{ asset('images/braid4.jpg') }}" alt="Box Braids">
                        <h4>Box Braids</h4>
                        <p>Classic protective style perfect for all occasions. Long-lasting and versatile.</p>
                        <p class="price"><strong>Starting at $120</strong></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <img src="{{ asset('images/Cornrows.jpg') }}" alt="Cornrows">
                        <h4>Cornrows</h4>
                        <p>Traditional braiding technique that creates beautiful patterns close to the scalp.</p>
                        <p class="price"><strong>Starting at $80</strong></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <img src="{{ asset('images/wig installation.jpg') }}" alt="Wig Installation">
                        <h4>Wig Installation</h4>
                        <p>Professional wig installation services for a natural, flawless look.</p>
                        <p class="price"><strong>Starting at $100</strong></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <img src="{{ asset('images/extention.jpg') }}" alt="Hair Extensions">
                        <h4>Hair Extensions</h4>
                        <p>Add length and volume with our premium hair extension services.</p>
                        <p class="price"><strong>Starting at $20</strong></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <img src="{{ asset('images/hair_mask.png') }}" alt="Protective Styles">
                        <h4>Protective Styles</h4>
                        <p>Various protective styling options to maintain healthy hair growth.</p>
                        <p class="price"><strong>Starting at $100</strong></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <img src="{{ asset('images/kids hair style.webp') }}" alt="Kids Braiding">
                        <h4>Kids Braiding</h4>
                        <p>Gentle braiding services specially designed for children's delicate hair.</p>
                        <p class="price"><strong>Starting at $60</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="contact-section">
        <div class="container" style="padding-top: 60px; padding-bottom: 60px;">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="text-center mb-5">
                        <h2 class="section-title" style="font-size:2.7rem; font-weight:800; letter-spacing:-1px;">Book Your Appointment</h2>
                        <p class="lead" style="font-size:1.25rem; color:#1a237e;">Ready to get your hair styled? Choose your style and book now!</p>
                    </div>
                    <div class="card shadow-lg border-0 booking-form" style="border-radius: 24px; background: linear-gradient(135deg,#f8f9fa 0%,#e3eafc 100%); padding: 38px 32px 32px 32px;">
                        <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="service" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Style *</label>
                                    <select class="form-select" id="service" name="service" required onchange="toggleLengthDropdown()" style="display: block !important; width: 100% !important; padding: 12px 16px !important; border: 2px solid #e3e3e0 !important; border-radius: 8px !important; background-color: #fff !important; cursor: pointer !important;">
                                        <option value="">Select a style...</option>
                                        <optgroup label="Braids">
                                            <option value="Box Braids">Box Braids</option>
                                            <option value="Cornrows">Cornrows</option>
                                            <option value="Knotless Braids">Knotless Braids</option>
                                            <option value="Feed-in Braids">Feed-in Braids</option>
                                            <option value="Stitch Braids">Stitch Braids</option>
                                            <option value="Twists">Twists</option>
                                            <option value="Kids Braiding">Kids Braiding</option>
                                        </optgroup>
                                        <optgroup label="Extensions & Weaves">
                                            <option value="Sew-in Weaves">Sew-in Weaves</option>
                                            <option value="Quick Weaves">Quick Weaves</option>
                                            <option value="Crotchets">Crotchets</option>
                                            <option value="Hair Extensions">Hair Extensions</option>
                                        </optgroup>
                                        <optgroup label="Wigs & Installations">
                                            <option value="Wig Installation">Wig Installation</option>
                                            <option value="Wig Fixing">Wig Fixing</option>
                                            <option value="Wig Revamping">Wig Revamping</option>
                                        </optgroup>
                                        <optgroup label="Hair Care">
                                            <option value="Hair Mask & Retouching">Hair Mask & Retouching</option>
                                            <option value="Deep Conditioning">Deep Conditioning</option>
                                            <option value="Protective Styles">Protective Styles</option>
                                            <option value="Natural Hair Care">Natural Hair Care</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3" id="length-dropdown-container" style="display:none;">
                                    <label for="length" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Braid Length *</label>
                                    <select class="form-select" id="length" name="length" style="display: block !important; width: 100% !important; padding: 12px 16px !important; border: 2px solid #e3e3e0 !important; border-radius: 8px !important; background-color: #fff !important; cursor: pointer !important;">
                                        <option value="">Select length...</option>
                                        <option value="Short">Short</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Long">Long</option>
                                        <option value="Extra Long">Extra Long</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Preferred Date *</label>
                                    <input type="date" class="form-control" id="date" name="date" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="time" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Preferred Time *</label>
                                    <select class="form-select" id="time" name="time" required style="display: block !important; width: 100% !important; padding: 12px 16px !important; border: 2px solid #e3e3e0 !important; border-radius: 8px !important; background-color: #fff !important; cursor: pointer !important;">
                                        <option value="">Select time</option>
                                        <option value="09:00">9:00 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="13:00">1:00 PM</option>
                                        <option value="14:00">2:00 PM</option>
                                        <option value="15:00">3:00 PM</option>
                                        <option value="16:00">4:00 PM</option>
                                        <option value="17:00">5:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <label for="sample_picture" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Upload Sample Picture (optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
                                        <input class="form-control" type="file" id="sample_picture" name="sample_picture" accept="image/*">
                                    </div>
                                    <small class="form-text text-muted" style="margin-top:4px; display:block;">Accepted formats: JPG, PNG, JPEG. Max size: 2MB.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="message" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Special Requests or Notes</label>
                                    <textarea class="form-control" id="message" name="message" placeholder="Any special requests or additional information..." style="height: 100px; resize: vertical;"></textarea>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn-book" style="font-size:1.15rem; padding:14px 48px; border-radius:10px; font-weight:700;">Book Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            <div class="faq-answer" style="display:none; color:#222; font-size:1.08rem; margin-top:12px;">
                                Yes, at Dab's Beauty Touch, we offer gentle and tailored hair care services for children under 4 years. We are experienced in working with young children. We use age-appropriate, safe, and non-irritating products that are specifically designed for sensitive scalps. If you have any special requests, please feel free to reach out to us. We are here to make the experience enjoyable for both children and parents.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>How many hours is your cancellation notice and any penalty?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="display:none; color:#222; font-size:1.08rem; margin-top:12px;">
                                We kindly request a minimum 2-day cancellation notice for all appointments. If you cancel within less than 2 days, a deposit fee will be non-refundable. This helps us accommodate other clients who may need the time slot. We appreciate your understanding and cooperation.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you render home services and do you charge differently for that?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="display:none; color:#222; font-size:1.08rem; margin-top:12px;">
                                Yes, we offer home services for your convenience! Please note, we do not charge differently for home service fee, our clients take charge of the transportation to and fro. Clients can book a ride or use any other means.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you also do men's hair?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="display:none; color:#222; font-size:1.08rem; margin-top:12px;">
                                Absolutely! We provide a variety of grooming and hairstyling services for men, including braids, twists, and basic grooming. We ensure that each style is tailored to fit your preferences.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>What kind of extensions should I get for my appointment?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="display:none; color:#222; font-size:1.08rem; margin-top:12px;">
                                The type of hair extensions depends on the style you're looking for. For braids we recommend Xpression extension/attachment. We recommend human hair extensions for a natural look and durability. For a temporary style or budget-friendly option, synthetic extensions work well. Feel free to consult us before your appointment for personalized recommendations.
                            </div>
                        </li>
                        <li class="faq-list-item" style="display:flex; flex-direction:column; border-bottom:1px solid #eee; padding:32px 0 16px 0;">
                            <div class="faq-question" style="display:flex; align-items:center; justify-content:space-between; font-size:1.45rem; color:#1a237e; font-weight:400; cursor:pointer;">
                                <span>Do you charge the same amount for all ages?</span>
                                <span class="faq-arrow" style="font-size:1.7rem; color:#030f68; transition:transform 0.2s;">&#x25BC;</span>
                            </div>
                            <div class="faq-answer" style="display:none; color:#222; font-size:1.08rem; margin-top:12px;">
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
        // Show/hide braid length dropdown based on style selection
        function toggleLengthDropdown() {
            var styleSelect = document.getElementById('service');
            var lengthContainer = document.getElementById('length-dropdown-container');
            var stylesWithLength = [
                'Box Braids', 
                'Cornrows', 
                'Knotless Braids', 
                'Feed-in Braids', 
                'Stitch Braids', 
                'Twists', 
                'Kids Braiding',
                'Sew-in Weaves',
                'Quick Weaves',
                'Crotchets',
                'Hair Extensions'
            ];
            if (styleSelect && lengthContainer) {
                if (stylesWithLength.includes(styleSelect.value)) {
                    lengthContainer.style.display = 'block';
                    document.getElementById('length').setAttribute('required', 'required');
                } else {
                    lengthContainer.style.display = 'none';
                    document.getElementById('length').removeAttribute('required');
                }
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            toggleLengthDropdown();
        });
    </script>
    <script>
        // FAQ collapse logic
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.faq-question').forEach(function(q) {
                q.addEventListener('click', function() {
                    var answer = this.parentElement.querySelector('.faq-answer');
                    var arrow = this.querySelector('.faq-arrow');
                    var isOpen = answer.style.display === 'block';
                    // Close all answers
                    document.querySelectorAll('.faq-answer').forEach(function(a) { a.style.display = 'none'; });
                    document.querySelectorAll('.faq-arrow').forEach(function(ar) { ar.style.transform = 'rotate(0deg)'; });
                    // Toggle current
                    if (!isOpen) {
                        answer.style.display = 'block';
                        arrow.style.transform = 'rotate(180deg)';
                    }
                });
            });
        });
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

        // Form submission handling
        const bookingForm = document.querySelector('form[action*="bookings.store"]');
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;

                // Show loading state
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                submitBtn.disabled = true;

                // Get form data
                const formData = new FormData(this);

                // Submit via AJAX
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        alert(data.message);
                        this.reset();
                        // Reset length dropdown visibility
                        toggleLengthDropdown();
                    } else {
                        // Show error message
                        alert('Error: ' + (data.message || 'Something went wrong. Please try again.'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }

        // Add CSRF token meta tag if not present
        if (!document.querySelector('meta[name="csrf-token"]')) {
            const meta = document.createElement('meta');
            meta.name = 'csrf-token';
            meta.content = document.querySelector('input[name="_token"]').value;
            document.head.appendChild(meta);
        }

        // Show/hide braid length dropdown based on style selection
        function toggleLengthDropdown() {
            var styleSelect = document.getElementById('service');
            var lengthContainer = document.getElementById('length-dropdown-container');
            // Only show for styles that require length selection
            var stylesWithLength = [
                'Box Braids', 
                'Cornrows', 
                'Knotless Braids', 
                'Feed-in Braids', 
                'Stitch Braids', 
                'Twists', 
                'Kids Braiding',
                'Sew-in Weaves',
                'Quick Weaves',
                'Crotchets',
                'Hair Extensions'
            ];
            if (stylesWithLength.includes(styleSelect.value)) {
                lengthContainer.style.display = 'block';
                document.getElementById('length').setAttribute('required', 'required');
            } else {
                lengthContainer.style.display = 'none';
                document.getElementById('length').removeAttribute('required');
            }
        }

        // Initialize length dropdown on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleLengthDropdown();
            
            // Debug: Check if dropdowns are working
            console.log('Page loaded, checking dropdowns...');
            
            const styleSelect = document.getElementById('service');
            const timeSelect = document.getElementById('time');
            
            if (styleSelect) {
                console.log('Style dropdown found:', styleSelect);
                styleSelect.addEventListener('click', function() {
                    console.log('Style dropdown clicked');
                });
            } else {
                console.log('Style dropdown NOT found');
            }
            
            if (timeSelect) {
                console.log('Time dropdown found:', timeSelect);
                timeSelect.addEventListener('click', function() {
                    console.log('Time dropdown clicked');
                });
            } else {
                console.log('Time dropdown NOT found');
            }
        });

        const contactForm = document.querySelector('form[action*="contact.store"]');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                // You can add client-side validation here if needed
                console.log('Contact form submitted');
            });
        }
    </script>
</body>
</html>

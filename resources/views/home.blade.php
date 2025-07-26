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

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container" style="padding-top: 60px; padding-bottom: 60px;">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10">
                    <div class="card flex-row shadow-lg border-0" style="border-radius: 24px; overflow: hidden; background: #fff;">
                        <div class="col-md-7 p-5 d-flex flex-column justify-content-center">
                            <h2 class="section-title mb-3" style="font-size:2.5rem; font-weight:700;">About Dab's Beauty Touch</h2>
                            <p class="lead mb-3" style="font-size:1.25rem; color:#333;">Professional hair braiding services with over 10 years of experience.</p>
                            <p style="font-size:1.05rem; color:#444;">At Dab's Beauty Touch, we specialize in creating beautiful, long-lasting braided hairstyles that enhance your natural beauty. Our expert stylists are passionate about delivering exceptional results that exceed your expectations.</p>
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
                        <p class="price"><strong>Starting at $150</strong></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card h-100">
                        <img src="{{ asset('images/tucson-hair-braiding.jpeg') }}" alt="Protective Styles">
                        <h4>Protective Styles</h4>
                        <p>Various protective styling options to maintain healthy hair growth.</p>
                        <p class="price"><strong>Starting at $90</strong></p>
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
                    <div class="card shadow-lg border-0" style="border-radius: 24px; background: linear-gradient(135deg,#f8f9fa 0%,#e3eafc 100%); padding: 38px 32px 32px 32px;">
                        <form action="{{ route('bookings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name *" required>
                                        <label for="name">Full Name *</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number *" required>
                                        <label for="phone">Phone Number *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="service" name="service" required aria-label="Service">
                                            <option value="">Select a style...</option>
                                            <option value="Box Braids">Box Braids</option>
                                            <option value="Cornrows">Cornrows</option>
                                            <option value="Wig Installation">Wig Installation</option>
                                            <option value="Hair Mask & Retouching">Hair Mask & Retouching</option>
                                            <option value="Crotchets">Crotchets</option>
                                            <option value="Weaves">Weaves</option>
                                            <option value="Kids Braiding">Kids Braiding</option>
                                        </select>
                                        <label for="service">Style *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6 mb-3 d-flex flex-column justify-content-end">
                                    <label for="sample_picture" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Upload Sample Picture (optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
                                        <input class="form-control" type="file" id="sample_picture" name="sample_picture" accept="image/*">
                                    </div>
                                    <small class="form-text text-muted" style="margin-top:4px; display:block;">Accepted formats: JPG, PNG, JPEG. Max size: 2MB.</small>
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
                                        <label for="time">Preferred Time *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6 mb-3">
                                    <div style="margin-bottom:8px;">

                                    </div>
                                    <label for="sample_picture" class="form-label" style="font-weight:600; color:#05137c; font-size:1rem; margin-bottom:8px; display:block;">Upload Sample Picture (optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
                                        <input class="form-control" type="file" id="sample_picture" name="sample_picture" accept="image/*">
                                    </div>
                                    <small class="form-text text-muted" style="margin-top:4px; display:block;">Accepted formats: JPG, PNG, JPEG. Max size: 2MB.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="message" name="message" placeholder="Any special requests or additional information..." style="height: 100px"></textarea>
                                        <label for="message">Special Requests or Notes</label>
                                    </div>
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
                // You can add client-side validation here if needed
                console.log('Booking form submitted');
            });
        }

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

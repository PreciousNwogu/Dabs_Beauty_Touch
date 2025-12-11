<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed - Dab's Beauty Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            margin: auto;
        }
        .success-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
        }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }
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
        .booking-details {
            background: #f8f9fa;
            padding: 1.5rem;
            margin: 1.5rem;
            border-radius: 15px;
            border-left: 5px solid #28a745;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #212529;
            font-weight: 500;
        }
        .btn-home {
            background: linear-gradient(135deg, #030f68 0%, #4a8bc2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s ease;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 class="mb-3">Booking Confirmed!</h1>
                <p class="lead mb-0">Your appointment has been successfully booked</p>
            </div>

            <div class="p-4">
                <div class="booking-details">
                    <h5 class="mb-3 text-success">
                        <i class="fas fa-calendar-check me-2"></i>
                        Appointment Details
                    </h5>

                    <div class="alert alert-success">
                        <i class="fas fa-info-circle me-2"></i>
                        Your booking has been confirmed! <br>
                        All booking details (Booking ID, Confirmation Code and pricing) have been emailed to you. Please check your email for confirmation.
                    </div>
                </div>

                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>What's Next?</h6>
                    <ul class="mb-0 ps-3">
                        <li>We'll contact you within 24 hours to confirm your appointment</li>
                        <li>A $20 deposit will be required to secure your booking</li>
                        <li>Please keep your Booking ID and Confirmation Code for reference</li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn-home me-3">
                        <i class="fas fa-home me-2"></i>
                        Back to Home
                    </a>
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-phone me-1"></i>
                                Questions? Call us at <strong>(343) 254-8848</strong>
                            </small>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Dab's Beauty Touch</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin-bottom: 20px;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .success-message {
            text-align: center;
            margin-bottom: 30px;
        }
        .booking-details {
            background: #f8fafc;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #10b981;
        }
        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 8px 0;
        }
        .detail-item:last-child {
            margin-bottom: 0;
        }
        .detail-icon {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            color: #6b7280;
            flex-shrink: 0;
        }
        .detail-label {
            color: #6b7280;
            margin-right: 8px;
            font-weight: 500;
        }
        .detail-value {
            color: #1f2937;
            font-weight: 600;
        }
        .warning-box {
            background: #fef3cd;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 16px;
            margin: 20px 0;
            display: flex;
            align-items: flex-start;
        }
        .warning-icon {
            color: #d97706;
            margin-right: 12px;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .contact-info {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        .contact-item:last-child {
            margin-bottom: 0;
        }
        .contact-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            color: #4f46e5;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        a {
            color: #4f46e5;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="icon">✓</div>
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">Appointment Booked Successfully!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="success-message">
                <p style="color: #6b7280; margin: 0;">Your beauty appointment has been confirmed. Here are your booking details:</p>
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <h3 style="margin: 0 0 20px 0; color: #1f2937; font-size: 18px;">📅 Booking Information</h3>

                <div class="detail-item">
                    <span class="detail-icon">🔖</span>
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">{{ $booking_id ?? 'BK000024' }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-icon">🛡️</span>
                    <span class="detail-label">Confirmation Code:</span>
                    <span class="detail-value">{{ $confirmation_code ?? 'CONFEAB923BD' }}</span>
                </div>

                @if(isset($appointment_date))
                <div class="detail-item">
                    <span class="detail-icon">📅</span>
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $appointment_date }}</span>
                </div>
                @endif

                @if(isset($appointment_time))
                <div class="detail-item">
                    <span class="detail-icon">⏰</span>
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">{{ $appointment_time }}</span>
                </div>
                @endif

                @if(isset($service))
                <div class="detail-item">
                    <span class="detail-icon">✂️</span>
                    <span class="detail-label">Service:</span>
                    <span class="detail-value">{{ $service }}</span>
                </div>
                @endif
            </div>

            <!-- Deposit Warning -->
            <div class="warning-box">
                <span class="warning-icon">⚠️</span>
                <div>
                    <strong>Important: Deposit Required</strong>
                    <p style="margin: 5px 0 0 0; color: #92400e;">Please contact us to arrange the $20 deposit payment. Your appointment will be confirmed once payment is received!</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                <h4 style="margin: 0 0 15px 0; color: #1f2937;">📞 Contact Us</h4>

                <div class="contact-item">
                    <span class="contact-icon">📱</span>
                    <div>
                        <strong>Phone:</strong> <a href="tel:3432548848">(343) 254-8848</a>
                    </div>
                </div>

                <div class="contact-item">
                    <span class="contact-icon">✉️</span>
                    <div>
                        <strong>Email:</strong> <a href="mailto:info@dabsbeautytouch.com">info@dabsbeautytouch.com</a>
                    </div>
                </div>
            </div>

            <p style="text-align: center; color: #6b7280; margin: 25px 0 0 0;">
                We look forward to seeing you! Please save this email for your records.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0;">© 2025 Dab's Beauty Touch. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

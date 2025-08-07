<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .booking-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .confirmation-code {
            background-color: #e8f5e8;
            color: #2d5a2d;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Booking Confirmed!</h1>
            <p>Thank you for choosing Dab's Beauty Touch</p>
        </div>
        
        <div class="content">
            <p>Hello {{ $booking->name ?? 'Valued Customer' }},</p>
            
            <p>Your appointment has been successfully confirmed! Here are your booking details:</p>
            
            <div class="booking-details">
                <h3>📅 Appointment Details</h3>
                <p><strong>Service:</strong> {{ $booking->service ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ $booking->date ?? 'N/A' }}</p>
                <p><strong>Time:</strong> {{ $booking->time ?? 'N/A' }}</p>
                <p><strong>Name:</strong> {{ $booking->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $booking->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $booking->phone ?? 'N/A' }}</p>
                @if(!empty($booking->message))
                <p><strong>Special Requests:</strong> {{ $booking->message }}</p>
                @endif
            </div>
            
            <div class="confirmation-code">
                📋 Confirmation Code: {{ $confirmationCode ?? $bookingId }}
            </div>
            
            <p><strong>What's Next?</strong></p>
            <ul>
                <li>Please arrive 10 minutes before your appointment</li>
                <li>Bring a valid ID for verification</li>
                <li>If you need to reschedule, please contact us 24 hours in advance</li>
            </ul>
            
            <p>We look forward to providing you with exceptional beauty services!</p>
            
            <p>Best regards,<br>
            <strong>Dab's Beauty Touch Team</strong></p>
        </div>
    </div>
</body>
</html>

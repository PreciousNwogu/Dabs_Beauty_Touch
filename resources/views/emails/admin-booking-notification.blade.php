<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Notification</title>
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
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
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
            border-left: 4px solid #28a745;
        }
        .alert {
            background-color: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 New Booking Alert!</h1>
            <p>A new appointment has been scheduled</p>
        </div>
        
        <div class="content">
            <div class="alert">
                <strong>⚠️ Action Required:</strong> Please confirm this appointment and prepare your schedule.
            </div>
            
            <div class="booking-details">
                <h3>👤 Customer Information</h3>
                <p><strong>Name:</strong> {{ $booking->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $booking->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $booking->phone ?? 'N/A' }}</p>
                
                <h3>📅 Appointment Details</h3>
                <p><strong>Service:</strong> {{ $booking->service ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ $booking->date ?? 'N/A' }}</p>
                <p><strong>Time:</strong> {{ $booking->time ?? 'N/A' }}</p>
                <p><strong>Booking ID:</strong> {{ $bookingId ?? 'N/A' }}</p>
                <p><strong>Confirmation Code:</strong> {{ $confirmationCode ?? 'N/A' }}</p>
                
                @if(!empty($booking->message))
                <h3>💬 Special Requests</h3>
                <p>{{ $booking->message }}</p>
                @endif
            </div>
            
            <p><strong>📋 Next Steps:</strong></p>
            <ul>
                <li>Review the appointment details above</li>
                <li>Ensure you have availability at the scheduled time</li>
                <li>Prepare any necessary materials for the service</li>
                <li>Contact the customer if any changes are needed</li>
            </ul>
            
            <p>This notification was automatically generated from the Dab's Beauty Touch booking system.</p>
        </div>
    </div>
</body>
</html>

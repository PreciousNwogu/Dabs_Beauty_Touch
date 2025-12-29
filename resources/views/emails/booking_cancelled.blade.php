@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Cancelled - Dabs Beauty Touch</title>
  <style>
    body { 
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; 
      background: #f6f9fc; 
      color: #1a202c; 
      margin: 0; 
      padding: 0;
      line-height: 1.6;
    }
    .email-container { 
      max-width: 600px; 
      margin: 0 auto; 
      background: #ffffff;
    }
    .header {
      background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
      padding: 32px 24px;
      text-align: center;
      border-radius: 8px 8px 0 0;
    }
    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      margin: 0;
      letter-spacing: -0.5px;
    }
    .header-badge {
      display: inline-block;
      background: rgba(255, 255, 255, 0.2);
      color: #ffffff;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      margin-top: 12px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .content {
      padding: 32px 24px;
    }
    .greeting {
      font-size: 18px;
      color: #1a202c;
      font-weight: 600;
      margin: 0 0 16px 0;
    }
    .message {
      font-size: 16px;
      color: #4a5568;
      margin: 0 0 24px 0;
      line-height: 1.7;
    }
    .info-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .info-card h3 {
      color: #0b3a66;
      font-size: 13px;
      font-weight: 700;
      margin: 0 0 16px 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    .info-table tr {
      border-bottom: 1px solid #e2e8f0;
    }
    .info-table tr:last-child {
      border-bottom: none;
    }
    .info-table td {
      padding: 12px 0;
      font-size: 15px;
    }
    .info-table td:first-child {
      color: #718096;
      font-weight: 600;
      width: 40%;
      vertical-align: top;
    }
    .info-table td:last-child {
      color: #1a202c;
      font-weight: 500;
    }
    .notice-box {
      background: #fef2f2;
      border-left: 4px solid #dc2626;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .notice-box h3 {
      color: #991b1b;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .notice-box p {
      color: #7f1d1d;
      font-size: 14px;
      margin: 0;
      line-height: 1.6;
    }
    .action-box {
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .action-box h3 {
      color: #0b3a66;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .action-box p {
      color: #4a5568;
      font-size: 14px;
      margin: 0 0 16px 0;
    }
    .btn {
      display: inline-block;
      padding: 14px 28px;
      background: #ff6600;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 15px;
      text-align: center;
      margin: 8px 8px 8px 0;
      transition: background 0.2s;
    }
    .btn:hover {
      background: #e55a00;
    }
    .btn-secondary {
      background: #0b3a66;
    }
    .btn-secondary:hover {
      background: #0a2d4d;
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 24px;
      text-align: center;
      border-radius: 0 0 8px 8px;
    }
    .footer h4 {
      color: #0b3a66;
      font-size: 14px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .footer p {
      color: #718096;
      font-size: 13px;
      margin: 8px 0;
      line-height: 1.6;
    }
    .signature {
      color: #4a5568;
      font-size: 14px;
      margin-top: 24px;
      padding-top: 24px;
      border-top: 1px solid #e2e8f0;
    }
    @media only screen and (max-width: 600px) {
      .content { padding: 24px 16px; }
      .header { padding: 24px 16px; }
      .header h1 { font-size: 24px; }
      .btn { display: block; margin: 8px 0; }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <!-- Header -->
    <div class="header">
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">Booking Cancelled</div>
    </div>

    <!-- Content -->
    <div class="content">
      <p class="greeting">Hello {{ $booking->name ?? 'Valued Customer' }},</p>
      
      <p class="message">
        We regret to inform you that your booking has been cancelled. We understand this may be disappointing, 
        and we sincerely apologize for any inconvenience this may cause.
      </p>

      <!-- Cancellation Details Card -->
      <div class="info-card">
        <h3>Cancellation Details</h3>
        <table class="info-table">
          <tr>
            <td>Booking ID</td>
            <td><strong>BK{{ str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT) }}</strong></td>
          </tr>
          <tr>
            <td>Service</td>
            <td><strong>{{ $booking->service ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>Original Date</td>
            <td>
              @if($booking->appointment_date)
                {{ \Carbon\Carbon::parse($booking->appointment_date)->format('l, F j, Y') }}
              @else
                N/A
              @endif
            </td>
          </tr>
          <tr>
            <td>Original Time</td>
            <td>
              @if($booking->appointment_time)
                {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
              @else
                N/A
              @endif
            </td>
          </tr>
          <tr>
            <td>Cancelled By</td>
            <td><strong>{{ $cancelledBy ?? ($booking->cancelled_by ?? 'Administrator') }}</strong></td>
          </tr>
        </table>
      </div>

      <!-- Action Box -->
      <div class="action-box">
        <h3>💡 What's Next?</h3>
        <p>
          We'd love to have you back! If you'd like to reschedule your appointment or book a new service, 
          we're here to help. Simply reply to this email or visit our website to book a new appointment.
        </p>
        <div style="text-align: center; margin-top: 20px;">
          <a href="{{ route('home') }}" class="btn">Book a New Appointment</a>
        </div>
      </div>

      <!-- Signature -->
      <div class="signature">
        <p style="margin: 0; color: #4a5568;">We apologize for any inconvenience,<br>
        <strong style="color: #0b3a66;">Dabs Beauty Touch</strong></p>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <h4>Stay Connected</h4>
      <p>Follow us for updates, styling inspiration, and special offers:</p>
      {!! \App\Helpers\SocialLinks::render() !!}
      <p style="margin-top: 20px; font-size: 12px; color: #a0aec0;">
        This is an automated notification email. Please do not reply directly to this message.<br>
        If you have any questions, please contact us through our website or phone.
      </p>
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>

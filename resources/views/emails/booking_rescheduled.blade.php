@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Appointment Rescheduled - Dabs Beauty Touch</title>
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
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
    .schedule-card {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .schedule-card h3 {
      color: #0b3a66;
      font-size: 13px;
      font-weight: 700;
      margin: 0 0 16px 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .schedule-comparison {
      display: flex;
      gap: 16px;
      margin: 16px 0;
    }
    .schedule-item {
      flex: 1;
      padding: 16px;
      border-radius: 6px;
      text-align: center;
    }
    .schedule-item.old {
      background: #fef2f2;
      border: 1px solid #fecaca;
    }
    .schedule-item.new {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
    }
    .schedule-item-label {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 8px;
    }
    .schedule-item.old .schedule-item-label {
      color: #991b1b;
    }
    .schedule-item.new .schedule-item-label {
      color: #166534;
    }
    .schedule-item-date {
      font-size: 18px;
      font-weight: 700;
      color: #1a202c;
      margin: 4px 0;
    }
    .schedule-item-time {
      font-size: 16px;
      color: #4a5568;
      font-weight: 500;
    }
    .arrow {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: #f59e0b;
      font-weight: bold;
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
      background: #fef3c7;
      border-left: 4px solid #f59e0b;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .notice-box h3 {
      color: #92400e;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .notice-box p {
      color: #78350f;
      font-size: 14px;
      margin: 0;
      line-height: 1.6;
    }
    .calendar-section {
      background: #f0f9ff;
      border: 1px solid #bae6fd;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .calendar-section h3 {
      color: #0b3a66;
      font-size: 16px;
      font-weight: 700;
      margin: 0 0 12px 0;
    }
    .calendar-section p {
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
      .schedule-comparison { flex-direction: column; }
      .arrow { transform: rotate(90deg); margin: 8px 0; }
      .btn { display: block; margin: 8px 0; }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <!-- Header -->
    <div class="header">
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">Appointment Rescheduled</div>
    </div>

    <!-- Content -->
    <div class="content">
      <p class="greeting">Hello {{ $booking->name ?? 'Valued Customer' }},</p>
      
      <p class="message">
        This email is to confirm that your appointment has been successfully rescheduled. 
        Please review the updated details below and update your calendar accordingly.
      </p>

      <!-- Schedule Comparison -->
      <div class="schedule-card">
        <h3>Schedule Change</h3>
        <div class="schedule-comparison">
          <div class="schedule-item old">
            <div class="schedule-item-label">Previous Appointment</div>
            <div class="schedule-item-date">{{ $oldDisplay ?? 'N/A' }}</div>
          </div>
          <div class="arrow">→</div>
          <div class="schedule-item new">
            <div class="schedule-item-label">New Appointment</div>
            <div class="schedule-item-date">{{ $newDisplay ?? 'N/A' }}</div>
          </div>
        </div>
      </div>

      <!-- Booking Details Card -->
      <div class="info-card">
        <h3>Booking Information</h3>
        <table class="info-table">
          <tr>
            <td>Booking ID</td>
            <td><strong>BK{{ str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT) }}</strong></td>
          </tr>
          <tr>
            <td>Confirmation Code</td>
            <td><strong>{{ $booking->confirmation_code ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT)) }}</strong></td>
          </tr>
          <tr>
            <td>Service</td>
            <td><strong>{{ $booking->service ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>New Date</td>
            <td>
              <strong>
                @if(isset($new['date']) && $new['date'])
                  {{ \Carbon\Carbon::parse($new['date'])->format('l, F j, Y') }}
                @elseif($booking->appointment_date)
                  {{ \Carbon\Carbon::parse($booking->appointment_date)->format('l, F j, Y') }}
                @else
                  N/A
                @endif
              </strong>
            </td>
          </tr>
          <tr>
            <td>New Time</td>
            <td>
              <strong>
                @if(isset($new['time']) && $new['time'])
                  {{ \Carbon\Carbon::parse($new['time'])->format('g:i A') }}
                @elseif($booking->appointment_time)
                  {{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}
                @else
                  N/A
                @endif
              </strong>
            </td>
          </tr>
        </table>
      </div>

      <!-- Notice Box -->
      <div class="notice-box">
        <h3>⚠️ Important Notice</h3>
        <p>
          <strong>If you did not request this change, please contact us immediately.</strong> 
          We take the security of your bookings seriously and want to ensure your booking is protected.
        </p>
      </div>

      <!-- Calendar Section -->
      @php
        $tz = config('app.timezone') ?: 'UTC';
        $gcal = null;
        if (!empty($new['date']) && !empty($new['time'])) {
            try {
                $start = \Carbon\Carbon::parse($new['date'] . ' ' . $new['time'], $tz)->utc()->format('Ymd\THis\Z');
                $duration = (int) ($booking->service_duration_minutes ?? 90);
                $end = \Carbon\Carbon::parse($new['date'] . ' ' . $new['time'], $tz)->addMinutes($duration)->utc()->format('Ymd\THis\Z');
                $title = rawurlencode(($booking->service ?? 'Appointment') . ' (' . ($booking->confirmation_code ?? ('BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT))) . ')');
                $details = rawurlencode('Customer: ' . ($booking->name ?? '') . '\nPhone: ' . ($booking->phone ?? ''));
                $gcal = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . $title . '&dates=' . $start . '/' . $end . '&details=' . $details;
            } catch (\Exception $e) { $gcal = null; }
        }
      @endphp

      @if($gcal)
      <div class="calendar-section">
        <h3>📅 Update Your Calendar</h3>
        <p>Add the updated appointment to your calendar to receive reminders for the new date and time.</p>
        <a href="{{ $gcal }}" class="btn btn-secondary">Add to Google Calendar</a>
      </div>
      @endif

      <!-- Action Buttons -->
      <div style="text-align: center; margin: 32px 0;">
        <a href="{{ url('/bookings/confirm/' . ($booking->id ?? '') . '/' . ($booking->confirmation_code ?? '')) }}" class="btn">View Booking Details</a>
      </div>

      <!-- Important Notes -->
      <div style="background: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 16px; border-radius: 6px; margin: 24px 0;">
        <p style="margin: 0; color: #0c4a6e; font-size: 14px; line-height: 1.6;">
          <strong>Reminder:</strong> Please arrive on time for your appointment.
        </p>
      </div>

      <!-- Signature -->
      <div class="signature">
        <p style="margin: 0; color: #4a5568;">Best regards,<br>
        <strong style="color: #0b3a66;"> Dabs Beauty Touch </strong></p>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <h4>Stay Connected</h4>
      <p>Follow us for updates, styling inspiration, and special offers:</p>
      {!! \App\Helpers\SocialLinks::render() !!}
      <!-- <p style="margin-top: 20px; font-size: 12px; color: #a0aec0;">
        This is an automated notification email. Please do not reply directly to this message.<br>
        If you have any questions, please contact us through our website or phone.
      </p> -->
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>





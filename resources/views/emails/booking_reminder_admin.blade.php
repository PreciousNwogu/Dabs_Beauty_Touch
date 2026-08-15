@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Appointment Reminder - Dabs Beauty Touch</title>
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
      border-radius: 8px;
      overflow: hidden;
    }
    .header {
      background: linear-gradient(135deg, #030f68 0%, #05137c 100%);
      padding: 24px;
      text-align: center;
    }
    .header h1 {
      color: #ffffff;
      font-size: 24px;
      font-weight: 800;
      margin: 0;
    }
    .header-badge {
      display: inline-block;
      background: #ff6600;
      color: #ffffff;
      padding: 6px 14px;
      border-radius: 16px;
      font-size: 13px;
      font-weight: 700;
      margin-top: 10px;
    }
    .content { padding: 24px; }
    .message {
      font-size: 15px;
      color: #4a5568;
      margin: 0 0 20px 0;
    }
    .info-card {
      background: #f8fafc;
      border-radius: 6px;
      padding: 16px;
      margin: 16px 0;
    }
    .info-table { width: 100%; border-collapse: collapse; }
    .info-table tr { border-bottom: 1px solid #e2e8f0; }
    .info-table tr:last-child { border-bottom: none; }
    .info-table td { padding: 10px 0; font-size: 14px; }
    .info-table td:first-child { color: #718096; font-weight: 600; width: 40%; }
    .info-table td:last-child { color: #1a202c; font-weight: 500; }
    .btn {
      display: inline-block;
      padding: 12px 24px;
      background: #030f68;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 16px;
      text-align: center;
      color: #718096;
      font-size: 12px;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Appointment Reminder</h1>
      <div class="header-badge">{{ $isSoon ? 'Starts in 1 hour' : 'In 24 hours' }}</div>
    </div>

    <div class="content">
      <p class="message">
        @if($isSoon)
          This appointment starts in about 1 hour.
        @else
          This appointment is in 24 hours.
        @endif
      </p>

      <div class="info-card">
        <table class="info-table">
          <tr>
            <td>Booking ID</td>
            <td><strong>{{ $formattedId }}</strong></td>
          </tr>
          <tr>
            <td>Client</td>
            <td><strong>{{ $booking->name ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>Phone</td>
            <td><strong>{{ $booking->phone ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><strong>{{ $booking->email ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>Service</td>
            <td><strong>{{ $booking->service ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>When</td>
            <td><strong>{{ $whenLabel }}</strong></td>
          </tr>
          <tr>
            <td>Where</td>
            <td><strong>{{ $locationLabel }}</strong></td>
          </tr>
        </table>
      </div>

      <p style="text-align:center; margin: 24px 0 8px;">
        <a href="{{ $adminUrl }}" class="btn">Open in admin</a>
      </p>
    </div>

    <div class="footer">
      Dabs Beauty Touch — admin reminder
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>

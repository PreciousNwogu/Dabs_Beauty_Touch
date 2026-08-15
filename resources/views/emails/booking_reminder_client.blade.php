@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Appointment Reminder - Dabs Beauty Touch</title>
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
      font-size: 26px;
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
    .greeting {
      font-size: 16px;
      color: #1a202c;
      font-weight: 600;
      margin: 0 0 12px 0;
    }
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
    .tip {
      background: #fff7ed;
      border-left: 4px solid #ff6600;
      border-radius: 6px;
      padding: 12px;
      margin: 16px 0;
      font-size: 14px;
      color: #9a3412;
    }
    .btn {
      display: inline-block;
      padding: 12px 24px;
      background: #ff6600;
      color: #ffffff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 14px;
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 20px;
      text-align: center;
    }
    .footer p { color: #718096; font-size: 12px; margin: 8px 0; }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">{{ $isSoon ? 'See you soon' : 'Friendly reminder' }}</div>
    </div>

    <div class="content">
      <p class="greeting">Hi {{ $firstName }},</p>

      @if($isSoon && $isHomeService)
        <p class="message">Your home appointment is coming up in about an hour, and we are on our way to you. We cannot wait to take care of you.</p>
      @elseif($isSoon)
        <p class="message">Your appointment is coming up in about an hour, and we are so looking forward to seeing you. We have your time set aside and cannot wait to take care of you.</p>
      @elseif($isHomeService)
        <p class="message">Just a little reminder that we are coming to you tomorrow. We cannot wait to help you look and feel your best.</p>
      @else
        <p class="message">Just a little reminder that your appointment with us is tomorrow. We cannot wait to see you and help you look and feel your best.</p>
      @endif

      <div class="info-card">
        <table class="info-table">
          <tr>
            <td>Service</td>
            <td><strong>{{ $booking->service ?? 'Your appointment' }}</strong></td>
          </tr>
          <tr>
            <td>Date</td>
            <td><strong>{{ $formattedDate }}</strong></td>
          </tr>
          <tr>
            <td>Time</td>
            <td><strong>{{ $formattedTime }}</strong></td>
          </tr>
          <tr>
            <td>Where</td>
            <td><strong>{{ $locationLabel }}</strong></td>
          </tr>
        </table>
      </div>

      @if($isSoon && $isHomeService)
        <div class="tip">
          <strong>A quick note:</strong> Please be ready at home so we can start as soon as we arrive. If anything changes, just call or message us.
        </div>
      @elseif($isSoon)
        <div class="tip">
          <strong>A quick note:</strong> Please arrive on time so we can use your full appointment window. If you are running a little late, just call or message us.
        </div>
      @elseif($isHomeService)
        <div class="tip">
          <strong>A little prep goes a long way:</strong> Please have your hair washed, blow-dried, and detangled before we arrive so we can start right away. If you need to reschedule, kindly give us at least 48 hours’ notice.
        </div>
      @else
        <div class="tip">
          <strong>A little prep goes a long way:</strong> Please come with your hair washed, blow-dried, and detangled so we can start right on time. If you need to reschedule, kindly give us at least 48 hours’ notice.
        </div>
      @endif

      @if(!empty($manageUrl))
        <p style="text-align:center; margin: 24px 0 8px;">
          <a href="{{ $manageUrl }}" class="btn">View your booking</a>
        </p>
      @endif

      <p class="message" style="margin-top: 20px;">If anything comes up, reach us at <a href="tel:+13432458848" style="color:#030f68; font-weight:600;">(+1) 343-245-8848</a> or WhatsApp. We cannot wait to {{ $isHomeService ? 'see you at home' : 'see you' }}{{ $isSoon ? ' very soon' : ' tomorrow' }}!</p>

      <p style="margin: 0; color: #4a5568;">With love,<br>
      <strong style="color: #0b3a66;">Dabs Beauty Touch</strong></p>
    </div>

    <div class="footer">
      <p>Stay connected</p>
      {!! \App\Helpers\SocialLinks::render() !!}
      <p style="margin-top: 16px;">Thanks for choosing Dabs Beauty Touch</p>
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>

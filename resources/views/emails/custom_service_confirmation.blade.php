@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Custom Service Request Received - Dabs Beauty Touch</title>
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
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .header {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      padding: 32px 24px;
      text-align: center;
    }
    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 900;
      margin: 0 0 12px 0;
      text-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      letter-spacing: 0.5px;
    }
    .header-badge {
      display: inline-block;
      background: rgba(255, 255, 255, 0.3);
      color: #ffffff;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      border: 1px solid rgba(255, 255, 255, 0.4);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .content {
      padding: 32px 24px;
    }
    .greeting {
      font-size: 18px;
      color: #1a202c;
      font-weight: 700;
      margin: 0 0 16px 0;
    }
    .message {
      font-size: 15px;
      color: #4a5568;
      margin: 0 0 24px 0;
      line-height: 1.7;
    }
    .info-card {
      background: #f8fafc;
      border-radius: 8px;
      padding: 20px;
      margin: 20px 0;
      border-left: 4px solid #28a745;
    }
    .info-card-title {
      font-size: 16px;
      font-weight: 700;
      color: #1a202c;
      margin: 0 0 16px 0;
      display: flex;
      align-items: center;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
    }
    .info-table tr {
      border-bottom: 1px solid #e2e8f0;
    }
    .info-table tr:last-child {
      border-bottom: none;
    }
    .info-table td {
      padding: 12px 0;
      font-size: 14px;
      vertical-align: top;
    }
    .info-table td:first-child {
      color: #718096;
      font-weight: 600;
      width: 40%;
    }
    .info-table td:last-child {
      color: #1a202c;
      font-weight: 500;
    }
    .next-steps {
      background: #f0f9ff;
      border-left: 4px solid #0ea5e9;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .next-steps-title {
      font-size: 16px;
      font-weight: 700;
      color: #0c4a6e;
      margin: 0 0 12px 0;
      display: flex;
      align-items: center;
    }
    .next-steps-list {
      margin: 0;
      padding-left: 20px;
      color: #0c4a6e;
    }
    .next-steps-list li {
      margin: 8px 0;
      line-height: 1.6;
    }
    .btn {
      display: inline-block;
      padding: 14px 28px;
      background: linear-gradient(135deg, #0066ff 0%, #0080ff 100%);
      color: #ffffff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 15px;
      text-align: center;
      margin: 20px 0;
      box-shadow: 0 4px 6px rgba(0, 102, 255, 0.3);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 102, 255, 0.4);
      background: linear-gradient(135deg, #0052cc 0%, #0066ff 100%);
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 24px;
      text-align: center;
    }
    .footer p {
      color: #718096;
      font-size: 13px;
      margin: 8px 0;
      line-height: 1.6;
    }
    .footer-logo {
      font-size: 18px;
      font-weight: 700;
      color: #030f68;
      margin-bottom: 8px;
    }
    @media only screen and (max-width: 600px) {
      .content { padding: 24px 20px; }
      .header { padding: 24px 20px; }
      .btn { display: block; margin: 16px 0; }
      .info-table td:first-child { width: 35%; }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">✓ Request Received</div>
    </div>

    <div class="content">
      <p class="greeting">Hello {{ $request['name'] ?? 'there' }},</p>
      <p class="message">
        Thank you for submitting your custom service request! We have received your details and will review them shortly. Our team will contact you within <strong>24-48 hours</strong> to discuss pricing and availability.
      </p>

      <div class="info-card">
        <div class="info-card-title">
          📋 Request Summary
        </div>
        <table class="info-table">
          <tr>
            <td>Service:</td>
            <td><strong>{{ $request['service'] ?? 'Custom Service' }}</strong></td>
          </tr>
          @if(!empty($request['service_category']))
          <tr>
            <td>Category:</td>
            <td>{{ ucwords(str_replace(['_', '-'], ' ', $request['service_category'])) }}</td>
          </tr>
          @endif
          @if(!empty($request['braid_size']))
          <tr>
            <td>Braid/Twist Size:</td>
            <td>{{ ucwords(str_replace(['_', '-'], ' ', $request['braid_size'])) }}</td>
          </tr>
          @endif
          @if(!empty($request['hair_length']))
          <tr>
            <td>Hair Length:</td>
            <td>{{ ucwords(str_replace(['_', '-'], ' ', $request['hair_length'])) }}</td>
          </tr>
          @endif
          @if(!empty($request['budget_range']))
          <tr>
            <td>Budget Range:</td>
            <td>{{ ucwords(str_replace(['_', '-'], [' ', ' - '], $request['budget_range'])) }}</td>
          </tr>
          @endif
          @if(!empty($request['urgency']))
          <tr>
            <td>Timeline:</td>
            <td>{{ ucwords(str_replace(['_', '-'], ' ', $request['urgency'])) }}</td>
          </tr>
          @endif
          @if(!empty($request['style_preferences']))
          @php
            $preferences = is_string($request['style_preferences']) ? json_decode($request['style_preferences'], true) : ($request['style_preferences_array'] ?? []);
            $preferencesDisplay = [];
            if (is_array($preferences) && !empty($preferences)) {
              $preferencesDisplay = array_map(function($p) {
                return ucwords(str_replace(['_', '-'], ' ', $p));
              }, $preferences);
            }
          @endphp
          @if(!empty($preferencesDisplay))
          <tr>
            <td>Style Preferences:</td>
            <td>{{ implode(', ', $preferencesDisplay) }}</td>
          </tr>
          @endif
          @endif
          @if(!empty($request['appointment_date']))
          <tr>
            <td>Preferred Date:</td>
            <td>{{ \Carbon\Carbon::parse($request['appointment_date'])->format('F j, Y') }}</td>
          </tr>
          @else
          <tr>
            <td>Preferred Date:</td>
            <td>Not specified</td>
          </tr>
          @endif
          @if(!empty($request['appointment_time']))
          <tr>
            <td>Preferred Time:</td>
            <td>{{ \Carbon\Carbon::parse($request['appointment_time'])->format('g:i A') }}</td>
          </tr>
          @else
          <tr>
            <td>Preferred Time:</td>
            <td>Not specified</td>
          </tr>
          @endif
          @if(!empty($request['special_requirements']))
          <tr>
            <td>Special Requirements:</td>
            <td>{{ $request['special_requirements'] }}</td>
          </tr>
          @endif
          @if(!empty($request['message']))
          <tr>
            <td>Your Message:</td>
            <td>{{ $request['message'] }}</td>
          </tr>
          @endif
        </table>
      </div>

      <div class="next-steps">
        <div class="next-steps-title">
          ℹ️ What happens next?
        </div>
        <ul class="next-steps-list">
          <li>Our team will review your custom service request</li>
          <li>We'll prepare a detailed pricing quote based on your requirements</li>
          <li>We'll contact you via phone or email within 24-48 hours</li>
          <li>We'll work with you to schedule your appointment at a convenient time</li>
        </ul>
      </div>

      <p class="message" style="margin-top: 24px;">
        If you have any questions or need to update your request, please reply to this email or contact us directly.
      </p>

      <div style="text-align: center;">
        <a href="{{ url('/#contact') }}" class="btn">Contact Us</a>
      </div>
    </div>

    <div class="footer">
      <div class="footer-logo">Dabs Beauty Touch</div>
      <p>Thank you for choosing us for your beauty needs!</p>
      <p style="font-size: 12px; color: #a0aec0;">
        This is an automated confirmation email. Please do not reply directly to this message.
      </p>
    </div>
  </div>
</body>
</html>
@php 
$html = ob_get_clean();
echo $html;
@endphp


@php ob_start(); @endphp
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Service Completed - Dabs Beauty Touch</title>
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
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      padding: 32px 24px;
      text-align: center;
    }
    .header h1 {
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      margin: 0;
      letter-spacing: -0.5px;
    }
    .header-icon {
      font-size: 48px;
      margin-bottom: 12px;
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
      font-size: 20px;
      color: #1a202c;
      font-weight: 700;
      margin: 0 0 16px 0;
      text-align: center;
    }
    .message {
      font-size: 16px;
      color: #4a5568;
      margin: 0 0 24px 0;
      text-align: center;
      line-height: 1.7;
    }
    .success-box {
      background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
      border: 2px solid #10b981;
      border-radius: 12px;
      padding: 24px;
      margin: 24px 0;
      text-align: center;
    }
    .success-box h2 {
      color: #065f46;
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 8px 0;
    }
    .success-box p {
      color: #047857;
      font-size: 16px;
      margin: 0;
    }
    .info-card {
      background: #f8fafc;
      border-radius: 8px;
      padding: 20px;
      margin: 24px 0;
    }
    .info-card h3 {
      color: #0b3a66;
      font-size: 14px;
      font-weight: 700;
      margin: 0 0 16px 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
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
      font-size: 15px;
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
    .price-summary {
      background: #ffffff;
      border: 2px solid #ff6600;
      border-radius: 12px;
      padding: 24px;
      margin: 24px 0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .price-summary h4 {
      color: #0b3a66;
      font-size: 18px;
      font-weight: 800;
      margin: 0 0 20px 0;
      padding-bottom: 12px;
      border-bottom: 2px solid #ff6600;
    }
    .price-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 0;
      border-bottom: 1px solid #e3e3e0;
    }
    .price-row:last-of-type {
      border-bottom: none;
    }
    .price-row-label {
      color: #666;
      font-size: 15px;
      font-weight: 500;
    }
    .price-row-value {
      color: #0b3a66;
      font-size: 16px;
      font-weight: 600;
    }
    .price-total {
      background: #fff7e0;
      border-radius: 8px;
      padding: 18px;
      margin-top: 16px;
      border-top: 2px solid #ff6600;
    }
    .price-total-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .price-total-label {
      color: #0b3a66;
      font-size: 18px;
      font-weight: 700;
    }
    .price-total-value {
      color: #ff6600;
      font-size: 28px;
      font-weight: 800;
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
      margin: 8px;
      transition: background 0.2s;
    }
    .btn:hover {
      background: #e55a00;
    }
    .footer {
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
      padding: 24px;
      text-align: center;
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
    <div class="header">
      <div class="header-icon">✨</div>
      <h1>Dabs Beauty Touch</h1>
      <div class="header-badge">Service Completed</div>
    </div>

    <div class="content">
      <p class="greeting">Hello {{ $booking->name ?? 'Valued Customer' }}!</p>
      
      <div class="success-box">
        <h2>Service Completed Successfully!</h2>
        <p>We hope you love your new look! ✨</p>
      </div>

      <div class="info-card">
        <h3>Service Details</h3>
        <table class="info-table">
          <tr>
            <td>Service</td>
            <td><strong>{{ $booking->service ?? 'N/A' }}</strong></td>
          </tr>
          <tr>
            <td>Completed On</td>
            <td><strong>{{ $completedAt ?? 'N/A' }}</strong></td>
          </tr>
          @if(isset($duration) && $duration)
          <tr>
            <td>Duration</td>
            <td><strong>{{ $duration }}</strong></td>
          </tr>
          @endif
        </table>
      </div>

      @php
        $bd = $breakdown ?? [];
        $displayBase = $bd['resolved_base'] ?? $booking->base_price ?? 0;
        $displayAdjustments = $bd['adjustments_total'] ?? $bd['selector_adjust'] ?? $bd['length_adjust'] ?? $booking->length_adjustment ?? $booking->kb_length_adjustment ?? 0;
        $displayAddons = $bd['addons_total'] ?? $bd['selector_addons'] ?? 0;
        $displayTotal = $finalPrice ?? ($bd['final_price'] ?? $bd['computed_total'] ?? ($displayBase + $displayAdjustments + $displayAddons));
      @endphp
      <div class="price-summary">
        <h4>Price Summary</h4>
        <div class="price-row">
          <span class="price-row-label">Base Price:</span>
          <span class="price-row-value">${{ number_format($displayBase, 2) }}</span>
        </div>
        @if($displayAdjustments != 0)
        <div class="price-row">
          <span class="price-row-label">Adjustments:</span>
          <span class="price-row-value">{{ $displayAdjustments >= 0 ? '+' : '' }}${{ number_format(abs($displayAdjustments), 2) }}</span>
        </div>
        @endif
        @if($displayAddons > 0)
        <div class="price-row">
          <span class="price-row-label">Add-ons:</span>
          <span class="price-row-value">+${{ number_format($displayAddons, 2) }}</span>
        </div>
        @endif
        <div class="price-total">
          <div class="price-total-row">
            <span class="price-total-label">Total:</span>
            <span class="price-total-value">${{ number_format($displayTotal, 2) }}</span>
          </div>
        </div>
      </div>

      <div style="text-align: center; margin: 32px 0;">
        <a href="{{ route('home') }}" class="btn">Book Another Appointment</a>
      </div>

      <div style="background: #f0f9ff; border-left: 4px solid #0ea5e9; border-radius: 6px; padding: 16px; margin: 24px 0;">
        <p style="margin: 0; color: #0c4a6e; font-size: 14px; text-align: center;">
          <strong>Thank you for choosing Dabs Beauty Touch!</strong><br>
          We appreciate your patronage and look forward to serving you again.
        </p>
      </div>
    </div>

    <div class="footer">
      <h4>Stay Connected</h4>
      <p>Follow us for styling tips and latest trends:</p>
      {!! \App\Helpers\SocialLinks::render() !!}
      <p style="margin-top: 16px;">Best regards,<br><strong>The Dabs Beauty Touch Team</strong></p>
    </div>
  </div>
@php
  $html = ob_get_clean();
  echo preg_replace('/\s+/', ' ', trim($html));
@endphp
</body>
</html>


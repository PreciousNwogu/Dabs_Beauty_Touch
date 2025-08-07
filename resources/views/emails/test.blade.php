<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $mailData['subject'] ?? 'Test Email' }}</title>
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
        .greeting {
            font-size: 18px;
            font-weight: bold;
            color: #ff6600;
            margin-bottom: 20px;
        }
        .line {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .action-button {
            display: inline-block;
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .outro {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name', 'Dabs Beauty Touch') }}</h1>
            <p>Professional Hair Braiding Services</p>
        </div>
        
        <div class="content">
            @if(!empty($mailData['greeting']))
                <div class="greeting">{{ $mailData['greeting'] }}</div>
            @endif

            @if(!empty($mailData['lines']) && is_array($mailData['lines']))
                @foreach($mailData['lines'] as $line)
                    <div class="line">{{ $line }}</div>
                @endforeach
            @else
                <div class="line">This is a test email from your Laravel application.</div>
            @endif

            @if(!empty($mailData['action']) && is_array($mailData['action']) && !empty($mailData['action']['url']))
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $mailData['action']['url'] }}" class="action-button">
                        {{ $mailData['action']['text'] ?? 'Click Here' }}
                    </a>
                </div>
            @endif

            @if(!empty($mailData['outro']))
                <div class="outro">{{ $mailData['outro'] }}</div>
            @endif
        </div>

        <div class="footer">
            <p><strong>{{ config('app.name', 'Dabs Beauty Touch') }}</strong></p>
            <p>📞 Phone: (123) 456-7890 | 📧 Email: info@dabsbeautytouch.com</p>
            <p>This is a test email sent via Mailtrap for development purposes.</p>
            <p><em>Current time: {{ now()->format('F j, Y g:i A') }}</em></p>
        </div>
    </div>
</body>
</html>

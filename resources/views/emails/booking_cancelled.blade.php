<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Booking Cancelled</title>
	</head>
	<body>
		<div style="max-width:640px;margin:18px auto;font-family:Arial,Helvetica,sans-serif;color:#222;background:#fff;padding:20px;border-radius:10px;">
			<h2 style="color:#0b3a66;margin-top:0;">Booking Cancelled</h2>
			<p style="color:#333;">We regret to inform you that your booking has been cancelled. Please find the details below.</p>

			@php $formattedId = 'BK' . str_pad($booking->id ?? 0, 6, '0', STR_PAD_LEFT); @endphp
			<table width="100%" cellpadding="6" style="border-collapse:collapse;margin-top:12px;font-size:14px;">
				<tr style="background:#f8fafc;"><td style="width:40%;font-weight:700;">Booking ID</td><td>{{ $formattedId }}</td></tr>
				<tr><td style="font-weight:700;">Service</td><td>{{ $booking->service ?? 'N/A' }}</td></tr>
				<tr style="background:#f8fafc;"><td style="font-weight:700;">Cancelled By</td><td>{{ $cancelledBy ?? ($booking->cancelled_by ?? 'Admin') }}</td></tr>
			</table>

			<p style="margin-top:16px;color:#333;">If you have any questions or would like to reschedule, please reply to this email or contact us directly.</p>

			<!-- Social links -->
			<div style="margin-top:18px;border-top:1px solid #eef2f6;padding-top:12px;font-size:13px;color:#6c757d;">
				<p style="margin:6px 0 8px 0;font-weight:700;color:#0b3a66;">Stay connected</p>
				<p style="margin:0;">Follow us for updates and styling inspiration:</p>
				<p style="margin:8px 0 0 0;">
					<a href="https://www.instagram.com/dabs_beauty_touch?igsh=MXYycGNraGxwem5tZw%3D%3D&utm_source=qr" style="margin-right:12px;color:#0b3a66;text-decoration:none;">Instagram</a>
					<a href="https://wa.me/13432548848" style="color:#0b3a66;text-decoration:none;">WhatsApp</a>
				</p>
			</div>
		</div>
	</body>
</html>

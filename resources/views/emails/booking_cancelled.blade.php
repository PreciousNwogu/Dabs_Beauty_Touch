<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Booking Cancelled</title>
	</head>
	<body>
		<p>Your booking has been cancelled.</p>
		<p>Booking ID: {{ $booking->id ?? 'N/A' }}</p>
		<p>Service: {{ $booking->service ?? 'N/A' }}</p>
		<p>Cancelled By: {{ $cancelledBy ?? ($booking->cancelled_by ?? 'Admin') }}</p>
	</body>
</html>

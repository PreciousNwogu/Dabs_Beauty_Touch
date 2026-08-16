<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File too large – Dab's Beauty Touch</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f6f8fb; color: #1a202c; margin: 0; padding: 32px 16px; }
        .card { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 16px; padding: 28px; box-shadow: 0 8px 24px rgba(3,15,104,.08); }
        h1 { color: #030f68; font-size: 1.4rem; margin: 0 0 12px; }
        p { color: #555; line-height: 1.6; }
        a { display: inline-block; margin-top: 8px; background: #030f68; color: #fff; text-decoration: none; font-weight: 700; padding: 10px 18px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>That file is too large to save</h1>
        <p>{{ $message ?? 'Use a photo or a short clip under 100 MB, then try again.' }}</p>
        <p>Phone videos are often too big. Trim the clip or export it at a smaller size, then upload it again from Settings.</p>
        <a href="{{ url('/admin/settings') }}">Back to Settings</a>
    </div>
</body>
</html>

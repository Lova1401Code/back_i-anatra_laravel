<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badge</title>
</head>
<body>
    <h1>{{ $badge->titre }}</h1>
    <p>{{ $badge->description }}</p>
    <img src="{{ asset($badge->qr_code) }}" alt="QR Code">
</body>
</html>

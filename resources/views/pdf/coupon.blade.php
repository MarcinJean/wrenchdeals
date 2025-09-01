<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Coupon {{ $coupon->code }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { text-align: center; padding: 2em; }
        .code { font-size: 2em; letter-spacing: 0.2em; }
        .barcode { margin-top: 1em; }
    </style>
</head>
<body>
<div class="container">
    <h1>Your Coupon</h1>
    <div class="code">{{ chunk_split($coupon->code, 4, '-') }}</div>
    <div class="barcode">
        {!! QrCode::size(200)->generate($coupon->code) !!}
    </div>
    <p>Expires: {{ $coupon->campaign->expires_at->format('F j, Y') }}</p>
</div>
</body>
</html>

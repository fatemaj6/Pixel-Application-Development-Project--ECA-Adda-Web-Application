<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>OTP Code</title>
</head>
<body style="font-family:arial; background:#fff; color:#1f2937; padding:20px;">
    <div style="max-width:600px;margin:0 auto;">
        <h2 style="color:#f97316;">ECA Adda — {{ $purpose }} OTP</h2>
        <p>Hi {{ $name ?? 'there' }},</p>
        <p>Your OTP code is:</p>
        <div style="font-size:28px; font-weight:700; color:#111827; margin:16px 0; background:#fff; padding:12px; border-radius:6px; display:inline-block;">
            {{ $otp }}
        </div>
        <p>This code expires in 10 minutes.</p>
        <p>If you did not request this, please ignore this email.</p>
        <p>Thanks,<br/>ECA Adda Team</p>
    </div>
</body>
</html>

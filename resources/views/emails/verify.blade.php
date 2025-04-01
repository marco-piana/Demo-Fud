<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <h1>Verify Your Email Address</h1>
    <p>Hello,</p>
    <p>Please click the link below to verify your email address:</p>
    <p>
        <a href="{{ $verificationUrl }}" style="color: #1a73e8; text-decoration: none;">
            Verify Email Address
        </a>
    </p>
    <p>If you did not create an account, no further action is required.</p>
    <p>Thank you!</p>
</body>
</html>

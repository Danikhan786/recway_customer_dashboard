<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #AC0206;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .otp-code {
            font-size: 24px;
            color: #007bff;
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            color: #AC0206;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ url('https://orderspi.se/customer/assets/images/logo.png') }}" alt="Company Logo">
        </div>

        <div class="content">
            <h2>Login Code Verification</h2>
            <p>Dear <strong>{{ $name }}</strong>,</p> <!-- User ka naam yahan display hoga -->
            <p>Here is your One-Time Password (OTP) to complete the login process:</p>
            
            <div class="otp-code" style="background:#AC0206;color:#fff;padding:20px;border-radius:10px">{{ $otp }}</div>

            <p>This OTP will expire in 10 minutes. If you did not request this, please ignore this email.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} <a href="https://recway.se/">Recway AB</a>. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

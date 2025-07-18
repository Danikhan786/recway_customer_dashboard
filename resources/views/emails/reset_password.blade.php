<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        /* Reset styles */
        body, table, td, a {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #AC0206;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            color: #ffffff;
        }
        img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #AC0206;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <div style="text-align:center">
                <img src="{{ url('https://orderspi.se/customer/assets/images/logo.png') }}" alt="Recway Logo">
            </div>
            <p>Hi, <strong>{{ $name }}</strong>,</p>
            <p>We received a request to reset your password. Click the button below to reset it:</p>
            <p style="text-align: center;">
                <a href="{{ $url }}" class="button" style="color:#fff">Reset Password</a>
            </p>
            <p style="text-align: center; color: #555; margin-top: 10px;">
                <em>This link is valid for 15 minutes only.</em>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} <a href="https://recway.se/">Recway AB</a>. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

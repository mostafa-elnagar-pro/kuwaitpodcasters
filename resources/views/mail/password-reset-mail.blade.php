<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            margin: 50px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
        }

        .otp {
            background-color: #f0f0f0;
            padding: 15px;
            font-size: 24px;
            text-align: center;
            letter-spacing: 5px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .content {
            text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        .footer {
            text-align: left;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>Your OTP Code</h2>
        </div>

        <div class="content">
            <p>You are receiving this email because we received a request for an OTP (One-Time Password) for your
                account.</p>

            <div class="otp">
                {{ $otp }}
            </div>

            <p>This OTP is valid for a limited time. Please do not share this code with anyone.</p>

            <p>If you did not request an OTP, no further action is required.</p>
        </div>

        <div class="footer">
            <p>Thanks,<br>{{ config('app.name', 'Podcasters') }}</p>
        </div>
    </div>

</body>

</html>

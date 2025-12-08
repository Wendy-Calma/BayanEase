<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-body {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #FA812F;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
            margin: -30px -30px 20px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #FA812F;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #ff6b35;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .link-text {
            word-break: break-all;
            font-size: 12px;
            color: #666;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-body">
            <div class="header">
                <h1>Welcome to Smart Barangay!</h1>
            </div>

            <div class="content">
                <p>Hi {{ $user->first_name }},</p>

                <p>Thank you for registering with Smart Barangay. To complete your registration and start using our services, please verify your email address by clicking the button below:</p>

                <center>
                    <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
                </center>

                <p>Or, copy and paste this link into your browser:</p>
                <div class="link-text">
                    {{ $verificationUrl }}
                </div>

                <p>This verification link will expire in 24 hours.</p>

                <p>If you did not create this account, please ignore this email or contact our support team.</p>

                <p>Best regards,<br>
                The Smart Barangay Team</p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Smart Barangay. All rights reserved.</p>
                <p>If you have any questions, please contact us at support@smartbarangay.com</p>
            </div>
        </div>
    </div>
</body>
</html>

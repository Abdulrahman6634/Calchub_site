<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - CalcHub</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .header {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px;
        }
        .verification-code {
            background: #f8fafc;
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 42px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #22c55e;
            margin: 10px 0;
        }
        .warning {
            background: #fef3cd;
            border: 1px solid #fde68a;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            color: #92400e;
        }
        .footer {
            background: #f8fafc;
            padding: 20px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: #22c55e;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CalcHub</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Password Reset Verification</p>
        </div>
        
        <div class="content">
            @if($userName)
            <h2 style="color: #1f2937; margin-bottom: 10px;">Hello, {{ $userName }}!</h2>
            @else
            <h2 style="color: #1f2937; margin-bottom: 10px;">Hello!</h2>
            @endif
            
            <p style="color: #6b7280; margin-bottom: 20px;">
                You requested to reset your password for your CalcHub account. 
                Use the verification code below to complete the process:
            </p>
            
            <div class="verification-code">
                <p style="margin: 0 0 10px 0; color: #64748b; font-size: 14px;">Your verification code:</p>
                <div class="code">{{ $verificationCode }}</div>
                <p style="margin: 10px 0 0 0; color: #64748b; font-size: 14px;">
                    This code will expire in {{ $expiryMinutes }} minutes
                </p>
            </div>
            
            <div class="warning">
                <strong>⚠️ Security Notice:</strong><br>
                If you didn't request this password reset, please ignore this email. 
                Your account security is important to us.
            </div>
            
            <p style="color: #6b7280; margin: 25px 0 15px 0;">
                Enter this code in the password reset page to verify your identity and create a new password.
            </p>
            
            <p style="color: #6b7280; margin: 20px 0 0 0; font-size: 14px;">
                Need help? Contact our support team at 
                <a href="mailto:support@calchub.com" style="color: #22c55e;">support@calchub.com</a>
            </p>
        </div>
        
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                &copy; {{ date('Y') }} CalcHub. All rights reserved.
            </p>
            <p style="margin: 0; font-size: 12px; opacity: 0.7;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>
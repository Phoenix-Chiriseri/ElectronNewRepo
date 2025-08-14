<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Test Email</h1>
    </div>
    
    <div class="content">
        <h2>Hello!</h2>
        <p>This is a test email to verify that the email system is working correctly.</p>
        <p>If you received this email, it means:</p>
        <ul>
            <li>✅ Mail configuration is working</li>
            <li>✅ Email templates are loading correctly</li>
            <li>✅ The TestMail class is functioning properly</li>
        </ul>
        <p>Thank you for testing the email system!</p>
    </div>
    
    <div class="footer">
        <p>This is an automated test email from your Laravel application.</p>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
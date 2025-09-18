<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
        }
        p {
            margin: 6px 0;
        }
        ul {
            padding-left: 20px;
            margin: 15px 0;
        }
        ul li {
            margin-bottom: 6px;
        }
        .login-details {
            background: #f4f7fc;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        strong {
            color: #000;
        }
        .footer {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white !important;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .btn:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Hello {{ $user->name }},</p>

        <p>Thank you for choosing <strong>Webexcels!</strong> We’re excited to start working on your projects.</p>

        <p>
            To help you stay updated and make communication smoother, we’ve created your 
            <strong>Customer Support Dashboard</strong> where you can:
        </p>
        <ul>
            <li>Track the real-time status of your projects</li>
            <li>Upload and share any missing documents</li>
            <li>Communicate with our support team directly</li>
            <li>Access updates from both desktop and mobile app</li>
            <li>Generate support tickets and follow up</li>
        </ul>

        <div class="login-details">
            <p><strong>Here are your login details:</strong></p>
            <p><strong>Dashboard Link:</strong> 
                <a href="https://xlserp.com/customersupport/" target="_blank">https://xlserp.com/customersupport/</a>
            </p>
            <p><strong>Username:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $plainPassword }}</p>
        </div>

        <p>
            For your security, we recommend logging in and changing your password on your first visit.
        </p>

        <p>
            If you face any issues accessing your dashboard, feel free to reach out to our support team at 
            <a href="mailto:support@webexcels.com">support@webexcels.com</a>.
        </p>

        <p>We’re looking forward to building something amazing together!</p>

        <p class="footer">
            Best regards,<br>
            <strong>The Webexcels Team</strong>
        </p>
    </div>
</body>
</html>

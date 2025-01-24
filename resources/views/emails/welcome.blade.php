<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Bank</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light grey background */
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #007bff; /* Bank blue for borders */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #007bff; /* Bank blue for header */
        }
        .email-body {
            font-size: 16px;
            line-height: 1.6;
            margin-top: 20px;
        }
        .email-body p {
            margin-bottom: 15px;
        }
        .email-footer {
            margin-top: 30px;
            font-size: 14px;
            color: #007bff; /* Bank blue for footer */
            text-align: center;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .highlight {
            color: #007bff; /* Bank blue for highlights */
            font-weight: bold;
        }
        .bank-logo {
            display: block;
            margin: 0 auto;
            width: 120px;
            height: auto;
        }
        .cta-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Get Loan With Us For 60% And Loose Everything</h1>
        <div class="email-header">
            Welcome, {{ $user->name }}!
        </div>
        <div class="email-body">
            <p>
                Thank you for choosing <span class="highlight">DudasBank</span>. We’re thrilled to have you on board!
            </p>
            <p>
                Your account has been successfully created, and you can now enjoy secure and seamless banking services.
            </p>
            <p>
                Start managing your finances by logging into your account:
            </p>
            <a href="https://example.com/login" class="cta-button">Login to Your Account</a>
            <p>
                If you have any questions or need assistance, our support team is here to help.
            </p>
            <p class="highlight">
                We look forward to serving you!
            </p>
        </div>
        <div class="email-footer">
            <p>Best Regards,</p>
            <p>Your Trusted Bank Team</p>
        </div>
    </div>
</body>
</html>

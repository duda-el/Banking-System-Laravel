<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Fantasy Football</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; /* White background for Georgian theme */
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #d10000; /* Georgian red for borders */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #d10000; /* Georgian red for header */
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
            color: #d10000; /* Georgian red for footer */
            text-align: center;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .highlight {
            color: #d10000; /* Georgian red for highlights */
            font-weight: bold;
        }
        .team-logo {
            display: block;
            margin: 0 auto;
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <img src="https://upload.wikimedia.org/wikipedia/en/9/9c/Georgia_national_football_team_crest.svg" alt="Georgia National Team Crest" class="team-logo">
        <div class="email-header">
            Welcome, {{ $user->name }}!
        </div>
        <div class="email-body">
            <p>
                Thank you for registering at <span class="highlight">Fantasy Football</span>. We're excited to have you onboard!
            </p>
            <p>
                Start building your fantasy team and compete with others to win exciting prizes!
            </p>
            <p>
                If you have any questions, feel free to contact us.
            </p>
            <p class="highlight">
                Good luck!
            </p>
        </div>
        <div class="email-footer">
            <p>Regards,</p>
            <p>Fantasy Football Team</p>
        </div>
    </div>
</body>
</html>

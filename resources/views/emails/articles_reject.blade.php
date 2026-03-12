<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Review Update</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8f9fa;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header p {
            margin: 8px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .article-info {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }

        .article-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 8px 0;
        }

        .article-meta {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
        }

        .message-body {
            font-size: 16px;
            line-height: 1.7;
            margin: 25px 0;
        }

        .message-body p {
            margin: 0 0 18px 0;
        }

        .status-badge {
            display: inline-block;
            background-color: #ffeaa7;
            color: #d63031;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin: 20px 0;
        }

        .next-steps {
            background-color: #e8f4f8;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .next-steps h3 {
            margin: 0 0 15px 0;
            color: #0c5460;
            font-size: 16px;
            font-weight: 600;
        }

        .next-steps ul {
            margin: 0;
            padding-left: 20px;
            color: #0c5460;
        }

        .next-steps li {
            margin-bottom: 8px;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }

        .cta-button:hover {
            transform: translateY(-1px);
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .signature {
            margin: 25px 0 0 0;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .signature p {
            margin: 0 0 5px 0;
            font-weight: 500;
            color: #2c3e50;
        }

        .signature small {
            color: #6c757d;
            font-size: 14px;
        }

        .footer-links {
            margin-top: 20px;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 20px;
                border-radius: 8px;
            }

            .header,
            .content,
            .footer {
                padding: 25px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .article-info {
                margin: 20px -5px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>ASKLY!</h1>
            <p>Your submission requires revision</p>
        </div>

        <div class="content">
            <div class="greeting">
                Hello {{ $article->user->firstName }},
            </div>

            <div class="article-info">
                <div class="article-title">"{{ $article->title }}"</div>
                <div class="article-meta">Submitted for review</div>
            </div>

            <div class="status-badge">
                Revision Required
            </div>

            <div class="message-body">
                <p>Thank you for your submission to our platform. Our editorial team has completed the initial review of your article.</p>

                <p>While we appreciate the effort you've put into your work, we've identified some areas that need attention before we can move forward with publication. This is a normal part of our editorial process, and we encourage you to view this as an opportunity to strengthen your article.</p>

                <p>We believe your article has potential and would like to see it improved and resubmitted for another review.</p>
            </div>

            <div class="next-steps">
                <h3>Next Steps:</h3>
                <ul>
                    <li>Review your article carefully against our submission guidelines</li>
                    <li>Make the necessary revisions to address any issues</li>
                    <li>Resubmit your updated article through our submission portal</li>
                    <li>Our team will prioritize reviewing your revised submission</li>
                </ul>
            </div>

            <a href="#" class="cta-button">Access Submission Portal</a>

            <div class="signature">
                <p>Best regards,</p>
                <small>The Editorial Team</small>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0 0 10px 0; color: #6c757d; font-size: 14px;">
                Need help? We're here to support you through the revision process.
            </p>
            <div class="footer-links">
                <a href="#">Submission Guidelines</a>
                <a href="#">Contact Support</a>
                <a href="#">Writing Resources</a>
            </div>
        </div>
    </div>
</body>

</html>
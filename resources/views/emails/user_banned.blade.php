<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended - Askly</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: slideInUp 0.6s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .header {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            animation: float 20s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }
        
        .warning-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }
        
        .warning-icon::before {
            content: '⚠';
            font-size: 28px;
            color: white;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 25px;
        }
        
        .message {
            font-size: 16px;
            color: #5a6c7d;
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .violation-notice {
            background: linear-gradient(135deg, #fff5f5, #fed7d7);
            border-left: 4px solid #e53e3e;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        
        .violation-notice h3 {
            color: #c53030;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .violation-notice p {
            color: #744210;
            font-size: 14px;
            margin: 0;
        }
        
        .support-section {
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            border: 1px solid #e2e8f0;
        }
        
        .support-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .support-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .signature {
            font-size: 16px;
            color: #495057;
            margin-bottom: 15px;
        }
        
        .company-name {
            font-weight: 700;
            color: #667eea;
        }
        
        .footer-links {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        
        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #667eea;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .footer {
                padding: 20px;
            }
            
            .logo {
                font-size: 24px;
            }
            
            .greeting {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="warning-icon"></div>
            <div class="logo">Askly</div>
            <div style="font-size: 18px; opacity: 0.9; position: relative; z-index: 2;">Account Suspended</div>
        </div>
        
        <div class="content">
            <div class="greeting">Hello {{ $user->firstName }},</div>
            
            <div class="message">
                We regret to inform you that your account has been temporarily suspended due to a violation of our community guidelines and terms of service.
            </div>
            
            <div class="violation-notice">
                <h3>Policy Violation Detected</h3>
                <p>Our systems have identified activity on your account that goes against our community standards. This action helps us maintain a safe and positive environment for all users.</p>
            </div>
            
            <div class="message">
                We understand this may be disappointing, and we want to ensure you have the opportunity to address any concerns or misunderstandings.
            </div>
            
            <div class="support-section">
                <strong>Think this was a mistake?</strong>
                <p style="margin: 10px 0; color: #5a6c7d;">If you believe your account was suspended in error, our support team is here to help. We'll review your case promptly and work with you to resolve any issues.</p>
                <a href="mailto:support@askly.com" class="support-button">Contact Support Team</a>
            </div>
            
            <div class="message">
                Thank you for your understanding as we work to maintain the quality and safety of our platform.
            </div>
        </div>
        
        <div class="footer">
            <div class="signature">
                Best regards,<br>
                <span class="company-name">The Askly Team</span>
            </div>
            
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Community Guidelines</a>
                <a href="#">Help Center</a>
            </div>
        </div>
    </div>
</body>
</html>
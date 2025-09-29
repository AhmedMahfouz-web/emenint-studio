<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>استشارة جديدة - Eminent Studio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background: linear-gradient(135deg, #003cfc 0%, #0056ff 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 15px;
        }

        .email-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .email-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .email-body {
            padding: 40px 30px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-right: 4px solid #003cfc;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background-color: #003cfc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            flex-shrink: 0;
        }

        .info-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        .message-section {
            margin-top: 30px;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-right: 4px solid #28a745;
        }

        .message-title {
            font-size: 18px;
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .message-title svg {
            width: 24px;
            height: 24px;
            fill: #28a745;
            margin-left: 10px;
        }

        .message-content {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            background-color: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .email-footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .email-footer p {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: 600;
            color: #003cfc;
        }

        .timestamp {
            font-size: 12px;
            color: #999;
            margin-top: 15px;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .email-header {
                padding: 20px;
            }
            
            .email-body {
                padding: 25px 20px;
            }
            
            .info-item {
                flex-direction: column;
                text-align: center;
            }
            
            .info-icon {
                margin: 0 0 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <img src="{{ asset('icon.svg') }}" alt="Eminent Studio Logo" class="logo">
            <h1>استشارة جديدة</h1>
            <p>تم استلام طلب استشارة جديد من موقع Eminent Studio</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="info-section">
                <!-- Name -->
                <div class="info-item">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">الاسم</div>
                        <div class="info-value">{{ $name }}</div>
                    </div>
                </div>

                <!-- Email -->
                <div class="info-item">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.89 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">البريد الإلكتروني</div>
                        <div class="info-value">{{ $email }}</div>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="info-item">
                    <div class="info-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <div class="info-label">رقم الجوال</div>
                        <div class="info-value">{{ $mobile }}</div>
                    </div>
                </div>
            </div>

            <!-- Message Section -->
            <div class="message-section">
                <div class="message-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                    </svg>
                    نص الاستشارة
                </div>
                <div class="message-content">
                    {{ $body }}
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>تم إرسال هذه الرسالة من موقع <span class="company-name">Eminent Studio</span></p>
            <p>يرجى الرد على هذه الاستشارة في أقرب وقت ممكن</p>
            <div class="timestamp">
                تاريخ الإرسال: {{ date('Y-m-d H:i:s') }}
            </div>
        </div>
    </div>
</body>

</html>

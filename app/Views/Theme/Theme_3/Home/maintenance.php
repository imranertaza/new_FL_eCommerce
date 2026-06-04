<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $title; ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --bg: #1e2022;
            --gold: #ffffff;
            --muted: #bdbdbd;
            --button-green: linear-gradient(180deg, #43d36b, #2ca84f);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            min-height: 100%;
            font-family: Montserrat, system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial;
        }

        body {
            background: radial-gradient(1200px 800px at 50% 20%, rgba(255, 255, 255, 0.03), transparent 10%),
            var(--bg);

            color: #fff;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px 15px;
        }

        .card {
            width: 100%;
            max-width: 920px;
            text-align: center;
            padding: 20px 20px;
        }

        .logo {
            width: 100%;
            max-width: 300px;
            height: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto 35px;
        }

        .headline {
            color: var(--gold);
            font-size: 34px;
            line-height: 1.4;
            letter-spacing: 2px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .sub {
            color: #ffffff;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(
                    90deg,
                    transparent,
                    rgb(26 138 208),
                    transparent
            );
            margin: 30px auto 40px;
            border-radius: 2px;
            width: 100%;
            max-width: 600px;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 25px;
            color: #fff;
            font-weight: 700;
        }

        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 14px;

            padding: 16px 26px;

            border-radius: 10px;
            background: var(--button-green);

            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);

            font-weight: 700;
            font-size: 20px;

            text-decoration: none;
            color: #fff;

            transition: 0.3s ease;
        }

        .whatsapp-btn:hover {
            transform: translateY(-2px);
        }

        .whatsapp-icon {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
        }

        .qr-text {
            margin-top: 28px;
            color: var(--muted);
            font-size: 16px;
        }

        .qr-wrapper {
            margin-top: 18px;
        }

        .qr {
            width: 180px;
            height: 180px;

            background: #fff;

            border-radius: 12px;
            padding: 14px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .qr img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 6px;
        }

        .footer {
            margin-top: 45px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .footer span {
            color: #fff;
            word-break: break-word;
        }

        /* =========================
           Tablet
        ========================== */
        @media (max-width: 768px) {

            body {
                padding: 25px 15px;
            }

            .card {
                padding: 25px 10px;
            }

            .headline {
                font-size: 26px;
                letter-spacing: 1px;
            }

            .sub {
                font-size: 16px;
            }

            .section-title {
                font-size: 22px;
            }

            .whatsapp-btn {
                font-size: 18px;
                padding: 14px 22px;
            }

            .qr {
                width: 160px;
                height: 160px;
            }
        }

        /* =========================
           Mobile
        ========================== */
        @media (max-width: 480px) {

            body {
                padding: 20px 12px;
            }

            .card {
                padding: 20px 5px;
            }

            .logo {
                max-width: 220px;
                margin-bottom: 28px;
            }

            .headline {
                font-size: 20px;
                line-height: 1.5;
            }

            .sub {
                font-size: 14px;
                line-height: 1.6;
            }

            .section-title {
                font-size: 18px;
                line-height: 1.5;
            }

            .whatsapp-btn {
                width: 100%;
                max-width: 300px;

                font-size: 16px;
                padding: 14px 18px;
            }

            .whatsapp-icon {
                width: 24px;
                height: 24px;
            }

            .qr {
                width: 140px;
                height: 140px;
                padding: 10px;
            }

            .qr-text {
                font-size: 14px;
            }

            .footer {
                font-size: 13px;
                line-height: 1.7;
            }
        }
    </style>
</head>

<body>

<main class="card">

    <img class="logo" src="<?= base_url('uploads/logo.png') ?>" alt="logo"/>

    <h1 class="headline">
        YOUR TRUSTED SOURCE FOR SUPER REP LUXURIES
    </h1>

    <div class="sub">
        Authenticity and Excellence Since 2015
    </div>

    <div class="divider"></div>

    <div class="section-title">
        Connect With Us Instantly
    </div>

    <a class="whatsapp-btn" href="https://wa.me/8618529237990" target="_blank" rel="noopener noreferrer">

        <svg class="whatsapp-icon" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 3C8.82 3 3 8.82 3 16c0 2.3.6 4.5 1.8 6.5L3 29l6.7-1.8c1.9 1 4 1.6 6.3 1.6 7.2 0 13-5.8 13-13S23.2 3 16 3zm0 23.4c-2 0-3.9-.5-5.6-1.5l-.4-.2-4 .9.9-3.9-.3-.4c-1.1-1.7-1.6-3.7-1.6-5.7 0-6.1 5-11.1 11.1-11.1 3 0 5.8 1.2 7.8 3.2s3.2 4.9 3.2 7.8c0 6.1-5 11.1-11.1 11.1zm6.1-8.3c-.3-.2-1.8-.9-2.1-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1-.3-.2-1.4-.5-2.6-1.6-1-1-1.6-2.1-1.8-2.5-.2-.3 0-.5.1-.7.1-.1.3-.3.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.6 0-.2-.7-1.7-1-2.3-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.1-1.2 2.7s1.2 3.1 1.4 3.3c.2.2 2.3 3.5 5.5 4.9.8.3 1.4.5 1.9.6.8.2 1.5.2 2 .1.6-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.1-.3-.2-.6-.4z"
                  fill="#fff"/>
        </svg>

        Chat on WhatsApp
    </a>

    <div class="qr-text">
        Scan the QR Code to chat:
    </div>

    <div class="qr-wrapper">
        <div class="qr">
            <img src="<?= base_url('uploads/finerlabelsQR.jpg') ?>" alt="QR to chat"/>
        </div>
    </div>

    <div class="footer">
        Official Domain:
        <span>https://finerlabels.io/</span>
        <br>
        © Finerlabels. All Rights Reserved.
    </div>

</main>

</body>
</html>
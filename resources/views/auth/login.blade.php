<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In &bull; Amber's Roots</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Amber Custom Alerts -->
    <link rel="stylesheet" href="{{ asset('css/amber-alerts.css') }}?v=1.0">

    <style>
        :root {
            --rm-gold: #dfc285;
            --rm-gold-dark: #c5a059;
            --rm-bg: #090a0d;
            --rm-card: #12141a;
            --rm-border: rgba(223, 194, 133, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--rm-bg);
            background-image: radial-gradient(circle at 50% 20%, rgba(223, 194, 133, 0.08) 0%, transparent 70%);
            color: #f1f5f9;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-crest {
            width: 54px;
            height: 54px;
            margin: 0 auto 14px;
            border-radius: 14px;
            background: linear-gradient(135deg, #1b1e28, #11131a);
            border: 1px solid var(--rm-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--rm-gold);
            font-size: 1.5rem;
            box-shadow: 0 0 25px rgba(223, 194, 133, 0.25);
        }

        .brand-title {
            font-family: 'Cinzel', serif;
            font-size: 1.75rem;
            letter-spacing: 1px;
            color: #fff;
        }

        .brand-title span {
            color: var(--rm-gold);
        }

        .brand-subtitle {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        .login-card {
            background: var(--rm-card);
            border: 1px solid var(--rm-border);
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.7);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            background: #090a0e;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            color: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input:focus {
            border-color: var(--rm-gold);
            box-shadow: 0 0 0 3px rgba(223, 194, 133, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #dfc285, #c5a059);
            color: #0b0c10;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #f3d79b, #dfc285);
            box-shadow: 0 6px 20px rgba(223, 194, 133, 0.35);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #34d399;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #94a3b8;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: var(--rm-gold);
        }

        @media (max-width: 360px) {
            body {
                padding: 16px 8px;
            }
            .login-card {
                padding: 20px 14px;
                border-radius: 12px;
            }
            .brand-title {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 280px) {
            body {
                padding: 12px 4px;
            }
            .login-card {
                padding: 16px 10px;
                border-radius: 10px;
            }
            .brand-title {
                font-size: 1.2rem;
            }
            .brand-subtitle {
                font-size: 0.75rem;
            }
            .form-input {
                padding: 9px 10px;
                font-size: 0.85rem;
            }
            .btn-submit {
                padding: 10px;
                font-size: 0.85rem;
            }
            .brand-header img {
                height: 44px !important;
                max-width: 180px !important;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="brand-header">
        <div style="margin-bottom: 16px;">
            <img src="{{ asset('assets/Logos/logo-light.png') }}" 
                 alt="Amber's Roots" 
                 style="height: 58px; width: auto; max-width: 270px; object-fit: contain; filter: drop-shadow(0 4px 16px rgba(201, 147, 27, 0.4));"
                 onerror="this.onerror=null; this.src='{{ asset('assets/Logos/logo-trimmed.png') }}';" />
        </div>
        <p class="brand-subtitle">Enter your email and password to access your dashboard</p>
    </div>

    <div class="login-card">
        @if(session('error'))
            <div class="alert-error">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf

            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
            </div>

            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                <input type="checkbox" name="remember" id="remember" style="accent-color: var(--rm-gold);" checked>
                <label for="remember" style="font-size: 0.8rem; color: #94a3b8; cursor: pointer;">Remember me</label>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right: 6px;"></i>
                Sign In
            </button>
        </form>
    </div>

    <div class="back-link">
        <a href="{{ route('home') }}">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Return to Amber's Roots Store Front</span>
        </a>
    </div>
</div>

<!-- Amber Custom Luxury Alerts Engine -->
<script src="{{ asset('js/amber-alerts.js') }}?v=1.0"></script>

</body>
</html>

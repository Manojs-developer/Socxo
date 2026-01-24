<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socxo Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="https://socxo.com/wp-content/themes/socxo-custom/assets/images/socxo/socxo.png" alt="logo"
                width="100%" style="max-width: 160px;">
        </div>
        <h2 class="form-title"><span><a href="{{ route('register') }}" style="text-decoration: none">Sign up</a></span> or Login with</h2>


        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input id="email" type="email" name="email" placeholder="Email Address"
                        value="{{ old('email') }}" required autofocus autocomplete="username" />
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <div class="input-wrapper">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input id="password" type="password" name="password" placeholder="Password" required
                        autocomplete="current-password" />
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="continue-btn">
                Continue
            </button>

            <div class="terms">
                By Signing Up/Signing in, you agree to our <a href="#">Terms and Conditions</a> and <a
                    href="#">Privacy Policy</a>
            </div>

            <div class="footer">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                    <circle cx="12" cy="12" r="10" stroke-width="2" />
                    <path d="M12 6v6l4 2" stroke-width="2" stroke-linecap="round" />
                </svg>
                2026 Socxo. All rights reserved.
            </div>
        </form>
    </div>

    <div class="confidential">Socxo Confidential</div>
</body>

</html>

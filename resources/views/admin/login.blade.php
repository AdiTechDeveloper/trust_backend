<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Sidhh Rudreshwar Seva Trust</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
</head>
<body>

    <div class="admin-login-page">
        <div class="admin-login-bg-pattern"></div>

        <div class="admin-login-card">
            <div class="admin-login-header">
                <span class="admin-shield-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2 3 6v6c0 5 4 9 9 10 5-1 9-5 9-10V6l-9-4Z" />
                    </svg>
                </span>
                <h1>Trust Admin Panel</h1>
                <p>Sidhh Rudreshwar Seva Trust — Management Console</p>
            </div>

            @if ($errors->any())
            <div class="admin-form-error">
                {{ $errors->first() }}
            </div>
            @endif

            @if (session('status'))
            <div class="admin-form-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-form">
                @csrf

                <div class="admin-form-field">
                    <label for="email">Admin Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="admin@rudreshwartrust.org" required autofocus autocomplete="username">
                </div>

                <div class="admin-form-field">
                    <label for="password">Password</label>
                    <div class="admin-password-wrap">
                        <input id="password" name="password" type="password" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="admin-password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                            👁
                        </button>
                    </div>
                </div>

                <div class="admin-login-row">
                    <label class="admin-checkbox">
                        <input type="checkbox" name="remember">
                        Keep me signed in
                    </label>
                    <a href="#" class="admin-forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="admin-login-submit">
                    Sign In to Admin Panel
                </button>
            </form>

            <p class="admin-security-note">
                🔒 Authorized personnel only. All login attempts are logged and monitored.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }

    </script>
</body>
</html>

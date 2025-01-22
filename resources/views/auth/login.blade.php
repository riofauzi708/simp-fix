<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Manajemen Pegawai</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 30px;
        }

        .login-container h1 {
            font-size: 1.75rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .login-container .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-container .form-control {
            border-radius: 8px;
            box-shadow: none;
            height: 40px;
            padding-left: 10px;
        }

        .login-container .form-control:focus {
            border-color: #0069d9;
            box-shadow: 0 0 5px rgba(0, 105, 217, 0.5);
        }

        .login-container .form-check-input {
            width: auto;
        }

        .login-container .form-check-label {
            font-size: 0.875rem;
        }

        .login-container .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .login-container .forgot-password {
            font-size: 0.875rem;
            text-align: right;
            margin-top: 15px;
        }

        .login-container .forgot-password a {
            text-decoration: none;
            color: #007bff;
        }

        .login-container .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-container .btn-link {
            text-decoration: none;
            font-size: 0.875rem;
        }

        .login-container .btn-link:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-container {
                padding: 25px;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Logo PNG kecil -->
        <img src="{{ asset('manager.png') }}" alt="Logo" class="logo">

        <h1>Login</h1>

        <!-- Session Status -->
        @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
        @endif

        <!-- Error Validation Message -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Forgot Password Link -->
            @if (Route::has('password.request'))
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
            </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-4">{{ __('Log in') }}</button>

            <div class="mt-3">
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-link">{{ __('Register') }}</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
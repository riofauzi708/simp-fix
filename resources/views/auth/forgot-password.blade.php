<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Aplikasi Manajemen Pegawai</title>

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

        .forgot-password-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .forgot-password-container .logo {
            width: 80px;
            height: 80px;
            margin-bottom: 30px;
        }

        .forgot-password-container h1 {
            font-size: 1.75rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .forgot-password-container .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .forgot-password-container .form-control {
            border-radius: 8px;
            box-shadow: none;
            height: 40px;
            padding-left: 10px;
        }

        .forgot-password-container .form-control:focus {
            border-color: #0069d9;
            box-shadow: 0 0 5px rgba(0, 105, 217, 0.5);
        }

        .forgot-password-container .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .forgot-password-container .back-to-login {
            font-size: 0.875rem;
            text-align: right;
            margin-top: 15px;
        }

        .forgot-password-container .back-to-login a {
            text-decoration: none;
            color: #007bff;
        }

        .forgot-password-container .back-to-login a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .forgot-password-container {
                padding: 25px;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="forgot-password-container">
        <!-- Logo PNG kecil -->
        <img src="{{ asset('manager.png') }}" alt="Logo" class="logo">

        <h1>Forgot Your Password?</h1>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div class="alert alert-info mb-4">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" :value="old('email')" required autofocus />
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
            <a href="{{ route('login') }}" class="back-to-login">
                {{ __('Remember your password?') }}
            </a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
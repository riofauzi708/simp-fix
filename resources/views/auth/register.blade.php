<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi Manajemen Pegawai</title>

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

        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }

        .register-container .logo {
            width: 80px;
            height: 80px;
            display: block;
            margin: 0 auto 20px;
        }

        .register-container h1 {
            font-size: 1.75rem;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
        }

        .form-control {
            border-radius: 8px;
            box-shadow: none;
            height: 40px;
            padding-left: 10px;
        }

        .form-control:focus {
            border-color: #0069d9;
            box-shadow: 0 0 5px rgba(0, 105, 217, 0.5);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .btn-link {
            text-decoration: none;
            font-size: 0.875rem;
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .form-row {
                flex-direction: column;
            }

            .form-group {
                flex: unset;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <!-- Logo -->
        <img src="{{ asset('manager.png') }}" alt="Logo" class="logo">

        <h1>Register</h1>

        <!-- Session Status -->
        @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row">
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" :value="old('name')" required autofocus>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Company Name -->
                <div class="form-group">
                    <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                    <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" :value="old('company_name')" required>
                    @error('company_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" :value="old('email')" required autofocus autocomplete="username">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">{{ __('Register') }}</button>

            <a href="{{ route('login') }}" class="btn-link">{{ __('Already registered? Log in') }}</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Manajemen Pegawai dengan Bootstrap dan CSS">
    <meta name="author" content="Rio Fauzi">
    <meta name="keywords" content="Manajemen Pegawai, Employee Management, Bootstrap, CSS">
    <link rel="icon" href="{{ asset('staff.png') }}" type="image/x-icon">

    <title>Sistem Informasi Manajemen Pegawai</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            color: #374151;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            color: white;
            padding: 15px 0;
            transition: all 0.3s ease-in-out;
        }

        header.sticky {
            padding: 5px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header h1 img {
            width: 42px;
            height: 42px;
        }

        .fas {
            font-size: 1.5rem;
            margin-right: 5px;
        }

        nav .navbar-toggler {
            border: none;
            outline: none;
            color: white;
            font-size: 3rem;
            cursor: pointer;
        }

        nav .navbar-collapse {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
        }

        nav .navbar-nav {
            display: flex;
            justify-content: flex-end;
            align-items: end;
            list-style: none;
            font-size: 3rem;
            transition: all 0.3s ease-in-out;
        }

        nav .navbar-nav .nav-item {
            margin-left: 10px;
        }

        nav .navbar-nav .nav-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 1rem;
            transition: color 0.3s, transform 0.3s;
        }

        nav .navbar-nav .nav-link:hover {
            color: #60a5fa;
            transform: translateX(5px);
        }

        nav .btn-logout {
            background-color: white;
            color: #2563eb;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
        }

        nav .btn-logout:hover {
            background-color: #60a5fa;
            color: white;
            transform: scale(1.05);
        }

        .content {
            flex: 1;
        }

        footer {
            background: #1f2937;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        footer a {
            color: #60a5fa;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            header .container {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .fas {
                font-size: 1.2rem;
                margin-right: 10px;
            }

            header h1 {
                font-size: 1.2rem;
                flex: 1;
            }

            header h1 img {
                width: 34px;
                height: 34px;
            }

            #site-title {
                font-size: 1rem;
                line-height: 1.2;
                max-width: 80%;
            }

            nav .navbar-toggler {
                margin-left: auto;
            }

            nav .navbar-nav {
                display: flex;
                justify-content: flex-end;
            }

            nav .navbar-nav .nav-item {
                margin-left: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header id="main-header">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo dan Judul -->
            <h1 class="d-flex align-items-center">
                <img src="{{ asset('staff.png') }}" alt="Logo">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none" id="site-title">Sistem Informasi Manajemen Pegawai</a>
            </h1>

            <!-- Navigasi -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <nav class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <span class="nav-item">
                        <a href="{{ route('profile.show') }}" class="nav-link">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                        </a>
                    </span>
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employees.index', ['company' => auth()->user()->company_id]) }}" class="nav-link">
                            <i class="fas fa-users"></i> Data Pegawai
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('attendances.index') }}" class="nav-link">
                            <i class="fas fa-clipboard-list"></i> Data Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('salaries.index') }}" class="nav-link">
                            <i class="fas fa-coins"></i> Penggajian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.show', ['company' => auth()->user()->company_id]) }}" class="nav-link">
                            <i class="fas fa-building"></i> Perusahaan
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout">Logout</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-light">Login</a>
                    </li>
                    @endauth
                </ul>
            </nav>

        </div>
    </header>

    <!-- Main Content -->
    <div class="content">
        <div class="container my-4">
            @yield('content')
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; {{ date('Y') }} Rio Fauzi & Dima Ikmila. All rights reserved. <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sticky Header JS -->
    <script>
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
    </script>
</body>

</html>
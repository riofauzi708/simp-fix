@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<div class="hero-section text-center text-white py-5 position-relative overflow-hidden">
    <img src="{{ asset('img/cover.jpg') }}" alt="Hero Background" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; z-index: -1;">
    <div class="container position-relative">
        <h1 class="display-4 fw-bold animated fadeIn">Selamat datang di Aplikasi Data Pegawai</h1>
        <p class="lead animated fadeIn delay-1s">Kelola data pegawai Anda dengan mudah dan cepat. Temukan pegawai yang Anda cari, dan lakukan perubahan yang diperlukan secara efisien.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg mt-3 animated fadeIn delay-2s">Akses Data Pegawai</a>
    </div>
</div>

<!-- Carousel Section -->
<div id="carouselExample" class="carousel slide mt-5" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('img/team.jpg') }}" class="d-block w-100 carousel-image" alt="Tim yang bekerja sama">
            <div class="carousel-caption d-none d-md-block">
                <h5>Tim Solid</h5>
                <p>Bersama, kita membangun solusi terbaik untuk data pegawai Anda.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/service.jpg') }}" class="d-block w-100 carousel-image" alt="Layanan terbaik">
            <div class="carousel-caption d-none d-md-block">
                <h5>Layanan Terbaik</h5>
                <p>Kami menyediakan layanan yang cepat dan handal.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/succed.jpg') }}" class="d-block w-100 carousel-image" alt="Kesuksesan bersama">
            <div class="carousel-caption d-none d-md-block">
                <h5>Kesuksesan</h5>
                <p>Bersama mencapai keberhasilan dalam pengelolaan data pegawai.</p>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- About Section -->
<section class="about-section py-5 bg-light mt-5">
    <div class="container">
        <h2 class="text-center">Kenapa Memilih Aplikasi Ini?</h2>
        <p class="text-center">Aplikasi ini dibuat untuk memudahkan pengelolaan data pegawai Anda dengan antarmuka yang intuitif dan mudah digunakan.</p>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card shadow-sm hover-shadow">
                    <img src="{{ asset('img/run.jpg') }}" class="card-img-top" alt="Kecepatan">
                    <div class="card-body">
                        <h5 class="card-title">Kecepatan</h5>
                        <p class="card-text">Aplikasi ini didesain untuk bekerja dengan cepat dan responsif, baik di perangkat desktop maupun mobile.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm hover-shadow">
                    <img src="{{ asset('img/security.jpg') }}" class="card-img-top" alt="Keamanan">
                    <div class="card-body">
                        <h5 class="card-title">Keamanan</h5>
                        <p class="card-text">Data pegawai Anda disimpan dengan aman dan dilindungi menggunakan enkripsi tingkat tinggi.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm hover-shadow">
                    <img src="{{ asset('img/relax.jpg') }}" class="card-img-top" alt="Kemudahan Penggunaan">
                    <div class="card-body">
                        <h5 class="card-title">Kemudahan Penggunaan</h5>
                        <p class="card-text">Antarmuka yang sederhana dan mudah digunakan, bahkan bagi pengguna awam.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<div class="cta-section text-center py-4 bg-primary text-white">
    <div class="container">
        <h3>Siap untuk mengelola data pegawai Anda?</h3>
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg mt-3 rounded-pill">Mulai Sekarang</a>
    </div>
</div>

@endsection

@section('styles')
<style>
    /* Hero Section Styles */
    .hero-section {
        height: 80vh;
        position: relative;
    }

    .hero-section img {
        object-fit: cover;
    }

    .hero-section h1,
    .hero-section p {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        opacity: 0;
        animation: fadeIn 1s ease-out forwards;
    }

    .hero-section p {
        animation-delay: 1s;
    }

    .hero-section a {
        animation-delay: 2s;
    }

    /* Animation for Fade In */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    /* Carousel Image Styles */
    .carousel-image {
        height: 450px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .carousel-image {
            height: 250px;
        }
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.6);
        padding: 1rem;
        border-radius: 10px;
    }

    /* About Section Styles */
    .about-section .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .about-section .card:hover {
        transform: translateY(-10px);
    }

    .about-section .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    /* CTA Section Styles */
    .cta-section {
        background: linear-gradient(135deg, #007bff, #00d2ff);
        color: #fff;
    }

    .cta-section a {
        background-color: #fff;
        color: #007bff;
        transition: background-color 0.3s ease;
    }

    .cta-section a:hover {
        background-color: #00d2ff;
    }
</style>
@endsection
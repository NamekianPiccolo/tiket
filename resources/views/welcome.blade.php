<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
    <title>{{auth()->user()->name}} - Hypetix</title>
    @endauth
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #000000;
            --secondary: #111111;
            --accent: #ff4757;
            --text: #f8f9fa;
            --text-muted: #adb5bd;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--primary);
            color: var(--text);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            height: 100px;
        }
        .login-btn {
    transition: background-color 0.3s ease;
}
        .login-btn:hover {
    background-color: #ff0000 !important; /* Warna merah */
    border-color: #ff0000 !important;
}

        .nav-link {
            position: relative;
            font-weight: 300;
            margin: 0 10px;
            color: var(--text) !important;
        }
        .active {

            color: var(--accent) !important;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s;
        }

        .nav-link:hover:after {
            width: 100%;
        }
         .hypetix-red {
        color: #ff0000;
        text-shadow:
            0 0 5px rgba(255, 0, 0, 0.5),
            0 0 10px rgba(255, 50, 50, 0.3),
            0 0 15px rgba(255, 100, 100, 0.2);
        font-weight: 800;
        letter-spacing: 1px;
        position: relative;
        display: inline-block;
        animation: pulse 1.5s infinite alternate;
    }

    .hypetix-red::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 3px;
        bottom: -5px;
        left: 0;
        background: linear-gradient(90deg, #ff0000, transparent);
        border-radius: 100%;
    }

    @keyframes pulse {
        0% {
            text-shadow:
                0 0 5px rgba(255, 0, 0, 0.5),
                0 0 10px rgba(255, 50, 50, 0.3);
        }
        100% {
            text-shadow:
                0 0 10px rgba(255, 0, 0, 0.8),
                0 0 20px rgba(255, 50, 50, 0.6),
                0 0 30px rgba(255, 100, 100, 0.4);
        }
    }
    /* background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.5)),
                        url('{{asset('storage/apa.png')}}'); */
                        /* background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.5)),
                        url('https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); */

        /* Hero Section */
        .hero-section {
            height: 100vh;
           background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.5)),
                        url('{{asset('storage/apa.png')}}');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-primary {
            background-color: var(--accent);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        /* Tiket Section */
        .tiket-section {
            padding: 5rem 0;
            background-color: var(--secondary);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--accent);
        }

        .tiket-card {
            background-color: var(--primary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .tiket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 71, 87, 0.1);
        }

        .tiket-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .tiket-body {
            padding: 1.5rem;
        }

        .tiket-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .tiket-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            margin: 0.75rem 0;
        }

        .tiket-location {
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .tiket-description {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        /* Footer */
        footer {
            background-color: #000;
            padding: 3rem 0 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-title {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .footer-links a {
            color: var(--text-muted);
            display: block;
            margin-bottom: 0.75rem;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--accent);
            text-decoration: none;
        }

        .social-icons a {
            color: var(--text);
            font-size: 1.25rem;
            margin-right: 1rem;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: var(--accent);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                text-align: center;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    @include('navbar')

    <!-- Hero Section -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section class="hero-section" id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="hero-title">Temukan Pengalaman Tak Terlupakan</h1>
                    <p class="hero-subtitle">Beli tiket untuk acara terbaik dengan mudah dan aman</p>
                    <a href="#tiket" class="btn btn-primary btn-lg me-2 login-btn"><i class="fas fa-ticket-alt"></i> Lihat Tiket</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Tiket Section -->
    <section class="tiket-section" id="tiket">
        <div class="container">
            <h2 class="section-title text-center">Tiket Tersedia</h2>

            <div class="row g-4">
                @foreach ($tikets as $tiket)
                <div class="col-md-4">
                    <div class="tiket-card">
                        @if($tiket->gambar)
                        <img src="{{ asset('storage/' . $tiket->gambar) }}" class="tiket-img" alt="{{ $tiket->namaTiket }}">
                        @else
                        <div class="tiket-img bg-dark d-flex align-items-center justify-content-center">
                            <i class="fas fa-ticket-alt fa-3x text-muted"></i>
                        </div>
                        @endif
                        <div class="tiket-body">
                            <h3 class="tiket-title">{{ $tiket->namaTiket }}</h3>
                            <p class="tiket-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $tiket->regency->name }}
                            </p>
                            <p class="tiket-price">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</p>
                            <p class="tiket-description">{{ $tiket->deskripsi }}</p>
                            <div class="d-flex gap-2">
                                <a href="/detailTiket/{{$tiket->id}}" class="btn btn-outline-light flex-grow-1">
                                    <i class="fas fa-eye"></i> Detail
                                </a>


                                @auth
                                <form action="{{ secure_url("/keranjang") }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                                    <input type="hidden" name="jumlah" value="1" min="1" max="{{ $tiket->stok }}">
                                    @if ($tiket->stok > 0 && $tiket->status == 'tersedia')
                                    <button type="submit" class="btn btn-primary login-btn">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                    @else
                                    <span class="badge bg-danger">Habis</span>
                                    @endif
                                </form>
                                @else
                              q22
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h3 class="footer-title">Hypetix</h3>
                    <p class="">Platform penjualan tiket online terbaik. Kami menyediakan berbagai tiket.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h3 class="footer-title">Tautan Cepat</h3>
                    <div class="footer-links">
                        <a href="#home">Beranda</a>
                        <a href="#tiket">Tiket</a>
                        <a href="#tentang">Tentang Kami</a>
                        <a href="#kontak">Kontak</a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h3 class="footer-title">Kontak Kami</h3>
                    <p class=""><i class="fas fa-map-marker-alt me-2"></i> Jl. Sudirman No. 123, Jakarta</p>
                    <p class=""><i class="fas fa-phone me-2"></i> (021) 1234-5678</p>
                    <p class=""><i class="fas fa-envelope me-2"></i> info@hypetix.id</p>
                </div>
            </div>

            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

            <div class="text-center pt-3">
                <p class="mb-0 text-muted">&copy; 2025 Hypetix. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>
</body>
</html>

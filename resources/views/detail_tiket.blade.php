<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
    <title>{{ $tiket->namaTiket }} - Hypetix</title>
    @endauth
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            padding-top: 70px;
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
            background-color: #ff0000 !important;
            border-color: #ff0000 !important;
        }

        .nav-link {
            position: relative;
            font-weight: 300;
            margin: 0 10px;
            color: var(--text) !important;
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

        /* Ticket Detail Section */
        .tiket-detail-container {
            background-color: var(--secondary);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .tiket-image {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .tiket-info {
            padding: 2rem;
        }

        .tiket-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text);
        }

        .tiket-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent);
            margin: 1rem 0;
        }

        .info-label {
            font-weight: 600;
            color: var(--accent);
            margin-right: 10px;
        }

        .info-value {
            margin-bottom: 15px;
            color: var(--text);
        }

        .tiket-description {
            line-height: 1.8;
            margin: 2rem 0;
            color: var(--text-muted);
        }

        .btn-primary {
            background-color: var(--accent);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
        .active {

            color: var(--accent) !important;
        }

        .btn-primary:hover {
            background-color: #e84141;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: var(--secondary);
            color: var(--text);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .quantity-input {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin: 0 5px;
            background-color: var(--secondary);
            color: var(--text);
        }

        .event-details-card {
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            background-color: var(--primary);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .event-details-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--accent);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--text);
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            bottom: -10px;
            left: 0;
            background-color: var(--accent);
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

        @media (max-width: 768px) {
            .tiket-image {
                height: 300px;
            }

            .tiket-title {
                font-size: 1.8rem;
            }

            .tiket-price {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    @include('navbar')

    <!-- Detail Tiket Section -->
    <section class="py-5">
        <div class="container">
            <div class="tiket-detail-container">
                <div class="row g-0">
                    <div class="col-lg-6">
                        @if($tiket->gambar)
                        <img src="{{ asset('storage/' . $tiket->gambar) }}" class="tiket-image" alt="{{ $tiket->namaTiket }}">
                        @else
                        <div class="tiket-image bg-dark d-flex align-items-center justify-content-center text-white">
                            <i class="fas fa-ticket-alt fa-5x"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="tiket-info">
                            <h1 class="tiket-title">{{ $tiket->namaTiket }}</h1>

                            <div class="d-flex align-items-center mb-3">
                                <span class="badge bg-{{ $tiket->status == 'tersedia' && $tiket->stok > 0  ? 'success' : 'danger' }}">
                                    {{ $tiket->status == 'tersedia' && $tiket->stok >0 ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                                <span class="ms-3">
                                    <i class="fas fa-box-open me-1"></i> Stok: {{ $tiket->stok }}
                                </span>
                            </div>

                            <div class="tiket-price">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</div>

                            <div class="event-details-card">
                                <h3 class="event-details-title">Detail Acara</h3>
                                <div class="info-value">
                                    <span class="info-label"><i class="far fa-calendar-alt me-1"></i> Tanggal:</span>
                                    {{ \Carbon\Carbon::parse($tiket->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}
                                    @if($tiket->tanggal_selesai_pelaksanaan)
                                        s/d {{ \Carbon\Carbon::parse($tiket->tanggal_selesai_pelaksanaan)->translatedFormat('l, d F Y') }}
                                    @endif
                                </div>

                                @if($tiket->waktu_mulai)
                                <div class="info-value">
                                    <span class="info-label"><i class="far fa-clock me-1"></i> Waktu:</span>
                                    {{ \Carbon\Carbon::parse($tiket->waktu_mulai)->format('H:i') }}
                                    @if($tiket->waktu_selesai)
                                        - {{ \Carbon\Carbon::parse($tiket->waktu_selesai)->format('H:i') }} WIB
                                    @endif
                                </div>
                                @endif

                                <div class="info-value">
                                    <span class="info-label"><i class="fas fa-map-marker-alt me-1"></i> Lokasi:</span>
                                    {{ $tiket->lokawebsi }}
                                </div>

                                <div class="info-value">
                                    <span class="info-label"><i class="fas fa-city me-1"></i> Kota:</span>
                                    {{ $tiket->regency->name }}
                                </div>
                            </div>

                            @if($tiket->status == 'tersedia')
                                <div class="booking-section">
                                    @auth
                                        @if($tiket->stok > 0)
                                            <!-- Form Tambah ke Keranjang -->
                                            <form action="{{secure_url('/keranjang')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                                                <input type="hidden" name="harga" value="{{ $tiket->harga }}">
                                                <input type="hidden" name="jumlah" value="1">

                                                <div class="d-grid gap-2">
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        <i class="fas fa-cart-plus me-2"></i> Tambah ke Keranjang
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Tombol Beli Sekarang -->
                                            <div class="d-grid gap-2">
                                                <button type="button" class="btn btn-primary login-btn btn-lg mt-2" data-bs-toggle="modal" data-bs-target="#buyNowModal">
                                                    <i class="fas fa-bolt me-2"></i> Beli Sekarang
                                                </button>
                                            </div>
                                        @else
                                            <div class="alert alert-danger mt-4">
                                                <i class="fas fa-times-circle me-2"></i> Maaf, stok tiket ini sudah habis.
                                            </div>
                                        @endif
                                    @else
                                        @if($tiket->stok > 0)
                                            <a href="{{ secure_url(route('login', ['return_url' => url()->current()])) }}" class="btn btn-primary btn-lg">
                                                <i class="fas fa-sign-in-alt me-2"></i> Login untuk Membeli
                                            </a>
                                        @else
                                            <div class="alert alert-danger mt-4">
                                                <i class="fas fa-times-circle me-2"></i> Maaf, stok tiket ini sudah habis.
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            @else
                                <div class="alert alert-warning mt-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> Tiket ini saat ini tidak tersedia untuk dibeli.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Tiket -->
            <div class="tiket-detail-container p-4">
                <h3 class="section-title">Deskripsi Tiket</h3>
                <div class="tiket-description">
                    {!! nl2br(e($tiket->deskripsi)) !!}
                </div>

                @if($tiket->terms_and_conditions)
                <div class="mt-4">
                    <h5 class="section-title" style="font-size: 1.3rem;">Syarat dan Ketentuan</h5>
                    <div class="terms-content">
                        {!! nl2br(e($tiket->terms_and_conditions)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Buy Now Modal -->
    <div class="modal fade" id="buyNowModal" tabindex="-1" aria-labelledby="buyNowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title" id="buyNowModalLabel">Beli Sekarang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="buyNowForm" action="{{secure_url('/checkoutLangsung') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                        <input type="hidden" name="total_harga" id="totalHargaInput" value="{{ $tiket->harga }}">

                        <div class="mb-3">
                            <label for="buyQuantity" class="form-label">Jumlah Tiket</label>
                            <div class="quantity-selector">
                                <button type="button" class="quantity-btn" id="modalDecrement">-</button>
                                <input type="number" name="jumlah" id="buyQuantity" class="quantity-input" value="1" min="1" max="{{ $tiket->stok }}">
                                <button type="button" class="quantity-btn" id="modalIncrement">+</button>
                            </div>
                        </div>

                        <div class="alert alert-dark">
                            <h5>Ringkasan Pembelian</h5>
                            <p>Total Harga: <span id="totalPayment">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">
                            <i class="fas fa-bolt me-1"></i> Lanjutkan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
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

                <div class="col-lg 2 col-md-6">
                <h3 class="footer-title">Tautan Cepat</h3>
                <div class="footer-links">
                <a href="#">Beranda</a>
                <a href="#">Tiket</a>
                <a href="#">Tentang Kami</a>
                <a href="#">Kontak</a>
            </div>
        </div>

            <div class="col-lg-4 col-md-6">
                <h3 class="footer-title">Hubungi Kami</h3>
                <div class="footer-contact">
                    <p><i class="fas fa-map-marker-alt me-2"></i> Jl. Contoh No. 123, Jakarta</p>
                    <p><i class="fas fa-phone me-2"></i> +62 123 4567 890</p>
                    <p><i class="fas fa-envelope me-2"></i> info@hypetix.com</p>
                </div>
            </div>
        </div>

        <hr class="my-4 bg-secondary">

        <div class="text-center">
            <p class="mb-0">&copy; 2023 Hypetix. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Quantity Selector Logic for Modal
    document.addEventListener('DOMContentLoaded', function() {
        const incrementBtn = document.getElementById('modalIncrement');
        const decrementBtn = document.getElementById('modalDecrement');
        const quantityInput = document.getElementById('buyQuantity');
        const totalPayment = document.getElementById('totalPayment');
        const totalHargaInput = document.getElementById('totalHargaInput');
        const ticketPrice = {{ $tiket->harga }};
        const maxStock = {{ $tiket->stok }};

        // Update total price function
        function updateTotalPrice() {
            const quantity = parseInt(quantityInput.value);
            const totalPrice = quantity * ticketPrice;
            totalPayment.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
            totalHargaInput.value = totalPrice;
        }

        // Increment quantity
        incrementBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxStock) {
                quantityInput.value = currentValue + 1;
                updateTotalPrice();
            }
        });

        // Decrement quantity
        decrementBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateTotalPrice();
            }
        });

        // Manual input change
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > maxStock) {
                this.value = maxStock;
                alert('Jumlah tiket melebihi stok yang tersedia');
            }
            updateTotalPrice();
        });

        // Initialize total price
        updateTotalPrice();
    });
</script>

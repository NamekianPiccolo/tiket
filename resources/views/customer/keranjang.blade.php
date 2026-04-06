<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Hypetix</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .navbar {
            background-color: var(--primary) !important;
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
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
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
            color: var(--accent);
            text-shadow:
                0 0 5px rgba(255, 71, 87, 0.5),
                0 0 10px rgba(255, 71, 87, 0.3),
                0 0 15px rgba(255, 71, 87, 0.2);
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
            background: linear-gradient(90deg, var(--accent), transparent);
            border-radius: 100%;
        }

        .cart-header {
            background-color: var(--primary);
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .cart-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text);
        }

        .cart-item {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            color: var(--text);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cart-item:hover {
            transform: translateY(-3px);
            background-color: rgba(255, 255, 255, 0.15);
        }

        .item-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        .item-title {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 5px;
        }

        .item-price {
            font-weight: 700;
            color: var(--text);
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }
        .login-btn {
            transition: background-color 0.3s ease;
            background-color: var(--accent) !important;
        }
        .login-btn:hover {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text);
        }

        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin: 0 5px;
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .remove-item {
            color: var(--accent);
            cursor: pointer;
            transition: color 0.3s;
        }
        .active {
            color: var(--accent) !important;
        }

        .remove-item:hover {
            color: #e04f4f;
        }

        .cart-summary {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 100px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .summary-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .summary-total {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--text);
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-checkout {
            background-color: var(--accent);
            color: white;
            font-weight: 500;
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            margin-top: 20px;
            transition: all 0.3s;
            border: none;
        }

        .btn-checkout:hover {
            background-color: #ff2d42;
            transform: translateY(-2px);
        }

        .empty-cart {
            text-align: center;
            padding: 50px 0;
            color: var(--text);
        }

        .empty-cart-icon {
            font-size: 5rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        .empty-cart-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text);
        }

        footer {
            background-color: var(--primary) !important;
            color: var(--text) !important;
        }

        footer a {
            color: var(--text) !important;
        }

        footer a:hover {
            color: var(--accent) !important;
        }

        .breadcrumb {
            background-color: transparent;
        }

        .breadcrumb-item.active {
            color: var(--text-muted);
        }

        .modal-content {
            background-color: var(--secondary);
            color: var(--text);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-close-white {
            filter: invert(1);
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
            }

            .item-img {
                margin-bottom: 15px;
                width: 100%;
                height: auto;
            }

            .quantity-control {
                margin-top: 15px;
                justify-content: flex-start;
            }
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0.8;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    @include('navbar')

    <!-- Header Keranjang -->
    <div class="cart-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="cart-title"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h1>
                </div>
                <div class="col-md-6 text-md-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item active">Keranjang</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Keranjang -->
    <div class="container mb-5">
        <div class="row">
            <!-- Daftar Item -->
            <div class="col-lg-8">
                @if($keranjang->isEmpty())
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2 class="empty-cart-title">Keranjang Anda Kosong</h2>
                    <p class="mb-4">Anda belum menambahkan tiket apapun ke keranjang</p>
                    <a href="/" class="btn btn-primary btn-lg login-btn">
                        <i class="fas fa-ticket-alt"></i> Jelajahi Tiket
                    </a>
                </div>
                @else
                <div class="cart-items">
                    @foreach($keranjang as $item)
                    <div class="cart-item d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <img src="{{ asset('storage/' . $item->tiket->gambar) }}" alt="{{ $item->tiket->namaTiket }}" class="item-img me-3">
                            <div>
                                <h5 class="item-title">{{ $item->tiket->namaTiket }}</h5>
                                <p class=" small"> Stok {{$item->tiket->stok}}</p>
                                <p class=" small">{{ $item->tiket->tanggal_pelaksanaan }} • {{ $item->tiket->waktu_mulai }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <p class="item-price mb-0">Rp {{ number_format($item->tiket->harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="quantity-control me-4">
                                <button type="button" class="quantity-btn minus-btn" data-id="{{ $item->id }}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" value="{{ $item->jumlah }}" min="1" max="{{$item->tiket->stok}}" class="quantity-input" data-id="{{ $item->id }}" readonly>
                                <button type="button" class="quantity-btn plus-btn" data-id="{{ $item->id }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <form action="{{ secure_url("/keranjang/$item->id") }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-item btn btn-link p-0">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Ringkasan Belanja -->
            <div class="col-lg-4">
                @if(!$keranjang->isEmpty())
                <div class="cart-summary">
                    <h3 class="summary-title">Ringkasan Belanja</h3>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $keranjang->sum('jumlah') }} Tiket)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <div class="summary-total d-flex justify-content-between">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" class="btn btn-checkout" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        <i class="fas fa-credit-card"></i> Beli Sekarang
                    </button>

            <a href="/" class="btn btn-checkout login-btn mt-2 w-100">
                        <i class="fas fa-ticket-alt"></i> Lanjutkan Belanja
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--accent);">
                    <h5 class="modal-title" id="checkoutModalLabel">Konfirmasi Pembelian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="mb-3">Detail Pesanan:</h6>

                    @foreach($keranjang as $item)
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                        <div>
                            <strong>{{ $item->tiket->namaTiket }}</strong>
                            <div class="text-muted small">{{ $item->jumlah }} x Rp {{ number_format($item->tiket->harga, 0, ',', '.') }}</div>
                        </div>
                        <div>Rp {{ number_format($item->tiket->harga * $item->jumlah, 0, ',', '.') }}</div>
                    </div>
                    @endforeach

                    <div class="summary-total d-flex justify-content-between mt-3">
                        <div>Total Pembayaran</div>
                        <div>Rp {{ number_format($total, 0, ',', '.') }}</div>
                    </div>

                    <form id="checkoutForm" action="{{ secure_url('/checkout') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="total_harga" value="{{ $total }}">
                        @foreach($keranjang as $item)
                            <input type="hidden" name="items[{{ $item->id }}][tiket_id]" value="{{ $item->tiket_id }}">
                            <input type="hidden" name="items[{{ $item->id }}][jumlah]" value="{{ $item->jumlah }}">
                        @endforeach

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn" style="background-color: var(--accent);">
                                <i class="fas fa-check-circle"></i> Konfirmasi Pembelian
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Hypetix</h5>
                    <p>Platform penjualan tiket online terpercaya.</p>
                </div>
                <div class="col-md-3">
                    <h5>Tautan</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-white">Beranda</a></li>
                        <li><a href="/" class="text-white">Tiket</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> hypetix.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-3" style="border-color: rgba(255, 255, 255, 0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Hypetix. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Update quantity
            $('.minus-btn, .plus-btn').click(function() {
                var itemId = $(this).data('id');
                var input = $('.quantity-input[data-id="' + itemId + '"]');
                var currentVal = parseInt(input.val());
                var newVal = $(this).hasClass('minus-btn') ? currentVal - 1 : currentVal + 1;

                if (newVal < 1) return;

                $.ajax({
                    url: '/keranjang/' + itemId,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        jumlah: newVal
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        alert('sudah maksimal');
                    }
                });
            });

            // Delete item
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function() {
                            location.reload();
                        },
                        error: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            padding-top: 80px;
        }

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

        @keyframes pulse {
            0% {
                text-shadow:
                    0 0 5px rgba(255, 71, 87, 0.5),
                    0 0 10px rgba(255, 71, 87, 0.3);
            }
            100% {
                text-shadow:
                    0 0 10px rgba(255, 71, 87, 0.8),
                    0 0 20px rgba(255, 71, 87, 0.6),
                    0 0 30px rgba(255, 71, 87, 0.4);
            }
        }

        /* Transaction Card Styles */
        .transaction-card {
            background-color: var(--secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transaction-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3) !important;
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-footer {
            background-color: rgba(0, 0, 0, 0.3) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .badge-dibayar {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .badge-menunggu {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .badge-gagal {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .list-group-item {
            background-color: transparent;
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        hr {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.2);
            border-color: rgba(40, 167, 69, 0.3);
            color: #28a745;
        }

        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background-color: #ff2d42;
            border-color: #ff2d42;
        }

        .btn-success {
            background-color: rgba(40, 167, 69, 0.2);
            border-color: #28a745;
            color: #28a745;
        }

        .btn-success:hover {
            background-color: #28a745;
            color: white;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .empty-card {
            background-color: var(--secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bi-receipt {
            color: var(--accent);
        }
    </style>
</head>
<body>
    @include('navbar')

    <div class="container py-5">
        <div class="row justify-content-between mb-4 mt-5">
            <div class="col-md-8">
                <h1 class="fw-bold text-white"><i class="bi bi-receipt"></i> Riwayat Transaksi</h1>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($transaksis->isEmpty())
            <div class="card shadow empty-card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-receipt" style="font-size: 3rem"></i>
                    <h4 class="mt-3 text-white">Belum ada transaksi</h4>
                    <p class="text-muted">Mulai belanja tiket untuk melihat riwayat transaksi</p>
                    <a href="{{ route('tikets.index') }}" class="btn btn-primary mt-2">
                        Lihat Tiket Tersedia
                    </a>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($transaksis as $transaksi)
                <div class="col-md-6 mb-4">
                    <div class="card transaction-card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-white">#{{ $transaksi->kode_transaksi }}</span>
                            <span class="badge rounded-pill
                                @if($transaksi->status_pembayaran == 'dibayar') badge-dibayar
                                @elseif($transaksi->status_pembayaran == 'gagal') badge-gagal
                                @else badge-menunggu
                                @endif">
                                {{ ucfirst($transaksi->status_pembayaran) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tanggal:</span>
                                <span>{{ $transaksi->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Metode Pembayaran:</span>
                                <span>{{ $transaksi->metode_pembayaran ?? '-' }}</span>
                            </div>
                            <hr>
                            <h6 class="fw-bold mb-3 text-white">Item Tiket:</h6>
                            <ul class="list-group list-group-flush mb-3">
                                @foreach($transaksi->details as $item)
                                <li class="list-group-item d-flex justify-content-between">
                                    <div>
                                        <span class="fw-bold text-white">{{ $item->tiket->namaTiket }}</span>
                                        <small class="d-block text-muted">{{ $item->jumlah }} x</small>
                                    </div>
                                    <span class="text-white">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between fw-bold fs-5 text-white">
                                <span>Total:</span>
                                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($transaksi->status_pembayaran == 'menunggu')
                                <form action="{{url('/bayar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $transaksi->id }}">
                                    <button class="btn btn-success btn-sm ms-2">
                                        <i class="bi bi-credit-card"></i> Bayar Sekarang
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>

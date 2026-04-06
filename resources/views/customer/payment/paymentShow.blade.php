<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - TicketHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

        .transaction-card {
            background-color: var(--secondary);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .transaction-header {
            background-color: var(--accent);
            color: white;
            padding: 20px;
        }

        .badge-waiting {
            background-color: #ffc107;
            color: #000;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge-failed {
            background-color: #dc3545;
            color: #fff;
        }

        .payment-method {
            background-color: var(--secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: var(--accent);
            background-color: rgba(255, 71, 87, 0.1);
        }

        .payment-method.active {
            border-color: var(--accent);
            background-color: rgba(255, 71, 87, 0.2);
        }

        .payment-icon {
            font-size: 2rem;
            margin-right: 15px;
            color: var(--accent);
        }

        .ticket-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 0;
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        /* Payment modal styling */
        .payment-modal-content {
            background-color: var(--secondary);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .loading-payment {
            text-align: center;
            padding: 50px 0;
            color: var(--text);
        }

        .loading-spinner {
            width: 3rem;
            height: 3rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }

        .snap-container {
            width: 100%;
            min-height: 500px;
        }

        .btn-close-custom {
            position: absolute;
            right: 20px;
            top: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text);
        }

        .btn-close-custom:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .alert {
            background-color: var(--secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .alert-info {
            background-color: rgba(23, 162, 184, 0.1);
            border-color: rgba(23, 162, 184, 0.3);
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border-color: rgba(40, 167, 69, 0.3);
        }

        hr {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background-color: #ff2d42;
            border-color: #ff2d42;
        }

        footer {
            background-color: var(--secondary) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->


    <!-- Transaction Detail Section -->
    <section class="py-5">
        <div class="container">
            <div class="transaction-card">
                <!-- Header -->
                <div class="transaction-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail Transaksi</h4>
                        <span class="badge {{ $transaksi->status_pembayaran == 'dibayar' ? 'badge-success' : ($transaksi->status_pembayaran == 'gagal' ? 'badge-failed' : 'badge-waiting') }}">
                            {{ ucfirst(str_replace('_', ' ', $transaksi->status_pembayaran)) }}
                        </span>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <!-- Transaction Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">Informasi Transaksi</h5>
                            <div class="mb-2">
                                <span class="">Kode Transaksi:</span>
                                <span class="fw-bold">{{ $transaksi->kode_transaksi }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="">Tanggal:</span>
                                <span class="fw-bold">{{ $transaksi->created_at->translatedFormat('l, d F Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3">Informasi Pembayaran</h5>
                            <div class="mb-2">
                                <span class="">Total Harga:</span>
                                <span class="fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                            @if($transaksi->metode_pembayaran)
                            <div class="mb-2">
                                <span class="">Metode Pembayaran:</span>
                                <span class="fw-bold text-capitalize">{{ str_replace('_', ' ', $transaksi->metode_pembayaran) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Ticket Items -->
                    <h5 class="fw-bold mb-3">Detail Tiket</h5>
                    <div class="mb-4">
                        @foreach($transaksi->details as $detail)
                        <div class="ticket-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">{{ $detail->tiket->namaTiket }}</h6>
                                    <div class=" small">
                                        <div>
                                            <i class="far fa-calendar-alt me-2"></i>
                                            {{ \Carbon\Carbon::parse($detail->tiket->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}
                                        </div>
                                        <div>
                                            <i class="fas fa-map-marker-alt me-2"></i>
                                            {{ $detail->tiket->lokawebsi }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-4 text-end">
                                            <span class="">Harga</span><br>
                                            <span>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="col-4 text-center">
                                            <span class="">Jumlah</span><br>
                                            <span>{{ $detail->jumlah }}x</span>
                                        </div>
                                        <div class="col-4 text-end">
                                            <span class="">Subtotal</span><br>
                                            <span class="fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Payment Section (only show if status is waiting) -->
                    @if($transaksi->status_pembayaran == 'menunggu')
                    <div class="payment-section">
                        <h5 class="fw-bold mb-3">Pilih Metode Pembayaran</h5>

                        <form id="paymentForm" action="{{ secure_url("/payment") }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $transaksi->id }}">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="payment-method" onclick="selectPayment('transfer_bank')">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-university payment-icon"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">Transfer Bank</h6>
                                                <small class="">BNI, BRI, Mandiri, dll</small>
                                            </div>
                                        </div>
                                        <input type="radio" name="metode_pembayaran" value="transfer_bank" id="transfer_bank" class="d-none" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-method" onclick="selectPayment('e_wallet')">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-wallet payment-icon"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">E-Wallet</h6>
                                                <small class="">Gopay, OVO, Dana, dll</small>
                                            </div>
                                        </div>
                                        <input type="radio" name="metode_pembayaran" value="e_wallet" id="e_wallet" class="d-none">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="payment-method" onclick="selectPayment('kartu_kredit')">
                                        <div class="d-flex align-items-center">
                                            <i class="far fa-credit-card payment-icon"></i>
                                            <div>
                                                <h6 class="fw-bold mb-1">Kartu Kredit</h6>
                                                <small class="">Visa, Mastercard, dll</small>
                                            </div>
                                        </div>
                                        <input type="radio" name="metode_pembayaran" value="kartu_kredit" id="kartu_kredit" class="d-none">
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <i class="fas fa-credit-card me-2"></i> Lanjutkan Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                    @elseif($transaksi->status_pembayaran == 'dibayar')
                        <div class="alert alert-success">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3 fa-2x"></i>
                                <div>
                                    <h5 class="mb-1">Pembayaran Berhasil</h5>
                                    <p class="mb-0">Sedang mengalihkan ke halaman terima kasih...</p>
                                </div>
                            </div>
                        </div>

                        <form id="autoRedirectForm" method="POST" action="{{secure_url('/createTiket')}}" class="d-none">
                            @csrf
                            <!-- Tambahkan input hidden jika perlu -->
                            <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}">
                        </form>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Auto submit form setelah 500ms (0.5 detik)
                                setTimeout(function() {
                                    document.getElementById('autoRedirectForm').submit();
                                }, 500);
                            });
                        </script>

                    @endif
                </div>
            </div>

            <!-- Payment Modal -->
            <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content payment-modal-content">
                        <div class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="modal-body p-0">
                            <div id="loadingPayment" class="loading-payment">
                                <div class="spinner-border loading-spinner text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <h5>Mempersiapkan pembayaran...</h5>
                                <p>Harap tunggu sebentar</p>
                            </div>
                            <div id="paymentContainer" class="snap-container d-none"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->

    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Hypetix. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        // Select payment method
        function selectPayment(method) {
            // Remove active class from all payment methods
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('active');
            });

            // Add active class to selected payment method
            document.querySelector(`.payment-method[onclick="selectPayment('${method}')"]`).classList.add('active');

            // Set the radio button as checked
            document.getElementById(method).checked = true;
        }

        // Handle form submission
        $('#paymentForm').on('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            // Show loading modal
            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();

            // Submit form via AJAX
            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.redirect_url) {
                        // Jika sudah dibayar, redirect langsung
                        window.location.href = response.redirect_url;
                    } else if (response.snapToken) {
                        // Hide loading and show payment container
                        $('#loadingPayment').addClass('d-none');
                        $('#paymentContainer').removeClass('d-none');

                        // Jika belum dibayar, tampilkan snap popup
                        snap.pay(response.snapToken, {
                            onSuccess: function(result) {
                                paymentModal.hide();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil',
                                    text: 'Tiket Anda akan segera diproses',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            onPending: function(result) {
                                paymentModal.hide();
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Pembayaran Diproses',
                                    text: 'Silakan selesaikan pembayaran Anda',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            onError: function(result) {
                                paymentModal.hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal',
                                    text: result.status_message || 'Terjadi kesalahan saat memproses pembayaran',
                                    confirmButtonText: 'Tutup'
                                });
                            },
                            onClose: function() {
                                paymentModal.hide();
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pembayaran Dibatalkan',
                                    text: 'Anda menutup popup pembayaran sebelum menyelesaikannya',
                                    confirmButtonText: 'Tutup'
                                });
                            }
                        });
                    }
                },
                error: function(xhr) {
                    paymentModal.hide();
                    let errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses pembayaran';

                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: errorMsg,
                        confirmButtonText: 'Tutup'
                    });
                }
            });
        });

        // Auto select payment method if already selected (for page refresh)
        document.addEventListener('DOMContentLoaded', function() {
            const selectedMethod = document.querySelector('input[name="metode_pembayaran"]:checked');
            if (selectedMethod) {
                selectPayment(selectedMethod.value);
            }
        });

        // Handle back button to prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>

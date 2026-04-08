
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth
    <title>{{auth()->user()->name}} - Tiket Saya | Hypetick</title>
    @endauth
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
            color: var(--text);
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            bottom: -10px;
            left: 25%;
            background-color: var(--accent);
        }

        .ticket-container {
            background: var(--secondary);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .ticket-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border-color: var(--accent);
        }

        .ticket-header {
            border-bottom: 2px dashed rgba(255, 255, 255, 0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .ticket-qr {
            width: 120px;
            height: 120px;
            background-color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ticket-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .status-aktif {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-digunakan {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .status-kadaluarsa {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .ticket-detail {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-muted);
            min-width: 120px;
            display: inline-block;
        }

        .empty-state {
            text-align: center;
            padding: 40px 0;
            color: var(--text);
        }

        .empty-state-icon {
            font-size: 5rem;
            color: var(--text-muted);
            margin-bottom: 20px;
        }

        /* Search and filter box */
        .search-box {
            background: var(--secondary);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .search-box .form-control {
            border-radius: 20px;
            padding: 10px 20px;
            background-color: var(--primary);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .search-box .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(255, 71, 87, 0.25);
        }

        .search-box .btn {
            border-radius: 20px;
            padding: 10px 20px;
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .search-box .form-select {
            background-color: var(--primary);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .search-box .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(255, 71, 87, 0.25);
        }

        /* Pagination styling */
        .pagination {
            justify-content: center;
            margin-top: 30px;
        }

        .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .page-link {
            color: var(--accent);
            background-color: var(--secondary);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .page-link:hover {
            color: var(--text);
            background-color: var(--accent);
            border-color: var(--accent);
        }

        /* Enhanced ticket design for download */
        .ticket-design {
            max-width: 100%;
            border: 2px solid var(--accent);
            border-radius: 10px;
            overflow: hidden;
            background: var(--secondary);
            position: relative;
            margin-bottom: 20px;
            color: var(--text);
        }

        .ticket-header-print {
            background: var(--accent);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .ticket-header-print h3 {
            margin: 0;
            font-size: 1.8rem;
        }

        .ticket-header-print .subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        .ticket-body-print {
            display: flex;
            padding: 20px;
        }

        .ticket-info-print {
            flex: 2;
            padding-right: 20px;
        }

        .ticket-qr-print {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-left: 2px dashed var(--accent);
            padding-left: 20px;
        }

        .ticket-qr-code-print {
            width: 150px;
            height: 150px;
            background: white;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .ticket-detail-print {
            margin-bottom: 12px;
            display: flex;
        }

        .detail-label-print {
            font-weight: 600;
            color: var(--accent);
            min-width: 140px;
        }

        .ticket-footer-print {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .ticket-status-print {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .ticket-watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 100px;
            font-weight: bold;
            color: var(--accent);
            transform: rotate(-30deg);
            top: 30%;
            left: 10%;
            z-index: 0;
        }

        /* Hidden printable version */
        .printable-ticket {
            display: none;
        }

        /* Text colors */
        .text-muted {
            color: var(--text-muted) !important;
        }

        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background-color: #ff2d42;
            border-color: #ff2d42;
        }
    </style>
</head>
<body>
  @include('navbar')

    <div class="container py-5">

        @if($tiketCustomers->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <h3>Anda belum memiliki tiket</h3>
                <p class="text-muted">Setelah membeli tiket, tiket Anda akan muncul di halaman ini</p>
                <a href="/" class="btn btn-primary mt-3">
                    <i class="fas fa-shopping-cart me-2"></i> Beli Tiket Sekarang
                </a>
            </div>
        @else
            <!-- Search and Filter Box -->
            {{-- <div class="search-box">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari tiket..." aria-label="Cari tiket">
                            <button class="btn btn-primary" type="button" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="digunakan">Digunakan</option>
                            <option value="kadaluarsa">Kadaluarsa</option>
                        </select>
                    </div>
                </div>
            </div> --}}

            <div class="row" id="ticketsContainer" style="margin-top: 10vh">
                @foreach($tiketCustomers as $tiket)
                <div class="col-md-6 mb-4 ticket-item" data-status="{{ strtolower($tiket->status) }}" data-search="{{ $tiket->tiket->namaTiket }} {{ $tiket->kode_tiket }} {{ $tiket->nama }} {{ $tiket->email }}">
                    <div class="ticket-container">
                        <div class="ticket-header d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0">{{ $tiket->tiket->namaTiket }}</h3>
                                <small class="text-muted">Kode: {{ $tiket->kode_tiket }}</small>
                            </div>
                            <span class="ticket-status status-{{ strtolower($tiket->status) }}">
                                {{ $tiket->status }}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="ticket-detail">
                                    <span class="detail-label">Lokasi:</span> {{ $tiket->tiket->lokawebsi }}
                                </div>
                                <div class="ticket-detail">
                                    <span class="detail-label">Atas Nama:</span>
                                    {{ $tiket->nama }}
                                </div>
                                <div class="ticket-detail">
                                    <span class="detail-label">Email:</span>
                                    {{ $tiket->email }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="ticket-qr mb-3">
                                    @if($tiket->qr_code)
                                        <img src="{{ asset('storage/qrcodes/'.$tiket->qr_code.'.png') }}" alt="QR Code" class="img-fluid">
                                    @else
                                        <i class="fas fa-qrcode fa-4x text-muted"></i>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button onclick="downloadTicketImage('ticket-image-{{ $tiket->id }}')" class="btn btn-primary">
                                <i class="fas fa-download me-2"></i> Download Gambar
                            </button>
                        </div>
                    </div>

                    <!-- Hidden ticket image for download -->
                    <div id="ticket-image-{{ $tiket->id }}" class="printable-ticket">
                        <div class="ticket-design">
                            <div class="ticket-watermark">HYPETICK</div>
                            <div class="ticket-header-print">
                                <h3>{{ $tiket->tiket->namaTiket }}</h3>
                                <div class="subtitle">Kode Tiket: {{ $tiket->kode_tiket }}</div>
                            </div>

                            <div class="ticket-body-print">
                                <div class="ticket-info-print">

                                    <div class="ticket-detail-print">
                                        <span class="detail-label-print">Atas Nama:</span>
                                        <span>{{ $tiket->nama }}</span>
                                    </div>


                                    <div class="    ">
                                        @if($tiket->qr_code)
                                            <img src="{{ asset('storage/qrcodes/'.$tiket->qr_code.'.png') }}" alt="QR Code" style="width:100%;height:100%;">
                                        @else
                                            <i class="fas fa-qrcode" style="font-size:5rem;color:#ccc;"></i>
                                        @endif
                                        <small>Scan QR code untuk validasi</small>
                                    </div>
                                </div>
                            </div>
                            <div class="ticket-footer-print">
                                Tiket ini sah dan diterbitkan oleh Hypetick
                            </div>
                            <span class="ticket-status-print status-{{ strtolower($tiket->status) }}">
                                {{ $tiket->status }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item {{ $tiketCustomers->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $tiketCustomers->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @for ($i = 1; $i <= $tiketCustomers->lastPage(); $i++)
                        <li class="page-item {{ $tiketCustomers->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $tiketCustomers->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ !$tiketCustomers->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $tiketCustomers->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>

    <footer id="kontak">
        <!-- Footer content -->
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Download ticket as image function
        function downloadTicketImage(elementId) {
            const element = document.getElementById(elementId);

            // Show the printable ticket temporarily
            element.style.display = 'block';

            html2canvas(element, {
                scale: 2, // Higher quality
                logging: false,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#000000'
            }).then(canvas => {
                // Create download link
                const link = document.createElement('a');
                link.download = `tiket-hypetick.png`;
                link.href = canvas.toDataURL('image/png', 1.0); // Highest quality
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Hide the printable ticket again
                element.style.display = 'none';
            }).catch(err => {
                console.error('Error generating image:', err);
                alert('Gagal mengunduh tiket. Silakan coba lagi.');
                element.style.display = 'none';
            });
        }

        // Search and filter functionality
        $(document).ready(function() {
            // Search function
            $('#searchInput, #searchButton').on('input keyup click', function() {
                filterTickets();
            });

            // Status filter function
            $('#statusFilter').change(function() {
                filterTickets();
            });

            function filterTickets() {
                const searchTerm = $('#searchInput').val().toLowerCase();
                const statusFilter = $('#statusFilter').val().toLowerCase();

                $('.ticket-item').each(function() {
                    const ticketText = $(this).data('search').toLowerCase();
                    const ticketStatus = $(this).data('status');

                    const matchesSearch = ticketText.includes(searchTerm);
                    const matchesStatus = statusFilter === '' || ticketStatus === statusFilter;

                    if (matchesSearch && matchesStatus) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    </script>
</body>
</html>

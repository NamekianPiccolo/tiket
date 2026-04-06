<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - TicketHub</title>
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
            padding-top: 70px;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .success-card {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            background-color: var(--secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
        }

        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background-color: #ff2d42;
            border-color: #ff2d42;
        }

        .text-success {
            color: #28a745 !important;
        }

        footer {
            background-color: var(--secondary) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
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
    </style>
</head>
<body>
    <!-- Navbar -->
  @include('navbar')

    <section class="py-5">
        <div class="container">
            <div class="success-card text-center">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="mb-3">Pembayaran Berhasil!</h2>
                <p class="mb-4">Terima kasih telah melakukan pembayaran. Tiket Anda akan segera diproses.</p>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    <a href="/tiketCustomer" class="btn btn-outline-light px-4 py-2">
                        <i class="fas fa-ticket-alt me-2"></i> Lihat Tiket Saya
                    </a>
                    <a href="/" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-home me-2"></i> Kembali ke Beranda
                    </a>
                </div>


            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} hypetix. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

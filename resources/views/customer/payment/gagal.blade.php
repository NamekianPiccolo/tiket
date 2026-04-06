<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal - Hypetix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #000000;
            --secondary: #111111;
            --accent: #ff4757;
            --text: #f8f9fa;
            --text-muted: #adb5bd;
            --error: #dc3545;
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

        .error-card {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            background-color: var(--secondary);
            border: 1px solid rgba(255, 71, 87, 0.3);
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

        .btn-outline-error {
            border-color: var(--error);
            color: var(--error);
        }

        .btn-outline-error:hover {
            background-color: var(--error);
            color: white;
        }

        .text-error {
            color: var(--error) !important;
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

        .alert-error {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.3);
            color: var(--text);
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


    <section class="py-5">
        <div class="container">
            <div class="error-card text-center">
                <div class="mb-4">
                    <i class="fas fa-times-circle text-error" style="font-size: 5rem;"></i>
                </div>
                <h2 class="mb-3">Pembayaran Gagal!</h2>
                <p class="mb-4">Maaf, proses pembayaran Anda tidak berhasil. Silakan coba lagi.</p>

                <div class="alert alert-error mt-3 mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="error-message">Transaksi dibatalkan atau waktu pembayaran telah habis.</span>
                </div>

                <div class="d-flex justify-content-center gap-3">

                    <a href="/" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-home me-2"></i> Kembali ke Beranda
                    </a>
                </div>

                <div class="mt-4 text-muted">
                    <small>Masalah terus berlanjut? Hubungi <a href="mailto:support@tickethub.com" class="text-accent">support@hypetix.com</a></small>
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

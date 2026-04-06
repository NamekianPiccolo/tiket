@include('admin.tiket.header')
<body>
    @include('admin.tiket.sidebar')

    <div class="content">
        <h2>Ticket QR Scanner</h2>

        <div class="qr-scanner-container">
            <!-- QR Code Input Section -->
            <div class="qr-input-section">
                <label for="qr-code">Scan QR Code:</label>
                <input type="text" id="qr-code" name="qr_code" class="form-control" placeholder="Scan or enter QR code here" autofocus>
                <button id="scan-btn" class="btn btn-primary">Scan QR</button>

                <!-- Alternative: Camera Scanner -->
                <div id="qr-reader" style="width: 300px; "></div>
                <button id="toggle-camera" class="btn btn-secondary">Use Camera</button>
            </div>

            <!-- Ticket Info Display (will be populated after scan) -->
            <div id="ticket-info" class="ticket-info" style="display: none;">
                <h3>Ticket Information</h3>
                <div id="ticket-details"></div>
            </div>
        </div>
    </div>

    <!-- Include QR Scanner Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qrInput = document.getElementById('qr-code');
            const scanBtn = document.getElementById('scan-btn');
            const toggleCameraBtn = document.getElementById('toggle-camera');
            const qrReaderDiv = document.getElementById('qr-reader');
            const ticketInfoDiv = document.getElementById('ticket-info');
            const ticketDetailsDiv = document.getElementById('ticket-details');

            let html5QrCode;
            let cameraActive = false;

            // Manual scan button click
            scanBtn.addEventListener('click', function() {
                const qrValue = qrInput.value.trim();
                if(qrValue) {
                    processQRCode(qrValue);
                }
            });

            // Toggle camera scanner
            toggleCameraBtn.addEventListener('click', function() {
                if(cameraActive) {
                    stopCamera();
                } else {
                    startCamera();
                }
            });

            function startCamera() {
                html5QrCode = new Html5Qrcode("qr-reader");

                html5QrCode.start(
                    { facingMode: "environment" },
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    (decodedText, decodedResult) => {
                        // Successfully scanned
                        qrInput.value = decodedText;
                        processQRCode(decodedText);
                        stopCamera();
                    },
                    (errorMessage) => {
                        // Parse error
                        console.error(errorMessage);
                    }
                ).catch((err) => {
                    console.error(`Unable to start scanning: ${err}`);
                });

                qrReaderDiv.style.display = 'block';
                toggleCameraBtn.textContent = 'Stop Camera';
                cameraActive = true;
            }

            function stopCamera() {
                if(html5QrCode) {
                    html5QrCode.stop().then((ignore) => {
                        console.log("QR scanning stopped.");
                    }).catch((err) => {
                        console.error(`Unable to stop scanning: ${err}`);
                    });
                }

                qrReaderDiv.style.display = 'none';
                toggleCameraBtn.textContent = 'Use Camera';
                cameraActive = false;
            }

            function processQRCode(qrData) {
                fetch('/tiket/verify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ qr_code: qrData })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if(data.success) {
                        displayTicketInfo(data.ticket);

                        // Optional: Automatically mark as used when displaying
                        markTicketAsUsed(qrData);

                    } else {
                        alert(data.message || 'Invalid ticket');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error verifying ticket: ' + error.message);
                });
            }

        function markTicketAsUsed(qrData) {
            // This is separate so you can choose when to mark as used
            fetch('/tiket/scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ qr_code: qrData })
            })
            .then(response => response.json())
            .then(data => {
                if(!data.success) {
                    console.error('Error marking ticket:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

            function displayTicketInfo(ticket) {
                ticketDetailsDiv.innerHTML = `
                    <p><strong>Ticket ID:</strong> ${ticket.id}</p>
                    <p><strong>Event:</strong> ${ticket.event}</p>
                    <p><strong>Status:</strong> ${ticket.status}</p>
                `;
                ticketInfoDiv.style.display = 'block';
                setTimeout(() => {
                    ticketInfoDiv.style.display = 'none';
                    if (!cameraActive) {
                        startCamera();
                    }
                }, 200);
            }

        });
    </script>


</body>
</html>

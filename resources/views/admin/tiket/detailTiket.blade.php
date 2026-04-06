<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #1e2b37 100%);
            --sidebar-color: #e9ecef;
            --sidebar-active-bg: rgba(0, 123, 255, 0.2);
            --sidebar-active-color: #007bff;
            --sidebar-hover-bg: rgba(255, 255, 255, 0.1);
            --sidebar-header-bg: rgba(0, 0, 0, 0.2);
            --sidebar-border-color: rgba(255, 255, 255, 0.05);
            --sidebar-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
            --sidebar-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            display: flex;
            min-height: 100vh;
            padding-left: var(--sidebar-width);
            background-color: #f8f9fa;
            transition: var(--sidebar-transition);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            padding: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: var(--sidebar-transition);
            box-shadow: var(--sidebar-shadow);
            border-right: 1px solid var(--sidebar-border-color);
        }

        .user-profile {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid var(--sidebar-border-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            display: block;
        }

        .sidebar-menu {
            padding: 15px 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu li {
            position: relative;
            margin: 5px 10px;
            border-radius: 6px;
            overflow: hidden;
        }

        .sidebar-menu li.divider {
            height: 1px;
            background-color: var(--sidebar-border-color);
            margin: 15px 20px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--sidebar-color);
            text-decoration: none;
            transition: var(--sidebar-transition);
            font-size: 0.95rem;
            font-weight: 500;
            border-radius: 6px;
        }

        .sidebar-menu a:hover {
            background: var(--sidebar-hover-bg);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            font-weight: 600;
            border-left: 3px solid var(--sidebar-active-color);
        }

        .sidebar-menu a.active i {
            color: var(--sidebar-active-color);
        }

        .sidebar-menu i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: var(--sidebar-transition);
        }

        .sidebar-footer {
            padding: 15px;
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            border-top: 1px solid var(--sidebar-border-color);
            position: absolute;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.1);
        }

        .main-content {
            flex: 1;
            padding: 25px;
            transition: var(--sidebar-transition);
        }

        .detail-card {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .detail-header {
            background: linear-gradient(135deg, #007bff 0%, #00b4db 100%);
            color: white;
            padding: 20px;
            position: relative;
        }

        .detail-header h2 {
            margin-bottom: 5px;
            font-weight: 700;
        }

        .detail-price {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 15px 0;
        }

        .detail-badge {
            font-size: 0.9rem;
            padding: 5px 12px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .detail-body {
            padding: 25px;
        }

        .detail-section {
            margin-bottom: 25px;
        }

        .detail-section h4 {
            color: #007bff;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .detail-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .detail-img:hover {
            transform: scale(1.02);
        }

        .location-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .location-info i {
            margin-right: 10px;
            color: #007bff;
            font-size: 1.2rem;
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        .img-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }

        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .detail-img {
                height: 200px;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-profile">
            <img src="https://ui-avatars.com/api/?name=Admin&background=007bff&color=fff" alt="User" class="user-avatar">
            <div class="user-info">
                <span class="user-name">Admin</span>
                <span class="user-role">Administrator</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('tikets.index') }}">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </li>
            <li>
                <a href="{{ route('tikets.index') }}" class="active">
                    <i class="fas fa-ticket-alt"></i> Manajemen Tiket
                </a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            v1.0.0 &copy; 2023
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="card detail-card">
                <div class="detail-header">
                    <h2>{{ $tiket->namaTiket }}</h2>
                    <span class="detail-badge">
                        <i class="fas fa-map-marker-alt"></i> {{ $tiket->regency->name }}, {{ $tiket->regency->province->name }}
                    </span>
                    <div class="detail-price">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</div>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-ticket-alt"></i> Stok: {{ $tiket->stok }}
                    </span>
                </div>

                <div class="detail-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-section">
                                <h4><i class="fas fa-info-circle"></i> Deskripsi</h4>
                                <p>{{ $tiket->deskripsi }}</p>
                            </div>

                            <div class="detail-section">
                                <h4><i class="fas fa-map-marked-alt"></i> Lokasi</h4>
                                <div class="location-info">
                                    <div>
                                        <i class="fas fa-map-pin"></i>
                                        <strong>Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $tiket->lokawebsi }}<br>
                                        <strong>Kabupaten/Kota&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $tiket->regency->name }}<br>
                                        <strong>Provinsi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $tiket->regency->province->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="detail-section">
                                <h4><i class="fas fa-calendar-alt"></i> Informasi Tiket</h4>
                                <div class="row">
                                    <div class="col-md-7">
                                        <p><strong>Tanggal Dimulai&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ \Carbon\Carbon::parse($tiket->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div class="col-md-7">
                                        <p><strong>Tanggal Selesai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $tiket->tanggal_selesai_pelaksanaan ? \Carbon\Carbon::parse($tiket->tanggal_selesai_pelaksanaan)->translatedFormat('d F Y') : '-' }}</p>
                                    </div>
                                    <div class="col-md-7">
                                        <p><strong>Waktu Mulai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $tiket->waktu_mulai ? \Carbon\Carbon::parse($tiket->waktu_mulai)->translatedFormat('H:i') : '-' }}</p>
                                    </div>
                                    <div class="col-md-7">
                                        <p><strong>Waktu Selesai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> {{ $tiket->waktu_selesai ? \Carbon\Carbon::parse($tiket->waktu_selesai)->translatedFormat('H:i') : '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-section">
                                <h4><i class="fas fa-image"></i> Gambar Tiket</h4>
                                <img src="{{ asset('storage/'.$tiket->gambar) }}" alt="{{ $tiket->namaTiket }}" class="detail-img">
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tiketModal" onclick="prepareEditModal({{ $tiket->id }})">
                            <i class="fas fa-edit"></i> Edit Tiket
                        </button>
                        <button class="btn btn-danger" onclick="confirmDelete({{ $tiket->id }})">
                            <i class="fas fa-trash-alt"></i> Hapus Tiket
                        </button>
                        <a href="{{ route('tikets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus tiket ini? Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-ban"></i> Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Tiket Modal -->
    <div class="modal fade" id="tiketModal" tabindex="-1" aria-labelledby="tiketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle"><i class="fas fa-plus-circle"></i> Tambah Tiket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="tiketForm" enctype="multipart/form-data">
                    <input type="hidden" id="tiketId" name="tiketId" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="namaTiket" class="form-label required-field">Nama Tiket</label>
                                    <input type="text" class="form-control" id="namaTiket" name="namaTiket" required>
                                    <div class="invalid-feedback" id="namaTiketError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="harga" class="form-label required-field">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" required>
                                    <div class="invalid-feedback" id="hargaError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="stok" class="form-label required-field">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" required>
                                    <div class="invalid-feedback" id="stokError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label required-field">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="tersedia">Tersedia</option>
                                        <option value="tidak tersedia">Tidak Tersedia</option>
                                    </select>
                                    <div class="invalid-feedback" id="statusError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_pelaksanaan" class="form-label required-field">Tanggal Pelaksanaan</label>
                                    <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" required>
                                    <div class="invalid-feedback" id="tanggal_pelaksanaanError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_selesai_pelaksanaan" class="form-label">Tanggal Selesai Pelaksanaan</label>
                                    <input type="date" class="form-control" id="tanggal_selesai_pelaksanaan" name="tanggal_selesai_pelaksanaan">
                                    <div class="invalid-feedback" id="tanggal_selesai_pelaksanaanError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai">
                                    <div class="invalid-feedback" id="waktu_mulaiError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai">
                                    <div class="invalid-feedback" id="waktu_selesaiError"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="province_id" class="form-label">Provinsi</label>
                                    <select class="form-select" id="province_id" name="province_id">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="province_idError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="regencie_id" class="form-label">Kabupaten/Kota</label>
                                    <select class="form-select" id="regencie_id" name="regencie_id">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    <div class="invalid-feedback" id="regencie_idError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="lokawebsi" class="form-label required-field">Lokasi</label>
                                    <textarea class="form-control" id="lokawebsi" name="lokawebsi" rows="3" required></textarea>
                                    <div class="invalid-feedback" id="lokawebsiError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                                    <div class="invalid-feedback" id="deskripsiError"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="gambar" class="form-label" id="gambarLabel">Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                    <div class="invalid-feedback" id="gambarError"></div>
                                    <div class="img-preview-container mt-2">
                                        <img id="previewGambar" src="#" alt="Preview Gambar" class="img-preview d-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" id="saveButton" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Setup CSRF Token untuk AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inisialisasi modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const tiketModal = new bootstrap.Modal(document.getElementById('tiketModal'));

        // Variabel global untuk menyimpan ID tiket yang akan dihapus
        let tiketIdToDelete = null;

        // Konfirmasi hapus
        function confirmDelete(id) {
            tiketIdToDelete = id;
            // Set form action
            $('#deleteForm').attr('action', `/tikets/${id}`);
            deleteModal.show();
        }

        // Fungsi untuk mempersiapkan modal edit dengan data tiket
        function prepareEditModal(id) {
            // Kosongkan form terlebih dahulu
            $('#tiketForm')[0].reset();
            $('#previewGambar').addClass('d-none');
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            // Ambil data tiket dari server
            $.get(`/tikets/${id}/edit`, function(data) {
                // Isi form dengan data tiket
                $('#tiketId').val(data.tiket.id);
                $('#namaTiket').val(data.tiket.namaTiket);
                $('#harga').val(data.tiket.harga);
                $('#stok').val(data.tiket.stok);
                $('#status').val(data.tiket.status);
                $('#tanggal_pelaksanaan').val(data.tiket.tanggal_pelaksanaan);
                $('#tanggal_selesai_pelaksanaan').val(data.tiket.tanggal_selesai_pelaksanaan);
                $('#waktu_mulai').val(data.tiket.waktu_mulai.substring(0, 5));
                $('#waktu_selesai').val(data.tiket.waktu_selesai.substring(0, 5));
                $('#lokawebsi').val(data.tiket.lokawebsi);
                $('#deskripsi').val(data.tiket.deskripsi);

                // Set provinsi dan load kabupaten/kota
                if (data.tiket.regency) {
                    $('#province_id').val(data.tiket.regency.province_id);
                    loadRegencies(data.tiket.regency.province_id, data.tiket.regencie_id);
                }

                // Tampilkan gambar jika ada
                if (data.tiket.gambar) {
                    $('#previewGambar').attr('src', `/storage/${data.tiket.gambar}`).removeClass('d-none');
                }

                // Ubah judul modal
                $('#modalTitle').html('<i class="fas fa-edit"></i> Edit Tiket');
                $('#gambarLabel').removeClass('required-field');
                $('#gambar').prop('required', false);

                // Tampilkan modal
                tiketModal.show();
            }).fail(function(xhr) {
                toastr.error('Gagal memuat data tiket: ' + xhr.responseJSON?.message);
            });
        }

        // Fungsi untuk load kabupaten/kota berdasarkan provinsi
        function loadRegencies(provinceId, selectedRegencyId = null) {
            if (!provinceId) {
                $('#regencie_id').html('<option value="">Pilih Kabupaten/Kota</option>');
                return;
            }

            $.get(`/get-Regencie/${provinceId}`, function(data) {
                let options = '<option value="">Pilih Kabupaten/Kota</option>';
                data.forEach(function(regency) {
                    const selected = selectedRegencyId == regency.id ? 'selected' : '';
                    options += `<option value="${regency.id}" ${selected}>${regency.name}</option>`;
                });
                $('#regencie_id').html(options);
            }).fail(function(xhr) {
                toastr.error('Gagal memuat data kabupaten/kota');
            });
        }

        // Event ketika provinsi diubah
        $('#province_id').change(function() {
            const provinceId = $(this).val();
            loadRegencies(provinceId);
        });

        // Preview gambar sebelum upload
        $('#gambar').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (maksimal 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    $('#gambar').addClass('is-invalid');
                    $('#gambarError').text('Ukuran gambar maksimal 2MB');
                    $(this).val('');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#previewGambar').attr('src', event.target.result).removeClass('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                $('#previewGambar').addClass('d-none');
            }
        });

        // Submit form create/edit tiket
        $('#tiketForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = $('#tiketId').val();
            const url = id ? `/tikets/${id}` : '/tikets';

            // Jika edit, tambahkan method PUT
            if (id) {
                formData.append('_method', 'PUT');
            }

            // Reset pesan error
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');

            // Disable tombol submit
            const saveButton = $('#saveButton');
            saveButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message);
                    tiketModal.hide();
                    // Reload halaman setelah 1.5 detik
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    // Enable tombol submit
                    saveButton.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');

                    if (xhr.status === 422) {
                        // Tampilkan error validasi
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            $(`#${field}`).addClass('is-invalid');
                            $(`#${field}Error`).text(errors[field][0]);
                        }
                        toastr.warning('Terdapat kesalahan pada inputan');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data');
                    }
                }
            });
        });

        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": 5000
        };

        // Tampilkan pesan sukses jika ada
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        // Tampilkan pesan error jika ada
        @if($errors->any())
            toastr.error('{{ $errors->first() }}');
        @endif
    </script>
</body>
</html>

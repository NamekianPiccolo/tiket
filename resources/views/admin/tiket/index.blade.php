@include('admin.tiket.header')
<body>
    @include('admin.tiket.sidebar')

    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">Manajemen Tiket</h2>
                        <button class="btn btn-light btn-sm" onclick="openModal()">
                            <i class="fas fa-plus"></i> Tambah Tiket
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ url()->current() }}" class="search-form">
                                <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari tiket..."
                                           value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                    <a href="{{ url()->current() }}?perPage={{ request('perPage', 10) }}" class="btn btn-outline-secondary search-reset-btn">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ url()->current() }}" class="form-inline">
                                <div class="input-group">
                                    <label for="perPage" class="input-group-text">Tampilkan</label>
                                    <select name="perPage" id="perPage" class="form-select per-page-selector" onchange="this.form.submit()">
                                        <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('perPage') == 10 || !request('perPage') ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                    <span class="input-group-text">data per halaman</span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tiket-table" class="table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Tiket</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Lokasi</th>
                                    <th>Deskripsi</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tikets as $index => $tiket)
                                <tr>
                                    <td>{{ $tikets->firstItem() + $index }}</td>
                                    <td>
                                        @if($tiket->gambar)
                                            <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->namaTiket }}" width="800" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $tiket->namaTiket }}</td>
                                    <td>Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                                    <td>{{ $tiket->stok }}</td>
                                    <td>
                                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($tiket->status)) }}">
                                            {{ $tiket->status }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($tiket->tanggal_pelaksanaan)->format('d M Y') }}</td>
                                    <td>{{ $tiket->tanggal_selesai_pelaksanaan ? \Carbon\Carbon::parse($tiket->tanggal_selesai_pelaksanaan)->format('d M Y') : '-' }}</td>
                                    <td>{{ $tiket->waktu_mulai ? \Carbon\Carbon::parse($tiket->waktu_mulai)->format('H:i') : '-' }}</td>
                                    <td>{{ $tiket->waktu_selesai ? \Carbon\Carbon::parse($tiket->waktu_selesai)->format('H:i') : '-' }}</td>
                                    <td>{{ $tiket->lokawebsi }}</td>
                                    <td class="deskripsi-cell">{{ $tiket->deskripsi }}</td>
                                    <td>{{ $tiket->regency->province->name ?? '-' }}</td>
                                    <td>{{ $tiket->regency->name ?? '-' }}</td>
                                    <td class="action-buttons">
                                        <a href="/tikets/{{$tiket->id}}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> <span class="d-none d-md-inline">Detail</span>
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="editModal({{ $tiket->id }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $tiket->id }})">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="14" class="text-center">
                                        Tidak ada data tiket ditemukan
                                        @if(request('search'))
                                            untuk "<strong>{{ request('search') }}</strong>"
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($tikets->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">
                            Menampilkan {{ $tikets->firstItem() }} - {{ $tikets->lastItem() }} dari {{ $tikets->total() }}
                            @if(request('search'))
                                hasil pencarian untuk "<strong>{{ request('search') }}</strong>"
                            @else
                                data
                            @endif
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($tikets->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tikets->previousPageUrl() }}&perPage={{ request('perPage', 10) }}&search={{ request('search', '') }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @php
                                    $current = $tikets->currentPage();
                                    $last = $tikets->lastPage();
                                    $start = max($current - 1, 1);
                                    $end = min($current + 1, $last);

                                    // Adjust start and end when near boundaries
                                    if ($current <= 3) {
                                        $start = 1;
                                        $end = min(4, $last);
                                    }

                                    if ($current >= $last - 2) {
                                        $start = max($last - 3, 1);
                                        $end = $last;
                                    }
                                @endphp

                                {{-- Always show first page --}}
                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tikets->url(1) }}&perPage={{ request('perPage', 10) }}&search={{ request('search', '') }}">1</a>
                                    </li>
                                    @if ($start > 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                @endif

                                {{-- Middle pages --}}
                                @for ($page = $start; $page <= $end; $page++)
                                    @if ($page == $tikets->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $tikets->url($page) }}&perPage={{ request('perPage', 10) }}&search={{ request('search', '') }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- Always show last page --}}
                                @if ($end < $last)
                                    @if ($end < $last - 1)
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tikets->url($last) }}&perPage={{ request('perPage', 10) }}&search={{ request('search', '') }}">{{ $last }}</a>
                                    </li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($tikets->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tikets->nextPageUrl() }}&perPage={{ request('perPage', 10) }}&search={{ request('search', '') }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tambah/Edit Tiket -->
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
                                    <textarea class="form-control" id="lokawebsi" name="lokawebsi" rows="3"></textarea>

                                    <div class="invalid-feedback" id="lokasiError"></div>
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

    <!-- Modal untuk Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-trash-alt"></i> Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus tiket ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmDelete" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const tiketModal = new bootstrap.Modal(document.getElementById('tiketModal'));
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        let deleteId = null;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": 5000
        };

        function loadRegencies(provinceId, selectedRegencieId) {
            if (!provinceId) {
                $('#regencie_id').html('<option value="">Pilih Kabupaten/Kota</option>');
                return;
            }

            showLoading();
            $.get(`/get-Regencie/${provinceId}`, function(data) {
                let options = '<option value="">Pilih Kabupaten/Kota</option>';
                data.forEach(function(regencie) {
                    const selected = selectedRegencieId == regencie.id ? 'selected' : '';
                    options += `<option value="${regencie.id}" ${selected}>${regencie.name}</option>`;
                });
                $('#regencie_id').html(options);
            }).fail(function(xhr) {
                toastr.error('Gagal memuat data Kabupaten/Kota');
            }).always(function() {
                hideLoading();
            });
        }

        $('#province_id').change(function() {
            const provinceId = $(this).val();
            loadRegencies(provinceId);
        });

        function openModal() {
            resetForm();
            $('#modalTitle').html('<i class="fas fa-plus-circle"></i> Tambah Tiket');
            $('#gambarLabel').addClass('required-field');
            $('#gambar').prop('required', true);
            tiketModal.show();
        }

        function editModal(id) {
            showLoading();
            resetForm();

            const currentParams = new URLSearchParams(window.location.search);
            const searchParams = currentParams.get('search') ? `&search=${currentParams.get('search')}` : '';
            const perPageParams = currentParams.get('perPage') ? `&perPage=${currentParams.get('perPage')}` : '';

            $.get(`/tikets/${id}/edit?${searchParams}${perPageParams}`, function(data) {

               $('#tiketId').val(data.tiket.id);
                $('#namaTiket').val(data.tiket.namaTiket);
                $('#harga').val(data.tiket.harga);
                $('#stok').val(data.tiket.stok);
                $('#status').val(data.tiket.status);
                $('#tanggal_pelaksanaan').val(data.tiket.tanggal_pelaksanaan);
                $('#tanggal_selesai_pelaksanaan').val(data.tiket.tanggal_selesai_pelaksanaan);
                $('#lokawebsi').val(data.tiket.lokawebsi);
                $('#waktu_mulai').val(data.tiket.waktu_mulai.substring(0, 5));
                $('#waktu_selesai').val(data.tiket.waktu_selesai.substring(0, 5));
                $('#deskripsi').val(data.tiket.deskripsi);


                if (data.province_id) {
                    $('#province_id').val(data.province_id);
                    loadRegencies(data.province_id, data.tiket.regencie_id);
                }

                if (data.tiket.gambar) {
                    $('#previewGambar').attr('src', `/storage/${data.tiket.gambar}`).removeClass('d-none');
                }

                $('#modalTitle').html('<i class="fas fa-edit"></i> Edit Tiket');
                $('#gambarLabel').removeClass('required-field');
                $('#gambar').prop('required', false);

                tiketModal.show();
            }).fail(function(xhr) {
                toastr.error('Gagal memuat data tiket: ' + xhr.responseJSON?.message);
            }).always(function() {
                hideLoading();
            });
        }

        function resetForm() {
            const currentId = $('#tiketId').val();
            $('#tiketForm')[0].reset();
            $('#tiketId').val(currentId || '');
            $('#previewGambar').addClass('d-none');
            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');
            $('#regencie_id').html('<option value="">Pilih Kabupaten/Kota</option>');
        }

        $('#gambar').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024 * 1024 * 1024 ) {
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

        $('#tiketForm').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = $('#tiketId').val();

            if (id) {
                formData.append('_method', 'PUT');
            }

            const currentParams = new URLSearchParams(window.location.search);
            const searchParams = currentParams.get('search') ? `&search=${currentParams.get('search')}` : '';
            const perPageParams = currentParams.get('perPage') ? `&perPage=${currentParams.get('perPage')}` : '';

            const url = id ? `/tikets/${id}?${searchParams}${perPageParams}` : `/tikets?${searchParams}${perPageParams}`;

            $('.invalid-feedback').text('');
            $('.form-control').removeClass('is-invalid');
            $('#saveButton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            showLoading();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.message);
                    tiketModal.hide();
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    $('#saveButton').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            $(`#${field}`).addClass('is-invalid');
                            $(`#${field}Error`).text(errors[field][0]);
                        }
                        toastr.warning('Terdapat kesalahan pada inputan');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan data');
                    }
                },
                complete: function() {
                    hideLoading();
                }
            });
        });

        function confirmDelete(id) {
            deleteId = id;
            deleteModal.show();
        }

        $('#confirmDelete').click(function() {
            if (!deleteId) return;

            showLoading();
            $('#confirmDelete').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menghapus...');

            const currentPage = {{ $tikets->currentPage() }};
            const lastPage = {{ $tikets->lastPage() }};
            const isLastPage = currentPage === lastPage;
            const isOnlyOneItemInPage = $('#tiket-table tbody tr').length === 1;
            const isFirstPage = currentPage === 1;

            const currentParams = new URLSearchParams(window.location.search);
            const searchParams = currentParams.get('search') ? `&search=${currentParams.get('search')}` : '';
            const perPageParams = currentParams.get('perPage') ? `&perPage=${currentParams.get('perPage')}` : '';

            $.ajax({
                url: `/tikets/${deleteId}`,
                type: 'POST',
                data: {
                    _method: 'DELETE'
                },
                success: function(response) {
                    toastr.success(response.message);
                    deleteModal.hide();

                    if (isLastPage && isOnlyOneItemInPage && !isFirstPage) {
                        window.location.href = `{{ $tikets->url($tikets->currentPage() - 1) }}${perPageParams}${searchParams}`;
                    } else {
                        window.location.href = `{{ url()->current() }}?page={{ $tikets->currentPage() }}${perPageParams}${searchParams}`;
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Gagal menghapus tiket');
                    $('#confirmDelete').prop('disabled', false).html('<i class="fas fa-trash-alt"></i> Hapus');
                },
                complete: function() {
                    hideLoading();
                    deleteId = null;
                }
            });
        });
        const sidebar = document.querySelector('.sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        // Toggle sidebar
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        // Tutup sidebar saat mengklik di luar sidebar pada layar kecil
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Handle resize event
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
            }
        });

        function showLoading() {
            $('#loadingOverlay').css('display', 'flex');
        }

        function hideLoading() {
            $('#loadingOverlay').fadeOut();
        }
    </script>
</body>
</html>

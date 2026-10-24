<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Supplier - Inventory Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { width: 260px; position: fixed; top: 0; bottom: 0; left: 0; background-color: #0f172a; color: #fff; padding: 20px 15px; z-index: 1000; }
        .main-wrapper { margin-left: 260px; padding: 30px; }
        .nav-link-custom { display: flex; align-items: center; gap: 12px; color: #94a3b8; padding: 12px 15px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: all 0.3s; }
        .nav-link-custom:hover, .nav-link-custom.active { background-color: #1e293b; color: #38bdf8; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="d-flex align-items-center gap-2 px-2 mb-4">
                <i class="fa-solid fa-boxes-stacked text-info fs-3"></i>
                <span class="fs-5 fw-bold text-white">INVENTORY PRO</span>
            </div>

            <div class="px-2 mb-2 text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">Menu Utama</div>
            <a href="{{ url('/products') }}" class="nav-link-custom mb-1">
                <i class="fa-solid fa-box-archive"></i>
                <span>Daftar Barang</span>
            </a>
            <a href="{{ url('/suppliers') }}" class="nav-link-custom active mb-1">
                <i class="fa-solid fa-truck-field"></i>
                <span>Master Supplier</span>
            </a>
        </div>

        <div>
            <form action="{{ route('logout') }}" method="POST" class="px-2 mt-4">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 rounded-3 py-2 fw-semibold">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar / Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Master Data Supplier</h3>
                <p class="text-muted mb-0">Kelola informasi mitra dan pemasok barang toko.</p>
            </div>
            <button class="btn btn-primary rounded-3 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahSupplier">
                <i class="fa-solid fa-plus me-1"></i> Tambah Supplier Baru
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i>Gagal Menyimpan Data:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-custom">
            <div class="card-header bg-white py-3 border-0">
                <form action="{{ url('/suppliers') }}" method="GET" class="row g-2">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari nama supplier atau kontak..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-semibold"><i class="fa-solid fa-filter me-1"></i> Cari</button>
                        @if(request('search'))
                            <a href="{{ url('/suppliers') }}" class="btn btn-light border"><i class="fa-solid fa-rotate me-1"></i> Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">NO</th>
                                <th>NAMA SUPPLIER</th>
                                <th>KONTAK / HP</th>
                                <th>ALAMAT</th>
                                <th class="text-center">AKSI MANAGEMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $columns = \Illuminate\Support\Facades\Schema::getColumnListing('suppliers');
                                $nameCol = 'nama_supplier';
                                foreach ($columns as $col) { if (in_array(strtolower($col), ['nama_supplier', 'nama', 'name'])) { $nameCol = $col; break; } }
                                
                                $phoneCol = 'kontak';
                                foreach ($columns as $col) {
                                    $l = strtolower($col);
                                    if (str_contains($l, 'kontak') || str_contains($l, 'telp') || str_contains($l, 'phone') || str_contains($l, 'hp') || str_contains($l, 'telepon')) { $phoneCol = $col; break; }
                                }
                                if (!in_array($phoneCol, $columns)) {
                                    foreach ($columns as $col) { if (!in_array($col, ['id', $nameCol, 'alamat', 'address', 'created_at', 'updated_at'])) { $phoneCol = $col; break; } }
                                }

                                $addrCol = 'alamat';
                                foreach ($columns as $col) { if (in_array(strtolower($col), ['alamat', 'address'])) { $addrCol = $col; break; } }
                            @endphp

                            @forelse($suppliers as $key => $supplier)
                                @php
                                    $namaSup = $supplier->$nameCol ?? '-';
                                    $kontakSup = $supplier->$phoneCol ?? '-';
                                    $alamatSup = $supplier->$addrCol ?? '-';
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $key + 1 }}</td>
                                    <td class="fw-semibold text-primary">{{ $namaSup }}</td>
                                    <td>{{ $kontakSup }}</td>
                                    <td>{{ $alamatSup }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-warning rounded-2" data-bs-toggle="modal" data-bs-target="#modalEditSupplier{{ $supplier->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Supplier -->
                                <div class="modal fade" id="modalEditSupplier{{ $supplier->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Supplier</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Supplier</label>
                                                        <input type="text" name="nama_supplier" class="form-control" value="{{ $namaSup }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kontak / HP</label>
                                                        <input type="text" name="kontak" class="form-control" value="{{ $kontakSup }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea name="alamat" class="form-control" rows="3" required>{{ $alamatSup }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-truck-field fs-1 mb-2 d-block"></i>
                                        Data supplier tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Supplier -->
    <div class="modal fade" id="modalTambahSupplier" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Supplier Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('suppliers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" name="nama_supplier" class="form-control" placeholder="Contoh: PT Sinar Jaya" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak / HP</label>
                            <input type="text" name="kontak" class="form-control" placeholder="08123456789" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap supplier" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
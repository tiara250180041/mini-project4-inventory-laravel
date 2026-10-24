<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang - Inventory Pro</title>
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
            <a href="{{ url('/products') }}" class="nav-link-custom active mb-1">
                <i class="fa-solid fa-box-archive"></i>
                <span>Daftar Barang</span>
            </a>
            <a href="{{ url('/suppliers') }}" class="nav-link-custom mb-1">
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
                <h3 class="fw-bold mb-1">Daftar Barang Inventaris</h3>
                <p class="text-muted mb-0">Kelola stok produk dan informasi barang toko.</p>
            </div>
            <button class="btn btn-primary rounded-3 px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                <i class="fa-solid fa-plus me-1"></i> Tambah Barang Baru
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
                <form action="{{ url('/products') }}" method="GET" class="row g-2">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari nama barang..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" class="form-select bg-light">
                            <option value="">-- Filter Semua Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori ?? $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-semibold"><i class="fa-solid fa-filter me-1"></i> Cari</button>
                        @if(request('search') || request('category_id'))
                            <a href="{{ url('/products') }}" class="btn btn-light border"><i class="fa-solid fa-rotate me-1"></i> Reset</a>
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
                                <th>NAMA BARANG</th>
                                <th>KATEGORI</th>
                                <th>HARGA</th>
                                <th>STOK STATUS</th>
                                <th class="text-center">AKSI MANAGEMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $key => $product)
                                @php
                                    $namaItem = $product->name ?? $product->nama_produk ?? $product->nama_barang ?? $product->nama ?? '-';
                                    $hargaItem = $product->price ?? $product->harga ?? 0;
                                    $stokItem = $product->stock ?? $product->stok ?? $product->quantity ?? 0;
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $key + 1 }}</td>
                                    <td class="fw-semibold text-primary">{{ $namaItem }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $product->category->nama_kategori ?? $product->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-success">Rp {{ number_format($hargaItem, 0, ',', '.') }}</td>
                                    <td>
                                        @if($stokItem <= 5)
                                            <span class="badge bg-danger text-white">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $stokItem }} unit (Kritis)
                                            </span>
                                        @elseif($stokItem <= 10)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $stokItem }} unit (Menipis)
                                            </span>
                                        @else
                                            <span class="badge bg-success text-white">
                                                {{ $stokItem }} unit
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-outline-warning rounded-2" data-bs-toggle="modal" data-bs-target="#modalEditProduk{{ $product->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Edit Produk -->
                                <div class="modal fade" id="modalEditProduk{{ $product->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Edit Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('products.update', $product->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Barang</label>
                                                        <input type="text" name="nama_produk" class="form-control" value="{{ $namaItem }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Kategori</label>
                                                        <select name="category_id" class="form-select" required>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id || $product->kategori_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->nama_kategori ?? $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Harga (Rp)</label>
                                                        <input type="number" name="harga" class="form-control" value="{{ $hargaItem }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Stok</label>
                                                        <input type="number" name="stok" class="form-control" value="{{ $stokItem }}" required>
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
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fs-1 mb-2 d-block"></i>
                                        Data barang tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Laptop Asus" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_kategori ?? $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="1000000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control" placeholder="10" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
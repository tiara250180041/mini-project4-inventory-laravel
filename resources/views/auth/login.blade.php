<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #0f172a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-login { border: none; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card card-login p-4 bg-white" style="width: 380px;">
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-info text-white rounded-circle mb-2" style="width: 50px; height: 50px;">
                <i class="fa-solid fa-boxes-stacked fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark">INVENTORY PRO</h4>
            <p class="text-muted small">Silakan login untuk mengakses aplikasi</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small py-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show small py-2" role="alert">
                {{ $errors->first() }}
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold text-secondary small">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="admin@gmail.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-secondary small">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mb-2">
                <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk Sekarang
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
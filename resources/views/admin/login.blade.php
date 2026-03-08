<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin XEPPO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
        }
        .logo-text {
            font-size: 2rem;
            font-weight: 800;
            color: #8B0000; /* Warna XEPPO */
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #8B0000;
            color: white;
            width: 100%;
            padding: 10px;
            font-weight: bold;
            border-radius: 8px;
        }
        .btn-login:hover {
            background-color: #A50000;
            color: white;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-text">XEPPO</div>
    
    @if(session('error'))
        <div class="alert alert-danger py-2 small text-center">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.login.post') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label text-muted">Alamat Email</label>
            <input type="email" name="email" class="form-control" placeholder="admin@admin.com" required autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label text-muted">Password</label>
            <input type="password" name="password" class="form-control" placeholder="password" required>
        </div>

        <button type="submit" class="btn btn-login">
            MASUK DASHBOARD
        </button>
    </form>
    
    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-muted small">← Kembali ke Halaman Utama</a>
    </div>
</div>

</body>
</html>
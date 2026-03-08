<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>XEPPO - Restoran App</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Variabel Warna Utama XEPPO */
        :root {
            --xepo-red: #8B0000;
            --xepo-red-light: #FFF0F0;
            --xepo-yellow: #FFD700;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Styling Umum Tombol */
        .btn-xepo {
            background-color: var(--xepo-red);
            color: white;
            border-radius: 25px;
            font-weight: bold;
            border: none;
        }
        .btn-xepo:hover {
            background-color: #A50000;
            color: white;
        }

        /* Kontainer Utama (Mobile View feel) */
        .main-container {
            max-width: 480px; /* Lebar HP */
            margin: 0 auto;
            background-color: white;
            min-height: 100vh;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            position: relative;
        }
    </style>
    
    <!-- Tempat menaruh CSS tambahan per halaman -->
    @yield('styles')
</head>
<body>

    <!-- Pembungkus utama agar tampilan seperti di HP -->
    <div class="main-container">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Tempat menaruh JS tambahan per halaman -->
    @yield('scripts')
</body>
</html>
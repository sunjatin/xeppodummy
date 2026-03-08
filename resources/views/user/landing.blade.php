@extends('layouts.app')

@section('styles')
<style>
    .jumbotron-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 20px;
    }
    .bottom-nav-xepo {
        background-color: var(--xepo-red);
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1000;
    }
    /* Agar konten tidak ketutupan nav bawah */
    body { padding-bottom: 70px; }
</style>
@endsection

@section('content')

<div class="p-3">
    <!-- HEADER -->
    <header class="d-flex justify-content-between align-items-center py-2 mb-3">
        <h2 class="fw-bolder mb-0" style="color: var(--xepo-red);">RESTO</h2>
        <div class="d-flex gap-3">
            <i class="fas fa-bell fs-5 text-dark"></i>
            <i class="fas fa-user-circle fs-5 text-dark"></i>
        </div>
    </header>

        <!-- JUMBOTRON / HERO SECTION -->
    <section class="mb-4">
        <div class="position-relative rounded-4 overflow-hidden shadow">
            <!-- Ubah bagian SRC gambar di sini -->
            <img src="{{ isset($jumbotron_image) && $jumbotron_image ? asset('storage/'.$jumbotron_image) : 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80' }}" 
                 class="w-100 jumbotron-img" 
                 alt="Promo">
            
            <!-- Overlay Content -->
            <div class="position-absolute bottom-0 start-0 p-3 w-100" style="background: linear-gradient(to top, rgba(139,0,0,0.9), transparent);">
                <!-- Ubah bagian Teks di sini -->
                <h4 class="text-white fw-bold">{{ $jumbotron_title ?? 'Be Ready for Iftar' }}</h4>
                <p class="text-white-50 small mb-2">{{ $jumbotron_subtitle ?? 'Segera pesan tempat.' }}</p>
                
                <a href="{{ route('reservasi.create') }}" class="btn btn-light text-danger fw-bold rounded-pill px-4 shadow">
                    RESERVASI SEKARANG
                </a>
            </div>
        </div>
    </section>

    <!-- ALERT SUKSES -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- QUICK ACTIONS -->
    <section class="mb-4">
        <div class="row g-2 text-center">
            <div class="col">
                <a href="{{ route('reservasi.create') }}" class="btn btn-outline-danger rounded-pill w-100 py-2 fw-semibold">Booking</a>
            </div>
            <div class="col">
                <button class="btn btn-outline-secondary rounded-pill w-100 py-2 fw-semibold disabled">Menu Makan</button>
            </div>
            <div class="col">
                <button class="btn btn-outline-secondary rounded-pill w-100 py-2 fw-semibold disabled">Menu Minuman</button>
            </div>
        </div>
    </section>

    <!-- MENU LIST -->
    <section>
        <h5 class="fw-bold mb-3">Menu Kami</h5>
        <div class="row g-3">
            @foreach($menus as $menu)
            <div class="col-6">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <img src="{{ $menu->image ? asset('storage/'.$menu->image) : 'https://via.placeholder.com/300' }}" class="card-img-top" style="height:120px; object-fit:cover;" alt="{{ $menu->name }}">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 text-truncate">{{ $menu->name }}</h6>
                        <p class="card-text text-danger fw-bold small mb-0">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

<!-- BOTTOM NAVIGATION -->
<nav class="navbar bottom-nav-xepo py-2 shadow-lg">
    <div class="container d-flex justify-content-around">
        <a href="#" class="text-white-50 text-center text-decoration-none">
            <i class="fas fa-shopping-bag fs-5"></i>
            <div><small style="font-size:9px;">Order</small></div>
        </a>
        <!-- TOMBOL BOOKING BAWAH -->
        <a href="{{ route('reservasi.create') }}" class="text-warning text-center text-decoration-none fw-bold">
            <i class="fas fa-calendar-alt fs-5"></i>
            <div><small style="font-size:9px;">Booking</small></div>
        </a>
        <a href="#" class="text-white-50 text-center text-decoration-none">
            <i class="fas fa-map-marker-alt fs-5"></i>
            <div><small style="font-size:9px;">Check In</small></div>
        </a>
    </div>
</nav>

@endsection
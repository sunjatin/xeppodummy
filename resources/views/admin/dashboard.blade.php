@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2 class="mt-4 mb-4">Dashboard</h2>
    
    <div class="row">
        <!-- Card Jumlah Menu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Menu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Menu::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Reservasi Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Reservasi Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Reservation::where('status', 'pending')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Reservasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Reservasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Reservation::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Reservasi Terbaru</h6>
                </div>
                <div class="card-body">
                    <p>Halaman ini menampilkan ringkasan data. Silakan gunakan menu di samping kiri untuk mengelola data.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
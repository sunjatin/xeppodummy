@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Data Reservasi</h3>
    <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari nama/telp..." value="{{ request('search') }}">
        <button class="btn btn-outline-secondary">Cari</button>
    </form>
</div>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Telp</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                <tr>
                    <td>{{ $r->customer_name }}</td>
                    <td>{{ $r->phone_number }}</td>
                    <td>{{ $r->reservation_date }}</td>
                    <td>Rp {{ number_format($r->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $r->status == 'pending' ? 'warning' : ($r->status == 'confirmed' ? 'success' : 'danger') }}">
                            {{ $r->status }}
                        </span>
                    </td>
                    <td>
                        <!-- ================== TAMBAHAN BARU: TOMBOL STRUK ================== -->
                        <a href="{{ route('admin.reservations.struk', $r->id) }}" target="_blank" class="btn btn-sm btn-info mb-1" title="Download Struk">
                            <i class="fas fa-print"></i>
                        </a>
                        <!-- ================================================================ -->

                        <a href="{{ route('admin.reservations.edit', $r->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                        
                        <form action="{{ route('admin.reservations.destroy', $r->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger mb-1">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $reservations->links() }}
    </div>
</div>
@endsection
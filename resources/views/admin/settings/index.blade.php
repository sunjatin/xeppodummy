@extends('admin.layout')

@section('content')
<h3>Pengaturan Website</h3>
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <!-- Jumbotron -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Jumbotron Homepage</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="jumbotron_title" class="form-control" value="{{ $settings['jumbotron_title'] ?? 'Be Ready for Iftar' }}">
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="jumbotron_subtitle" class="form-control">{{ $settings['jumbotron_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gambar Saat Ini</label><br>
                        @if(isset($settings['jumbotron_image']))
                            <img src="{{ asset('storage/'.$settings['jumbotron_image']) }}" width="200">
                        @endif
                        <input type="file" name="jumbotron_image" class="form-control mt-2">
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembayaran -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Informasi Pembayaran</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>No. Rekening Transfer</label>
                        <input type="text" name="bank_account" class="form-control" value="{{ $settings['bank_account'] ?? '1234567890' }}">
                    </div>
                    <div class="mb-3">
                        <label>Nama Bank</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ $settings['bank_name'] ?? 'Bank BCA' }}">
                    </div>
                    <div class="mb-3">
                        <label>Nama Pemilik</label>
                        <input type="text" name="bank_holder" class="form-control" value="{{ $settings['bank_holder'] ?? 'Xeppo' }}">
                    </div>
                    <div class="mb-3">
                        <label>Gambar QRIS</label><br>
                        @if(isset($settings['qris_image']))
                            <img src="{{ asset('storage/'.$settings['qris_image']) }}" width="150">
                        @endif
                        <input type="file" name="qris_image" class="form-control mt-2">
                    </div>
                    <div class="mb-3">
                        <label>No. WhatsApp (Konfirmasi)</label>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '6281234567890' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary btn-lg">Simpan Pengaturan</button>
</form>
@endsection
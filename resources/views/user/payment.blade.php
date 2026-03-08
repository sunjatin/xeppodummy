@extends('layouts.app')

@section('styles')
<style>
    /* Styling khusus Struk Thermal 58mm */
    .receipt-container {
        width: 100%;
        max-width: 320px; /* Lebar layar HP, tapi akan diresize saat print */
        margin: 0 auto;
        background: white;
        padding: 15px;
        font-family: 'Courier New', Courier, monospace; /* Font dot matrix */
        font-size: 12px;
        border: 1px dashed #ccc;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #receipt-area, #receipt-area * {
            visibility: visible;
        }
        #receipt-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 58mm; /* Ukuran struk thermal standar */
            font-size: 10px;
            padding: 0;
            margin: 0;
            border: none;
        }
        /* Sembunyikan elemen non-cetak */
        .no-print {
            display: none;
        }
    }
    
    .separator {
        border-bottom: 1px dashed #000;
        margin: 10px 0;
    }
    .payment-info-box {
        background: #fff0f0;
        border: 2px solid #ffcccc;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')

<div class="container py-4">
    <!-- Area Struk -->
    <div id="receipt-area" class="receipt-container shadow-sm mb-4">
        <!-- Header Struk -->
        <div class="text-center">
            <h4 class="fw-bolder" style="color: var(--xepo-red);">RESTO</h4>
            <small>Restoran & Cafe</small><br>
            <small>Jl. Contoh Alamat No. 123</small>
        </div>
        <div class="separator"></div>

        <!-- Info Pemesan -->
        <table width="100%">
            <tr>
                <td>Nama</td>
                <td style="text-align: right;">{{ $reservation->customer_name }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td style="text-align: right;">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Jam</td>
                <td style="text-align: right;">{{ $reservation->reservation_time }}</td>
            </tr>
            <tr>
                <td>Tamu</td>
                <td style="text-align: right;">{{ $reservation->number_of_guests }} Orang</td>
            </tr>
        </table>
        <div class="separator"></div>

        <!-- Detail Pesanan -->
        <table width="100%">
            @foreach($reservation->menus as $item)
            <tr>
                <td colspan="2">{{ $item['name'] }}</td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>
        <div class="separator"></div>

        <!-- Total -->
        <table width="100%">
            <tr>
                <td><strong>TOTAL</strong></td>
                <td style="text-align: right;"><strong>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
        <div class="separator"></div>
        
        <div class="text-center">
            <small>Terima kasih telah memesan!</small>
        </div>
    </div>

    <!-- Area Info Pembayaran -->
    <div class="payment-info-box no-print">
        <h6 class="fw-bold mb-3 text-center">Instruksi Pembayaran</h6>
        
        @if($reservation->payment_method == 'transfer')
            <div class="text-center mb-3">
                <p class="mb-1 small text-muted">Silakan transfer ke rekening berikut:</p>
                <h5 class="fw-bold text-danger">Bank BCA - 1234567890</h5>
                <p class="fw-bold">a.n. Pemilik Restoran</p>
            </div>
        @else
            <div class="text-center mb-3">
                <p class="mb-1 small text-muted">Scan QR Code berikut:</p>
                <!-- Ganti dengan gambar QR Code asli anda -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/220px-QR_code_for_mobile_English_Wikipedia.svg.png" style="width: 150px;" alt="QRIS">
            </div>
        @endif

        <div class="d-grid gap-2 mt-4">
            <!-- Tombol Konfirmasi (WA) -->
            <a href="https://wa.me/6281312016351?text=Halo%20XEPPO,%20saya%20sudah%20booking%20atas%20nama%20{{ urlencode($reservation->customer_name) }}%20dengan%20total%20Rp%20{{ number_format($reservation->total_price, 0, ',', '.') }}.%20Mohon%20dikonfirmasi." 
               target="_blank"
               id="btn-confirm-wa"
               class="btn btn-success py-2 rounded-pill fw-bold"
               onclick="enableFinishButton()">
                <i class="fab fa-whatsapp me-2"></i>Konfirmasi via WhatsApp
            </a>

            <!-- Tombol Selesai (Disabled awalnya) -->
            <button id="btn-finish" class="btn btn-secondary py-2 rounded-pill fw-bold" disabled onclick="downloadAndFinish()">
                Selesai & Download Struk
            </button>
        </div>
    </div>
</div>

<script>
    function enableFinishButton() {
        // Aktifkan tombol selesai setelah klik WA
        // Pakai timeout agar sedikit delay
        setTimeout(() => {
            document.getElementById('btn-finish').disabled = false;
            document.getElementById('btn-finish').classList.remove('btn-secondary');
            document.getElementById('btn-finish').classList.add('btn-danger');
        }, 1000);
    }

    function downloadAndFinish() {
        // 1. Trigger Print (Save as PDF)
        window.print();
        
        // 2. Redirect ke Home setelah print dialog ditutup
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 500);
    }
</script>
@endsection
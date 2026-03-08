<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Reservasi #{{ $reservation->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .container {
            width: 58mm; /* Ukuran struk thermal */
            margin: 0 auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .separator {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        .fw-bold { font-weight: bold; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center">
        <h3 style="margin:0; font-size: 16px;">RESTO</h3>
        <small>Restoran & Cafe</small><br>
        <small>Jl. Contoh Alamat No. 123</small>
    </div>
    
    <div class="separator"></div>

    <table width="100%">
        <tr>
            <td>Nama</td>
            <td class="text-right">{{ $reservation->customer_name }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Jam</td>
            <td class="text-right">{{ $reservation->reservation_time }}</td>
        </tr>
        <tr>
            <td>Tamu</td>
            <td class="text-right">{{ $reservation->number_of_guests }} Orang</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-right">{{ strtoupper($reservation->status) }}</td>
        </tr>
    </table>

    <div class="separator"></div>

    <table width="100%">
        @foreach($reservation->menus as $item)
        <tr>
            <td colspan="2">{{ $item['name'] }}</td>
        </tr>
        <tr>
            <td style="padding-left: 10px;">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="separator"></div>

    <table width="100%">
        <tr>
            <td class="fw-bold">TOTAL</td>
            <td class="text-right fw-bold">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td>
        </tr>
    </table>
    
    <div class="separator"></div>
    <div class="text-center">
        <small>Terima kasih telah memesan!</small><br>
        <small>Admin: {{ now()->format('d/m/Y H:i') }}</small>
    </div>
</div>F

<div class="no-print text-center mt-4">
    <button onclick="window.print()" class="btn btn-primary">Print / Save as PDF</button>
    <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
</div>

</body>
</html>
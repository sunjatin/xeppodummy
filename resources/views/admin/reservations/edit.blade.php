@extends('admin.layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-white fw-bold">
                Edit Reservasi #{{ $reservation->id }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST" id="reservationForm">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pemesan</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ $reservation->customer_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone_number" class="form-control" value="{{ $reservation->phone_number }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="2" required>{{ $reservation->address }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="reservation_date" class="form-control" value="{{ $reservation->reservation_date }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jam</label>
                            <input type="time" name="reservation_time" class="form-control" value="{{ $reservation->reservation_time }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Tamu</label>
                            <input type="number" name="number_of_guests" class="form-control" value="{{ $reservation->number_of_guests }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status Reservasi</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- SECTION: EDIT PESANAN -->
                    <div class="mb-3 border p-3 rounded bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0 fw-bold">Edit Pesanan:</h6>
                            <div class="d-flex gap-2">
                                <select id="menu-select" class="form-select form-select-sm" style="width: auto;">
                                    <option value="">-- Tambah Menu --</option>
                                    @foreach($menus as $m)
                                    <option value="{{ $m->id }}" data-price="{{ $m->price }}" data-name="{{ $m->name }}">{{ $m->name }} (Rp {{ number_format($m->price) }})</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-success btn-sm" onclick="addMenuItem()">Tambah</button>
                            </div>
                        </div>

                        <table class="table table-sm table-bordered bg-white mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>Menu</th>
                                    <th width="100">Harga</th>
                                    <th width="100">Qty</th>
                                    <th width="130">Subtotal</th>
                                    <th width="50">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="order-items">
                                @php
                                    $no = 0;
                                @endphp
                                @if($reservation->menus)
                                    @foreach($reservation->menus as $item)
                                    <tr data-id="{{ $item['id'] }}">
                                        <td>
                                            {{ $item['name'] }}
                                            <input type="hidden" name="menus[{{ $item['id'] }}][id]" value="{{ $item['id'] }}">
                                            <input type="hidden" name="menus[{{ $item['id'] }}][name]" value="{{ $item['name'] }}">
                                            <input type="hidden" name="menus[{{ $item['id'] }}][price]" value="{{ $item['price'] }}" class="item-price">
                                        </td>
                                        <td class="text-end">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>
                                            <input type="number" name="menus[{{ $item['id'] }}][qty]" value="{{ $item['qty'] }}" class="form-control form-control-sm item-qty" min="0" onchange="calculateTotal()">
                                        </td>
                                        <td class="text-end item-subtotal">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm py-0" onclick="removeItem(this)">X</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">TOTAL BARU:</td>
                                    <td class="text-end text-danger" id="grand-total">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- END SECTION -->

                    <div class="mb-3">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="notes" class="form-control" rows="2">{{ $reservation->notes }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning flex-grow-1 fw-bold">Simpan Perubahan</button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function addMenuItem() {
        var select = document.getElementById('menu-select');
        var id = select.value;
        if (!id) return;

        var name = select.options[select.selectedIndex].dataset.name;
        var price = select.options[select.selectedIndex].dataset.price;
        var priceFormatted = new Intl.NumberFormat('id-ID').format(price);

        // Cek apakah menu sudah ada
        var existingRow = document.querySelector('tr[data-id="' + id + '"]');
        if (existingRow) {
            // Jika sudah ada, tambah qty
            var qtyInput = existingRow.querySelector('.item-qty');
            qtyInput.value = parseInt(qtyInput.value) + 1;
            calculateTotal();
            select.value = "";
            return;
        }

        // Jika belum ada, buat baris baru
        var tbody = document.getElementById('order-items');
        var row = document.createElement('tr');
        row.setAttribute('data-id', id);
        row.innerHTML = `
            <td>
                ${name}
                <input type="hidden" name="menus[${id}][id]" value="${id}">
                <input type="hidden" name="menus[${id}][name]" value="${name}">
                <input type="hidden" name="menus[${id}][price]" value="${price}" class="item-price">
            </td>
            <td class="text-end">Rp ${priceFormatted}</td>
            <td>
                <input type="number" name="menus[${id}][qty]" value="1" class="form-control form-control-sm item-qty" min="1" onchange="calculateTotal()">
            </td>
            <td class="text-end item-subtotal">Rp ${priceFormatted}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm py-0" onclick="removeItem(this)">X</button>
            </td>
        `;
        tbody.appendChild(row);
        
        calculateTotal();
        select.value = ""; // Reset dropdown
    }

    function removeItem(btn) {
        var row = btn.closest('tr');
        row.remove();
        calculateTotal();
    }

    function calculateTotal() {
        var rows = document.querySelectorAll('#order-items tr');
        var grandTotal = 0;

        rows.forEach(row => {
            var price = parseFloat(row.querySelector('.item-price').value);
            var qty = parseInt(row.querySelector('.item-qty').value);
            var subtotal = price * qty;
            
            row.querySelector('.item-subtotal').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            grandTotal += subtotal;
        });

        document.getElementById('grand-total').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(grandTotal);
    }
</script>
@endsection
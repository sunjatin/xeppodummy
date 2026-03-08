<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Setting;

class ReservationController extends Controller
{
    public function create()
    {
        $menus = Menu::all();
        return view('user.reservation', compact('menus'));
    }

    public function store(Request $request)
    {
        // VALIDASI 24 JAM
        $lastReservation = Reservation::where('phone_number', $request->phone_number)
            ->where('created_at', '>=', now()->subDay()) // Cek 24 jam terakhir
            ->first();

        if ($lastReservation) {
            return back()->with('error', 'Maaf, Anda hanya bisa melakukan reservasi 1x dalam 24 jam.')->withInput();
        }

        // Validasi Dasar
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'reservation_date' => 'required|date|after:today',
            'reservation_time' => 'required',
            'payment_method' => 'required|in:qris,transfer',
            'menus' => 'required|array',
        ]);

        // 2. Proses Data Menu & Hitung Total
        $orderDetails = [];
        $totalPrice = 0;
        $hasItems = false;

        foreach ($request->menus as $item) {
            $qty = (int) $item['qty'];
            if ($qty > 0) {
                $hasItems = true;
                $subtotal = $item['price'] * $qty;
                $totalPrice += $subtotal;

                $orderDetails[] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }
        }

        // Validasi: Minimal harus pesan 1 menu
        if (!$hasItems) {
            return back()->with('error', 'Anda harus memesan minimal 1 menu.')->withInput();
        }

        // 3. Simpan ke Database
        $reservation = Reservation::create([
            'customer_name' => $request->customer_name,
            'address'       => $request->address,
            'phone_number'  => $request->phone_number,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'number_of_guests' => $request->number_of_guests ?? 1,
            'menus'         => $orderDetails, // Disimpan sebagai JSON
            'total_price'   => $totalPrice,
            'payment_method' => $request->payment_method,
            'notes'         => $request->notes,
            'status'        => 'pending'
        ]);

        // 4. Arahkan ke Halaman Pembayaran
        return redirect()->route('payment.show', $reservation->id);
    }

    // Menampilkan Halaman Pembayaran
    public function showPayment($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Ambil settings pembayaran
        $bank_name = Setting::get('bank_name');
        $bank_account = Setting::get('bank_account');
        $bank_holder = Setting::get('bank_holder');
        $qris_image = Setting::get('qris_image');
        $whatsapp = Setting::get('whatsapp_number');

        return view('user.payment', compact(
            'reservation',
            'bank_name',
            'bank_account',
            'bank_holder',
            'qris_image',
            'whatsapp'
        ));
    }
}

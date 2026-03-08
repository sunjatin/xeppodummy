<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Reservation;
use Illuminate\Http\Request;


class AdminReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::latest();

        if ($request->search) {
            $query->where('customer_name', 'like', "%{$request->search}%")
                ->orWhere('phone_number', 'like', "%{$request->search}%");
        }

        $reservations = $query->paginate(10);
        return view('admin.reservations.index', compact('reservations'));
    }

    public function edit(Reservation $reservation)
    {
        $menus = Menu::where('is_active', true)->get(); // Ambil semua menu yang aktif
        return view('admin.reservations.edit', compact('reservation', 'menus'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'customer_name' => 'required',
            'phone_number' => 'required',
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        // Proses ulang data menu jika ada perubahan
        $orderDetails = [];
        $totalPrice = 0;

        if ($request->menus) {
            foreach ($request->menus as $id => $item) {
                $qty = (int) $item['qty'];
                if ($qty > 0) {
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
        }

        $reservation->update([
            'customer_name' => $request->customer_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'number_of_guests' => $request->number_of_guests,
            'status' => $request->status,
            'notes' => $request->notes,
            'menus' => $orderDetails, // Update data menu JSON
            'total_price' => $totalPrice // Update total harga
        ]);

        return redirect()->route('admin.reservations.index')->with('success', 'Data reservasi & pesanan berhasil diupdate');
    }


    public function printStruk($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('admin.reservations.struk', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Reservasi dihapus');
    }
}

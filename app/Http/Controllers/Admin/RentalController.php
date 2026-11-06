<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Tampilkan daftar transaksi rental mobil dengan pencarian dan filter status
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Rental::with('rentalDetail.car');

        if ($status && in_array($status, ['Disewa', 'Selesai', 'Batal'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('nik_number', 'like', "%{$search}%")
                    ->orWhereHas('rentalDetail.car', function ($cq) use ($search) {
                        $cq->where('brand_model', 'like', "%{$search}%")
                           ->orWhere('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        $rentals = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $statuses = ['Disewa', 'Selesai', 'Batal'];

        return view('admin.rentals.index', compact('rentals', 'status', 'search', 'statuses'));
    }

    /**
     * Detail transaksi sewa mobil
     */
    public function show(Rental $rental)
    {
        $rental->load('rentalDetail.car');
        return view('admin.rentals.show', compact('rental'));
    }

    /**
     * Memperbarui status transaksi sewa mobil ('Disewa', 'Selesai', 'Batal')
     */
    public function updateStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:Disewa,Selesai,Batal',
        ], [
            'status.required' => 'Status transaksi wajib ditentukan.',
            'status.in' => 'Status tidak valid. Pilihan hanya: Disewa, Selesai, atau Batal.',
        ]);

        $oldStatus = $rental->status;
        $rental->update(['status' => $validated['status']]);

        return redirect()->back()->with(
            'success',
            "Status transaksi {$rental->invoice_number} berhasil diubah dari '{$oldStatus}' menjadi '{$validated['status']}'."
        );
    }
}

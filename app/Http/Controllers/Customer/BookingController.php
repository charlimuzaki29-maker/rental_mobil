<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\RentalDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Menampilkan formulir pemesanan untuk mobil tertentu
     */
    public function create(Request $request, Car $car)
    {
        $startDate = $request->query('start_date', now()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->addDay()->format('Y-m-d'));

        // Hitung estimasi awal
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();
        $diffDays = $start->diffInDays($end);
        $initialDays = max(1, $diffDays == 0 ? 1 : (int)$diffDays);
        $initialSubtotal = $initialDays * $car->rental_rate_per_day;

        return view('customer.booking', compact('car', 'startDate', 'endDate', 'initialDays', 'initialSubtotal'));
    }

    /**
     * Memproses pengajuan sewa mobil
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_name' => 'required|string|min:3|max:150',
            'nik_number' => ['required', 'string', 'regex:/^[0-9]{16}$/'],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'car_id.required' => 'Pilihan mobil wajib ditentukan.',
            'customer_name.required' => 'Nama lengkap penyewa wajib diisi.',
            'customer_name.min' => 'Nama minimal terdiri dari 3 karakter.',
            'nik_number.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik_number.regex' => 'Format NIK harus berupa 16 digit angka.',
            'start_date.required' => 'Tanggal mulai sewa wajib ditentukan.',
            'start_date.after_or_equal' => 'Tanggal mulai sewa tidak boleh sebelum hari ini.',
            'end_date.required' => 'Tanggal selesai sewa wajib ditentukan.',
            'end_date.after_or_equal' => 'Tanggal selesai sewa harus sama atau setelah tanggal mulai sewa.',
        ]);

        $car = Car::findOrFail($validated['car_id']);

        // Verifikasi ketersediaan mobil pada rentang tanggal untuk mencegah double-booking
        if (!$car->isAvailableBetween($validated['start_date'], $validated['end_date'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'availability' => 'Maaf, mobil ' . $car->brand_model . ' (' . $car->plate_number . ') tidak tersedia pada rentang tanggal tersebut karena sedang disewa. Silakan pilih tanggal atau armada lain.'
                ]);
        }

        // Kalkulasi durasi sewa (days_count) & subtotal
        $start = Carbon::parse($validated['start_date'])->startOfDay();
        $end = Carbon::parse($validated['end_date'])->startOfDay();
        $diffDays = $start->diffInDays($end);
        $daysCount = $diffDays == 0 ? 1 : (int)$diffDays;
        $subtotal = $daysCount * $car->rental_rate_per_day;

        // Simpan transaksi rental dan rincian rental_details dalam database transaction
        $rental = DB::transaction(function () use ($validated, $car, $daysCount, $subtotal) {
            $newRental = Rental::create([
                'customer_name' => $validated['customer_name'],
                'nik_number' => $validated['nik_number'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'total_price' => $subtotal,
                'status' => 'Disewa',
            ]);

            RentalDetail::create([
                'rental_id' => $newRental->id,
                'car_id' => $car->id,
                'days_count' => $daysCount,
                'subtotal' => $subtotal,
            ]);

            return $newRental;
        });

        return redirect()
            ->route('booking.success', $rental->id)
            ->with('success', 'Pengajuan rental berhasil dibuat! Mobil telah tercatat sebagai Disewa.');
    }

    /**
     * Menampilkan halaman konfirmasi / struk invoice pemesanan sewa
     */
    public function success(Rental $rental)
    {
        $rental->load(['rentalDetail.car']);

        return view('customer.success', compact('rental'));
    }
}

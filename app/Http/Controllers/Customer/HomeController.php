<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan katalog armada mobil dengan filter kategori dan ketersediaan tanggal
     */
    public function index(Request $request)
    {
        $categories = ['Sedan', 'SUV', 'MPV'];
        $selectedCategory = $request->query('category');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Car::query();

        // Filter berdasarkan kategori jika dipilih
        if ($selectedCategory && in_array($selectedCategory, $categories)) {
            $query->where('category', $selectedCategory);
        }

        // Filter berdasarkan rentang tanggal: hanya tampilkan mobil yang tidak sedang berstatus 'Disewa'
        if ($startDate && $endDate) {
            $request->validate([
                'start_date' => 'date',
                'end_date' => 'date|after_or_equal:start_date',
            ]);

            $query->availableBetween($startDate, $endDate);
        }

        $cars = $query->orderBy('rental_rate_per_day', 'asc')->get();

        return view('customer.home', compact(
            'cars',
            'categories',
            'selectedCategory',
            'startDate',
            'endDate'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;

class DashboardController extends Controller
{
    /**
     * Tampilkan ringkasan statistik dan analitik sistem rental
     */
    public function index()
    {
        $totalCars = Car::count();
        $sedanCount = Car::where('category', 'Sedan')->count();
        $suvCount = Car::where('category', 'SUV')->count();
        $mpvCount = Car::where('category', 'MPV')->count();

        $activeRentals = Rental::where('status', 'Disewa')->count();
        $completedRentals = Rental::where('status', 'Selesai')->count();
        $cancelledRentals = Rental::where('status', 'Batal')->count();
        $totalRentals = Rental::count();

        $totalRevenue = Rental::where('status', '!=', 'Batal')->sum('total_price');

        $recentRentals = Rental::with('rentalDetail.car')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalCars',
            'sedanCount',
            'suvCount',
            'mpvCount',
            'activeRentals',
            'completedRentals',
            'cancelledRentals',
            'totalRentals',
            'totalRevenue',
            'recentRentals'
        ));
    }
}

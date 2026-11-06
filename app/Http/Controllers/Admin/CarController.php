<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Tampilkan daftar seluruh armada mobil dengan pencarian dan filter
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');

        $query = Car::withCount(['rentalDetails as active_rentals_count' => function ($q) {
            $q->whereHas('rental', function ($rq) {
                $rq->where('status', 'Disewa');
            });
        }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('brand_model', 'like', "%{$search}%")
                    ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        if ($category && in_array($category, ['Sedan', 'SUV', 'MPV'])) {
            $query->where('category', $category);
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.cars.index', compact('cars', 'search', 'category'));
    }

    /**
     * Formulir penambahan unit mobil baru
     */
    public function create()
    {
        $categories = ['Sedan', 'SUV', 'MPV'];
        return view('admin.cars.create', compact('categories'));
    }

    /**
     * Simpan data mobil baru ke database beserta file gambar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_model' => 'required|string|max:150',
            'category' => 'required|in:Sedan,SUV,MPV',
            'rental_rate_per_day' => 'required|integer|min:10000',
            'plate_number' => 'required|string|max:20|unique:cars,plate_number',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'brand_model.required' => 'Merek & Model mobil wajib diisi.',
            'category.required' => 'Kategori mobil wajib dipilih.',
            'rental_rate_per_day.required' => 'Tarif sewa per hari wajib diisi.',
            'rental_rate_per_day.min' => 'Tarif sewa minimal Rp 10.000.',
            'plate_number.required' => 'Nomor plat polisi wajib diisi.',
            'plate_number.unique' => 'Nomor plat polisi sudah terdaftar dalam sistem.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran file gambar maksimal 2 MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        Car::create($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Armada mobil baru berhasil ditambahkan ke sistem!');
    }

    /**
     * Formulir edit data mobil
     */
    public function edit(Car $car)
    {
        $categories = ['Sedan', 'SUV', 'MPV'];
        return view('admin.cars.edit', compact('car', 'categories'));
    }

    /**
     * Perbarui data mobil dan perbarui gambar bila ada unggahan baru
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand_model' => 'required|string|max:150',
            'category' => 'required|in:Sedan,SUV,MPV',
            'rental_rate_per_day' => 'required|integer|min:10000',
            'plate_number' => 'required|string|max:20|unique:cars,plate_number,' . $car->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'brand_model.required' => 'Merek & Model mobil wajib diisi.',
            'category.required' => 'Kategori mobil wajib dipilih.',
            'rental_rate_per_day.required' => 'Tarif sewa per hari wajib diisi.',
            'rental_rate_per_day.min' => 'Tarif sewa minimal Rp 10.000.',
            'plate_number.required' => 'Nomor plat polisi wajib diisi.',
            'plate_number.unique' => 'Nomor plat polisi sudah digunakan oleh mobil lain.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran file gambar maksimal 2 MB.',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($car->image && Storage::disk('public')->exists($car->image)) {
                Storage::disk('public')->delete($car->image);
            }
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($validated);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Data armada mobil berhasil diperbarui!');
    }

    /**
     * Hapus mobil dari sistem
     */
    public function destroy(Car $car)
    {
        // Cek apakah mobil sedang memiliki status sewa aktif
        $hasActiveRental = $car->rentalDetails()
            ->whereHas('rental', function ($q) {
                $q->where('status', 'Disewa');
            })
            ->exists();

        if ($hasActiveRental) {
            return back()->with('error', 'Mobil ini tidak dapat dihapus karena saat ini sedang berada dalam status rental aktif (Disewa).');
        }

        // Hapus file gambar jika ada
        if ($car->image && Storage::disk('public')->exists($car->image)) {
            Storage::disk('public')->delete($car->image);
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Armada mobil berhasil dihapus dari sistem!');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'brand_model',
        'category',
        'rental_rate_per_day',
        'plate_number',
        'image',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rental_rate_per_day' => 'integer',
        ];
    }

    /**
     * Relasi ke rental details
     */
    public function rentalDetails(): HasMany
    {
        return $this->hasMany(RentalDetail::class, 'car_id');
    }

    /**
     * Scope untuk menyaring mobil yang tersedia pada rentang tanggal sewa
     * Mobil dianggap TIDAK tersedia jika ada rental berstatus 'Disewa' yang tanggalnya bertabrakan.
     */
    public function scopeAvailableBetween($query, $startDate, $endDate)
    {
        return $query->whereDoesntHave('rentalDetails', function ($q) use ($startDate, $endDate) {
            $q->whereHas('rental', function ($rq) use ($startDate, $endDate) {
                $rq->where('status', 'Disewa')
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            });
        });
    }

    /**
     * Cek ketersediaan mobil spesifik pada rentang tanggal
     */
    public function isAvailableBetween($startDate, $endDate): bool
    {
        $hasConflict = $this->rentalDetails()
            ->whereHas('rental', function ($rq) use ($startDate, $endDate) {
                $rq->where('status', 'Disewa')
                    ->where('start_date', '<=', $endDate)
                    ->where('end_date', '>=', $startDate);
            })
            ->exists();

        return !$hasConflict;
    }

    /**
     * Accessor untuk URL gambar mobil dengan dukungan file upload lokal dan URL eksternal (Unsplash/CDN)
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            if (Storage::disk('public')->exists($this->image)) {
                return asset('storage/' . $this->image);
            }
        }

        // Placeholder default jika belum ada gambar diupload
        return asset('images/cars/' . strtolower($this->category) . '-placeholder.svg');
    }

    /**
     * Format harga sewa ke format mata uang Rupiah
     */
    public function getFormattedRateAttribute(): string
    {
        return 'Rp ' . number_format($this->rental_rate_per_day, 0, ',', '.');
    }
}

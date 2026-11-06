<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Rental extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'customer_name',
        'nik_number',
        'start_date',
        'end_date',
        'total_price',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_price' => 'integer',
        ];
    }

    /**
     * Relasi ke seluruh detail transaksi sewa
     */
    public function rentalDetails(): HasMany
    {
        return $this->hasMany(RentalDetail::class, 'rental_id');
    }

    /**
     * Relasi ke detail transaksi pertama (1 transaksi per rental)
     */
    public function rentalDetail(): HasOne
    {
        return $this->hasOne(RentalDetail::class, 'rental_id');
    }

    /**
     * Relasi langsung ke data mobil melalui rental detail
     */
    public function car(): HasOneThrough
    {
        return $this->hasOneThrough(
            Car::class,
            RentalDetail::class,
            'rental_id', // Foreign key on rental_details table
            'id',        // Foreign key on cars table
            'id',        // Local key on rentals table
            'car_id'     // Local key on rental_details table
        );
    }

    /**
     * Format total harga ke Rupiah
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Nomor faktur / invoice unik
     */
    public function getInvoiceNumberAttribute(): string
    {
        return 'RNT-' . str_pad((string)$this->id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * CSS class badge untuk status
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Disewa' => 'badge bg-warning text-dark',
            'Selesai' => 'badge bg-success text-white',
            'Batal' => 'badge bg-danger text-white',
            default => 'badge bg-secondary text-white',
        };
    }
}

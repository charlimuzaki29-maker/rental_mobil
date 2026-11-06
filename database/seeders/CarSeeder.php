<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds with Luxury & Exotic Sports Cars.
     */
    public function run(): void
    {
        $cars = [
            // --- Kategori Sedan (Sport Sedan & Performance Coupe) ---
            [
                'brand_model' => 'BMW M3 Competition G80',
                'category' => 'Sedan',
                'rental_rate_per_day' => 7500000,
                'plate_number' => 'B 3 M',
                'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand_model' => 'Mercedes-AMG GT Coupe',
                'category' => 'Sedan',
                'rental_rate_per_day' => 10500000,
                'plate_number' => 'B 63 AMG',
                'image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand_model' => 'Porsche Panamera Turbo S',
                'category' => 'Sedan',
                'rental_rate_per_day' => 11500000,
                'plate_number' => 'B 911 POR',
                'image' => 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=1200&q=80',
            ],

            // --- Kategori SUV (Super SUV & Luxury Performance) ---
            [
                'brand_model' => 'Lamborghini Urus Performante',
                'category' => 'SUV',
                'rental_rate_per_day' => 18000000,
                'plate_number' => 'B 1 URUS',
                'image' => 'https://images.unsplash.com/photo-1544829099-b9a0c07fad1a?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand_model' => 'Porsche Cayenne Turbo GT',
                'category' => 'SUV',
                'rental_rate_per_day' => 12500000,
                'plate_number' => 'B 999 GT',
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand_model' => 'Aston Martin DBX707',
                'category' => 'SUV',
                'rental_rate_per_day' => 15000000,
                'plate_number' => 'B 707 DBX',
                'image' => 'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80',
            ],

            // --- Kategori MPV (Luxury Sport VIP Lounge) ---
            [
                'brand_model' => 'Lexus LM 350h VIP Lounge',
                'category' => 'MPV',
                'rental_rate_per_day' => 8500000,
                'plate_number' => 'B 1 VIP',
                'image' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'brand_model' => 'Toyota Alphard Executive Lounge',
                'category' => 'MPV',
                'rental_rate_per_day' => 5000000,
                'plate_number' => 'B 888 LUX',
                'image' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80',
            ],
        ];

        foreach ($cars as $car) {
            Car::updateOrCreate(
                ['plate_number' => $car['plate_number']],
                $car
            );
        }
    }
}

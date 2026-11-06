<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Rental;
use App\Models\RentalDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RentalSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database
        $this->seed();
    }

    /**
     * Uji katalog publik dapat diakses dan menampilkan mobil
     */
    public function test_public_catalog_displays_cars(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('BMW M3 Competition G80');
        $response->assertSee('Lamborghini Urus Performante');
    }

    /**
     * Uji filter kategori bekerja
     */
    public function test_category_filter_works(): void
    {
        $response = $this->get(route('home', ['category' => 'Sedan']));

        $response->assertStatus(200);
        $response->assertSee('BMW M3 Competition G80');
        $response->assertDontSee('Aston Martin DBX707');
    }

    /**
     * Uji alur booking pelanggan dan kalkulasi otomatis
     */
    public function test_customer_booking_and_auto_calculation(): void
    {
        $car = Car::where('brand_model', 'BMW M3 Competition G80')->first();

        $bookingData = [
            'car_id' => $car->id,
            'customer_name' => 'Budi Santoso',
            'nik_number' => '3201123456780001',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'), // 2 hari
        ];

        $response = $this->post(route('booking.store'), $bookingData);

        // Harus diarahkan ke halaman invoice sukses
        $rental = Rental::where('customer_name', 'Budi Santoso')->first();
        $this->assertNotNull($rental);
        $response->assertRedirect(route('booking.success', $rental->id));

        // Verifikasi kalkulasi durasi dan total harga (2 hari x tarif harian)
        $expectedTotal = 2 * $car->rental_rate_per_day;
        $this->assertEquals($expectedTotal, $rental->total_price);
        $this->assertEquals('Disewa', $rental->status);

        // Verifikasi detail transaksi
        $detail = RentalDetail::where('rental_id', $rental->id)->first();
        $this->assertNotNull($detail);
        $this->assertEquals($car->id, $detail->car_id);
        $this->assertEquals(2, $detail->days_count);
        $this->assertEquals($expectedTotal, $detail->subtotal);

        // Akses invoice sukses
        $successResponse = $this->get(route('booking.success', $rental->id));
        $successResponse->assertStatus(200);
        $successResponse->assertSee($rental->invoice_number);
        $successResponse->assertSee('Budi Santoso');
    }

    /**
     * Uji pencegahan pemesanan ganda (double-booking) pada tanggal yang bertabrakan
     */
    public function test_prevents_double_booking_on_overlapping_dates(): void
    {
        $car = Car::first();

        // Buat rental pertama
        $start = now()->addDays(2)->format('Y-m-d');
        $end = now()->addDays(5)->format('Y-m-d');

        $this->post(route('booking.store'), [
            'car_id' => $car->id,
            'customer_name' => 'Penyewa Pertama',
            'nik_number' => '3201123456780001',
            'start_date' => $start,
            'end_date' => $end,
        ]);

        // Coba rental kedua pada tanggal yang bertabrakan (overlap)
        $overlapStart = now()->addDays(3)->format('Y-m-d');
        $overlapEnd = now()->addDays(6)->format('Y-m-d');

        $response = $this->post(route('booking.store'), [
            'car_id' => $car->id,
            'customer_name' => 'Penyewa Kedua',
            'nik_number' => '3201123456780002',
            'start_date' => $overlapStart,
            'end_date' => $overlapEnd,
        ]);

        // Harus gagal dan menampilkan error availability
        $response->assertSessionHasErrors('availability');
        $this->assertEquals(1, Rental::where('status', 'Disewa')->count());
    }

    /**
     * Uji autentikasi admin login & proteksi rute
     */
    public function test_admin_authentication_and_route_protection(): void
    {
        // Akses dashboard tanpa login -> dialihkan ke login
        $unauthResponse = $this->get(route('admin.dashboard'));
        $unauthResponse->assertRedirect(route('login'));

        // Login dengan kredensial salah
        $failLogin = $this->post(route('admin.login.submit'), [
            'email' => 'admin@rentalmobil.com',
            'password' => 'passwordsalah',
        ]);
        $failLogin->assertSessionHasErrors('email');
        $this->assertGuest();

        // Login dengan kredensial benar
        $successLogin = $this->post(route('admin.login.submit'), [
            'email' => 'admin@rentalmobil.com',
            'password' => 'admin123',
        ]);
        $successLogin->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        // Akses dashboard setelah login
        $dashboardResponse = $this->get(route('admin.dashboard'));
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Dashboard Ringkasan Operasional');

        // Logout
        $logoutResponse = $this->post(route('admin.logout'));
        $logoutResponse->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    /**
     * Uji admin dapat menambah armada mobil baru dan mengunggah foto
     */
    public function test_admin_can_create_car_with_image_upload(): void
    {
        $admin = User::first();
        Storage::fake('public');

        $image = UploadedFile::fake()->create('fortuner.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($admin)->post(route('admin.cars.store'), [
            'brand_model' => 'Toyota Fortuner 2.8 GR Sport',
            'category' => 'SUV',
            'rental_rate_per_day' => 950000,
            'plate_number' => 'B 9999 VIP',
            'image' => $image,
        ]);

        $response->assertRedirect(route('admin.cars.index'));

        $car = Car::where('plate_number', 'B 9999 VIP')->first();
        $this->assertNotNull($car);
        $this->assertEquals('Toyota Fortuner 2.8 GR Sport', $car->brand_model);
        $this->assertNotNull($car->image);

        // Verifikasi file gambar tersimpan di storage public
        Storage::disk('public')->assertExists($car->image);
    }

    /**
     * Uji admin dapat mengubah status transaksi sewa mobil
     */
    public function test_admin_can_update_rental_status(): void
    {
        $admin = User::first();
        $car = Car::first();

        // Buat data rental
        $rental = Rental::create([
            'customer_name' => 'Ahmad Dani',
            'nik_number' => '3201123456789999',
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
            'total_price' => 700000,
            'status' => 'Disewa',
        ]);

        RentalDetail::create([
            'rental_id' => $rental->id,
            'car_id' => $car->id,
            'days_count' => 2,
            'subtotal' => 700000,
        ]);

        // Admin mengubah status menjadi Selesai
        $response = $this->actingAs($admin)->patch(route('admin.rentals.status', $rental->id), [
            'status' => 'Selesai',
        ]);

        $response->assertRedirect();
        $rental->refresh();
        $this->assertEquals('Selesai', $rental->status);

        // Admin mengubah status menjadi Batal
        $this->actingAs($admin)->patch(route('admin.rentals.status', $rental->id), [
            'status' => 'Batal',
        ]);

        $rental->refresh();
        $this->assertEquals('Batal', $rental->status);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('nik_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('total_price');
            $table->enum('status', ['Disewa', 'Selesai', 'Batal'])->default('Disewa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};

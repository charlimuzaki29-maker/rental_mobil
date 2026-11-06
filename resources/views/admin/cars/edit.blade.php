@extends('layouts.admin')

@section('title', 'Edit Data Supercar - ' . $car->brand_model)

@section('content')
<div class="mb-4 pb-2 border-bottom border-secondary border-opacity-15">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('admin.cars.index') }}" class="text-decoration-none text-danger">Armada Supercar</a></li>
            <li class="breadcrumb-item active text-secondary" aria-current="page">Edit Data Unit</li>
        </ol>
    </nav>
    <h3 class="fw-bold text-white mb-0">Edit Data: {{ $car->brand_model }}</h3>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card card-custom p-4 p-md-5">
            <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Merek & Model -->
                <div class="mb-3">
                    <label for="brand_model" class="form-label text-white small fw-bold">Merek & Model Supercar <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-dark form-control-lg fs-6 @error('brand_model') is-invalid @enderror" 
                           id="brand_model" name="brand_model" value="{{ old('brand_model', $car->brand_model) }}" 
                           placeholder="Contoh: BMW M3 Competition G80" required>
                    @error('brand_model')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-3">
                    <!-- Kategori -->
                    <div class="col-md-6">
                        <label for="category" class="form-label text-white small fw-bold">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select form-select-dark form-select-lg fs-6 @error('category') is-invalid @enderror" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $car->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat == 'Sedan' ? 'Sport Sedan & Coupe' : ($cat == 'SUV' ? 'Super SUV Performance' : 'VIP Presidential Lounge') }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Plat Polisi -->
                    <div class="col-md-6">
                        <label for="plate_number" class="form-label text-white small fw-bold">Nomor Plat Polisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-dark form-control-lg fs-6 @error('plate_number') is-invalid @enderror" 
                               id="plate_number" name="plate_number" value="{{ old('plate_number', $car->plate_number) }}" 
                               placeholder="Contoh: B 3 M" required>
                        @error('plate_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tarif Sewa Per Hari -->
                <div class="mb-3">
                    <label for="rental_rate_per_day" class="form-label text-white small fw-bold">Tarif Sewa Harian (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text form-control-dark border-end-0 fw-bold text-warning">Rp</span>
                        <input type="number" class="form-control form-control-dark form-control-lg fs-6 @error('rental_rate_per_day') is-invalid @enderror" 
                               id="rental_rate_per_day" name="rental_rate_per_day" value="{{ old('rental_rate_per_day', $car->rental_rate_per_day) }}" 
                               placeholder="Contoh: 7500000" min="10000" step="500000" required>
                    </div>
                    @error('rental_rate_per_day')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Unggah Foto Mobil -->
                <div class="mb-4">
                    <label for="image" class="form-label text-white small fw-bold">Foto Kendaraan</label>
                    
                    @if($car->image)
                        <div class="mb-3">
                            <span class="text-secondary small d-block mb-1">Foto Saat Ini:</span>
                            <img src="{{ $car->image_url }}" alt="{{ $car->brand_model }}" class="rounded-3 border border-secondary border-opacity-25 object-fit-cover shadow-sm mb-2" style="max-height: 140px; background: #030508;">
                        </div>
                    @endif

                    <input type="file" class="form-control form-control-dark form-control-lg fs-6 @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-secondary">Pilih file gambar baru jika ingin mengganti foto yang ada.</small>
                    @error('image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror

                    <!-- Preview Container Baru -->
                    <div class="mt-3 d-none" id="previewContainer">
                        <label class="form-label text-secondary small d-block">Pratinjau Foto Baru:</label>
                        <img id="imagePreview" src="#" alt="Preview" class="rounded-3 border border-secondary border-opacity-25 object-fit-cover shadow-sm" style="max-height: 180px;">
                    </div>
                </div>

                <!-- Tombol Simpan & Batal -->
                <div class="d-flex gap-2 pt-3 border-top border-secondary border-opacity-15">
                    <button type="submit" class="btn btn-luxury-red fw-bold px-4 py-2">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary text-white px-4 py-2">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
</script>
@endpush

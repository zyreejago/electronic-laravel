<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penerimaan Barang') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card border-0 shadow rounded-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-box me-2"></i>Form Penerimaan Barang</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.reception.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Customer Selection -->
                        <div class="col-md-6">
                            <label for="user_id" class="form-label fw-bold">Pelanggan</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" name="user_id" required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone_number }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Service Type -->
                        <div class="col-md-6">
                            <label for="service_id" class="form-label fw-bold">Jenis Barang/Service</label>
                            <select class="form-select @error('service_id') is-invalid @enderror" name="service_id" required>
                                <option value="">Pilih Jenis Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Damage Category -->
                        <div class="col-md-6">
                            <label for="damage_category" class="form-label fw-bold">Kategori Kerusakan</label>
                            <select class="form-select @error('damage_category') is-invalid @enderror" name="damage_category" id="damage_category" required>
                                <option value="">Pilih Kategori Kerusakan</option>
                                @foreach($damageCategories as $key => $category)
                                    <option value="{{ $key }}">{{ $category }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya</option>
                            </select>
                            @error('damage_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Custom Damage Category Input -->
                        <div class="col-md-6" id="custom_damage_category" style="display: none;">
                            <label for="custom_damage_category_input" class="form-label fw-bold">Kategori Kerusakan Lainnya</label>
                            <input type="text" class="form-control" name="custom_damage_category_input" id="custom_damage_category_input" placeholder="Masukkan kategori kerusakan...">
                        </div>
                        
                        <!-- Item Condition -->
                        <div class="col-md-6">
                            <label for="item_condition" class="form-label fw-bold">Kondisi Fisik Barang</label>
                            <select class="form-select" name="item_condition" id="item_condition">
                                <option value="">Pilih Kondisi</option>
                                <option value="baik">Baik</option>
                                <option value="lecet">Lecet</option>
                                <option value="penyok">Penyok</option>
                                <option value="retak">Retak</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        
                        <!-- Custom Item Condition Input -->
                        <div class="col-md-6" id="custom_item_condition" style="display: none;">
                            <label for="custom_item_condition_input" class="form-label fw-bold">Kondisi Fisik Lainnya</label>
                            <input type="text" class="form-control" name="custom_item_condition_input" id="custom_item_condition_input" placeholder="Masukkan kondisi fisik...">
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-bold">Deskripsi Keluhan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="3" required 
                                      placeholder="Jelaskan keluhan atau masalah yang dialami..."></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Accessories -->
                        <div class="col-12">
                            <label for="accessories_included" class="form-label fw-bold">Aksesoris yang Diserahkan</label>
                            <textarea class="form-control" name="accessories_included" rows="2" 
                                      placeholder="Contoh: Charger, Earphone, Case, dll..."></textarea>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan & Buat Tanda Terima
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle damage category dropdown
        document.getElementById('damage_category').addEventListener('change', function() {
            const customDiv = document.getElementById('custom_damage_category');
            const customInput = document.getElementById('custom_damage_category_input');
            
            if (this.value === 'lainnya') {
                customDiv.style.display = 'block';
                customInput.required = true;
            } else {
                customDiv.style.display = 'none';
                customInput.required = false;
                customInput.value = '';
            }
        });
        
        // Handle item condition dropdown
        document.getElementById('item_condition').addEventListener('change', function() {
            const customDiv = document.getElementById('custom_item_condition');
            const customInput = document.getElementById('custom_item_condition_input');
            
            if (this.value === 'lainnya') {
                customDiv.style.display = 'block';
            } else {
                customDiv.style.display = 'none';
                customInput.value = '';
            }
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Komponen Layanan') }}
            </h2>
            <a href="{{ route('service-components.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>{{ __('Tambah Komponen Baru') }}
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #1cc88a, #13855c); color: white;">
                <div class="d-flex align-items-center">
                    <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <strong>{{ __('Berhasil!') }}</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow rounded-4 overflow-hidden">
            <div class="card-header p-0">
                <div style="background: linear-gradient(90deg, #4e73df, #224abe);" class="text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-tools me-2"></i>{{ __('Semua Komponen') }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('ID') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('NAMA') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('DESKRIPSI') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('HARGA') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('STOK') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('AKSI') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($components as $component)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">#{{ $component->id }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-microchip"></i>
                                            </div>
                                            <span class="fw-bold">{{ $component->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        {{ Str::limit($component->description, 100) }}
                                    </td>
                                    <td class="p-3 fw-bold">
                                        Rp {{ number_format($component->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3">
                                        @if($component->stock > 10)
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                <i class="fas fa-check-circle me-1"></i> {{ $component->stock }} {{ __('tersedia') }}
                                            </span>
                                        @elseif($component->stock > 0)
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #f6c23e, #dda20a);">
                                                <i class="fas fa-exclamation-circle me-1"></i> {{ $component->stock }} {{ __('tersisa') }}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #e74a3b, #be2617);">
                                                <i class="fas fa-times-circle me-1"></i> {{ __('Stok Habis') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('service-components.edit', $component) }}" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('service-components.destroy', $component) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus komponen ini?') }}')">
                                                    <i class="fas fa-trash-alt me-1"></i> {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-top">
                    {{ $components->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
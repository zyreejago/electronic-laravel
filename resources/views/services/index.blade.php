<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Layanan') }}
            </h2>
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('services.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>{{ __('Tambah Layanan') }}
                </a>
            @endif
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
                        <h5 class="card-title mb-0 fw-bold">{{ __('Semua Layanan') }}</h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">ID</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('NAMA') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('DESKRIPSI') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('HARGA') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('DURASI') }}</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">{{ __('AKSI') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">#{{ $service->id }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-wrench"></i>
                                            </div>
                                            <span class="fw-bold">{{ $service->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        {{ Str::limit($service->description, 100) }}
                                    </td>
                                    <td class="p-3 fw-bold">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3">
                                        <span class="badge rounded-pill text-white px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #36b9cc, #258391);">
                                            <i class="fas fa-clock me-1"></i> {{ $service->duration }} {{ __('menit') }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('services.destroy', $service) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus layanan ini?') }}')">
                                                    <i class="fas fa-trash"></i> {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
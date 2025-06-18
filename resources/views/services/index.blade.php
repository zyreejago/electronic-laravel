<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Services') }}
            </h2>
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('services.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-plus-circle me-2"></i>Add New Service
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
                        <strong>Success!</strong> {{ session('success') }}
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
                            <i class="fas fa-cogs me-2"></i>All Services
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 text-uppercase small fw-bold p-3">ID</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">NAME</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">DESCRIPTION</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">PRICE</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">DURATION</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">ACTIONS</th>
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
                                            <i class="fas fa-clock me-1"></i> {{ $service->duration }} minutes
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('services.edit', $service) }}" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('services.destroy', $service) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Are you sure you want to delete this service?')">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
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
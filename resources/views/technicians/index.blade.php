<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Technicians') }}
            </h2>
            <a href="{{ route('technicians.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-user-plus me-2"></i>Add New Technician
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
                            <i class="fas fa-users-cog me-2"></i>All Technicians
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
                                <th class="border-0 text-uppercase small fw-bold p-3">EMAIL</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">SPECIALIZATION</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">STATUS</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($technicians as $technician)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">#{{ $technician->id }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                {{ substr($technician->user->name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold">{{ $technician->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <span>{{ $technician->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-tools"></i>
                                            </div>
                                            <span class="fw-bold">{{ $technician->specialization }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        @if($technician->is_available)
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #1cc88a, #13855c);">
                                                <i class="fas fa-check-circle me-1"></i> Available
                                            </span>
                                        @else
                                            <span class="badge rounded-pill text-white px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #e74a3b, #be2617);">
                                                <i class="fas fa-times-circle me-1"></i> Not Available
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('technicians.edit', $technician) }}" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('technicians.destroy', $technician) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Are you sure you want to delete this technician?')">
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

                <div class="p-4 border-top">
                    {{ $technicians->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
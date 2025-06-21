<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Admins') }}
            </h2>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-lg shadow-sm">
                <i class="fas fa-user-plus me-2"></i>Add New Admin
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

        @if(session('error'))
            <div class="alert border-0 shadow-sm rounded-3 mb-4" style="background: linear-gradient(135deg, #e74a3b, #be2617); color: white;">
                <div class="d-flex align-items-center">
                    <div class="p-2 me-3 bg-white bg-opacity-25 rounded-circle">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <strong>Error!</strong> {{ session('error') }}
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
                            <i class="fas fa-users-cog me-2"></i>All Admins
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
                                <th class="border-0 text-uppercase small fw-bold p-3">PHONE</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">CREATED</th>
                                <th class="border-0 text-uppercase small fw-bold p-3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="p-3">
                                        <span class="fw-bold">#{{ $admin->id }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #4e73df, #224abe);">
                                                {{ substr($admin->name, 0, 1) }}
                                            </div>
                                            <span class="fw-bold">{{ $admin->name }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <span>{{ $admin->email }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <span>{{ $admin->phone_number }}</span>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-muted">{{ $admin->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-warning btn-sm shadow-sm">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            @if($admin->id !== auth()->id())
                                                <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Are you sure you want to delete this admin?')">
                                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-top">
                    {{ $admins->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
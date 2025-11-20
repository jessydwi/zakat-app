@extends('layouts.admin')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8"> 
    <div class="max-w-7xl mx-auto">

        <!-- Header Section --> 
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div> 
                        <h1 class="text-3xl font-bold text-white leading-tight">Manajemen User</h1> 
                        <p class="text-emerald-100 mt-2">Kelola pengguna sistem dengan mudah</p>
                    </div> 
                    <a href="{{ route('admin.users.create') }}" 
                        class="inline-flex items-center px-6 py-3 bg-white text-emerald-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600 transition-transform duration-300 transform hover:scale-105 mt-4 sm:mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah User
                    </a> 
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M6.938 20h10.124c1.54 0 2.502-1.667 1.732-2.5L13.732 5.5c-.77-.833-1.964-.833-2.732 0L5.206 17.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">{{ $errors->first() }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    <span>Daftar User</span>
                </h2>
                <p class="text-blue-100 mt-1">Kelola semua pengguna dalam sistem</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse border border-gray-200 text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide border-b border-gray-300">Nama</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide border-b border-gray-300">Email</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide border-b border-gray-300">Peran</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide border-b border-gray-300">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wide border-b border-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($userList as $u)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                            <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center bg-gradient-to-r from-emerald-400 to-teal-500 text-white font-semibold">
                                    {{ strtoupper(substr($u->nama, 0, 1)) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $u->nama }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $u->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full capitalize 
                                    {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $u->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($u->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-4">
                                <a href="{{ route('admin.users.show', $u->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center gap-1 transition">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1 transition">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                @if($u->status === 'aktif')
                                    <form action="{{ route('admin.users.deactivate', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menonaktifkan user ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-yellow-600 hover:text-yellow-800 flex items-center gap-1 transition">
                                            <i class="fas fa-ban"></i> Nonaktifkan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.activate', $u->id) }}" method="POST" onsubmit="return confirm('Aktifkan kembali user ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="text-green-600 hover:text-green-800 flex items-center gap-1 transition">
                                            <i class="fas fa-check-circle"></i> Aktifkan
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900 flex items-center gap-1 transition">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4">
                {{ $userList->links() }}
            </div>
    </div>
</div>

@endsection
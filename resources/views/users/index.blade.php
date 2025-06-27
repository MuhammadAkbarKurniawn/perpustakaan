@extends('layouts.app')

@hasanyrole('admin|librarian')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">👥 Manajemen Pengguna</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h5 class="text-lg font-semibold">Daftar Pengguna</h5>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i> Tambah Pengguna
            </a>
        </div>

        @if(session('success'))
            <div class="px-6 py-4 bg-green-100 text-green-800 text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-200 text-gray-700 rounded">{{ ucfirst($role->name) }}</span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center px-2 py-1 bg-yellow-400 text-white text-xs rounded hover:bg-yellow-500" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <div class="inline-block relative">
                                    <button class="inline-flex items-center px-2 py-1 bg-gray-200 text-xs text-gray-700 rounded hover:bg-gray-300" id="userActions{{ $user->id }}" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-md z-10 hidden" aria-labelledby="userActions{{ $user->id }}">
                                        <li>
                                            <a class="block px-4 py-2 text-left text-gray-700 hover:bg-gray-100" href="{{ route('users.borrowings', $user->id) }}">
                                                <i class="fas fa-book mr-2"></i>Lihat Peminjaman
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="fixed z-50 inset-0 overflow-y-auto hidden" id="deleteModal{{ $user->id }}">
                                    <div class="flex items-center justify-center min-h-screen px-4">
                                        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-sm sm:w-full">
                                            <div class="px-6 py-4 border-b">
                                                <h3 class="text-lg font-semibold">Konfirmasi Hapus</h3>
                                            </div>
                                            <div class="px-6 py-4">
                                                <p class="text-sm text-gray-700">Yakin ingin menghapus <strong>{{ $user->name }}</strong>?</p>
                                            </div>
                                            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-2">
                                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-4 py-1.5 bg-red-600 text-white text-sm rounded hover:bg-red-700">Hapus</button>
                                                </form>
                                                <button type="button" onclick="document.getElementById('deleteModal{{ $user->id }}').classList.add('hidden')" class="px-4 py-1.5 bg-gray-200 text-gray-700 text-sm rounded hover:bg-gray-300">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                <i class="fas fa-users fa-2x mb-2"></i><br>
                                Tidak ada pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center px-6 py-4 text-sm text-gray-600">
            <div>
                Menampilkan {{ $users->count() }} dari total {{ $users->total() }} pengguna
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(btn => {
            const targetId = btn.getAttribute('data-bs-target');
            const modal = document.querySelector(targetId);
            btn.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    // Buka modal hapus
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(btn => {
        const targetId = btn.getAttribute('data-bs-target');
        const modal = document.querySelector(targetId);
        btn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    });

    // Toggle dropdown titik tiga
    document.querySelectorAll('[id^="userActions"]').forEach(button => {
        const dropdownId = button.getAttribute('id');
        const dropdownMenu = button.nextElementSibling;

        button.addEventListener('click', function (e) {
            e.preventDefault();
            // Tutup semua dropdown lain
            document.querySelectorAll('ul[aria-labelledby]').forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add('hidden');
            });
            // Toggle dropdown yang diklik
            dropdownMenu.classList.toggle('hidden');
        });
    });

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function (e) {
        document.querySelectorAll('ul[aria-labelledby]').forEach(menu => {
            if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
});

</script>
@endsection
@endhasanyrole

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola User</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">User</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600">Toko</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Produk</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Belanja</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600">Penjualan</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600">Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-gray-600">{{ $user->sellerProfile->shop_name ?? '-' }}</td>
                                    <td class="px-4 py-4 text-center font-semibold text-gray-900">{{ $user->products_count }}</td>
                                    <td class="px-4 py-4 text-center font-semibold text-gray-900">{{ $user->purchases_count }}</td>
                                    <td class="px-4 py-4 text-center font-semibold text-gray-900">{{ $user->sales_count }}</td>
                                    <td class="px-4 py-4">
                                        <form action="{{ route('admin.users.role.update', $user) }}" method="POST" class="flex justify-end gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="w-28 rounded-md border-gray-300 text-xs focus:border-emerald-600 focus:ring-emerald-600">
                                                <option value="user" @selected($user->role === 'user')>User</option>
                                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                            </select>
                                            <button type="submit" class="rounded-md bg-gray-900 px-3 py-2 text-xs font-semibold text-white hover:bg-gray-800">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">User</h1>
            @can('user-create')
                <a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-2 md:mt-0">Tambah User</a>
            @endcan
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @can('permission-list')
            <!-- Wrapper untuk tabel dengan mode dark -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($users as $user)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                        <div class="mb-2">
                            <span class="font-semibold text-gray-900 dark:text-gray-200">Nama: </span>{{ $user->name }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-900 dark:text-gray-200">Email: </span>{{ $user->email }}
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-900 dark:text-gray-200">Role: </span>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                        </div>
                        <div class="flex gap-2">
                            @can('user-edit')
                                <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            @endcan
                            @can('user-delete')
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endcan
    </div>
</x-app-layout>

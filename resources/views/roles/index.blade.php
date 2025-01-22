<x-app-layout>
    <div class="container mx-auto px-4 dark:bg-gray-900 dark:text-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Roles</h1>

            {{-- Check if the user has permission to create a new role --}}
            @can('role-create')
            <a href="{{ route('roles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800">Tambah Role</a>
            @endcan
        </div>

        @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-2 rounded mb-4 dark:bg-green-700">
            {{ session('success') }}
        </div>
        @endif

        {{-- Check if the user has permission to view the role list --}}
        @can('role-list')
        <div class="space-y-4">
            @foreach($roles as $role)
            <div class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-4 rounded">
                <div class="flex justify-between">
                    <div>

                        <p class="font-semibold">Nama: {{ $role->name }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('roles.edit', $role) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700">Edit</a>
                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $roles->links() }}
        </div>
        @endcan
    </div>
</x-app-layout>

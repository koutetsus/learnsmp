<x-app-layout>
    <div class="container mx-auto px-4 dark:bg-gray-800 dark:text-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold dark:text-gray-300">Permissions</h1>
            {{-- Check if the user has permission to create a new permission --}}
            @can('permission-create')
            <a
                href="{{ route('permissions.create') }}"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-400"
            >
                Tambah Permission
            </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4 shadow dark:bg-green-600">
                {{ session('success') }}
            </div>
        @endif

        {{-- Check if the user has permission to view the permission list --}}
        @can('permission-list')
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-4">Permission</th>
                        <th class="bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                    <tr class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-4 py-2 text-gray-700 dark:text-gray-200 border-r border-gray-200 dark:border-gray-600">{{ $permission->name }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a
                                    href="{{ route('permissions.edit', $permission) }}"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:hover:bg-yellow-400"
                                >
                                    Edit
                                </a>
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 dark:hover:bg-red-400"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $permissions->links() }}
        </div>
        @endcan
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container mx-auto px-4 dark:bg-gray-800 dark:text-gray-200">
        <h1 class="text-2xl font-semibold mb-4">Tambah Role</h1>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300">Nama Role</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="w-full px-4 py-2 border rounded text-gray-900 dark:text-gray dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama role"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Permission</label>
                <div class="space-y-2">
                    @foreach($permissions as $permission)
                        <div>
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                id="permission-{{ $permission->id }}"
                                class="mr-2 rounded text-blue-500 border-gray-300 dark:bg-gray-700 dark:border-gray-600 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            >
                            <label for="permission-{{ $permission->id }}" class="text-gray-700 dark:text-gray-300">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 dark:hover:bg-blue-400"
            >
                Tambah Role
            </button>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container mx-auto border-2 border-solid p-4 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300">Nama:</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="w-full px-4 py-2 border rounded text-gray-900 dark:text-gray dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama"
                    required
                >
                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-300">Email:</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full px-4 py-2 border rounded text-gray-900 dark:text-gray dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('email', $user->email) }}"
                    placeholder="Masukkan email"
                    required
                >
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="roles" class="block text-gray-700 dark:text-gray-300">Role:</label>
                <select
                    name="roles[]"
                    id="roles"
                    multiple
                    class="w-full px-4 py-2 border rounded text-gray-900 dark:text-gray dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('roles')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <a href="{{ route('users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Kembali</a>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>

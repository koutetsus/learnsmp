<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Create Role</h1>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Role Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Permissions</label>
                <div class="space-y-2">
                    @foreach($permissions as $permission)
                        <div>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}" class="mr-2">
                            <label for="permission-{{ $permission->id }}" class="text-gray-700">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Role</button>
        </form>
    </div>
</x-app-layout>

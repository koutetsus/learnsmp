<x-app-layout>
    <div class="container mx-auto border-2 border-solid">
        <div class="flex justify-between p-4 item-center">
            <h1 class="text-2xl font-bold">Users</h1>
            <a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create User</a>
        </div>

        <table class="min-w-full table-auto mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Roles</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>

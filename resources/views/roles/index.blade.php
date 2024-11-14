<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Roles</h1>

             {{-- Check if the user has permission to create a new role --}}
             @can('role-create')
             <a href="{{ route('roles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Role</a>
             @endcan
            </div>

            @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
         @endif

             {{-- Check if the user has permission to view the role list --}}
        @can('role-list')
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-300 py-2 px-4 text-left">No</th>
                    <th class="border border-gray-300 py-2 px-4 text-left">Name</th>
                    <th class="border border-gray-300py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 py-2 px-4">{{ $role->name }}</td>
                        <td class="border border-gray-300 py-2 px-4">
                            <a href="{{ route('roles.edit', $role) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        {{ $roles->links() }}
        </div>

        @endcan
    </div>


</x-app-layout>

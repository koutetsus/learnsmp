<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Materi</h1>
            <a href="{{ route('materis.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Materi</a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="border-b py-2 px-4 text-left">Title</th>
                    <th class="border-b py-2 px-4 text-left">Type</th>
                    <th class="border-b py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materis as $materi)
                    <tr>
                        <td class="border-b py-2 px-4">{{ $materi->title }}</td>
                        <td class="border-b py-2 px-4">{{ ucfirst($materi->type) }}</td>
                        <td class="border-b py-2 px-4">
                            <a href="{{ route('materis.edit', $materi) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('materis.destroy', $materi) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $materis->links() }}
    </div>
</x-app-layout>

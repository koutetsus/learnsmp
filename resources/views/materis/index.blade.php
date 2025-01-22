<x-app-layout>
    <div class="container mx-auto px-4 dark:bg-gray-800 dark:text-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold dark:text-gray-300">Materi</h1>

            {{-- Check if the user has permission to create Materi --}}
            @can('materi-create')
                <a href="{{ route('materis.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-400">
                    Tambah Materi
                </a>
            @endcan
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4 shadow dark:bg-green-600">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">No</th>
                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Mata Pelajaran</th>
                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Nama Materi</th>
                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Type</th>
                        <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materis as $materi)
                    <tr class="border-b border-gray-200 dark:border-gray-600">
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $materi->mataPelajaran->name }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $materi->title }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ ucfirst($materi->type) }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">
                            <div class="flex space-x-2 ">
                                {{-- Check if the user has permission to edit Materi --}}
                                @can('materi-edit')
                                    <a href="{{ route('materis.edit', $materi) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:hover:bg-yellow-400">
                                        Edit
                                    </a>
                                @endcan
                                {{-- Check if the user has permission to show Materi --}}
                                @can('materi-show')
                                    <a href="{{ route('materis.show', $materi) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:hover:bg-blue-400">
                                        Show
                                    </a>
                                @endcan
                                {{-- Check if the user has permission to delete Materi --}}
                                @can('materi-delete')
                                    <form action="{{ route('materis.destroy', $materi) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 dark:hover:bg-red-400">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $materis->links() }}
        </div>
    </div>
</x-app-layout>

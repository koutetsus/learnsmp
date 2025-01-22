<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Pengumpulan Tugas</h2>
        <table class="table-auto w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">No</th>
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-6000">Mata Pelajaran</th>
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Materi</th>
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Siswa</th>
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Tipe</th>
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">file</th>
                    <th class="border-b py-2 px-4 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-600">Di Submit pada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submission as $submission)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $submission->assignment->materi->mataPelajaran->name }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $submission->assignment->materi->title }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ $submission->user->name }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">{{ ucfirst($submission->submission_type) }}</td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-200">
                            @if($submission->submission_type === 'document')
                                <a href="{{ Storage::url($submission->file_path) }}" class="text-blue-500 hover:underline" target="_blank">
                                    Download file
                                </a>
                            @elseif($submission->submission_type === 'link')
                                <a href="{{ $submission->submission_link }}" class="text-blue-500 hover:underline" target="_blank">
                                    Open Link
                                </a>
                            @elseif($submission->submission_type === 'article')
                                <p class="text-gray-700">{{ $submission->submission_content }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-left bg-gray-50 dark:bg-gray-800 dark:border-gray-2000">
                            {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">No submissions yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

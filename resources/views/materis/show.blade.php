<x-app-layout>
    <div class="container mx-auto px-4 ">
        <div class="bg-white shadow-md dark:bg-gray-800 dark:text-gray-200 rounded-md p-6 w-full px-4 py-2 border rounded text-gray-900 dark:text-gray dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <h1 class="text-2xl font-semibold mb-4">{{ $materi->title }}</h1>

            <div class="mb-4">
                <strong>Guru:</strong>
                <p>{{ $materi->teacher->name }}</p>
            </div>

            <div class="mb-4">
                <strong>Mata Pelajaran:</strong>
                <p>{{ $materi->mataPelajaran->name }}</p>
            </div>

            <div class="mb-4">
                <strong>Deskripsi:</strong>
                <p>{{ $materi->description }}</p>
            </div>

            <div class="mb-4">
                <strong>Tipe:</strong>
                <p>{{ ucfirst($materi->type) }}</p>
            </div>

                        <!-- Show content Document/ DOC, DOCX, or PDF -->
                @if($materi->type === 'document' && isset($materi->file))
                <a href="{{ asset('storage/materi_files/' . basename($materi->file)) }}" download class="text-blue-500">Download Document (DOC, DOCX, PDF)</a>
                @php
                    // Get the file extension
                    $extension = pathinfo($materi->file, PATHINFO_EXTENSION);
                @endphp

                <!-- If it's a PDF, show the inline preview -->
                @if($extension === 'pdf')
                    <div class="mt-4">
                        <h2 class="text-lg font-semibold text-gray-700">Preview Document:</h2>
                        <iframe src="{{ route('materis.displayPdf', $materi->id) }}" width="100%" height="600px"></iframe>
                    </div>
                @else
                    <!-- For DOC, DOCX, or any other non-PDF document, show download link -->
                    <a href="{{ asset('storage/materi_files/' . basename($materi->file)) }}" download class="text-blue-500">
                        Download Document (DOC, DOCX, PDF)
                    </a>
                @endif
                @endif


            <!-- Show content Link -->
            @if ($materi->type === 'link' && $materi->link)
            <div class="mt-4 mb-5">
                <h2 class="text-lg font-semibold text-gray-700">Link:</h2>
                <a href="{{ $materi->link }}" target="_blank" class="text-blue-500">
                    {{ $materi->link }}
                </a>
            </div>
            @endif

            <!-- Show content Article -->
            @if ($materi->type === 'article' && $materi->content)
            <div class="mt-4">
                <h3 class="font-medium">Content:</h3>
                <div class="mt-2 text-gray-700">
                    {!! nl2br(e($materi->content)) !!} <!-- Display content with line breaks -->
                </div>
            </div>
            @endif

            <!-- Show content Video -->
            @if($materi->type === 'video' && $materi->video_id)
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Video:</h2>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $materi->video_id }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        style="width: 70vw; height: 36.25vw;" <!-- Fullscreen -->
                    </iframe>
                </div>
            </div>
            @endif
                    <!-- Display Assignments -->
                    <div class="mt-8 border-t pt-4">
                        <h3 class="text-lg font-semibold">Tugas</h3>

                        @forelse($materi->assignments as $assignment)
                            <div class="mt-4">
                                @if($assignment->assignments_type === 'document' && $assignment->assignments_file)
                                <a href="{{ asset('storage/assignments_files/' . basename($assignment->assignments_file)) }}" download class="text-blue-500">Download Document (DOC, DOCX, PDF)</a>
                                    @php
                                        $filePath = str_replace('public/', '', $assignment->assignments_file);
                                    @endphp

                                    <p><strong>Document:</strong></p>
                                    @if(Str::endsWith($filePath, '.pdf'))
                                        <iframe src="{{ asset('storage/' . $filePath) }}" class="w-full h-96 border rounded-md"></iframe>
                                    @elseif(in_array(pathinfo($filePath, PATHINFO_EXTENSION), ['doc', 'docx']))
                                        <a href="{{ asset('storage/' . $filePath) }}" class="text-blue-500" download>Download File</a>
                                    @else
                                        <a href="{{ asset('storage/' . $filePath) }}" class="text-blue-500">Download File</a>
                                    @endif
                                @elseif($assignment->assignments_type === 'link' && $assignment->assignments_link)
                                    <a href="{{ $assignment->assignments_link }}" target="_blank" class="text-blue-500">Open Assignment Link</a>
                                @elseif($assignment->assignments_type === 'article' && $assignment->assignments_content)
                                    <p>{{ $assignment->assignments_content }}</p>
                                @endif
                            </div>
                        @empty
                            <p>Tidak Ada Tugas</p>
                        @endforelse
                    </div>
                    </div>

                @if(session('success'))
                    <div class="alert alert-success bg-green-500 text-white p-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if($materi->assignments->isNotEmpty())
                @foreach($materi->assignments as $assignment)
                    <div class="mt-4 relative">
                        <p><strong>Tipe Tugas:</strong> {{ ucfirst($assignment->assignments_type) }}</p>

                        <!-- Check if the assignment has been submitted by the user -->
                        @php
                            $submission = $assignment->submissions()->where('user_id', auth()->user()->id)->first();
                        @endphp

                        @if($submission)
                            <!-- Status pengumpulan tugas di kanan atas -->
                            <div class="absolute top-0 right-0 p-4 bg-green-500 text-white rounded">
                                <p><strong>Status:</strong> {{ ucfirst($submission->status) }}</p>
                            </div>

                            <!-- Display the submitted task content based on type -->
                            @if($submission->submission_type === 'document')
                                <p><strong>Submitted File:</strong></p>
                                <p>{{ basename($submission->file_path) }}</p>
                            @elseif($submission->submission_type === 'link')
                                <p><strong>Submitted Link:</strong></p>
                                <a href="{{ $submission->submission_link }}" target="_blank" class="text-blue-500 underline">{{ $submission->submission_link }}</a>
                            @elseif($submission->submission_type === 'article')
                                <p><strong>Submitted Article:</strong></p>
                                <p>{{ $submission->submission_content }}</p>
                            @endif
                        @else
                            <!-- If no submission exists, show the form to submit the assignment -->
                            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                <label for="submission_type" class="block text-sm font-medium text-gray-700">Pengumpulan Tugas</label>
                                <select name="submission_type" id="submission_type" class="mt-1 block w-full" required>
                                    <option value="document">Document</option>
                                    <option value="link">Link</option>
                                    <option value="article">Article</option>
                                </select>

                                <!-- Document input -->
                                <div id="document_input" class="mt-4 hidden">
                                    <label for="file_path" class="block text-sm font-medium text-gray-700">Upload Document (PDF, DOC, DOCX)</label>
                                    <input type="file" name="file_path" id="file_path" class="mt-1 block w-full">
                                </div>

                                <!-- Link input -->
                                <div id="link_input" class="mt-4 hidden">
                                    <label for="submission_link" class="block text-sm font-medium text-gray-700">Submit Link</label>
                                    <input type="url" name="submission_link" id="submission_link" class="mt-1 block w-full">
                                </div>

                                <!-- Article input -->
                                <div id="article_input" class="mt-4 hidden">
                                    <label for="submission_content" class="block text-sm font-medium text-gray-700">Write Your Article</label>
                                    <textarea name="submission_content" id="submission_content" rows="4" class="mt-1 block w-full"></textarea>
                                </div>

                                <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Upload Tugas</button>
                            </form>
                            {{-- @can('view-submissions')
                            <a href="{{ route('submissions.index', $assignment->id) }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded">View Submissions</a>
                        @endcan --}}

                            <script>
                                document.getElementById('submission_type').addEventListener('change', function () {
                                    const type = this.value;
                                    document.getElementById('document_input').classList.toggle('hidden', type !== 'document');
                                    document.getElementById('link_input').classList.toggle('hidden', type !== 'link');
                                    document.getElementById('article_input').classList.toggle('hidden', type !== 'article');
                                });
                            </script>
                        @endif
                    </div>
                @endforeach
            @endif



            <!-- Button back to list -->
            <div class="mt-5 flex justify-start">
                <a href="{{ route('materis.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
            </div>
        </div>
    </div>
</x-app-layout>

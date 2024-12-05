<x-app-layout>
    <div class="container mx-auto">
        <form method="POST" action="{{ route('materis.update', $materi->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="container flex flex-row mx-auto px-4 gap-8">
                <!-- Column for Materi -->
                <div class="basis-1/2">
                    <h1 class="text-2xl font-semibold mb-4">Edit Materi</h1>
                    <!-- Materi Fields -->

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $materi->title) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $materi->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select id="type" name="type"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="showTypeFields()">
                            <option value="link" {{ $materi->type == 'link' ? 'selected' : '' }}>Link</option>
                            <option value="document" {{ $materi->type == 'document' ? 'selected' : '' }}>Document</option>
                            <option value="article" {{ $materi->type == 'article' ? 'selected' : '' }}>Article</option>
                            <option value="ppt" {{ $materi->type == 'ppt' ? 'selected' : '' }}>PPT</option>
                            <option value="video" {{ $materi->type == 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                    </div>

                    <!-- Link Field (for Link type) -->
                    <div id="linkField" class="hidden mb-4">
                        <label for="link" class="block text-sm font-medium text-gray-700">Link Google Drive</label>
                        <textarea id="link" name="link" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('link', $materi->link) }}</textarea>
                    </div>

                    <!-- File Upload Field (Hidden or Visible based on Type) -->
                    <div id="fileUploadField" class="hidden mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
                        <input type="file" id="file" name="file"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewFile()">
                        <div id="filePreview" class="mt-2"></div>
                    </div>

                    <!-- Content Field (for Article type) -->
                    <div id="contentField" class="hidden mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea id="content" name="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Add your content here">{{ old('content', $materi->content) }}</textarea>
                    </div>

                    <!-- URL Field (for Video) -->
                    <div id="urlField" class="hidden mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700">Url</label>
                        <input type="text" id="url" name="url"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('url', $materi->url) }}">
                    </div>
                </div>

                <!-- Column for Tugas (Assignment) -->
                <div class="basis-1/2">
                    <h2 class="text-2xl font-semibold mb-4">Edit Assignment</h2>
                    <div class="mb-4">
                        <label for="assignment" class="block text-sm font-medium text-gray-700">Upload Assignment (PPT, DOC, PDF)</label>
                        <input type="file" id="assignment" name="assignment"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            accept=".ppt,.pptx,.doc,.docx,.pdf" onchange="previewAssignment()">
                        <div id="assignmentPreview" class="mt-2">
                            <!-- If there's an existing assignment file, show preview -->
                            @if($materi->assignment)
                                <a href="{{ asset('storage/' . $materi->assignment) }}" target="_blank" class="text-blue-500">View Current Assignment</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button for both Materi and Assignment -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Materi & Assignment</button>
        </form>
    </div>

    <!-- Modal -->
    <div id="createMataPelajaranModal"
        class="fixed inset-0 z-50 hidden bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
            <h2 class="text-xl font-semibold mb-4">Create New Mata Pelajaran</h2>
            <form id="createMataPelajaranForm" method="POST" action="{{ route('mataPelajaran.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Save</button>
                <button type="button" onclick="closeModal()"
                    class="ml-2 bg-red-500 text-white px-4 py-2 rounded-md">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('createMataPelajaranModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('createMataPelajaranModal').classList.add('hidden');
        }

        function showTypeFields() {
            const type = document.getElementById('type').value;
            const fileUploadField = document.getElementById('fileUploadField');
            const contentField = document.getElementById('contentField');
            const urlField = document.getElementById('urlField');
            const linkField = document.getElementById('linkField');

            fileUploadField.classList.add('hidden');
            contentField.classList.add('hidden');
            urlField.classList.add('hidden');
            linkField.classList.add('hidden');

            if (type === 'document' || type === 'ppt') {
                fileUploadField.classList.remove('hidden');
            } else if (type === 'article') {
                contentField.classList.remove('hidden');
            } else if (type === 'video') {
                urlField.classList.remove('hidden');
            } else if (type === 'link') {
                linkField.classList.remove('hidden');
            }
        }

        // Call showTypeFields on page load to display the correct fields
        document.addEventListener('DOMContentLoaded', () => {
            showTypeFields();
        });
    </script>
</x-app-layout>

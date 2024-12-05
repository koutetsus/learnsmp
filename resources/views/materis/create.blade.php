<x-app-layout>
    <div class="container mx-auto">
        <form method="POST" action="{{ route('materis.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="container flex flex-row mx-auto px-4 gap-8">
                <!-- Column for Materi -->
                <div class="basis-1/2">
                    <h1 class="text-2xl font-semibold mb-4">Add New Materi</h1>
                    <!-- Materi Fields -->
                    <div class="mb-4 relative">
                        <label for="mata_pelajaran_id" class="block text-sm font-medium text-gray-700">Mata
                            Pelajaran</label>
                        <div class="flex items-center">
                            <select id="mata_pelajaran_id" name="mata_pelajaran_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($mataPelajaran as $mata)
                                    <option value="{{ $mata->id }}">{{ $mata->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openModal()"
                                class="ml-2 bg-blue-500 text-white px-3 py-1 rounded-md shadow-sm hover:bg-blue-600">+</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select id="type" name="type"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="showTypeFields()">

                            <option value="link">Link</option>
                            <option value="document">Document</option>
                            <option value="article">Article</option>
                            <option value="video">Video</option>
                        </select>
                    </div>


                        <!-- Content Field (for Link type) -->
   <!-- Link Field (for Link type) -->
<div id="linkField" class="hidden mb-4">
    <label for="link" class="block text-sm font-medium text-gray-700">Link Google Drive</label>
    <textarea id="link" name="link" rows="3"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
        placeholder="Paste your link here" ></textarea>
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
                                          placeholder="Add your content here"></textarea>
                                    </div>


                    <!-- URL Field (for Video) -->
                    <div id="urlField" class="hidden mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700">Url</label>
                        <input type="text" id="url" name="url"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>


                </div>



                <!-- Column for Tugas (Assignment) -->
                <div class="basis-1/2">
                    <h2 class="text-2xl font-semibold mb-4">Upload Assignment</h2>
                    <div class="mb-4">
                        <label for="assignment" class="block text-sm font-medium text-gray-700">Upload Assignment (PPT,
                            DOC, PDF)</label>
                        <input type="file" id="assignment" name="assignment"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            accept=".ppt,.pptx,.doc,.docx,.pdf" onchange="previewAssignment()">
                        <div id="assignmentPreview" class="mt-2"></div>
                    </div>
                </div>
            </div>

            <!-- Submit Button for both Materi and Assignment -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Materi & Assignment</button>
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

    <!-- TinyMCE CDN -->

        <script src="https://cdn.tiny.cloud/1/pkpz2purcjfn9blpss7j6t45hagbconqdjykkgxwoex6dqpn/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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
    }
    else if (type === 'link') {
        linkField.classList.remove('hidden');
    }
}

        function previewFile() {
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('filePreview');
            filePreview.innerHTML = '';

            if (fileInput.files && fileInput.files[0]) {
                const file = fileInput.files[0];
                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-full');
                        filePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else if (fileType === 'application/pdf') {
                    const url = URL.createObjectURL(file);
                    const iframe = document.createElement('iframe');
                    iframe.src = url;
                    iframe.classList.add('w-full', 'h-60');
                    filePreview.appendChild(iframe);
                } else {
                    filePreview.innerText = 'Cannot preview this file type.';
                }
            }
        }

        function previewAssignment() {
            const assignmentInput = document.getElementById('assignment');
            const assignmentPreview = document.getElementById('assignmentPreview');
            assignmentPreview.innerHTML = '';

            if (assignmentInput.files && assignmentInput.files[0]) {
                const file = assignmentInput.files[0];
                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('w-full');
                        assignmentPreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                } else if (fileType === 'application/pdf') {
                    const url = URL.createObjectURL(file);
                    const iframe = document.createElement('iframe');
                    iframe.src = url;
                    iframe.classList.add('w-full', 'h-60');
                    assignmentPreview.appendChild(iframe);
                } else {
                    assignmentPreview.innerText = 'Cannot preview this file type.';
                }
            }
        }
    </script>
    </div>
</x-app-layout>

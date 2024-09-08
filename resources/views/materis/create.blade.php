<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Add New Materi</h1>

        <form method="POST" action="{{ route('materis.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="showTypeFields()">
                    <option value="document">Document</option>
                    <option value="article">Article</option>
                    <option value="ppt">PPT</option>
                    <option value="video">Video</option>
                </select>
            </div>

            <div id="fileUploadField" class="hidden mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
                <input type="file" id="file" name="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div id="contentField" class="hidden mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea id="content" name="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Add your content here"></textarea>
            </div>

            <div id="urlField" class="hidden mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700">Url</label>
                <input type="text" id="url" name="url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save</button>
        </form>

        <!-- TinyMCE CDN -->
        <script src="https://cdn.tiny.cloud/1/4pgdph1t0sle9a2mfzj7frhg7vva4u3kj8s48b6nk27kdk2i/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            function showTypeFields() {
                const type = document.getElementById('type').value;
                const fileUploadField = document.getElementById('fileUploadField');
                const contentField = document.getElementById('contentField');
                const urlField = document.getElementById('urlField');

                fileUploadField.classList.add('hidden');
                contentField.classList.add('hidden');
                urlField.classList.add('hidden');

                if (type === 'document' || type === 'ppt') {
                    fileUploadField.classList.remove('hidden');
                } else if (type === 'article') {
                    contentField.classList.remove('hidden');
                    tinymce.init({
                        selector: '#content',
                        menubar: false,
                        plugins: 'lists link image',
                        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                    });
                } else if (type === 'video') {
                    urlField.classList.remove('hidden');
                }
            }
        </script>
    </div>
</x-app-layout>

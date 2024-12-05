<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="bg-white shadow-md rounded-md p-6">
            <h1 class="text-2xl font-semibold mb-4">{{ $materi->title }}</h1>

            <div class="mb-4">
                <strong>Description:</strong>
                <p>{{ $materi->description }}</p>
            </div>

            <div class="mb-4">
                <strong>Type:</strong>
                <p>{{ ucfirst($materi->type) }}</p>
            </div>

            {{-- @if($materi->type === 'document' && $materi->url)
                <div class="mb-4">
                    <strong>Document:</strong>
                    <a href="{{ $materi->url }}" target="_blank" class="text-blue-500">Download Document</a>
                </div>
            @endif --}}
            @if($materi->type === 'document' && isset($materi->file))
            <a href="{{ asset('storage/materi_files/' . basename($materi->file)) }}" download class="text-blue-500">Download Document (DOC, DOCX)</a>
        @endif

             <!-- Show content Article / Video / Document/ PDF -->
             @if ($materi->type === 'article' && $materi->content)
             <div class="mt-4">
                 <h3 class="font-medium">Content:</h3>
                 <div class="mt-2 text-gray-700">
                     {!! nl2br(e($materi->content)) !!} <!-- Display content with line breaks -->
                 </div>
            </div>
            @endif

            <!-- Show content Article / Video / Document/ PDF -->
           @if($materi->type === 'video' && $materi->video_id)
           <div class="mb-4">
               <h2 class="text-lg font-semibold text-gray-700">Video:</h2>
               <div class="aspect-w-16 aspect-h-9">
                   <iframe
                       src="https://www.youtube.com/embed/{{ $materi->video_id }}"
                       frameborder="0"
                       allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                       allowfullscreen
                       class="w-full rounded">
                   </iframe>
               </div>
           </div>
       @endif

      <!-- Check if the materi type is 'link' and display the Google Drive link -->
            @if($materi->type === 'link' && isset($materi->link))
            <a href="{{ $materi->link }}" target="_blank" class="text-blue-500">Access To Google Drive</a>
            @endif

            @if($materi->type === 'document' && isset($materi->file))
            @php
                $filePath = asset('storage/public/materi_files' . $materi->file);
            @endphp

            <iframe src="{{ $filePath }}" width="100%" height="600px" class="border"></iframe>

        @endif




            <a href="{{ route('materis.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to List</a>
        </div>
    </div>
</x-app-layout>

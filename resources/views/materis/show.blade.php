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

            @if($materi->type === 'link' && $materi->url)
                <div class="mb-4">
                    <strong>Link:</strong>
                    <a href="{{ $materi->url }}" target="_blank" class="text-blue-500">{{ $materi->url }}</a>
                </div>
            @elseif($materi->type === 'video' && $materi->url)
                <div class="mb-4">
                    <strong>Video:</strong>
                    <video controls class="w-full">
                        <source src="{{ $materi->url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @elseif($materi->type === 'document' && $materi->url)
                <div class="mb-4">
                    <strong>Document:</strong>
                    <a href="{{ $materi->url }}" target="_blank" class="text-blue-500">Download Document</a>
                </div>
            @endif

            <a href="{{ route('materis.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to List</a>
        </div>
    </div>
</x-app-layout>

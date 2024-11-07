<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold">Quiz Results</h1>
    </x-slot>

    <div class="py-6">
        <p class="text-lg font-semibold">You scored {{ $score }} out of {{ $total }}.</p>
        <a href="{{ route('quizzes.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            Back to Quizzes
        </a>
    </div>
</x-app-layout>

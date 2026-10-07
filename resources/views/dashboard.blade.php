<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Portofolio Akademik
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Profile card --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                <p class="text-gray-600">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Bergabung {{ $user->created_at->translatedFormat('d F Y') }}
                    &middot; {{ $projects->count() }} ide proyek
                </p>
            </div>

            {{-- Projects owned by this user, newest first --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Proposal Ide Agentic AI</h3>

                @forelse ($projects as $project)
                    <article class="border-t border-gray-100 py-4 first:border-t-0 first:pt-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="font-medium text-gray-900">{{ $project->judul }}</h4>
                            <span class="text-xs rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5">
                                {{ $project->tema_agent }}
                            </span>
                        </div>
                        <p class="text-gray-700 mt-1">{{ $project->deskripsi ?? '—' }}</p>
                        <p class="text-xs text-gray-500 mt-2">
                            Dibuat {{ $project->created_at->translatedFormat('d F Y H:i') }}
                            &middot; API key tersimpan terenkripsi
                        </p>
                    </article>
                @empty
                    <p class="text-gray-500">Belum ada ide proyek.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

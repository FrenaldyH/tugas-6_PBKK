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

                @if ($profile)
                    <dl class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">NRP</dt>
                            <dd class="font-medium text-gray-900">{{ $profile->nrp }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Departemen</dt>
                            <dd class="font-medium text-gray-900">{{ $profile->departemen }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Angkatan</dt>
                            <dd class="font-medium text-gray-900">{{ $profile->angkatan }}</dd>
                        </div>
                    </dl>

                    @if ($profile->bio)
                        <p class="mt-4 text-gray-700">{{ $profile->bio }}</p>
                    @endif

                    @if ($profile->keahlian)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($profile->keahlian as $skill)
                                <span class="text-xs rounded-full border border-gray-300 text-gray-700 px-2 py-0.5">{{ $skill }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 flex gap-4 text-sm">
                        @if ($profile->github)
                            <a href="{{ $profile->github }}" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">GitHub</a>
                        @endif
                        @if ($profile->linkedin)
                            <a href="{{ $profile->linkedin }}" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">LinkedIn</a>
                        @endif
                    </div>
                @else
                    <p class="mt-4 text-gray-500">Profil akademik belum diisi.</p>
                @endif
            </div>

            {{-- Assignment history, newest submission first --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Tugas Kuliah</h3>

                @forelse ($assignments as $assignment)
                    <article class="border-t border-gray-100 py-4 first:border-t-0 first:pt-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="font-medium text-gray-900">{{ $assignment->judul }}</h4>
                            <span class="text-xs rounded-full bg-gray-100 text-gray-700 px-2 py-0.5">
                                {{ $assignment->mata_kuliah }}
                            </span>
                        </div>
                        @if ($assignment->deskripsi)
                            <p class="text-gray-700 mt-1">{{ $assignment->deskripsi }}</p>
                        @endif
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $assignment->dikumpulkan_pada?->translatedFormat('d F Y') ?? 'Sedang dikerjakan' }}
                            @if ($assignment->link_repo)
                                &middot;
                                <a href="{{ $assignment->link_repo }}" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">Repositori</a>
                            @endif
                        </p>
                    </article>
                @empty
                    <p class="text-gray-500">Belum ada riwayat tugas.</p>
                @endforelse
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

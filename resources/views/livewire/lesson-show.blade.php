<div>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 mb-6 text-sm">
        <a href="{{ route('lessons') }}" class="text-stone-400 hover:text-red-600 transition">📋 Lecciones</a>
        <span class="text-stone-200">›</span>
        <span class="text-stone-600 font-medium">{{ $lesson->title }}</span>
    </div>

    {{-- Header --}}
    <div class="bg-gradient-to-r from-red-600 to-red-800 text-white rounded-3xl p-7 mb-8 shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-5xl mb-3">{{ $lesson->emoji }}</div>
                <h1 class="text-3xl font-bold">{{ $lesson->title }}</h1>
                @if ($lesson->description)
                    <p class="text-red-200 mt-2 text-sm max-w-lg">{{ $lesson->description }}</p>
                @endif
            </div>
            <div class="text-right">
                <div class="text-xs text-red-300 mb-1">Nivel</div>
                <div class="text-3xl font-bold bg-white/20 rounded-2xl px-4 py-2">HSK {{ $lesson->hsk_level }}</div>
                <div class="text-red-200 text-xs mt-2">{{ $lesson->words->count() }} palabras</div>
            </div>
        </div>
    </div>

    {{-- Palabras --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($lesson->words as $index => $word)
            <div class="bg-white border border-stone-100 rounded-2xl shadow-sm p-5 hover:shadow-md transition">
                {{-- Número + emoji + caracter --}}
                <div class="flex items-start gap-3 mb-3">
                    <span class="text-xs text-stone-300 font-bold mt-1 w-5 text-right shrink-0">{{ $index + 1 }}</span>
                    <span class="text-3xl shrink-0">{{ $word->emoji }}</span>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <span class="text-4xl font-bold text-stone-800 leading-none">{{ $word->character }}</span>
                            <span class="text-xs bg-stone-100 text-stone-500 px-2 py-0.5 rounded-full ml-2 shrink-0">{{ $word->type }}</span>
                        </div>
                        <button onclick="speakChinese('{{ $word->character }}', this)"
                            class="text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg px-2 py-0.5 transition text-sm font-semibold flex items-center gap-1 mt-1"
                            title="Escuchar pronunciación">
                            🔊 {{ $word->pinyin }}
                        </button>
                        <div class="text-stone-700 font-bold">{{ $word->translation }}</div>
                    </div>
                </div>

                {{-- Ejemplo --}}
                @if ($word->example_sentence)
                    <div class="bg-stone-50 rounded-xl p-3 mt-2 space-y-0.5">
                        <p class="text-stone-600 text-sm font-medium">💬 {{ $word->example_sentence }}</p>
                        <p class="text-stone-400 text-xs">{{ $word->example_pinyin }}</p>
                        <p class="text-stone-500 text-xs italic">🇪🇸 {{ $word->example_translation }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Botón practicar --}}
    <div class="mt-8 text-center">
        <a href="{{ route('flashcard') }}"
           class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-2xl transition shadow text-lg">
            🃏 Practicar estas palabras con Flashcards
        </a>
    </div>
</div>

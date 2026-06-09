<div>
    {{-- Hero --}}
    <div class="rounded-3xl bg-gradient-to-r from-red-600 to-red-800 text-white p-8 mb-8 shadow-lg">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold mb-1">你好！ 👋</h1>
                <p class="text-red-200 text-lg">Tu diario de aprendizaje de chino mandarín</p>
                <p class="text-red-300 text-sm mt-1">📅 Unidad 1 — Vocabulario de la profesora</p>
            </div>
            <div class="text-6xl">🀄</div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-5">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl">📚</span>
                <span class="text-stone-400 text-sm">Palabras totales</span>
            </div>
            <span class="text-5xl font-bold text-red-600">{{ $totalWords }}</span>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-5">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl">✅</span>
                <span class="text-stone-400 text-sm">Palabras practicadas</span>
            </div>
            <span class="text-5xl font-bold text-amber-500">{{ $studiedWords }}</span>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-5">
            <div class="flex items-center gap-3 mb-2">
                <span class="text-2xl">🎯</span>
                <span class="text-stone-400 text-sm">Precisión</span>
            </div>
            <span class="text-5xl font-bold text-emerald-600">{{ $accuracy }}%</span>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
        <a href="{{ route('flashcard') }}"
           class="bg-gradient-to-br from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white rounded-2xl p-6 transition shadow-sm group">
            <div class="text-3xl mb-3">🃏</div>
            <div class="font-bold text-xl mb-1">Practicar Flashcards</div>
            <div class="text-red-200 text-sm">Repaso aleatorio · Sesiones de 10 palabras</div>
        </a>
        <a href="{{ route('vocab') }}"
           class="bg-gradient-to-br from-amber-400 to-amber-600 hover:from-amber-500 hover:to-amber-700 text-white rounded-2xl p-6 transition shadow-sm group">
            <div class="text-3xl mb-3">📖</div>
            <div class="font-bold text-xl mb-1">Ver Vocabulario</div>
            <div class="text-amber-100 text-sm">Busca, filtra y repasa todas las palabras</div>
        </a>
    </div>

    {{-- Lecciones --}}
    <h2 class="text-xl font-bold text-stone-700 mb-4">📋 Lecciones — Unidad 1</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($lessons as $lesson)
            <a href="{{ route('lessons.show', $lesson->slug) }}"
               class="bg-white border border-stone-100 rounded-2xl shadow-sm p-5 hover:border-red-300 hover:shadow-md transition group">
                <div class="flex items-start justify-between mb-3">
                    <span class="text-4xl">{{ $lesson->emoji }}</span>
                    <span class="text-xs bg-red-100 text-red-700 font-bold px-2 py-1 rounded-full">HSK {{ $lesson->hsk_level }}</span>
                </div>
                <div class="font-bold text-stone-800 text-lg group-hover:text-red-600 transition">{{ $lesson->title }}</div>
                <div class="text-stone-400 text-sm mt-0.5 mb-2">{{ $lesson->words_count }} palabras</div>
                @if ($lesson->description)
                    <p class="text-stone-500 text-sm leading-relaxed">{{ $lesson->description }}</p>
                @endif
            </a>
        @endforeach
    </div>
</div>

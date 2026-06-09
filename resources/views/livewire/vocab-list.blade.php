<div>
    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-stone-800">📖 Vocabulario</h1>
            <p class="text-stone-400 text-sm mt-0.5">Unidad 1 — Vocabulario de la profesora</p>
        </div>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="🔍  Buscar palabra..."
                class="border border-stone-200 rounded-xl px-4 py-2 text-sm w-full sm:w-56 focus:outline-none focus:ring-2 focus:ring-red-400"
            />
            <select wire:model.live="hskFilter"
                class="border border-stone-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                <option value="">Todos HSK</option>
                <option value="1">HSK 1</option>
                <option value="2">HSK 2</option>
            </select>
            <select wire:model.live="typeFilter"
                class="border border-stone-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 bg-white">
                <option value="">Todos los tipos</option>
                <option value="noun">🏷️ Sustantivo</option>
                <option value="verb">⚡ Verbo</option>
                <option value="phrase">💬 Frase</option>
                <option value="adjective">🎨 Adjetivo</option>
                <option value="adverb">📌 Adverbio</option>
                <option value="pronoun">👤 Pronombre</option>
                <option value="conjunction">🔗 Conjunción</option>
                <option value="preposition">📍 Preposición</option>
            </select>
        </div>
    </div>

    {{-- Tarjetas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($words as $word)
            <div class="bg-white border border-stone-100 rounded-2xl shadow-sm p-5 hover:shadow-md transition">
                {{-- Emoji + caracteres --}}
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">{{ $word->emoji }}</span>
                        <span class="text-4xl font-bold text-stone-800 leading-none">{{ $word->character }}</span>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-xs bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded-full">HSK {{ $word->hsk_level }}</span>
                        <span class="text-xs bg-stone-100 text-stone-500 px-2 py-0.5 rounded-full">{{ $word->type }}</span>
                    </div>
                </div>

                {{-- Pinyin + traducción --}}
                <div class="flex items-center gap-2 mb-1">
                    <button onclick="speakChinese('{{ $word->character }}', this)"
                        class="text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg px-2 py-0.5 transition text-sm font-semibold flex items-center gap-1"
                        title="Escuchar pronunciación">
                        🔊 {{ $word->pinyin }}
                    </button>
                </div>
                <div class="text-stone-700 font-bold text-base">{{ $word->translation }}</div>

                {{-- Ejemplo --}}
                @if ($word->example_sentence)
                    <div class="mt-3 pt-3 border-t border-stone-100 space-y-0.5">
                        <p class="text-stone-600 text-sm font-medium">💬 {{ $word->example_sentence }}</p>
                        <p class="text-stone-400 text-xs">{{ $word->example_pinyin }}</p>
                        <p class="text-stone-500 text-xs italic">🇪🇸 {{ $word->example_translation }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-3 text-center py-20 text-stone-300">
                <div class="text-5xl mb-3">🔍</div>
                <p class="text-stone-400">No se encontraron palabras.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $words->links() }}
    </div>
</div>

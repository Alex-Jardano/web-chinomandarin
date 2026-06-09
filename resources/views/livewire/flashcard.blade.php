<div class="max-w-xl mx-auto">
    {{-- Encabezado --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-stone-800">🃏 Flashcards</h1>
        <p class="text-stone-400 text-sm mt-1">
            Sesión de repaso · {{ $sessionCorrect + $sessionWrong }} respondidas
        </p>
    </div>

    @if ($sessionDone)
        {{-- Resultado final --}}
        <div class="bg-white border border-stone-100 rounded-3xl shadow-sm p-10 text-center">
            <div class="text-6xl mb-4">
                @if ($sessionCorrect >= $sessionWrong)
                    🎉
                @else
                    💪
                @endif
            </div>
            <h2 class="text-2xl font-bold text-stone-800 mb-1">¡Sesión completada!</h2>
            <p class="text-stone-400 text-sm mb-6">Sigue practicando para mejorar tu chino 中文</p>
            <div class="flex justify-center gap-10 mb-8">
                <div>
                    <div class="text-4xl font-bold text-emerald-500">{{ $sessionCorrect }}</div>
                    <div class="text-stone-400 text-sm mt-1">✅ Correctas</div>
                </div>
                <div class="border-l border-stone-100"></div>
                <div>
                    <div class="text-4xl font-bold text-red-400">{{ $sessionWrong }}</div>
                    <div class="text-stone-400 text-sm mt-1">❌ Incorrectas</div>
                </div>
            </div>
            <button wire:click="loadSession"
                class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-2xl transition text-lg shadow">
                🔄 Nueva sesión
            </button>
        </div>

    @elseif ($currentWord)
        {{-- Barra de progreso --}}
        @php
            $total = $sessionCorrect + $sessionWrong + count($remainingIds) + 1;
            $done = $sessionCorrect + $sessionWrong;
            $pct = $total > 0 ? round(($done / $total) * 100) : 0;
        @endphp
        <div class="mb-4">
            <div class="flex justify-between text-xs text-stone-400 mb-1">
                <span>Progreso</span>
                <span>{{ $done }}/{{ $total }}</span>
            </div>
            <div class="bg-stone-100 rounded-full h-2">
                <div class="bg-red-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
            </div>
        </div>

        {{-- Tarjeta --}}
        <div class="bg-white border-2 {{ $flipped ? 'border-red-200' : 'border-stone-100' }} rounded-3xl shadow-md p-10 text-center min-h-72 flex flex-col items-center justify-center mb-5 cursor-pointer select-none transition-all duration-200 hover:shadow-lg"
             wire:click="flip">

            <div class="text-5xl mb-4">{{ $currentWord->emoji }}</div>
            <div class="text-7xl font-bold text-stone-800 leading-none mb-4">
                {{ $currentWord->character }}
            </div>
            <button onclick="event.stopPropagation(); speakChinese('{{ $currentWord->character }}', this)"
                class="mb-2 text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 rounded-xl px-4 py-1.5 text-sm font-semibold transition"
                title="Escuchar pronunciación">
                🔊 Escuchar
            </button>

            @if ($flipped)
                <div class="mt-2 space-y-2 w-full">
                    <button onclick="event.stopPropagation(); speakChinese('{{ $currentWord->character }}', this)"
                        class="text-red-500 font-bold text-2xl hover:text-red-700 transition">
                        🔊 {{ $currentWord->pinyin }}
                    </button>
                    <div class="text-stone-700 font-bold text-xl">{{ $currentWord->translation }}</div>
                    @if ($currentWord->example_sentence)
                        <div class="mt-4 bg-stone-50 rounded-2xl p-4 text-left max-w-sm mx-auto">
                            <p class="text-stone-600 text-sm font-medium">💬 {{ $currentWord->example_sentence }}</p>
                            <p class="text-stone-400 text-xs mt-1">{{ $currentWord->example_pinyin }}</p>
                            <p class="text-stone-500 text-xs italic mt-0.5">🇪🇸 {{ $currentWord->example_translation }}</p>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-stone-300 text-sm mt-2">👆 Toca para revelar</p>
            @endif
        </div>

        {{-- Botones --}}
        @if ($flipped)
            <div class="grid grid-cols-2 gap-3">
                <button wire:click="answer(false)"
                    class="bg-red-50 hover:bg-red-100 border-2 border-red-200 text-red-600 font-bold py-4 rounded-2xl transition text-base">
                    ❌ No la sabía
                </button>
                <button wire:click="answer(true)"
                    class="bg-emerald-50 hover:bg-emerald-100 border-2 border-emerald-200 text-emerald-600 font-bold py-4 rounded-2xl transition text-base">
                    ✅ ¡La sabía!
                </button>
            </div>
        @else
            <button wire:click="flip"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl transition text-lg shadow">
                👁️ Revelar respuesta
            </button>
        @endif

        {{-- Mini stats --}}
        <div class="mt-5 flex justify-center gap-8 text-sm">
            <span class="text-emerald-500 font-bold">✅ {{ $sessionCorrect }}</span>
            <span class="text-stone-300">·</span>
            <span class="text-stone-400">Quedan {{ count($remainingIds) }}</span>
            <span class="text-stone-300">·</span>
            <span class="text-red-400 font-bold">❌ {{ $sessionWrong }}</span>
        </div>
    @endif
</div>

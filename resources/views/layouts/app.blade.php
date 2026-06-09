<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '中文学习 · Aprendizaje de Chino')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-stone-50 text-stone-900 min-h-screen font-sans">

    <nav class="bg-red-700 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                <span class="text-2xl font-bold text-yellow-300">中文</span>
                <div class="hidden sm:block">
                    <div class="text-xs text-red-300 leading-none">Mi aprendizaje</div>
                    <div class="text-xs text-red-200 leading-none">Unidad 1</div>
                </div>
            </a>

            <div class="flex items-center gap-1">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('dashboard') ? 'bg-white/20 text-yellow-300' : 'hover:bg-white/10 text-red-100' }}">
                    🏠 <span class="hidden sm:inline">Inicio</span>
                </a>
                <a href="{{ route('vocab') }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('vocab') ? 'bg-white/20 text-yellow-300' : 'hover:bg-white/10 text-red-100' }}">
                    📖 <span class="hidden sm:inline">Vocabulario</span>
                </a>
                <a href="{{ route('flashcard') }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('flashcard') ? 'bg-white/20 text-yellow-300' : 'hover:bg-white/10 text-red-100' }}">
                    🃏 <span class="hidden sm:inline">Flashcards</span>
                </a>
                <a href="{{ route('lessons') }}"
                   class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-medium transition
                          {{ request()->routeIs('lessons*') ? 'bg-white/20 text-yellow-300' : 'hover:bg-white/10 text-red-100' }}">
                    📋 <span class="hidden sm:inline">Lecciones</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="text-center text-stone-300 text-xs py-6 mt-8">
        加油！💪 — ¡Tú puedes aprender chino!
    </footer>

    @livewireScripts
    <script>
        function speakChinese(text, btn) {
            console.log('🔊 speakChinese:', text);

            if (btn) {
                const orig = btn.innerHTML;
                btn.innerHTML = orig.replace('🔊', '⏳');
                setTimeout(() => btn.innerHTML = orig, 3000);
            }

            const audioUrl = `/api/tts/speak?text=${encodeURIComponent(text)}&lang=zh-CN`;
            const audio = new Audio(audioUrl);

            audio.oncanplay = () => console.log('✅ Audio listo para reproducir');
            audio.onplay = () => console.log('▶️ Reproduciendo...');
            audio.onended = () => console.log('✅ Terminó');
            audio.onerror = (e) => console.error('❌ Error audio:', e.message);

            console.log('Intentando reproducir desde:', audioUrl);
            audio.play().catch(err => console.error('❌ Play rechazado:', err.message));
        }
    </script>
</body>
</html>

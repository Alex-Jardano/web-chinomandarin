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
        // Pre-cargar voces al iniciar
        if ('speechSynthesis' in window) {
            window.speechSynthesis.getVoices();
        }

        function speakChinese(text, btn) {
            console.group('🔊 speakChinese("' + text + '")');

            if (btn) {
                const orig = btn.innerHTML;
                btn.innerHTML = orig.replace('🔊', '⏳');
                setTimeout(() => btn.innerHTML = orig, 900);
            }

            // 1. ¿Existe speechSynthesis?
            if (!('speechSynthesis' in window)) {
                console.warn('❌ speechSynthesis NO disponible en este navegador');
                console.log('→ Intentando Google TTS como fallback...');
                console.groupEnd();
                playGoogleTTS(text);
                return;
            }
            console.log('✅ speechSynthesis disponible');

            // 2. Estado actual
            console.log('paused:', window.speechSynthesis.paused);
            console.log('speaking:', window.speechSynthesis.speaking);
            console.log('pending:', window.speechSynthesis.pending);

            window.speechSynthesis.cancel();

            function attempt() {
                const voices = window.speechSynthesis.getVoices();
                console.log('Total voces cargadas:', voices.length);

                if (voices.length === 0) {
                    console.warn('⚠️ Sin voces disponibles todavía');
                }

                const allLangs = [...new Set(voices.map(v => v.lang))].sort();
                console.log('Idiomas disponibles:', allLangs);

                const zhVoice = voices.find(v => v.lang === 'zh-CN')
                             || voices.find(v => v.lang === 'zh-TW')
                             || voices.find(v => v.lang.startsWith('zh'));

                if (zhVoice) {
                    console.log('✅ Voz china encontrada:', zhVoice.name, zhVoice.lang);
                } else {
                    console.warn('❌ Ninguna voz china encontrada → usando Google TTS');
                    console.groupEnd();
                    playGoogleTTS(text);
                    return;
                }

                const utterance = new SpeechSynthesisUtterance(text);
                utterance.voice = zhVoice;
                utterance.lang = zhVoice.lang;
                utterance.rate = 0.8;

                utterance.onstart   = () => console.log('▶️ Reproduciendo...');
                utterance.onend     = () => { console.log('✅ Terminó'); console.groupEnd(); };
                utterance.onerror   = (e) => {
                    console.error('❌ Error en utterance:', e.error);
                    console.log('→ Intentando Google TTS como fallback...');
                    console.groupEnd();
                    playGoogleTTS(text);
                };

                console.log('→ Llamando speechSynthesis.speak()...');
                window.speechSynthesis.speak(utterance);
            }

            const voices = window.speechSynthesis.getVoices();
            if (voices.length > 0) {
                attempt();
            } else {
                console.log('⏳ Voces no cargadas aún, esperando voiceschanged (timeout 300ms)...');
                let fired = false;
                window.speechSynthesis.addEventListener('voiceschanged', () => {
                    if (!fired) { fired = true; attempt(); }
                }, { once: true });
                setTimeout(() => {
                    if (!fired) {
                        fired = true;
                        console.warn('⏰ voiceschanged nunca disparó → Google TTS directo');
                        console.groupEnd();
                        playGoogleTTS(text);
                    }
                }, 300);
            }
        }

        function playGoogleTTS(text) {
            const url = 'https://translate.google.com/translate_tts?ie=UTF-8&tl=zh-CN&client=tw-ob&q='
                      + encodeURIComponent(text);
            console.log('🌐 Google TTS URL:', url);
            const audio = new Audio(url);
            audio.oncanplay = () => console.log('✅ Google TTS: audio listo');
            audio.onplay    = () => console.log('▶️ Google TTS: reproduciendo');
            audio.onerror   = (e) => console.error('❌ Google TTS error:', e);
            audio.play()
                .then(() => console.log('✅ Google TTS play() OK'))
                .catch(e => console.error('❌ Google TTS play() rechazado:', e.message));
        }
    </script>
</body>
</html>

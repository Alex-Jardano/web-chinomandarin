@extends('layouts.app')
@section('title', '中文学习 · Lecciones')
@section('content')
    <div>
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-stone-800">📋 Lecciones</h1>
            <p class="text-stone-400 text-sm mt-1">Unidad 1 — Vocabulario de la profesora · {{ $lessons->sum('words_count') }} palabras en total</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($lessons as $index => $lesson)
                <a href="{{ route('lessons.show', $lesson->slug) }}"
                   class="bg-white border border-stone-100 rounded-2xl shadow-sm p-6 hover:border-red-300 hover:shadow-md transition group">

                    <div class="flex items-start justify-between mb-4">
                        <span class="text-5xl">{{ $lesson->emoji }}</span>
                        <span class="text-xs bg-red-100 text-red-700 font-bold px-2 py-1 rounded-full">HSK {{ $lesson->hsk_level }}</span>
                    </div>

                    <div class="font-bold text-stone-800 text-lg group-hover:text-red-600 transition mb-1">
                        {{ $lesson->title }}
                    </div>
                    <div class="text-stone-400 text-sm mb-3">{{ $lesson->words_count }} palabras</div>

                    @if ($lesson->description)
                        <p class="text-stone-500 text-sm leading-relaxed">{{ $lesson->description }}</p>
                    @endif

                    <div class="mt-4 text-red-500 text-sm font-semibold group-hover:translate-x-1 transition-transform">
                        Ver lección →
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

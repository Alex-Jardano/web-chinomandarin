<?php

use App\Models\Lesson;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/vocabulario', function () {
    return view('pages.vocab');
})->name('vocab');

Route::get('/flashcards', function () {
    return view('pages.flashcard');
})->name('flashcard');

Route::get('/lecciones', function () {
    $lessons = Lesson::withCount('words')->orderBy('order')->get();
    return view('pages.lessons', compact('lessons'));
})->name('lessons');

Route::get('/lecciones/{slug}', function (string $slug) {
    $lesson = Lesson::where('slug', $slug)->firstOrFail();
    return view('pages.lesson-show', compact('lesson'));
})->name('lessons.show');

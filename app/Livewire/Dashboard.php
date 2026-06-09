<?php

namespace App\Livewire;

use App\Models\Lesson;
use App\Models\Progress;
use App\Models\Word;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalWords = Word::count();
        $studiedWords = Progress::count();
        $correctTotal = Progress::sum('correct_count');
        $wrongTotal = Progress::sum('wrong_count');
        $accuracy = ($correctTotal + $wrongTotal) > 0
            ? round(($correctTotal / ($correctTotal + $wrongTotal)) * 100)
            : 0;

        $lessons = Lesson::withCount('words')->orderBy('order')->get();

        return view('livewire.dashboard', compact(
            'totalWords', 'studiedWords', 'accuracy', 'lessons'
        ));
    }
}

<?php

namespace App\Livewire;

use App\Models\Lesson;
use Livewire\Component;

class LessonShow extends Component
{
    public Lesson $lesson;

    public function mount(Lesson $lesson): void
    {
        $this->lesson = $lesson->load('words');
    }

    public function render()
    {
        return view('livewire.lesson-show');
    }
}

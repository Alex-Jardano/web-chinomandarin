<?php

namespace App\Livewire;

use App\Models\Progress;
use App\Models\Word;
use Livewire\Component;

class Flashcard extends Component
{
    public ?Word $currentWord = null;
    public bool $flipped = false;
    public bool $sessionDone = false;
    public int $sessionCorrect = 0;
    public int $sessionWrong = 0;
    public array $remainingIds = [];

    public function mount(): void
    {
        $this->loadSession();
    }

    public function loadSession(): void
    {
        $this->remainingIds = Word::inRandomOrder()->limit(10)->pluck('id')->toArray();
        $this->sessionCorrect = 0;
        $this->sessionWrong = 0;
        $this->sessionDone = false;
        $this->nextCard();
    }

    public function flip(): void
    {
        $this->flipped = !$this->flipped;
    }

    public function answer(bool $correct): void
    {
        if (!$this->currentWord) return;

        $progress = Progress::firstOrCreate(['word_id' => $this->currentWord->id]);

        if ($correct) {
            $progress->increment('correct_count');
            $this->sessionCorrect++;
        } else {
            $progress->increment('wrong_count');
            $this->sessionWrong++;
        }

        $progress->update([
            'last_reviewed_at' => now(),
            'next_review_at' => now()->addHours($correct ? 24 : 4),
        ]);

        $this->nextCard();
    }

    private function nextCard(): void
    {
        if (empty($this->remainingIds)) {
            $this->sessionDone = true;
            $this->currentWord = null;
            return;
        }

        $id = array_shift($this->remainingIds);
        $this->currentWord = Word::find($id);
        $this->flipped = false;
    }

    public function render()
    {
        return view('livewire.flashcard');
    }
}

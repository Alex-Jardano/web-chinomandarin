<?php

namespace App\Livewire;

use App\Models\Word;
use Livewire\Component;
use Livewire\WithPagination;

class VocabList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $hskFilter = '';
    public string $typeFilter = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $words = Word::with('lesson')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('character', 'like', "%{$this->search}%")
                  ->orWhere('pinyin', 'like', "%{$this->search}%")
                  ->orWhere('translation', 'like', "%{$this->search}%");
            }))
            ->when($this->hskFilter, fn($q) => $q->where('hsk_level', $this->hskFilter))
            ->when($this->typeFilter, fn($q) => $q->where('type', $this->typeFilter))
            ->orderBy('hsk_level')
            ->orderBy('id')
            ->paginate(20);

        return view('livewire.vocab-list', compact('words'));
    }
}

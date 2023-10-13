<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class SearchResult extends Component
{
    public $search;

    public $showResult = false;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.search-result');
    }

    public function records()
    {
        $q = Course::query();

        $q = $q->where('title', 'LIKE', '%' . $this->search . '%');

        $q = $q->with('category');

        $q = $q->withCount('modules');

        return $q->paginate(4);
    }

    public function updatedSearch()
    {
        $this->showResult = true;
        $this->records();
    }
}

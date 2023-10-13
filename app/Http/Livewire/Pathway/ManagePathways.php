<?php

namespace App\Http\Livewire\Pathway;

use App\Models\Pathway;
use Livewire\Component;
use App\Enums\CourseStatus;

class ManagePathways extends Component
{
    # Data
    public $pathways = [];
    public $filter;

    public $deletingID;

    public $count;
    protected $queryString = ['filter'];

    public function render()
    {
        return view('livewire.pathway.manage-pathways');
        
    }

    public function mount()
    {
        $querys = [];
        $querys['published'] = Pathway::where('status', CourseStatus::Published)->latest();
        $querys['draft'] = Pathway::where('status', CourseStatus::Draft)->latest();
        $querys['deleted'] = Pathway::withTrashed()->whereNotNull('deleted_at')->latest();
        $querys['all'] = Pathway::latest();

        $this->count['published'] = $querys['published']->count();
        $this->count['draft'] = $querys['draft']->count();
        $this->count['deleted'] = $querys['deleted']->count();
        $this->count['all'] = $querys['all']->count();
        
        if ($this->filter == '')
            $this->pathways = $querys['all']->get();
        else {
            $this->pathways = $querys[$this->filter]->get();
        }
    }

    public function deletePathway()
    {
        $pathway = Pathway::findOrFail($this->deletingID);
        $pathway->delete();
        $this->deletingID = null;
        $this->pathways = Pathway::withCount('courses')->get();
    }
}

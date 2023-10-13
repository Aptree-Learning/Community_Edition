<?php

namespace App\Http\Livewire\Pathway;

use App\Models\Course;
use App\Models\Pathway;
use Livewire\Component;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Tables\Concerns\InteractsWithTable;

class PathwayContents extends Component
{
    use LivewireAlert;

    public Pathway $pathway;
    public $pathway_id;
    public $courses;
    public $assign_courses;
    public $confirmModal;
    public function render()
    {
        return view('livewire.pathway.pathway-contents');
    }

    public function mount($id)
    {
        $this->pathway_id = $id;
        $this->pathway = Pathway::findOrFail($id);
        $this->courses = Course::all();
        $this->assign_courses = $this->pathway->courses->pluck('id')->unique()->values()->all();
        $this->confirmModal = false;
    }

    public function assignCourse()
    {
        $this->pathway->courses()->sync($this->assign_courses);

        return redirect()->route('pathway.index');
    }
}

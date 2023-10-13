<?php

namespace App\Http\Livewire\Courses;

use App\Models\Module;
use Livewire\Component;
use Filament\Forms\Components\Grid;
use App\Forms\Components\SelectIcon;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;

class EditModule extends Component implements HasForms
{
    use InteractsWithForms;

    public $module_id;
    public $title, $icon;

    protected $listeners = ['editModule' => 'setModule'];
    
    public function render()
    {   
        return view('livewire.courses.edit-module');
    }

    public function setModule($id)
    {
        $this->module_id = $id;

        $module = Module::find($id);

        $this->form->fill([
            'title' => $module->title,
        ]);

        $this->dispatchBrowserEvent('openmodal-module-edit');
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(5)
            ->schema([
                TextInput::make('title')->columnSpan('full'),
            ])
        ];
    }

    public function submit()
    {   
        $data = $this->form->getState();

        $module = Module::find($this->module_id);
        $module->fill($data);
        $module->save();

        return redirect(request()->header('Referer'));
    }
}

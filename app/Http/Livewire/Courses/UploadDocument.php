<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use App\Enums\ActionType;
use App\Models\ModuleItem;
use App\Enums\ModuleItemType;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;

class UploadDocument extends Component implements HasForms
{
    use InteractsWithForms;

    public $action;

    public $title, $module_id, $module_item_id,  $type, $document;

    protected $listeners = ['editDocument' => 'edit'];
    
    public function render()
    {
        return view('livewire.courses.upload-document');
    }

    public function mount($moduleId)
    {
        $this->module_id = $moduleId;
        $this->type = ModuleItemType::Document; 
    }

    protected function getFormSchema(): array
    {
        return [
                Hidden::make('type'),
                TextInput::make('title')->required(),
                FileUpload::make('document')
                ->required(function(){
                    return $this->action == ActionType::Update ? false : true;
                })
                ->disk('do')
                ->directory('documents')
                ->visibility('public')
                ->columnSpan('full')
                ->imagePreviewHeight('100')
                ->loadingIndicatorPosition('left')
                ->panelAspectRatio('4:1')
                ->panelLayout('integrated')
                ->removeUploadedFileButtonPosition('right')
                ->uploadButtonPosition('left')
                ->uploadProgressIndicatorPosition('left')
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        if($this->action == ActionType::Update)
        {   
            $module_item = ModuleItem::find($this->module_item_id);
            $module_item->update([
                'title' => $data['title']
            ]);

        }else{
            $module = Module::find($this->module_id);
            $module->items()->create([
                'type' => $this->type,
                'title' => $data['title'],
                'document' => $data['document']
            ]);
        }
        

        return redirect(request()->header('Referer'));
        
    }

    public function edit($id)
    {
        $this->module_item_id = $id;
        $module_item = ModuleItem::find($id);
        $this->action = ActionType::Update;

        $this->form->fill([
            'title' => $module_item->title
        ]);
        $this->dispatchBrowserEvent('openmodal-upload');
    }
}

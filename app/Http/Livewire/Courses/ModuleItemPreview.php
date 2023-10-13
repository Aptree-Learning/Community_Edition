<?php

namespace App\Http\Livewire\Courses;

use App\Models\Answer;
use Livewire\Component;
use App\Models\ModuleItem;
use App\Enums\ModuleItemType;

class ModuleItemPreview extends Component
{
    public $module;

    public $selected_answer, $is_correct, $answers = [];

    public function render()
    {
        return view('livewire.courses.module-item-preview')->layout('layouts.slider');
    }

    public function mount($id)
    {
        $this->module = ModuleItem::find($id);

        if($this->module->type->value == ModuleItemType::Question)
        {
            $this->answers = $this->module->question?->answers()->inRandomOrder()->get();
        }
    }

    public function selectAnswer($answerId)
    {
        $answer = Answer::find($answerId);
        
        $this->selected_answer = $answerId;
        $this->is_correct = $answer->is_correct;
    }
}

<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use App\Models\ModuleItem;
use App\Enums\CourseStatus;
use App\Enums\ModuleItemType;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CourseContents extends Component
{
    use LivewireAlert;
    
    public $course, $modules = [];

    public $module_id, $selected_module;

    protected $queryString = ['module_id'];

    protected $listeners = [ 'refreshParent' => '$refresh', 'confirmPublish'];

    public function render()
    {
        if($this->module_id){
            $this->selectModule($this->module_id);
        }

        $this->modules = $this->course->modules()->orderBy('order')->get();

        
        return view('livewire.courses.course-contents');
    }

    public function mount($id)
    {
        $this->course = Course::find($id);
    }

    public function selectModule($id)
    {
        $this->reset('selected_module');

        $this->module_id = $id;
        $this->selected_module = Module::find($id);
    }

    

    public function editCard($module_item_id)
    {
        $module = ModuleItem::find($module_item_id);

        if($module->type->value == ModuleItemType::Content){
            $this->emit('editContent', $module_item_id);
        }

        if($module->type->value == ModuleItemType::Document){
            $this->emit('editDocument', $module_item_id);
        }

        if($module->type->value == ModuleItemType::Question){
            $this->emit('editQuestion', $module_item_id);
        }

        if($module->type->value == ModuleItemType::Video){
            $this->emit('editVideo', $module_item_id);
        }
    }

    public function deleteCard($module_item_id)
    {
        ModuleItem::destroy($module_item_id);

        $this->emit('toast', ['type' => 'success', 'Deleted!']);
    }

    public function editModule($module_id)
    {
        $this->emit('editModule', $module_id);
    }

    public function deleteModule($module_id)
    {
        Module::destroy($module_id);

        return redirect()->route('courses.contents', $this->course->id);
    }

    public function createContent($layout)
    {
        $this->emit('setContentType', ['module_id' => $this->module_id, 'layout' => $layout] );
    }

    public function createQuestion($type)
    {
        $this->emit('createQuestion', ['module_id' => $this->module_id, 'type' => $type] );
    }

    public function createAiQuestion()
    {
        $this->emit('createAiQuestion', ['module_id' => $this->module_id] );
    }

    public function reorderTable($data)
    {
        Module::setNewOrder($data);
    }

    public function reorderModuleItems($data)
    {
        ModuleItem::setNewOrder($data);
    }

    public function publish()
    {
        $this->confirm("Are you sure you want to publish this course?", [
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, Publish this Course',
            'onConfirmed' => 'confirmPublish' 
        ]);
    }

    public function confirmPublish()
    {
        $this->course->status = CourseStatus::Published;
        $this->course->save();

        $this->alert('success', 'Course has been published!');
    }

    public function save()
    {
        // $this->confirm("Save changes?", [
        //     'position' => 'center',
        //     'showConfirmButton' => true,
        //     'confirmButtonText' => 'Yes',
        // ]);
    }
}

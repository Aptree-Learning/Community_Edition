<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CourseIcons extends Component
{
    public $icon;
    public $class = "";

    public function render()
    {
        return view('livewire.course-icons');
    }
}

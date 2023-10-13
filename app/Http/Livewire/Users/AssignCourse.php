<?php

namespace App\Http\Livewire\Users;

use Auth;
use Mail;
use App\Models\Course;
use App\Models\Pathway;
use App\Models\User;
use App\Enums\CourseStatus;
use App\Mail\AssignedToCourse;
use App\Mail\AssignedToPathway;
use Livewire\Component;
use App\Models\Assignment;
use App\Mail\AssignedToTeam;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AssignCourse extends Component
{
    use LivewireAlert;

    # Data
    public $courses = [];
    public $pathways = [];

    # Props
    public $user_id;
    public $assign_courses = [];
    public $assign_pathways = [];

    public function render()
    {
        return view('livewire.users.assign-course');
    }

    public function mount($userId)
    {
        $this->user_id = $userId;
        $user = User::findOrFail($userId);
        $this->courses = Course::whereStatus(CourseStatus::Published)->get();
        $this->pathways = Pathway::whereStatus(CourseStatus::Published)->get();
        $this->assign_courses = $user->courses->pluck('id')->unique()->values()->all();
        $this->assign_pathways = $user->pathways->pluck('id')->unique()->values()->all();
    }

    public function assignCoursse()
    {
        $user = User::findOrFail($this->user_id);
        $result = $user->courses()->syncWithPivotValues($this->assign_courses, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
        
        foreach($result['attached'] as $eachAttached)
        {
            $course = Course::findOrFail($eachAttached);
            Mail::to($user->email)->send(new AssignedToCourse($course));
        }

        $this->alert('success', 'Assignment sent!');
    }
    
    public function assignPathway()
    {
        $user = User::findOrFail($this->user_id);
        $result = $user->pathways()->syncWithPivotValues($this->assign_pathways, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
        
        foreach($result['attached'] as $eachAttached)
        {
            $pathway = Pathway::findOrFail($eachAttached);
            var_dump((new AssignedToPathway($pathway))->render());exit;
            Mail::to($user->email)->send(new AssignedToPathway($pathway));
        }

        $this->alert('success', 'Assignment sent!');
    }
}

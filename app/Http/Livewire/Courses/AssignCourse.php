<?php

namespace App\Http\Livewire\Courses;

use Auth;
use Mail;
use App\Models\User;
use App\Models\Team;
use App\Models\Course;
use Livewire\Component;
use App\Models\Assignment;
use App\Mail\AssignedToCourse;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AssignCourse extends Component
{
    use LivewireAlert;

    # Data
    public $users = [];
    public $teams = [];

    # Props
    public $course_id;
    public $assign_users = [];
    public $assign_teams = [];

    public function render()
    {
        return view('livewire.courses.assign-course');
    }

    public function mount($courseId)
    {
        $this->course_id = $courseId;
        $course = Course::findOrFail($courseId);
        $this->users = User::get();
        $this->teams = Team::get();
        $this->assign_users = $course->assignments()->pluck('user_id')->unique()->values()->all();
        $this->assign_teams = $course->assignments()->pluck('team_id')->unique()->values()->all();
    }

    public function assignIndividual()
    {
        $course = Course::findOrFail($this->course_id);
        $result = $course->users()->syncWithPivotValues($this->assign_users, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
        
        foreach($result['attached'] as $eachAttached)
        {
            $user = User::findOrFail($eachAttached);
            Mail::to($user->email)->send(new AssignedToCourse($course));
        }

        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-course-' . $this->course_id);
    }
    
    public function assignTeam()
    {
        $course = course::findOrFail($this->course_id);
        $result = $course->teams()->syncWithPivotValues($this->assign_teams, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-course-' . $this->course_id);
    }

}

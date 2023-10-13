<?php

namespace App\Http\Livewire\Teams;

use Auth;
use Mail;
use App\Models\Course;
use App\Models\Pathway;
use App\Models\Team;
use App\Enums\CourseStatus;
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
    public $team_id;
    public $assign_courses = [];
    public $assign_pathways = [];

    public function render()
    {
        return view('livewire.teams.assign-course');
    }

    public function mount($teamId)
    {
        $this->team_id = $teamId;
        $team = Team::findOrFail($teamId);
        $this->courses = Course::whereStatus(CourseStatus::Published)->get();
        $this->pathways = Pathway::whereStatus(CourseStatus::Published)->get();
        $this->assign_courses = $team->courses->pluck('id')->unique()->values()->all();
        $this->assign_pathways = $team->pathways->pluck('id')->unique()->values()->all();
    }

    public function assignCoursse()
    {
        $team = Team::findOrFail($this->team_id);
        $result = $team->courses()->syncWithPivotValues($this->assign_courses, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);

        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-course-' . $this->team_id);
    }
    
    public function assignPathway()
    {
        $team = Team::findOrFail($this->team_id);
        $result = $team->pathways()->syncWithPivotValues($this->assign_pathways, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);

        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-course-' . $this->team_id);
    }
}

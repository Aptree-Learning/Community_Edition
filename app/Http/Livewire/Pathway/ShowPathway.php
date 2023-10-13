<?php

namespace App\Http\Livewire\Pathway;

use App\Models\Pathway;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ShowPathway extends Component
{
    public Pathway $pathway;

    public $graph_students_enrolled = 0, $graph_courses = 0, $graph_completed = 0;

    public function render()
    {
        return view('livewire.pathway.show-pathway');
    }

    public function mount($id)
    {
        $this->pathway = Pathway::with('courses', 'goal')->withCount('courses')->findOrFail($id);
        $this->getGraphData();
    }

    public function getGraphData()
    {
        $assignments = $this->pathway->assignments;
        $users_enrolled = collect([]);
        foreach($assignments as $eachAssignment) {
            if ($eachAssignment->user_id) {
                $users_enrolled->push($eachAssignment->user_id);
            } else if ($eachAssignment->team_id) {
                if ($team = $eachAssignment->team) {
                    $users = $team->users;
                    foreach($users as $eachUser)
                        $users_enrolled->push($eachUser->id);
                }
            }
        }
        $users = $users_enrolled->unique()->values()->all();
        $this->graph_students_enrolled = count($users);

        $courses = $this->pathway->courses->pluck('id')->values()->all();
        $this->graph_courses = count($courses);

        $users = User::whereIn('id', $users)
                        ->with(['enrollments' => function (Builder $query) {
                            $query->whereNotNull('completed_at');
                        }])
                        ->get();
        foreach($users as $eachUser) {
            $completed_courses = $eachUser->enrollments->pluck('id')->unique()->all();
            if (count(array_intersect($completed_courses, $courses)) == count($courses))
                $this->graph_completed++;
        }
    }
}

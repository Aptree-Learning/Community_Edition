<?php

namespace App\Http\Livewire\Reports;

use Closure;
use App\Models\Team;
use App\Models\Pathway;
use App\Models\Course;
use Filament\Tables\Columns\TextColumn;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;


class TeamReports extends Component
{
    public $team;
    public $courses;
    public $pathways;
    public $assignments;

    public function mount($id)
    {
        $this->team = Team::findOrFail($id);
        $this->team->load(['users.enrollments' => function($query) {
            $query->whereNotNull('completed_at');
        }]);
        $users = $this->team->users;

        $userAssignments = collect();
        $users->each(function($item, $key) use ($userAssignments) {
            $item->enrollments->each(function($iitem, $kkey) use ($userAssignments) {
                $userAssignments->push($iitem);
            });
        });
        $mpArr = [];
        $userAssignments->each(function($item, $key) use (&$mpArr) {
            $mpArr[$item['user_id']][$item['course_id']] = $item['completed_at'];
        });

        $this->assignments = $this->team->assignments->load(['assignmentable']);
        $courses = [];

        foreach($this->assignments as $index => &$eachAssignment) {
            if (is_a($eachAssignment->assignmentable, Course::class) ) {
                $flag = '1970-01-01 00:00:00';
                $course = $eachAssignment->assignmentable;
                foreach($users as $eachUser) {
                    if ( empty($mpArr[$eachUser['id']][$course['id']])) {
                        $flag = false;
                        break;
                    } else if ($mpArr[$eachUser['id']][$course['id']] > $flag) {
                        $flag = $mpArr[$eachUser['id']][$course['id']];
                    }
                }
                $eachAssignment->completed_at = $flag;
                $courses[$course->id]['completed_at'] = $flag;
            }
        }
        foreach($this->assignments as $index => &$eachAssignment) {
            if (is_a($eachAssignment->assignmentable, Pathway::class) ) {
                $pathway = $eachAssignment->assignmentable->load('courses');
                $flag = '1970-01-01 00:00:00';
                foreach($pathway->courses as $eachCourse) {
                    if (empty($courses[$eachCourse->id])) {
                        $flag = false;
                        break;
                    } else {
                        if ($courses[$eachCourse->id]) {
                            if ($flag < $courses[$eachCourse->id]['completed_at'])
                                $flag = $courses[$eachCourse->id]['completed_at'];
                        } else {
                            $flag = false;
                            break;
                        }
                    }
                }
                $eachAssignment->completed_at = $flag;
            }
        }
    }

    public function render(): View
    {
        return view('livewire.reports.team-reports');
    }
}

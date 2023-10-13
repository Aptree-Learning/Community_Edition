<?php

namespace App\Http\Livewire\Reports;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class IndividualReports extends Component
{
    public $user;
    public $courses;
    public $pathways;
    public $enrollments;

    public function render()
    {
        return view('livewire.reports.individual-reports');
        
    }

    public function mount($id=null)
    {
        if ($id)
            $this->user = User::findOrFail($id);
        else
            $this->user = Auth::user();

        $enrollments = $this->user->enrollments->load('enrollmentModuleItems');
        $this->enrollments = $enrollments->mapWithKeys(function($item, $key) {
            return [$item['course_id'] => $item];
        });
        foreach($this->enrollments as &$eachEnrollment) {
            $score = $eachEnrollment->enrollmentModuleItems->sum('is_correct');
            $count = $eachEnrollment->enrollmentModuleItems->count();
            if ($count)
                $eachEnrollment->score = $score/$count * 100;
            else
                $eachEnrollment->score = 0;
        }


        $courses = $this->user->courses;
        $course_ids = $courses->pluck('id')->merge(($enrollments->pluck('course_id')))->unique();
        $this->courses = Course::whereIn('id', $course_ids)->get();
        foreach($this->courses as &$eachCourse) {
            if (isset($enrollments[$eachCourse->id]) && $enrollments[$eachCourse->id]['completed_at']) {
                $eachCourse['completed_at'] = $enrollments[$eachCourse->id]['completed_at'];
            } else {
                $eachCourse['completed_at'] = null;
            }

            if (isset($enrollments[$eachCourse->id])) {
                $eachCourse['score'] = $enrollments[$eachCourse->id]['score'];
            } else {
                $eachCourse['score'] = null;
            }
            
            if (isset($enrollments[$eachCourse->id]) && $enrollments[$eachCourse->id]['completed_at'] && ($enrollments[$eachCourse->id]['score'] >= $eachCourse->passing_score)) {
                $eachCourse['passing'] = true;
            } else {
                $eachCourse['passing'] = false;
            }

        }
        $this->courses = $this->courses->mapWithKeys(function($item, $key) {
            return [$item['id'] => $item];
        });

        $this->pathways = $this->user->pathways;
        foreach($this->pathways as &$eachPathway) {
            $started = "1970-01-01 00:00:00";
            $completed = "1970-01-01 00:00:00";
            $passing = true;

            foreach($eachPathway->courses as $eachCourse) {
                if (isset($this->enrollments[$eachCourse->id]) && $started < $this->enrollments[$eachCourse->id]['created_at']) {
                    $started = $this->enrollments[$eachCourse->id]['created_at'];
                }
                if ($completed && isset($this->courses[$eachCourse->id])) {
                    if ($completed < $this->courses[$eachCourse->id]['completed_at']) {
                        $completed = $this->courses[$eachCourse->id]['completed_at'];
                    } 
                }
                $passing = $passing & $eachCourse['passing'];
            }

            if ($eachPathway->courses->count()) {
                $eachPathway->score = $eachPathway->courses->sum('score') / $eachPathway->courses->count();
                $eachPathway->passing = $passing;
            } else {
                $eachPathway->passing = null;
                $eachPathway->score = null;
            }
            $eachPathway->created_at = $started != "1970-01-01 00:00:00" ? $started : false;
            $eachPathway->completed_at = $completed != "1970-01-01 00:00:00" ? $completed: false;
        }
    }
}

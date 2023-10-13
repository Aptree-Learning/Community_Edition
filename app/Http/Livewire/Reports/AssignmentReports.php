<?php

namespace App\Http\Livewire\Reports;

use Closure;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Pathway;
use Livewire\Component;


class AssignmentReports extends Component
{
    public $assignment;
    public $users;
    public $teams;

    public function mount($id)
    {
        $this->assignment = Assignment::findOrFail($id);
        $assignmentable = $this->assignment->assignmentable;
        $this->users = $assignmentable->users;
        $this->teams = $assignmentable->teams;

        if (is_a($assignmentable, Course::class)) {
            $userCompletes = [];

            $this->users->load(['enrollments' => function($query) use ($assignmentable) {
                $query->whereCourseId($assignmentable->id)->whereNotNull('completed_at');
            }]);
            $this->teams->load(['users.enrollments' => function($query) use ($assignmentable) {
                $query->whereCourseId($assignmentable->id)->whereNotNull('completed_at');
            }]);

            foreach($this->users as &$eachUser) {
                if ($eachUser['enrollments']->count()) {
                    $userCompletes[$eachUser->id] = $eachUser['enrollments'][0]->completed_at;
                    $eachUser->completed_at = $eachUser['enrollments'][0]->completed_at;
                }
            }
            $totalUsers = $this->teams->pluck('users')->collapse();

            foreach($totalUsers as $eachUser) {
                if (!isset($userCompletes[$eachUser['id']])) {
                    if ($eachUser['enrollments']->count()) {
                        $userCompletes[$eachUser->id] = $eachUser['enrollments'][0]->completed_at;
                    }
                }
            }
            
            foreach($this->teams as &$eachTeam) {
                $flag = '1970-01-01 00:00:00';
                foreach($eachTeam->users as $eachUser) {
                    if (empty($userCompletes[$eachUser->id])) {
                        $flag = false;
                        break;
                    } else {
                        if ($flag < $userCompletes[$eachUser->id])
                            $flag = $userCompletes[$eachUser->id];
                    }
                }
                $eachTeam->completed_at = $flag;
            }
        } else {
            $courses = $assignmentable->courses;
            $userCompletesArr = [];
            $groupCompletesArr = [];

            foreach($courses as $assignmentable) {
                $userCompletes = [];

                $this->users->load(['enrollments' => function($query) use ($assignmentable) {
                    $query->whereCourseId($assignmentable->id)->whereNotNull('completed_at');
                }]);
                $this->teams->load(['users.enrollments' => function($query) use ($assignmentable) {
                    $query->whereCourseId($assignmentable->id)->whereNotNull('completed_at');
                }]);
                
                foreach($this->users as &$eachUser) {
                    if ($eachUser['enrollments']->count()) {
                        $userCompletes[$eachUser->id] = $eachUser['enrollments'][0]->completed_at;
                        $userCompletesArr[$assignmentable->id][$eachUser->id] = $eachUser['enrollments'][0]->completed_at;
                    }
                }

                $totalUsers = $this->teams->pluck('users')->collapse();

                foreach($totalUsers as $eachUser) {
                    if (!isset($userCompletes[$eachUser['id']])) {
                        if ($eachUser['enrollments']->count()) {
                            $userCompletes[$eachUser->id] = $eachUser['enrollments'][0]->completed_at;
                        }
                    }
                }
                
                foreach($this->teams as &$eachTeam) {
                    $flag = '1970-01-01 00:00:00';
                    foreach($eachTeam->users as $eachUser) {
                        if (empty($userCompletes[$eachUser->id])) {
                            $flag = false;
                            break;
                        } else {
                            if ($flag < $userCompletes[$eachUser->id])
                                $flag = $userCompletes[$eachUser->id];
                        }
                    }
                    $groupCompletesArrp[$assignmentable->id][$eachTeam->id] = $flag;
                }
            }
            
            foreach($this->users as &$eachUser) {
                foreach($courses as $eachCourse) {
                    $flag = '1970-01-01 00:00:00';
                    if (!empty($userCompletesArr[$eachCourse->id][$eachUser->id])) {
                        if ($flag < $userCompletesArr[$eachCourse->id][$eachUser->id])
                            $flag = $userCompletesArr[$eachCourse->id][$eachUser->id];
                    } else {
                        $flag = false;
                        break;
                    }
                }
                $eachUser['completed_at'] = $flag;
            }

            foreach($this->teams as &$eachTeam) {
                foreach($courses as $eachCourse) {
                    $flag = '1970-01-01 00:00:00';
                    if (!empty($groupCompletesArr[$eachCourse->id][$eachUser->id])) {
                        if ($flag < $groupCompletesArr[$eachCourse->id][$eachUser->id])
                            $flag = $groupCompletesArr[$eachCourse->id][$eachUser->id];
                    } else {
                        $flag = false;
                        break;
                    }
                }
                $eachTeam['completed_at'] = $flag;
            }
        }
    }

    public function render()
    {
        return view('livewire.reports.assignment-reports');
    }
}

<?php

namespace App\Http\Livewire\Courses;

use Str;
use Auth;
use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\EnrollmentModule;
use App\Enums\CourseStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ShowCourse extends Component
{
    use LivewireAlert;
    
    public $course;
    public $enrollment_record;
    public $modules = [];

    public $graph_students_enrolled=0, $graph_pathways = 0, $graph_average_score = 0, $graph_pass_rate = 0;
    
    public function render()
    {
        return view('livewire.courses.show-course');
    }

    public function mount($id)
    {
        $this->course = Course::findOrFail($id);

        $this->enrollment_record = Enrollment::whereUserId(Auth::id())->whereCourseId($id)->first();

        $this->getModules();

        $this->getGraphData();
    }

    public function getModules()
    {
        $course_modules = Module::withCount('items')->where('course_id', $this->course->id)->ordered()->get()->toArray();
        $modules = [];
        
        foreach($course_modules as $moduleItem)
        { 
            $moduleItem['completed_count'] = 0;

            if($this->enrollment_record)
            {
                $enrollmentModule = EnrollmentModule::where('enrollment_id', $this->enrollment_record->id)->where('module_id', $moduleItem['id'])->first();

                if($enrollmentModule){
                    $moduleItem['completed_count'] = $enrollmentModule->items()->count();
                }
            }

            $modules[] = $moduleItem;
        }

        $this->modules = $modules;
    }

    public function getGraphData()
    {
        $enrollments = $this->course->enrollments;
        $this->graph_students_enrolled = $enrollments->pluck('user_id')->unique()->values()->count();
        $this->graph_pathways = $this->course->pathways->count();

        foreach($enrollments as &$eachEnrollment) {
            $score = $eachEnrollment->enrollmentModuleItems->sum('is_correct');
            $count = $eachEnrollment->enrollmentModuleItems->count();
            if ($count)
                $eachEnrollment->score = $score/$count;
            else
                $eachEnrollment->score = 0;
        }
        $this->graph_average_score = round($enrollments->average('score') * 100, 2);

        $passed_count = 0;
        foreach($enrollments as $eachEnrollment) {
            if ($eachEnrollment->score*100 >= $this->course->passing_score)
                $passed_count++;
        }
        $this->graph_pass_rate = $enrollments->count() > 0 ? round($passed_count / $enrollments->count() * 100, 2) : 0;
    }

    public function start($module_id = null)
    {

        if(!$this->course->modules()->count()){
            return $this->alert('error', 'This course has no modules');
        }

        $enroll_module = null;
        if($this->enrollment_record){
            $enroll = $this->enrollment_record;
            if ($module_id)
                $enroll_module = EnrollmentModule::whereModuleId($module_id)->whereEnrollmentId($enroll->id)->first();
        }else{
            $enroll = new Enrollment;
            $enroll->user_id = Auth::id();
            $enroll->course_id = $this->course->id;
            $enroll->save();
        }
        
        if($module_id) {
            return redirect()->route('courses.play', [
                'uuid' => $enroll->uuid,
                'module_id' => $module_id,
                'enrollment_module' => $enroll_module ? $enroll_module->uuid : null
            ]);
        }
        else {
            return redirect()->route('courses.play', [
                'uuid' => $enroll->uuid,
                'retake' => $enroll->isComplete() ? true : false,
                'enrollment_module' => $enroll_module ? $enroll_module->uuid : null
            ]);
        }
    }

    public function publishCourse()
    {
        $this->course->status = CourseStatus::Published;
        $this->course->save();
    }
}

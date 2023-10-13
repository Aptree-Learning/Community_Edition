<?php

namespace App\Http\Livewire;

use Auth;
use Closure;
use App\Models\Course;
use App\Models\Pathway;
use App\Models\UserLogin;
use Livewire\Component;
use App\Enums\CourseStatus;
use App\Models\CourseCategory;
use App\Models\Team;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;

class MyCourses extends Component implements HasTable
{
    use InteractsWithTable;

    public $course_filter = '', $counts = [];

    public $categories = [];
    
    public $courses = [];

    public $category_id;
    public $course_filter_date;
    public $course_sort = "desc";
    public $team_filter_date;
    public $team_sort = "desc";
    public $update;

    protected $queryString = ['course_filter'];

    public $deletingID = null;

    public $graph_students = 0, $graph_published_courses = 0, $graph_learning_paths = 0, $graph_draft_courses = 0;
    public $graph_logins = [], $graph_login_labels = [], $graph_progress = [];
    public function mount()
    {
        $this->getCourses();
        
        $this->categories = CourseCategory::get();

        $this->counts['total'] = Course::where("author_id", auth()->user()->id)->count();
        $this->counts['published'] = Course::where("author_id", auth()->user()->id)->where('status', CourseStatus::Published)->count();
        $this->counts['draft'] = Course::where("author_id", auth()->user()->id)->where('status', CourseStatus::Draft)->count();
        $this->counts['deleted'] = Course::where("author_id", auth()->user()->id)->withTrashed()->whereNotNull('deleted_at')->count();

        $this->getGraphData();
    }
    
    public function refreshComponent() {
        $this->update = !$this->update;
    }
    
    protected function getTableQuery(): Builder
    {
        return Team::where('user_id', auth()->user()->id)->orderBy('created_at', $this->team_sort);
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Model $team): string => route('reports.team', ['id' => $team->id]);
    }

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('name')->label(settings('team')),
            TextColumn::make('created_at')->label('DATE CREATED')->dateTime(),
            TextColumn::make('users_count')->label('USERS')->counts('users')->formatStateUsing(fn (string $state)=> $state),
            TextColumn::make('courses_count')->label('COURSES')->counts('courses')->formatStateUsing(fn (string $state)=> $state),
            TextColumn::make('pathways_count')->label('PATHWAYS')->counts('pathways')->formatStateUsing(fn (string $state)=> $state),
        ];
    }

    protected function isTablePaginationEnabled(): bool 
    {
        return false;
    } 

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                Action::make('assign')
                    ->icon('heroicon-s-duplicate')
                    ->modalcontent(fn ($record) => new HtmlString(Blade::render("@livewire('teams.assign-course', ['teamId' => {$record['id']}])")))
                    ->modalActions(fn ($action) => [])
                    ->action(fn () => $this->record->advance()),
            ])
        ];
    }

    public function getCourses()
    {
        $query = Course::where("author_id", auth()->user()->id);
        if($this->course_filter == 'published'){
            $query = $query->where('status', CourseStatus::Published);
        }
        elseif($this->course_filter == 'draft'){
            $query = $query->where('status', CourseStatus::Draft);
        }
        elseif($this->course_filter == 'deleted'){
            $query = $query->withTrashed()->whereNotNull('deleted_at');
        }

        if($this->category_id)
        {
            $query = $query->where('category_id', $this->category_id);
        }

        if($this->course_filter_date)
        {
            $query = $query->whereDate('created_at', $this->course_filter_date);
        }

        $this->courses = $query->orderBy("created_at", $this->course_sort)->get();

    }

    public function updatedCategoryId()
    {
        $this->getCourses();
    }

    public function updatedCourseFilterDate()
    {
        $this->getCourses();
    }

    public function updatedCourseSort()
    {
        $this->getCourses();
    }

    public function updatedTeamSort()
    {
        $this->refreshComponent();
    }

    public function deleteCourse()
    {
        $course = Course::findOrFail($this->deletingID);
        $course->delete();
        $this->deletingID = null;
        $this->getCourses();
    }

    public function restoreCourse($id)
    {
        Course::withTrashed()->find($id)->restore();
        $this->getCourses();
    }

    public function render()
    {
        return view('livewire.my-courses');
    }

    public function getGraphData()
    {
        $teams = Team::where('user_id', auth()->user()->id)->get();
        $users = collect([]);
        foreach($teams as $eachTeam) {
            foreach($eachTeam->users as $eachUser)
            $users->push($eachUser->id);
        }
        $this->graph_students = count($users->unique()->values()->all());

        $published_courses = Course::whereAuthorId(auth()->user()->id)->whereStatus(CourseStatus::Published)->get();
        $this->graph_published_courses = $published_courses->count();

        $all_pathways = Pathway::with('courses')->get();
        $my_courses = $published_courses->pluck('id');

        foreach($all_pathways as $eachPathway) {
            $courses = $eachPathway->courses->pluck('id');
            if ($courses->intersect($my_courses)->count())
            {
                $this->graph_learning_paths++;
            }
        }

        $this->graph_draft_courses = Course::whereAuthorId(auth()->user()->id)->whereStatus(CourseStatus::Draft)->count();
        
        $labels = [];
        for($i=7; $i>=0; $i--) {
            $labels[] = date("Y-m-d", strtotime("-{$i} days"));
        }

        $logins = UserLogin::selectRaw('logged_at, COUNT(user_id) as count')
                                ->whereIn('logged_at', $labels)
                                ->groupBy('logged_at')
                                ->get()
                                ->mapWithKeys(function ($item, int $key) {
                                    return [$item['logged_at'] => $item['count']];
                                })
                                ->toArray();
        foreach($labels as $eachLabel) {
            if (!isset($logins[$eachLabel])) {
                $logins[$eachLabel] = 0;
            }
        }
        ksort($logins);
        $this->graph_logins = $logins;
        $this->graph_login_labels = $labels;

        $courses =  $published_courses->load('enrollments');
        $progressCircle = [0,0,0];

        foreach($courses as $eachCourse) {
            if ($eachCourse->enrollments->count()) {
                $filtered = $eachCourse->enrollments->filter(function ($value, int $key) {
                    return $value->completed_at;
                });
                if ($eachCourse->enrollments->count() == $filtered->count())
                    $progressCircle[2]++;
                else
                    $progressCircle[1]++;
            } else {
                $progressCircle[0]++;
            }
        }
        $this->graph_progress = $progressCircle;
        $this->graph_progress = [3,6,2];
    }
}

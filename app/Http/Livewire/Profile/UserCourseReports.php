<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Enrollment;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Concerns\InteractsWithTable;
use Auth;

class UserCourseReports extends Component implements HasTable
{
    use InteractsWithTable;
    
    public function render()
    {
        return view('livewire.profile.user-course-reports');
    }

    protected function getTableQuery() 
    {
        return Enrollment::where('user_id', Auth::id());
    } 

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('course.title'),
            TextColumn::make('completed_at')->dateTime('F d, Y'),
            TextColumn::make('remarks'),
            TextColumn::make('created_at')->dateTime('F d, Y')
        ];
    }

    protected function getTableHeading()
    {
        return 'Reports';
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                ViewAction::make()
                ->button()
                ->url(fn(Enrollment $record) => route('courses.show', $record->course_id))
            ])

            
        ];
    }
}

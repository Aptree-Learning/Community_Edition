<?php

namespace App\Http\Livewire\Reports;

use Closure;
use App\Models\Team;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ManageReports extends Component implements HasTable
{
    use InteractsWithTable;

    public function render(): View
    {
        return view('livewire.reports.manage-reports');
    }

    protected function getTableBulkActions(): array
    {
        return [
            ExportBulkAction::make()
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Team::query();
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('search_val')
                ->form([
                    TextInput::make('search')
                ])
                ->query(function (Builder $query, array $data){
                    return $query->where('name', 'like', "%{$data['search']}%");
                }),
            Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until')->default(now()),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
        ];
    }
    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('name'),
            TextColumn::make('created_at')->dateTime(),
            TextColumn::make('users_count')->counts('users')->formatStateUsing(fn (string $state)=> $state),
            TextColumn::make('courses_count')->counts('courses')->formatStateUsing(fn (string $state)=> $state),
            TextColumn::make('pathways_count')->counts('pathways')->formatStateUsing(fn (string $state)=> $state),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Model $record): string => route('reports.team', ['id' => $record->id]);
    }

    protected function isTablePaginationEnabled(): bool 
    {
        return false;
    } 
}

<?php

namespace App\Http\Livewire;

use Filament\Tables;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Tables\Columns;
use App\Models\CourseCategory;
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ManageCategories extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public function render()
    {
        return view('livewire.manage-categories');
    }

    protected function getTableQuery(): Builder
    {
        return CourseCategory::query();
    }

    protected function getTableColumns(): array
    {
        return [

            TextColumn::make('name')
                ->description(fn (CourseCategory $record): string => $record->slug, position: 'below')
                ->searchable(),

            TextColumn::make('parent.name')
                ->getStateUsing(fn (CourseCategory $record): string => $record->parent->name ?? '')
                ->description(fn (CourseCategory $record): string => $record->parent->slug ?? '', position: 'below'),

            TextColumn::make('created_at')
                ->label('Created at')
                ->dateTime('d M Y'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->form([
                    TextInput::make('name')
                        ->label('Name')
                        ->afterStateUpdated(function (string $context, $state, callable $set) {
                            $set('slug', Str::slug($state));
                        })
                        ->lazy()
                        ->required(),
                    TextInput::make('name')
                        ->label('Name')
                        ->afterStateUpdated(function (string $context, $state, callable $set) {
                            $set('slug', Str::slug($state));
                        })
                        ->lazy()
                        ->required(),
                ]),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            Tables\Actions\BulkAction::make('delete')
                ->label('Delete selected')
                ->color('danger')
                ->action(function (Collection $records): void {
                    $records->each->delete();
                })
                ->requiresConfirmation(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Group::make()
                ->schema([

                    TextInput::make('name')
                        ->label('Name')
                        ->afterStateUpdated(function (string $context, $state, callable $set) {
                            $set('slug', Str::slug($state));
                        })
                        ->lazy()
                        ->required(),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ModelsOrganization::class, 'slug', ignoreRecord: true),


                ])->columnSpan(['lg' => 2]),

        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-hashtag';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No categories yet';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'You may create a category using the button below.';
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\Action::make('create')
                ->label('Create category')
                ->url(route('categories.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }

}

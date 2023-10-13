<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;
use App\Models\ModuleItem;
use App\Enums\ModuleItemType;

class MediaLibrary extends Component implements HasTable
{
    use InteractsWithTable;

    public $deletingID = null;

    protected function getTableQuery()
    {
        return ModuleItem::where("type", ModuleItemType::Video)->where("video_source", "apivideo")->orderBy('created_at', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')->label("Video Title")->searchable()->sortable(),
            TextColumn::make('author')->label('Author'),
            CopyableTextColumn::make('video_player')
                ->successMessage('URL copied to clipboard')
                ->label('Link')
                ->searchable(),
            TextColumn::make('created_at')->label('Date Created')->dateTime('F d, Y')->sortable(),
        ];
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                DeleteAction::make(),
            ])
        ];
    }

    public function render()
    {
        return view('livewire.media-library');
    }
}

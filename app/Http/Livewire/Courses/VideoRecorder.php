<?php

namespace App\Http\Livewire\Courses;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use App\Models\Module;
use App\Models\ModuleItem;
use App\Enums\ModuleItemType;

class VideoRecorder extends Component implements HasForms
{
    use InteractsWithForms;

    public $moduleId;
    public $title;
    public $description;
    public $video;
    public $step = 'record';
    
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Textarea::make('description'),
        ];
    }

    public function changeVideo($video)
    {
        $this->video = $video;
        $this->step = 'submit';
    }

    public function submit()
    {
        $data = $this->form->getState();
        $module = Module::find($this->moduleId);
        $api_video = $this->video;
        $module->items()->create([
            'type' => ModuleItemType::Video,
            'title' => $data['title'],
            'content' => $data['description'],
            'video_response' => $api_video,
            'video_id' => $api_video['videoId'],
            'video_format' => $api_video['mp4Support'] ? 'mp4' : '',
            'video_embed_url' => $api_video['assets']['player'] ?? '',
            'video_source' => 'apivideo',
            'video_player' => $api_video['assets']['player'] ?? '',
            'video_thumbnail' => $api_video['assets']['thumbnail'] ?? '',
            'user_id' => auth()->user()->id,
        ]);

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.courses.video-recorder');
    }
}

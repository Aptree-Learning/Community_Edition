<?php

namespace App\Http\Livewire\Courses;

use SplFileObject;
use App\Models\Module;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Enums\ActionType;
use App\Models\ModuleItem;
use App\Enums\ModuleItemType;
use Livewire\WithFileUploads;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use ApiVideo\Client\Client as ApiClient;
use Filament\Forms\Components\TextInput;
use Symfony\Component\HttpClient\Psr18Client;
use ApiVideo\Client\Model\VideoCreationPayload;
use Filament\Forms\Concerns\InteractsWithForms;
use Justijndepover\EmbedVideo\Video;

class VideoEditor extends Component  implements HasForms
{
    use InteractsWithForms;

    public $action;

    public $module_id;

    public $title, $description, $video;

    public $api_video, $ready_for_upload = false, $video_thumbnail, $video_url,  $new_upload;

    protected $listeners = ['editVideo' => 'edit'];

    public function render()
    {
        return view('livewire.courses.video-editor');
    }

    public function mount($moduleId)
    {
        $this->module_id = $moduleId;
    }

    public function saveApiVideo($data)
    {
        if($data){
            $this->api_video = $data;
            $this->ready_for_upload = true;
            $this->new_upload = true;
            $this->video_thumbnail = $data['assets']['thumbnail'];
        }
    }

    public function saveURLVideo()
    {
        if($this->video_url && filter_var($this->video_url, FILTER_VALIDATE_URL) !== false){
            $thumbnail = 'https://cdn.pixabay.com/photo/2015/09/15/17/18/vector-video-player-941434_1280.png';
            $embedUrl = $this->video_url;
            try {
                $video = Video::from($this->video_url);
                if($video) {
                    $embedUrl = $video->embedUrl();
                    $thumbnail = $video->thumbnail();
                }
            }
            catch(Exception $ex) {

            }
            $this->api_video = [
                'assets' => [
                    'thumbnail' => $thumbnail,
                    'player' => $embedUrl,
                ],
                'videoId' => $embedUrl,
                'mp4Support' => true,
            ];
            $this->ready_for_upload = true;
            $this->video_thumbnail = $thumbnail;
        }
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            Textarea::make('description')
        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        return $this->action == ActionType::Update
                ? $this->update()
                : $this->store();
        
    }

    public function store()
    {
        $data = $this->form->getState();
        $module = Module::find($this->module_id);
        $api_video = $this->api_video;
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

    public function update()
    {
        $data = $this->form->getState();
        $module_item = ModuleItem::find($this->module_item_id);

        $module_item->update([
            'title' => $data['title'],
            'content' => $data['description'],
        ]);

        if($this->api_video)
        {
            $api_video = $this->api_video;

            $module_item->update([
                'video_response' => $api_video,
                'video_id' => $api_video['videoId'],
                'video_format' => $api_video['mp4Support'] ? 'mp4' : '',
                'video_embed_url' => $api_video['assets']['player'] ?? '',
                'video_source' => 'apivideo',
                'video_player' => $api_video['assets']['player'] ?? '',
                'video_thumbnail' => $api_video['assets']['thumbnail'] ?? '',
            ]);
        }


        return redirect(request()->header('Referer'));
    }

    public function edit($module_item_id)
    {
        $this->module_item_id = $module_item_id;

        $data = ModuleItem::find($module_item_id);

        $this->action = ActionType::Update;

        $this->form->fill([
            'title' => $data->title,
            'type' => $data->type->value,
            'content' => $data->content,
        ]);

        $this->video_thumbnail = $data->video_thumbnail;
        $this->video_url = $data->video_player;

        $this->dispatchBrowserEvent('openmodal-video');
    }
}

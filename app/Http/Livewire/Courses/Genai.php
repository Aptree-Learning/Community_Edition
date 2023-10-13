<?php

namespace App\Http\Livewire\Courses;

use Livewire\Component;
use Log;
use OpenAI\Laravel\Facades\OpenAI;

class Genai extends Component
{
    public $search = "";
    public $loading = false;

    public function mount()
    {
        $this->loading = false;
    }

    public function render()
    {
        $this->loading = false;
        return view('livewire.courses.genai');
    }

    public function queryAI()
    {
        $this->loading = true;
        $this->emit('genaiSelect', $this->search);
    }

    public function submit()
    {
        $system_prompt = "I'd like a short history to with a citation in 3 sentences.";
        $user_prompt = $this->search;

        $messages[] = [
            'role' => 'system', 
            'content' =>  $system_prompt
        ];

        $messages[] = [
            'role' => 'user', 
            'content' =>  $user_prompt
        ];


        Log::channel('openai')->info(json_encode($messages));

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages
        ]);

        // OpenAI returns choices array, so select the first one
        $result = $response['choices'][0]['message']['content'];

        Log::channel('openai')->info('CHATGPT Result');
        Log::channel('openai')->info($result);

        try {
            $content = strip_tags($result);
            $this->dispatchBrowserEvent('closemodal-aigen');
            $this->emit('contentSet', $content);
        } catch (\Throwable $th) {
            if(config('app.debug')){
                throw $th;
            }else{
                $this->alert('error', 'Error parsing your data. Please try to update your content.');
            }
            
        }
        
    }

    public function parseResult($content)
    {
        // $content is a text result, so convert it into a json
        $json = json_encode($content);

        $decode = json_decode($json);

        // this is to delete unnecessary strings
        $data =  json_decode(str_replace("\\\"", "\"", $decode), true);

        return $data;
    }
}

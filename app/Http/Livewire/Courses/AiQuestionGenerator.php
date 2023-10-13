<?php

namespace App\Http\Livewire\Courses;

use Log;
use Auth;
use App\Models\Module;
use Livewire\Component;
use App\Enums\ActionType;
use App\Enums\QuestionType;
use App\Enums\ModuleItemType;
use OpenAI\Laravel\Facades\OpenAI;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Forms\Concerns\InteractsWithForms;

class AiQuestionGenerator extends Component implements HasForms
{
    use InteractsWithForms;
    use LivewireAlert;

    public $module_id;

    public $action;

    public $prompt;

    public $request_time;

    public $results = [];

    protected $listeners = ['createAiQuestion' => 'create'];
    
    public function render()
    {
        return view('livewire.courses.ai-question-generator');
    }

    protected function getFormSchema()
    {
        return [
            Textarea::make('prompt')->rows(10)->label('Question Generator')->placeholder('No more than 500 words')
        ];
    }

    public function create($module_id)
    {
        $this->module_id = $module_id;
        $this->action = ActionType::Create;
        $this->reset(['results', 'request_time', 'prompt']);
        $this->dispatchBrowserEvent('openmodal-aiquestion');
    }

    public function submit()
    {
        $startTime = microtime(true);

        $data = $this->form->getState();

        $user_prompt = $data['prompt'];

        $system_prompt = 'Please generate 5 items of multiple-choice type questionnaire that covers the main topics and key points discussed in the article. The output should be in JSON format and grouped in a key called "questions". Each item must have these keys: "question", "choices", "answer" and "explanation". Note that the correct answer should be put at the first option.';


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
        $content = $response['choices'][0]['message']['content'];

        Log::channel('openai')->info('CHATGPT Result');
        Log::channel('openai')->info($content);

        try {
            $data = $this->parseResult ($content);

            $this->results = $data['questions'];

            $endTime = microtime(true);

            $this->request_time = round(($endTime - $startTime) * 1000, 2);

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

    public function insert($index)
    {
        $result = $this->results[$index];

        Log::channel('openai')->info(json_encode($result));

        $this->createQuestion($result);

        $this->results[$index]['hidden'] = true;
    }
    
    public function closeAiModal(){
        $this->emitUp('refreshParent');
    }

    public function createQuestion($data)
    {
        $module = Module::where('id', $this->module_id)->firstOrfail();

        $module_question = $module->items()->create([
            'type' => ModuleItemType::Question,
            'user_id' => Auth::id(),
            'title' => $data['question'],
        ]);

        $question = $module_question->question()->create([
            'title' => $data['question'],
            'type' => QuestionType::Ai,
            'description' => '',
            'explanation' => $data['explanation'],
            'display_explanation' => true,
        ]);

        foreach($data['choices'] as $i => $answer)
        {
            $question->answers()->create([
                'answer' => $answer,
                'is_correct' => $i == 0 ? true : false
            ]);
        }

        $this->alert('success', 'Question added successfully!');
    }
}

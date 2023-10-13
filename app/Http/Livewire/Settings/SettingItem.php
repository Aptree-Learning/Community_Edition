<?php

namespace App\Http\Livewire\Settings;

use App\Enums\FormType;
use Livewire\Component;
use App\Models\Settings;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Checkbox;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Forms\Concerns\InteractsWithForms;

class SettingItem extends Component implements HasForms
{
    use InteractsWithForms;
    use LivewireAlert;
    
    public Settings $setting;
    public $key, $description, $value, $type;
    public $saveFlag = false;
    protected $listeners = ['update'];

    public function render()
    {
        return view('livewire.settings.setting-item');
    }

    public function mount($id)
    {
        $this->setting = Settings::find($id);

        $this->form->fill([
            'value' => $this->setting->value,
        ]);
    }


    protected function getFormSchema()
    {
        $form_type = $this->setting->form_type?->value;

        if($form_type == FormType::Textarea ){
            return [
                Textarea::make('value')->disableLabel()->helperText($this->setting->helper_text)
            ];
        }
        elseif($form_type == FormType::Colorpicker ){
            return [
                ColorPicker::make('value')->disableLabel()->helperText($this->setting->helper_text)
            ];
        }
        elseif($form_type == FormType::Fileupload ){
            return [
                FileUpload::make('value')->disableLabel()->helperText($this->setting->helper_text)
                   ->disk('do')->visibility('public')->directory('Medscrippts_Images')
            ];
        }
        elseif($form_type == FormType::Checkbox ){
            return [
                Checkbox::make('value')->disableLabel()->helperText($this->setting->helper_text)
            ];
        }
        else{
            return [
                TextInput::make('value')->disableLabel()->helperText($this->setting->helper_text)
            ];
        }
        
        
    }

    public function save()
    {
        $this->saveFlag = true;
    }

    public function update()
    {
        $form = $this->form->getState();

        $this->setting->update([
            'value' => $form['value']
        ]);

        $this->alert('success', $this->setting->key . ' has been updated successsfully!');
        
        $this->saveFlag = false;
        return redirect('/settings#course-library');
    }

    
}

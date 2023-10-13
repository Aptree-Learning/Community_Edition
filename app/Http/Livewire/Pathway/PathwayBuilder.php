<?php

namespace App\Http\Livewire\Pathway;

use Str;
use App\Models\Goal;
use Spatie\Tags\Tag;
use App\Models\Pathway;
use Livewire\Component;
use App\Enums\CourseStatus;
use Filament\Forms\Components\Grid;
use App\Forms\Components\SelectIcon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use App\Forms\Components\SimpleFieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;

class PathwayBuilder extends Component implements HasForms
{
    use InteractsWithForms;

    # Props
    public $title, $icon = 'education';
    public $estimated_time,  $description;
    public $offer_certificate;
    public $image;
    public $status;
    public $pathway;

    
    public function render()
    {
        return view('livewire.pathway.pathway-builder');
    }

    public function mount($id = null)
    {
        if($id){
            $this->pathway = Pathway::findOrFail($id);
            $this->form->fill($this->pathway->toArray());
        }
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make([
                'default' => 1,
                'sm' => 1,
                'lg' => 5,
            ])
                ->schema([
                    SimpleFieldset::make('Form')
                        ->schema([
                            Grid::make(['default' => 1, 'lg' => 6])
                            ->schema([
                            TextInput::make('title')
                                ->label('Pathway Title')
                                ->placeholder('Enter your pathway title')
                                ->columnSpan(['default' => 6, 'sm' => 5, 'md' => 5])
                                ->required(),
                            SelectIcon::make('icon')
                                ->label('Select Icon')
                                ->required()
                                ->columnSpan(['lg' => 1, 'xl' => 1, 'default' => 2]),
                            
                            TimePicker::make('estimated_time')
                                ->label('Estimated Time to Complete')
                                ->placeholder('HH::mm')
                                ->withoutSeconds()
                                ->columnSpan(['default' => 3, 'md' => 2]),
                            Textarea::make('description')
                                ->placeholder('Enter description')
                                ->required()
                                ->columnSpan(['default' => 6]),
                            Select::make('status')
                                ->label('Select Status')
                                ->required()
                                ->columnSpan(['default' => 6])
                                ->options([
                                    CourseStatus::Draft => 'Draft',
                                    CourseStatus::Published => 'Published',
                                ]),
                            Toggle::make('offer_certificate')
                                ->label('Offer certificate of completion?')
                                ->inline()
                                ->columnSpan(['default' => 6, 'md' => 3]),
                            ]),
                        ])->columnSpan(3),
                ]),
        ];
    }

    public function store()
    {

        $data = $this->form->getState();
        # Create Pathway
        $pathway = new Pathway;
        $pathway->title = $data['title'];
        $pathway->icon = $data['icon'];
        $pathway->description = $data['description'];
        $pathway->estimated_time = $data['estimated_time'];
        $pathway->offer_certificate = $data['offer_certificate'];
        $pathway->image = $data['image'];
        $pathway->slug = Str::slug($data['title']);
        $pathway->status = $data['status'];
        $pathway->save();
    

        
        return redirect()->route('pathway.contents', ['id' => $pathway->id]);
    }

    public function update()
    {
        $data = $this->form->getState();

        # Create Pathway
        $pathway = $this->pathway;
        $pathway->title = $data['title'];
        $pathway->icon = $data['icon'];
        $pathway->description = $data['description'];
        $pathway->estimated_time = $data['estimated_time'];
        $pathway->offer_certificate = $data['offer_certificate'];
        $pathway->image = $data['image'];
        $pathway->slug = Str::slug($data['title']);
        $pathway->status = $data['status'];
        $pathway->save();
    

        
        return redirect()->route('pathway.contents', ['id' => $pathway->id]);
    }

    public function submit()
    {
        if($this->pathway){
            return $this->update();
        }

        return $this->store();
        

    }
}

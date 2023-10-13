<?php

namespace App\Http\Livewire;

use File;
use Artisan;
use Closure;
use DateTimeZone;
use App\Models\Settings;
use App\Models\CourseCategory;
use Livewire\Component;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;

class ManageSettings extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    use LivewireAlert;

    public $APP_TIMEZONE;
    public $FACEBOOK_ENABLE, $FACEBOOK_CLIENT_ID, $FACEBOOK_CLIENT_SECRET;
    public $TWITTER_ENABLE, $TWITTER_CLIENT_ID, $TWITTER_CLIENT_SECRET;
    public $GOOGLE_ENABLE, $GOOGLE_CLIENT_ID, $GOOGLE_CLIENT_SECRET;
    public $DB_CONNECTION;
    public $api_key;
    public $host;
    
    public function render()
    {
        return view('livewire.manage-settings', ['settings' => Settings::get()]);
    }

    public function mount()
    {
        $this->appForm->fill([
            'APP_TIMEZONE' => config('app.timezone'),
        ]);

        $this->googleForm->fill([
            'GOOGLE_ENABLE' => config('services.google.enable'),
            'GOOGLE_CLIENT_ID' => config('services.google.client_id'),
            'GOOGLE_CLIENT_SECRET' => config('services.google.client_secret'),
        ]);

        $this->openaiform->fill([
            'OPENAI_ENABLE' => config('services.openai.enable'),
            'OPENAI_API_KEY' => config('services.openai.key'),
            'OPENAI_API_ORGANIZATION' => config('services.openai.organization'),
        ]);

        $this->smtpform->fill([
            'MAIL_HOST' => config("mail.mailers.smtp.host"),
            'MAIL_PORT' => config("mail.mailers.smtp.port"),
            'MAIL_USERNAME' => config("mail.mailers.smtp.username"),
            'MAIL_PASSWORD' => config("mail.mailers.smtp.password"),
            'MAIL_ENCRYPTION' => config("mail.mailers.smtp.encryption"),
            'MAIL_FROM_ADDRESS' => config("mail.from.address")
        ]);

        $this->logoForm->fill([
            'image' => settings('logo')
        ]);

        $this->api_key = Crypt::encryptString(json_encode(["email" => auth()->user()->email, "password" => auth()->user()->password]));
        $this->host = request()->getHttpHost();
    }

    protected function getForms(): array
    {
        return [
            'appForm' => $this->makeForm()
                ->schema($this->getAppFormSchema()),
            'googleForm' => $this->makeForm()
                ->schema($this->getGoogleFormSchema()),
            'openaiform' => $this->makeForm()
                ->schema($this->getOpenAIFormSchema()),
            'smtpform' => $this->makeForm()
                ->schema($this->getSmtpFormSchema()),
            'logoForm' => $this->makeForm()
                ->schema($this->getLogoFormSchema()),
            'libraryForm' => $this->makeForm()
                ->schema($this->getLibraryFormSchema()),
        ];
    }

    public function getAppFormSchema()
    {
        return [
            TextInput::make('APP_TIMEZONE')
                ->label('App Timezone')
                ->hint('View the list of [timezones](https://www.php.net/manual/en/timezones.php)')
                ->helperText("As an example: UTC or Asia/Singapore, for more format please refer to the PHP list of timezones."),
        ];
    }

    public function getGoogleFormSchema()
    {
        return [
            Toggle::make('GOOGLE_ENABLE')->label('Enable')->reactive(),
            TextInput::make('GOOGLE_CLIENT_ID')->label('GOOGLE_CLIENT_ID')->disabled(fn (Closure $get) => !$get('GOOGLE_ENABLE')),
            TextInput::make('GOOGLE_CLIENT_SECRET')->label('GOOGLE_CLIENT_SECRET')->disabled(fn (Closure $get) => !$get('GOOGLE_ENABLE'))
        ];
    }

    public function getSmtpFormSchema()
    {
        return [
            TextInput::make('MAIL_HOST')->label('MAIL_HOST'),
            TextInput::make('MAIL_PORT')->label('MAIL_PORT'),
            TextInput::make('MAIL_USERNAME')->label('MAIL_USERNAME'),
            TextInput::make('MAIL_PASSWORD')->label('MAIL_PASSWORD'),
            TextInput::make('MAIL_ENCRYPTION')->label('MAIL_ENCRYPTION'),
            TextInput::make('MAIL_FROM_ADDRESS')->label('MAIL_FROM_ADDRESS')
        ];
    }

    public function getOpenAIFormSchema()
    {
        return [
            Toggle::make('OPENAI_ENABLE')->label('Enable')->reactive(),
            TextInput::make('OPENAI_API_KEY')->label('OPENAI_API_KEY')->disabled(fn (Closure $get) => !$get('OPENAI_ENABLE')),
            TextInput::make('OPENAI_API_ORGANIZATION')->label('OPENAI_API_ORGANIZATION')
                ->disabled(fn (Closure $get) => !$get('OPENAI_ENABLE'))
                ->helperText("Only fill if your OpenAI account belongs to multiple organizations. This will ensure which organization is used for an API request to OpenAI."),
        ];
    }

    public function updateEnv($env, $value, $config = null)
    {
        $envFilePath = base_path('.env');

        if (File::exists($envFilePath)) {
            $envContent = File::get($envFilePath);

            // replace the value of the config variable
            $envContent = preg_replace('/^' . $env . '=.*/m', $env . '=' . $value, $envContent);

            // write the updated content to the .env file
            try {
                File::put($envFilePath, $envContent);
                Artisan::call('config:cache');

                $this->alert('success', "Success! The {$env} environment variable has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");

                $this->$env = config($config);

                # Hard Refresh
                //return redirect(request()->header('Referer'));

            } catch (\Throwable $th) {
                throw $th;
            }

        }
    }

    public function saveAppForm()
    {
        $data = $this->appForm->getState();

        setEnvironmentValue('APP_TIMEZONE', $data['APP_TIMEZONE']);
        $this->alert('success', "Success! The APP_TIMEZONE environment variable has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");
    }
  
    public function saveOpenAIform()
    {
        $data = $this->openaiform->getState();
        updateEnv($data);
        $this->alert('success', "Success! The OpenAI has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");
    }
   
    public function saveSmtpForm()
    {
        $data = $this->smtpform->getState();
        updateEnv($data);
        $this->alert('success', "Success! The SMTP has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");
    }

    public function saveGoogleForm()
    {
        $data = $this->googleForm->getState();

        updateEnv($data);
        $this->alert('success', "Success! The Social Media Login has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");
    }

    protected function getLogoFormSchema(): array
    {
        return [
            FileUpload::make('image')
                ->required()
                ->directory('settings')
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    return (string) str($file->getClientOriginalName())->prepend('logo-');
                }),
        ];
    }

    protected function getLibraryFormSchema(): array
    {
        return [
            CheckboxList::make('courses')
                ->options(function(){
                    return CourseCategory::get()->pluck('name', 'id');
                })
                ->columns(3)
        ];
    }

    protected function getTableQuery()
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

            TextColumn::make('visible')
                ->getStateUsing(fn (CourseCategory $record): string => $record->visible ? "Visible" : "Hidden"),

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
                    Checkbox::make('visible')
                ]),
            Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete category')
                ->modalSubheading('Are you sure you\'d like to delete this category? This cannot be undone.')
                ->modalButton('Yes, delete it')
        ];
    }

    protected function getTableHeaderActions()
    {
        return [
            Action::make('Create Category')
                ->action(function (CourseCategory $category, array $data): void {
                    $category->name = $data['name'];
                    $category->slug = Str::slug($data['name']);
                    $category->visible = $data['visible'];
                    $category->save();
                })
                ->form([
                    TextInput::make('name')
                        ->required(),
                    Checkbox::make('visible')
                        ->default(true)
                ])
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

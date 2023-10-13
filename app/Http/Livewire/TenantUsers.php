<?php

namespace App\Http\Livewire;

use Closure;
use App\Models\User;
use App\Models\UserInvitation;
use App\Mail\UserInvitation as UserInvitationMail;
use Livewire\Component;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;
use App\Exports\TemplateExport;

class TenantUsers extends Component implements HasTable
{
    use InteractsWithTable;

    public $invitations;
    public $csvFile;
    public $roles;
    public $deletingID;
    public $addUserForm = [
        'email' => '',
        'role' => 'learner',
    ];

    public function mount()
    {
        $this->csvFile = null;
        $this->deletingID = null;
        $this->invitations = UserInvitation::all();
        $this->roles = [
            [
                'key' => 'admin',
                'name' => 'Administrator',
                'description' => 'Administrator users can perform any action.'
            ],
            [
                'key' => 'manager',
                'name' => 'Editor',
                'description' => 'Editor users have ability to read, create, and update.'
            ],
            [
                'key' => 'learner',
                'name' => 'Learner',
                'description' => 'Student can only view courses.'
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.tenant-users');
    }

    protected function getTableQuery()
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable()->sortable(),
            TextColumn::make('roles.display_name'),
            TextColumn::make('created_at')->dateTime('F d, Y')

        ];
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                ViewAction::make()->form([
                    TextInput::make('name'),
                    TextInput::make('email'),
                ]),
                EditAction::make()
                ->form([
                    TextInput::make('name'),
                    TextInput::make('email'),
                ]),
                Action::make('assign')
                    ->icon('heroicon-s-duplicate')
                    ->modalcontent(fn ($record) => new HtmlString(Blade::render("@livewire('users.assign-course', ['userId' => {$record['id']}])")))
                    ->modalActions(fn ($action) => [])
                    ->action(fn () => $this->record->advance()),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make()
            ])
        ];
    }

    public function inviteUser()
    {
        $this->resetErrorBag();

        $this->invite(
            $this->addUserForm['email'],
            $this->addUserForm['role']
        );

        $this->addUserForm = [
            'email' => '',
            'role' => 'learner',
        ];

        $this->invitations = UserInvitation::all();
        $this->emit('saved');
    }

    public function invite(string $email, string $role = null): void
    {
        $this->validateRequest($email, $role);

        $invitation = UserInvitation::create([
            'email' => $email,
            'role' => $role,
            'token' => (string) Str::uuid()
        ]);

        try {
            Mail::to($email)->send(new UserInvitationMail($invitation));
            
            $this->emit('saved');
        } catch (\Throwable $th) {

            $invitation->delete();
            
            throw $th;
        }
    }

    public function validateRequest(string $email, ?string $role): void
    {
        Validator::make([
            'email' => $email,
        ], $this->rules(), [
            'email.unique' => __('This user has already been invited.'),
        ])->after(
            $this->ensureUserIsNotAlreadyRegistered($email)
        )->validateWithBag('addTeamMember');
    }

    protected function rules(): array
    {
        return array_filter([
            'email' => [
                'required', 'email',
                Rule::unique('user_invitations'),
            ]
        ]);
    }

    protected function ensureUserIsNotAlreadyRegistered(string $email): Closure
    {
        return function ($validator) use ($email) {
            $validator->errors()->addIf(
                User::whereEmail($email)->count() > 0,
                'email',
                __('This user is already registered.')
            );
        };
    }

    public function cancelInvitation()
    {
        if ($this->deletingID) {
            UserInvitation::destroy($this->deletingID);
            $this->deletingID = null;
            $this->invitations = UserInvitation::all();
        }
    }

    public function resendInvitation($invitationId)
    {
        $invitation = UserInvitation::findOrFail($invitationId);
        Mail::to($invitation->email)->send(new UserInvitationMail($invitation));
    }

    public function parseCSV()
    {
        Excel::import(new UserImport, $this->csvFile);
        $this->invitations = UserInvitation::all();
        $this->csvFile = null;
    }

    public function downloadTemplate()
    {
        return Excel::download(new TemplateExport, 'template.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}

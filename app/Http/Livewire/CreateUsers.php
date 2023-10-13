<?php

namespace App\Http\Livewire;

use Closure;
use App\Models\User;
use App\Models\UserInvitation;
use App\Mail\UserInvitation as UserInvitationMail;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;

class CreateUsers extends Component
{
    public $roles;

    public $addUserForm = [
        'email' => '',
        'role' => 'learner',
    ];

    public function mount()
    {
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
        return view('livewire.create-users');
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
            echo ((new UserInvitationMail($invitation))->render());
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
}

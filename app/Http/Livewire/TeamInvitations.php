<?php

namespace App\Http\Livewire;

use Str;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use App\Models\Invitation;
use App\Mail\InvitationEmail;
use App\Events\InvitationCreated;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\CreateAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Tables\Concerns\InteractsWithTable;

class TeamInvitations extends Component implements HasTable
{
    use InteractsWithTable;
    use LivewireAlert;
    
    public Team $team;

    public function render()
    {
        return view('livewire.team-invitations');
    }

    public function mount($id)
    {
        $this->team = Team::findOrFail($id);
    }

    protected function getTableQuery() 
    {
        return Invitation::where('team_id', $this->team->id);
    } 

    protected function getTableHeaderActions()
    {
        return [
            CreateAction::make('invite')
                ->form([
                    TextInput::make('email')->required()
                ])
                ->action(function(array $data){
                    
                    $email = $data['email'];

                    if(!$this->hasInvitation($email))
                    {
                        $invitation = Invitation::create([
                            'team_id' => $this->team->id,
                            'email' => $email,
                            'token' => Str::random(40)
                        ]);

                        InvitationCreated::dispatch($invitation);
                        
                        $this->alert('success', 'Successfully invited ' . $email);
                    }else{
                        
                        $this->alert('error', $email . ' is already on the invitation list.');
                    }
                    
                })
            ];
    }

    protected function getTableColumns(): array 
    {
        return [
            TextColumn::make('email')->searchable(),
            BadgeColumn::make('accepted_at'),
            TextColumn::make('created_at')->label('Invitation sent')->dateTime(),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('resend')
                ->hidden(fn(Invitation $record) : bool => $record->accepted_at ? true : false  )
                ->action(function(Invitation $record){
                    InvitationCreated::dispatch($record);
                    $this->alert('success', 'Invitation resent to ' . $record->email);
                })
                ->button()
        ];
    }

    private function hasInvitation($email)
    {
        $invited = Invitation::whereEmail($email)->exists();

        if(!$invited)
        {
            return User::whereEmail($email)->exists();
        }

        return $invited;
    }
}

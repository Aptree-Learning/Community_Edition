<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use App\Models\User;

class OwnerForm extends Component
{
    public $team;
    public $owner;


    public function mount()
    {
        $this->owner = $this->team->owner->email ?? null;
    }

    public function render()
    {
        return view('teams.owner-form');
    }

    public function setOwner()
    {
        $user = User::whereEmail($this->owner)->first();
        $this->team->user_id = $user->id;
        $this->team->save();
    }
}

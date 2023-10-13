<?php

namespace App\Http\Livewire\Pathway;

use Auth;
use Mail;
use App\Models\User;
use App\Models\Team;
use App\Models\Pathway;
use Livewire\Component;
use App\Models\Assignment;
use App\Mail\AssignedToPathway;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AssignPathway extends Component
{
    use LivewireAlert;

    # Data
    public $users = [];
    public $teams = [];

    # Props
    public $pathway_id;
    public $assign_users = [];
    public $assign_teams = [];

    public function render()
    {
        return view('livewire.pathway.assign-pathway');
    }

    public function mount($pathwayId)
    {
        $this->pathway_id = $pathwayId;
        $pathway = Pathway::findOrFail($this->pathway_id);
        $this->users = User::get();
        $this->teams = Team::get();

        $this->assign_users = $pathway->assignments()->pluck('user_id')->unique()->values()->all();
        $this->assign_teams = $pathway->assignments()->pluck('team_id')->unique()->values()->all();
    }

    public function assignIndividual()
    {
        $pathway = Pathway::findOrFail($this->pathway_id);
        $result = $pathway->users()->syncWithPivotValues($this->assign_users, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
        
        foreach($result['attached'] as $eachAttached)
        {
            $user = User::findOrFail($eachAttached);
            Mail::to($user->email)->send(new AssignedToPathway($pathway));
        }

        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-pathway-' . $this->pathway_id);
    }
    
    public function assignTeam()
    {
        $pathway = Pathway::findOrFail($this->pathway_id);
        $result = $pathway->teams()->syncWithPivotValues($this->assign_teams, ['assigned_by' => Auth::id(), 'created_at' => now(), 'updated_at' => now()]);
        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-pathway-' . $this->pathway_id);
    }

}

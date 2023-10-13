<?php

namespace App\Http\Livewire\Teams;

use App\Models\Team;
use App\Models\UserLogin;
use Livewire\Component;

class Graph extends Component
{
    public $team;
    public $graph_logins, $graph_login_labels;

    public $students = 0, $pathways = 0, $courses = 0;
    public function render()
    {
        return view('livewire.teams.graph');
    }

    public function mount($team_id)
    {
        $this->team = Team::findOrFail($team_id);
        $users = $this->team->users;
        $this->students = $users->count();

        $user_ids = $users->pluck('id');

        $labels = [];
        for($i=7; $i>=0; $i--) {
            $labels[] = date("Y-m-d", strtotime("-{$i} days"));
        }

        $logins = UserLogin::selectRaw('logged_at, COUNT(user_id) as count')
                                ->whereIn('logged_at', $labels)
                                ->whereIn('user_id', $user_ids)
                                ->groupBy('logged_at')
                                ->get()
                                ->mapWithKeys(function ($item, int $key) {
                                    return [$item['logged_at'] => $item['count']];
                                })
                                ->toArray();
        foreach($labels as $eachLabel) {
            if (!isset($logins[$eachLabel])) {
                $logins[$eachLabel] = 0;
            }
        }

        ksort($logins);
        $this->graph_logins = $logins;
        $this->graph_login_labels = $labels;

        $this->pathways = $this->team->pathways->count();
        $this->courses = $this->team->courses->count();
    }
}

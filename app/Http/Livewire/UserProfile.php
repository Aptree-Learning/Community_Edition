<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Enrollment;
use Auth;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.user-profile');
    }
}

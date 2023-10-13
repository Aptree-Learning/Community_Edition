<?php

namespace App\Http\Controllers;

use Auth;
use Event;
use App\Models\Team;
use App\Models\User;
use App\Models\UserInvitation;
use Illuminate\Http\Request;
use App\Models\TeamInvitation;
use Laravel\Jetstream\Jetstream;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Jetstream\AddTeamMember;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use App\Events\ZapierEvent;

class InvitationController extends Controller
{
    public function accept(Request $request, $token)
    {
        $invitation = UserInvitation::whereToken($token)->firstOrFail();
        
        if($this->userDoesNotExist($invitation->email))
        {
            return view('auth.register-invitation', compact('invitation'));
        }
    }

    private function userDoesNotExist($email)
    {
        return User::where('email', $email)->first() ? false : true;
    }

    public function register(Request $request, $token)
    {
        $invitation = UserInvitation::whereToken($token)->firstOrFail();

        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|min:2|max:191',
            'password' => 'required|min:5|max:191|confirmed'
        ]);

        # User
        $user = $this->createUser($validated, $invitation->role);


        $invitation->delete();

        // TODO: Auth/login doesn't work
        Auth::login($user);

        return redirect('/dashboard')->banner(
            __('Great! You have accepted the invitation'),
        );
    }

    private function createUser($data, $role)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->email_verified_at = now();
        $user->save();

        $user->assignRole($role);

        Event::dispatch(new ZapierEvent('user.create', $user));

        return $user;
    }
}

<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\UserInvitation;
use App\Mail\UserInvitation as UserInvitationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $newUsers = $collection->collapse();

        foreach($newUsers as $eachUser) {
            $validator = $this->validateRequest($eachUser, 'learner');
            if (!$validator->fails()) {
                $invitation = UserInvitation::create([
                    'email' => $eachUser,
                    'role' => 'learner',
                    'token' => (string) Str::uuid()
                ]);
        
                try {
                    Mail::to($eachUser)->send(new UserInvitationMail($invitation));
                } catch (\Throwable $th) {
                    $invitation->delete();
                    throw $th;
                }
            }
        }
    }

    public function validateRequest(string $email, ?string $role)
    {
        return Validator::make([
            'email' => $email,
        ], $this->rules(), [
            'email.unique' => __('This user has already been invited.'),
        ])->after(
            $this->ensureUserIsNotAlreadyRegistered($email)
        );
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

    protected function ensureUserIsNotAlreadyRegistered(string $email)
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

<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');
        
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }
        
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'email' => $input['email'],
                'first_name' => $input['first_name'], 
                'last_name' => $input['last_name'], 
                'go_by_name' => $input['go_by_name'], 
                'gender' => $input['gender'], 
                'date_of_birth' => $input['date_of_birth'], 
                'street_address_1' => $input['street_address_1'], 
                'street_address_2' => $input['street_address_2'], 
                'city' => $input['city'], 
                'state' => $input['state'], 
                'zip_code' => $input['zip_code'], 
                'home_phone_number' => $input['home_phone_number'], 
                'cell_phone_number' => $input['cell_phone_number'], 
                'emergency_contact' => $input['emergency_contact'], 
                'emergency_phone_number' => $input['emergency_phone_number'], 
                'company' => $input['company'], 
                'plan' => $input['plan'], 
                'group' => $input['group'], 
                'physician_name' => $input['physician_name'], 
                'physician_phone_number' => $input['physician_phone_number'], 
                'physician_state' => $input['physician_state'], 
                'physician_city' => $input['physician_city'], 
                'physician_zip' => $input['physician_zip'], 
                'physician_street' => $input['physician_street'], 
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'email' => $input['email'],
            'email_verified_at' => null,
            'first_name' => $input['first_name'], 
            'last_name' => $input['last_name'], 
            'go_by_name' => $input['go_by_name'], 
            'gender' => $input['gender'], 
            'date_of_birth' => $input['date_of_birth'], 
            'street_address_1' => $input['street_address_1'], 
            'street_address_2' => $input['street_address_2'], 
            'city' => $input['city'], 
            'state' => $input['state'], 
            'zip_code' => $input['zip_code'], 
            'home_phone_number' => $input['home_phone_number'], 
            'cell_phone_number' => $input['cell_phone_number'], 
            'emergency_contact' => $input['emergency_contact'], 
            'emergency_phone_number' => $input['emergency_phone_number'], 
            'company' => $input['company'], 
            'plan' => $input['plan'], 
            'group' => $input['group'], 
            'physician_name' => $input['physician_name'], 
            'physician_phone_number' => $input['physician_phone_number'], 
            'physician_state' => $input['physician_state'], 
            'physician_city' => $input['physician_city'], 
            'physician_zip' => $input['physician_zip'], 
            'physician_street' => $input['physician_street'], 
        ])->save();
        
        $user->sendEmailVerificationNotification();
    }
}

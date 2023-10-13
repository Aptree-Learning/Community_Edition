<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::firstOrCreate(
            [
                'provider_id' => $socialUser->getId(),
            ],
            [
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName()
            ]
        );

        auth()->login($user, true);

        return redirect('dashboard');
    }

    public function deleteFacebookData(Request $request)
    {
        $signed_request = $request->signed_request;
        $data = $this->parse_signed_request($signed_request);
        $user_id = $data['user_id'];

        // Start data deletion

        User::where('provider_id', $data['user_id'])->forceDelete();

        $status_url =  url('login/facebook/delete/status?id=' . $user_id);
        $confirmation_code = 'abc123'; // unique code for the deletion request

        $data = array(
        'url' => $status_url,
        'confirmation_code' => $confirmation_code
        );


        return json_encode($data);
    }

    function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = "appsecret"; // Use your app secret here

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode(base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function checkIfFacebookUserIsDeleted(Request $request)
    {
        $user_id = $request->id;

        $user = User::where('provider_id', $user_id)->withTrashed()->first();

        return $user ? 'User still in the database' : 'User no longer exist!';
    }
}

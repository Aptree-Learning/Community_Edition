<x-auth-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-primary">Complete your registration.</h1>
        </div>


        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('invitation.register', ['token' => $invitation->token]) }}">
            @csrf

            <div class="mb-4">
                Email: <strong>{{ $invitation->email }}</strong>
            </div>

            <div>
                <x-label for="name" value="{{ __('Your Name') }}" />
                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="hidden mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" value="{{ $invitation->email }}" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <div class="flex items-start">
                        <x-checkbox name="terms" checked class="-mb-1" id="terms" required />

                        <div class="ml-2 text-sm ">
                            {!! __('By creating an account means you agree to the<br> :terms_of_service and our :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-sm font-bold text-gray-900 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-sm font-bold text-gray-900 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <button type="submit" class="w-full font-bold btn-primary">Register</button>
            </div>

        </form>
    </x-authentication-card>
</x-auth-layout>

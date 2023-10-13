<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- First Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('First Name') }}" />
            <x-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="state.first_name" autocomplete="first_name" />
            <x-input-error for="first_name" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="last_name" value="{{ __('Last Name') }}" />
            <x-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name" autocomplete="last_name" />
            <x-input-error for="last_name" class="mt-2" />
        </div>

        <!-- Prefers to go by -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="go_by_name" value="{{ __('Prefers to go by') }}" />
            <x-input id="go_by_name" type="text" class="mt-1 block w-full" wire:model.defer="state.go_by_name" autocomplete="go_by_name" />
            <x-input-error for="go_by_name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- Gender -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="gender" value="{{ __('Gender') }}" />
            <select wire:model.defer="state.gender" class="mt-1 block w-full w-52 rounded-md border border-gray-200 pl-10 text-sm !text-gray-900" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <x-input-error for="go_by_name" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="dob" value="{{ __('Date of Birth') }}" />
            <x-input id="dob" type="date" class="mt-1 block w-full" wire:model.defer="state.date_of_birth" autocomplete="dob" />
            <x-input-error for="dob" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4 mt-4 ">
            <h3 class="text-lg font-medium text-primary">Address</h3>
        </div>

        <!-- Street Address 1 -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="street_address_1" value="{{ __('Street Address 1') }}" />
            <x-input id="street_address_1" type="text" class="mt-1 block w-full" wire:model.defer="state.street_address_1" autocomplete="street_address_1" />
            <x-input-error for="street_address_1" class="mt-2" />
        </div>

        <!-- Street Address 2 -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="street_address_2" value="{{ __('Street Address 2') }}" />
            <x-input id="street_address_2" type="text" class="mt-1 block w-full" wire:model.defer="state.street_address_2" autocomplete="street_address_2" />
            <x-input-error for="street_address_2" class="mt-2" />
        </div>

        <!-- City -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="city" value="{{ __('City') }}" />
            <x-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" autocomplete="city" />
            <x-input-error for="city" class="mt-2" />
        </div>

        <!-- State -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="state" value="{{ __('State') }}" />
            <x-input id="state" type="text" class="mt-1 block w-full" wire:model.defer="state.state" autocomplete="state" />
            <x-input-error for="state" class="mt-2" />
        </div>

        <!-- Zip Code -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="zip_code" value="{{ __('Zip Code') }}" />
            <x-input id="zip_code" type="text" class="mt-1 block w-full" wire:model.defer="state.zip_code" autocomplete="zip_code" />
            <x-input-error for="zip_code" class="mt-2" />
        </div>

        <!-- Home Phone Number -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="home_phone_number" value="{{ __('Home Phone Number') }}" />
            <x-input id="home_phone_number" type="text" class="mt-1 block w-full" wire:model.defer="state.home_phone_number" autocomplete="home_phone_number" />
            <x-input-error for="home_phone_number" class="mt-2" />
        </div>

        <!-- Cell Phone Number -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="cell_phone_number" value="{{ __('Cell Phone Number') }}" />
            <x-input id="cell_phone_number" type="text" class="mt-1 block w-full" wire:model.defer="state.cell_phone_number" autocomplete="cell_phone_number" />
            <x-input-error for="cell_phone_number" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4 mt-4 ">
            <h3 class="text-lg font-medium text-primary">Emergency Contact</h3>
        </div>

        <!-- Emergency Contact Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="emergency_contact" value="{{ __('Emergency Contact Name') }}" />
            <x-input id="emergency_contact" type="text" class="mt-1 block w-full" wire:model.defer="state.emergency_contact" autocomplete="emergency_contact" />
            <x-input-error for="emergency_contact" class="mt-2" />
        </div>

        <!-- Emergency Contact Phone Number -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="emergency_phone_number" value="{{ __('Emergency Contact Phone Number') }}" />
            <x-input id="emergency_phone_number" type="text" class="mt-1 block w-full" wire:model.defer="state.emergency_phone_number" autocomplete="emergency_phone_number" />
            <x-input-error for="emergency_phone_number" class="mt-2" />
        </div>

        {{-- <!-- Company -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="company" value="{{ __('Company') }}" />
            <x-input id="company" type="text" class="mt-1 block w-full" wire:model.defer="state.company" autocomplete="company" />
            <x-input-error for="company" class="mt-2" />
        </div>

        <!-- Plan -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="plan" value="{{ __('Plan') }}" />
            <x-input id="plan" type="text" class="mt-1 block w-full" wire:model.defer="state.plan" autocomplete="plan" />
            <x-input-error for="plan" class="mt-2" />
        </div>

        <!-- Company -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="company" value="{{ __('Company') }}" />
            <x-input id="company" type="text" class="mt-1 block w-full" wire:model.defer="state.company" autocomplete="company" />
            <x-input-error for="company" class="mt-2" />
        </div>

        <!-- Group -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="group" value="{{ __('Group') }}" />
            <x-input id="group" type="text" class="mt-1 block w-full" wire:model.defer="state.group" autocomplete="group" />
            <x-input-error for="group" class="mt-2" />
        </div>

        <!-- Primary Care Physician Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="physician_name" value="{{ __('Primary Care Physician Name') }}" />
            <x-input id="physician_name" type="text" class="mt-1 block w-full" wire:model.defer="state.physician_name" autocomplete="physician_name" />
            <x-input-error for="physician_name" class="mt-2" />
        </div>

        <!-- Primary Care Physician Phone Number -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="physician_phone_number" value="{{ __('Primary Care Physician Phone Number') }}" />
            <x-input id="physician_phone_number" type="text" class="mt-1 block w-full" wire:model.defer="state.physician_phone_number" autocomplete="physician_phone_number" />
            <x-input-error for="physician_phone_number" class="mt-2" />
        </div>

        <!-- Primary Care Physician State -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="physician_state" value="{{ __('Primary Care Physician State') }}" />
            <x-input id="physician_state" type="text" class="mt-1 block w-full" wire:model.defer="state.physician_state" autocomplete="physician_state" />
            <x-input-error for="physician_state" class="mt-2" />
        </div>

        <!-- Primary Care Physician City -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="physician_city" value="{{ __('Primary Care Physician City') }}" />
            <x-input id="physician_city" type="text" class="mt-1 block w-full" wire:model.defer="state.physician_city" autocomplete="physician_city" />
            <x-input-error for="physician_city" class="mt-2" />
        </div>

        <!-- Primary Care Physician Zip -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="physician_zip" value="{{ __('Primary Care Physician Zip') }}" />
            <x-input id="physician_zip" type="text" class="mt-1 block w-full" wire:model.defer="state.physician_zip" autocomplete="physician_zip" />
            <x-input-error for="physician_zip" class="mt-2" />
        </div>

        <!-- Primary Care Physician Street -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="physician_street" value="{{ __('Primary Care Physician Street') }}" />
            <x-input id="physician_street" type="text" class="mt-1 block w-full" wire:model.defer="state.physician_street" autocomplete="physician_street" />
            <x-input-error for="physician_street" class="mt-2" />
        </div> --}}
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>

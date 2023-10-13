<div>
    <x-section-border />

    <div class="mt-10 sm:mt-0">
        <x-form-section submit="setOwner">
            <x-slot name="title">
                {{ __('Set Owner') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Sets a new team owner.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600">
                        {{ __('Please provide the email address of the person you would like to set as an owner.') }}
                    </div>
                </div>

                @php
                    $allUsers = \App\Models\User::all();
                @endphp

                <!-- Member Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="email" value="{{ __('Users') }}" />
                    <select class="mt1 block w-full text-sm border border-gray-200 rounded-md" wire:model="owner">
                        @foreach($allUsers as $eachUser)
                            <option @selected($team->user_id == $eachUser->id) value="{{ $eachUser->email }}">{{ $eachUser->name }} ({{ $eachUser->email }})</option>
                        @endforeach
                    </select>
                    <x-input-error for="email" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="mr-3" on="saved">
                    {{ __('Changed.') }}
                </x-action-message>

                <x-button>
                    {{ __('Change') }}
                </x-button>
            </x-slot>
        </x-form-section>
    </div>
</div>

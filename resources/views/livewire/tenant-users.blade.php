 <div>
    <header class="flex justify-between px-8 py-6 bg-white">
        <h1 class="text-4xl font-bold leading-7 text-primary sm:leading-9">Users</h1>
        <div>
        </div>
    </header>

    <div>
        <div class="px-8 py-12 space-y-8 bg-gray-100">
            <div class="mt-10 sm:mt-0">
                <x-form-section class="mb-5" submit="parseCSV">
                    <x-slot name="title">
                        {{ __('Upload CSV') }}
                    </x-slot>
    
                    <x-slot name="description">
                        {{ __('Invite new usesrs by uploading csv.') }}
                    </x-slot>
    
                    <x-slot name="form">
                        <div class="col-span-6" x-data>
                            <button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-primary uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="button" wire:click="downloadTemplate">
                                {{ __('Download Template CSV') }}
                            </button>
                            <input type="file" class="hidden" wire:model="csvFile" x-ref="csvFile" />
                            <button class="{{ $csvFile ? "hidden" : "" }} inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-primary uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="button" x-on:click.prevent="$refs.csvFile.click()">
                                {{ __('Select A New CSV') }}
                            </button>
                            <button class="{{ $csvFile ? "" : "hidden" }} inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-primary uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" type="submit">
                                {{ __('Upload') }}
                            </button>
                        </div>
                    </x-slot>
                </x-form-section>
                
                <x-form-section submit="inviteUser">
                    <x-slot name="title">
                        {{ __('Invite User') }}
                    </x-slot>
    
                    <x-slot name="description">
                        {{ __('Invite a new user, allowing them to collaborate with you.') }}
                    </x-slot>
    
                    <x-slot name="form">
                        <div class="col-span-6">
                            <div class="max-w-xl text-sm text-gray-600">
                                {{ __('Please provide the email address of the person you would like to invite.') }}
                            </div>
                        </div>
    
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="addUserForm.email" />
                            <x-input-error for="email" class="mt-2" />
                        </div>
    
                        <!-- Role -->
                        @if (count($this->roles) > 0)
                            <div class="col-span-6 lg:col-span-4">
                                <x-label for="role" value="{{ __('Role') }}" />
                                <x-input-error for="role" class="mt-2" />
    
                                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                    @foreach ($this->roles as $index => $role)
                                        <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                                        wire:click="$set('addUserForm.role', '{{ $role['key'] }}')">
                                            <div class="{{ isset($addUserForm['role']) && $addUserForm['role'] !== $role['key'] ? 'opacity-50' : '' }}">
                                                <!-- Role Name -->
                                                <div class="flex items-center">
                                                    <div class="text-sm text-gray-600 {{ $addUserForm['role'] == $role['key'] ? 'font-semibold' : '' }}">
                                                        {{ $role['name'] }}
                                                    </div>
    
                                                    @if ($addUserForm['role'] == $role['key'])
                                                        <svg class="ml-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @endif
                                                </div>
    
                                                <!-- Role Description -->
                                                <div class="mt-2 text-xs text-gray-600 text-left">
                                                    {{ $role['description'] }}
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </x-slot>
    
                    <x-slot name="actions">
                        <x-action-message class="mr-3" on="saved">
                            {{ __('Added.') }}
                        </x-action-message>
    
                        <x-button>
                            {{ __('Add') }}
                        </x-button>
                    </x-slot>
                </x-form-section>

                @if ($invitations->isNotEmpty())
                    <x-section-border />

                    <div class="mt-10 sm:mt-0">
                        <x-action-section>
                            <x-slot name="title">
                                {{ __('Pending User Invitations') }}
                            </x-slot>

                            <x-slot name="description">
                                {{ __('These people have been invited and have been sent an invitation email. They may join by accepting the email invitation.') }}
                            </x-slot>

                            <x-slot name="content">
                                <div class="gap-y-4 grid grid-cols-3 ">
                                    @foreach ($invitations as $invitation)
                                            <div class="text-gray-600">{{ $invitation->email }}</div>
                                            <div class="text-gray-600">{{ Str::upper($invitation->role) }}</div>

                                            <div class="flex items-end justify-end">
                                                <button class="cursor-pointer ml-6 text-sm text-blue-500 focus:outline-none"
                                                                    wire:click="resendInvitation({{ $invitation->id }})">
                                                    {{ __('Reinvite') }}
                                                </button>
                                                <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                                    wire:click="$set('deletingID', {{ $invitation->id }})">
                                                    {{ __('Cancel') }}
                                                </button>
                                        </div>
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-action-section>

                        <x-confirmation-modal wire:model="deletingID">
                            <x-slot name="title">
                                {{ __('Remove User Invitation') }}
                            </x-slot>

                            <x-slot name="content">
                                {{ __('Are you sure you would like to remove this invitation?') }}
                            </x-slot>

                            <x-slot name="footer">
                                <x-secondary-button wire:click="$set('deletingID', null)" wire:loading.attr="disabled">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ml-3" wire:click="cancelInvitation()" wire:loading.attr="disabled">
                                    {{ __('Remove') }}
                                </x-danger-button>
                            </x-slot>
                        </x-confirmation-modal>
                    </div>
                @endif
                <div class="mt-10 sm:mt-5">
                    <x-action-section>
                        <x-slot name="title">
                            {{ __('Active Users') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('Here is a list of active users.') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="space-y-6">
                                {{ $this->table }}
                            </div>
                        </x-slot>
                    </x-action-section>
                </div>
            </div>

        </div>
    </div>
    
</div>
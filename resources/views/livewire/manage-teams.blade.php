<div>
    <header class="flex justify-between px-4 py-6 bg-white lg:px-8 lg:pl-16">
        <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">{{ Str::plural(settings('team')) }}</h1>
        <div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('teams.create') }}" type="button" class="inline-flex items-center w-full btn-primary">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>

                Create {{ settings('team') }}
            </a>
            @endif
        </div>
    </header>

    <div class="px-4 py-12 bg-gray-100 lg:px-8 lg:pl-16">
        <div class="grid gap-6 mt-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($teams as $eachTeam)
                <div wire:key="{{ $eachTeam->id }}" class="flex flex-col p-4 bg-white border rounded-md shadow-md">
                    <div>
                        <x-heroicon-s-user-group class="w-10 h-10 text-gray-600" />
                    </div>
                    <p class="mt-1 text-secondary">{{ settings('team') }}</p>
                    <h3 class="mt-2 text-lg font-bold">
                        <a href="{{ route('teams.show', [$eachTeam]) }}">
                        {{ $eachTeam->name }}
                        </a>
                    </h3>
                    <div class="flex items-end justify-between flex-grow w-full mt-4">
                        <div class="flex gap-3">
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-template class="flex-shrink-0 w-4 h-4 text-gray-400" />
                                <span class="text-sm">{{ $eachTeam->users()->count() }} users</span>
                            </div>
                        </div>
                        <x-dropdown>
                            <x-slot name="button">
                                <button>
                                    <x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400" />
                                </button>
                            </x-slot>
                            <div>
                                <a href="{{ route('teams.show', $eachTeam->id) }}"
                                    class="flex items-center px-4 py-2 text-sm text-primary group"
                                    role="menuitem" tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-eye
                                        class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500" />
                                    View
                                </a>
                                <a x-data x-on:click.prevent="$dispatch('openmodal-assign-course-{{ $eachTeam->id }}'); " href="#" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
                                    tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-duplicate  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                    Assign
                                </a>
                                <button wire:click="$set('deletingID', {{ $eachTeam->id }})" class="flex items-center px-4 py-2 text-sm text-primary group" tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-trash  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                    Delete
                                </button>
                                <x-modal-default ref="assign-course-{{ $eachTeam->id }}">
                                    <div>
                                        @livewire('teams.assign-course', ['teamId' => $eachTeam->id], key($eachTeam->id))
                                    </div>
                                </x-modal-default>
                            </div>
                        </x-dropdown>
                    </div>
                </div>
            @endforeach
            <x-confirmation-modal wire:model="deletingID">
                <x-slot name="title">
                    {{ __('Delete Team') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you would like to delete this team?') }}
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$set('deletingID', null)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" wire:click="deleteTeam()" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </x-slot>
            </x-confirmation-modal>
        </div>
    </div>
</div>

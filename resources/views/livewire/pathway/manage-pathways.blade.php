

<div>
    <header class="flex justify-between bg-white py-6 px-4 lg:px-16">
        <h1 class="text-3xl font-bold leading-7 text-primary sm:leading-9">Pathways</h1>
        <div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('pathway.builder') }}" type="button" class="inline-flex items-center w-full btn-primary">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>

                Create Pathway
            </a>
            @endif
        </div>
    </header>
    <div class="px-4 py-12 bg-gray-100 lg:px-8">
        <section>

            <div class="flex justify-between pb-2 border-b border-gray-200">
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select id="tabs" name="tabs"
                        class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option>View All</option>

                        <option>Published</option>

                        <option>Drafts</option>

                        <option>Deleted</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div>
                        <nav class="flex -mb-px space-x-4" aria-label="Tabs">

                            <a href="?"
                                class="@if ($filter == '') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                View All
                                <span class="@if ($filter == '') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['all'] }}</span>
                            </a>

                            @if(Auth::user()->isAdmin())
                            <a href="?filter=published"
                                class="@if ($filter == 'published') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Published
                            <span class="@if ($filter == 'published') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['published'] }}</span>
                            </a>

                            <a href="?filter=draft"
                                class="@if ($filter == 'draft') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Drafts
                                <span class="@if ($filter == 'draft') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['draft'] }}</span>
                            </a>

                            <a href="?filter=deleted"
                                class="@if ($filter == 'deleted') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                Deleted
                                <span class="@if ($filter == 'deleted') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['deleted'] }}</span>
                            </a>
                            @endif
                        </nav>
                    </div>
                </div>
                <div class="flex gap-2">
                    <select class="text-sm border border-gray-200 rounded-md">
                        <option value="">Filter by Author</option>
                    </select>
                    <select class="text-sm border border-gray-200 rounded-md">
                        <option value="">Filter by category</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 mt-8 md:grid-cols-3">

                @foreach($pathways as $pathway)
                <div wire:key="grid-pathway-{{ $pathway->id }}" class="flex flex-col p-6 space-y-2 bg-white border rounded-md">
                    <div class="">
                        <x-heroicon-s-cube-transparent class="w-10 h-10 text-primary "/>
                    </div>
                    <p class="mt-1 text-secondary">Pathway</p>
                    <div>
                        <h3 class="text-lg font-bold text-primary">{{ $pathway->title }}</h3>
                        <div class="mt-2 text-gray-600">
                            {{ Str::limit($pathway->description, 200) }}
                        </div>
                    </div>
                    <div class="flex items-end justify-between flex-grow w-full mt-4">
                        <div class="flex gap-3">
                            <div class="flex items-center gap-1">
                                <x-heroicon-s-template class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ $pathway->courses->count() }} Courses</span>
                            </div>
                        </div>
                        <div>
                            <x-dropdown>
                                <x-slot name="button">
                                    <button>
                                        <x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400"/>
                                    </button>
                                </x-slot>
                                <div>
                                    <a href="{{ route('pathway.show', $pathway->id) }}" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
                                        tabindex="-1" id="menu-item-0">
                                        <x-heroicon-s-eye  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                        View
                                    </a>
                                    <a href="{{ route('pathway.builder', $pathway->id) }}" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
                                        tabindex="-1" id="menu-item-0">
                                        <x-heroicon-s-pencil  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                        Edit
                                    </a>
                                    <button wire:click="$set('deletingID', {{ $pathway->id }})" class="flex items-center px-4 py-2 text-sm text-primary group" tabindex="-1" id="menu-item-0">
                                        <x-heroicon-s-trash  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                        Delete
                                    </button>
                                    @if (!$pathway->trashed() && $pathway->status == \App\Enums\CourseStatus::Published && (Auth::user()->isAdmin() || Auth::user()->isManager()))
                                    <div>
                                        <a x-data x-on:click.prevent="$dispatch('openmodal-assign-pathway-{{ $pathway->id }}'); " href="#" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
                                            tabindex="-1" id="menu-item-0">
                                            <x-heroicon-s-duplicate  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                            Assign
                                        </a>

                                        <x-modal-default ref="assign-pathway-{{ $pathway->id }}">
                                            <div>
                                                @livewire('pathway.assign-pathway', ['pathwayId' => $pathway->id])
                                            </div>
                                        </x-modal-default>
                                    </div>
                                    @endif
                                </div>
                            </x-dropdown>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <x-confirmation-modal wire:model="deletingID">
                <x-slot name="title">
                    {{ __('Delete Course') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you would like to delete this course?') }}
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$set('deletingID', null)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ml-3" wire:click="deletePathway()" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-danger-button>
                </x-slot>
            </x-confirmation-modal>
        </section>
    </div>
</div>


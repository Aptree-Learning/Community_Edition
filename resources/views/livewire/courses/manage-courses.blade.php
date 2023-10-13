<div>
    <header class="flex justify-between bg-white py-6 px-4 lg:px-16">
        <h1 class="text-primary text-xl font-bold leading-7 sm:leading-9 lg:text-3xl">Course Library</h1>
        <div>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('courses.create') }}" type="button" class="btn-primary inline-flex w-full items-center">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    Create Course
                </a>
            @endif
        </div>
    </header>
    <div class="bg-gray-100 px-4 py-12 lg:px-16">
        <section>

            <div class="flex justify-between border-b border-gray-200 pb-2">
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select id="tabs" name="tabs"
                        class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option>Applied</option>

                        <option>Phone Screening</option>

                        <option selected>Interview</option>

                        <option>Offer</option>

                        <option>Disqualified</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <div>
                        <nav class="-mb-px flex space-x-4" aria-label="Tabs">

                            <a href="?"
                                class="@if ($filter == '') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                aria-current="page">
                                View All
                                <span
                                    class="@if ($filter == '') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['total'] }}</span>
                            </a>

                            @if (Auth::user()->isAdmin())
                                <a href="?filter=published"
                                    class="@if ($filter == 'published') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                    aria-current="page">
                                    Published
                                    <span
                                        class="@if ($filter == 'published') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['published'] }}</span>
                                </a>

                                <a href="?filter=draft"
                                    class="@if ($filter == 'draft') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                    aria-current="page">
                                    Drafts
                                    <span
                                        class="@if ($filter == 'draft') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['draft'] }}</span>
                                </a>

                                <a href="?filter=deleted"
                                    class="@if ($filter == 'deleted') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                    aria-current="page">
                                    Deleted
                                    <span
                                        class="@if ($filter == 'deleted') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['deleted'] }}</span>
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>
                <div class="hidden gap-2 lg:flex">
                    <select wire:model="author_id" class="rounded-md border border-gray-200 text-sm">
                        <option value="">Filter by Author</option>
                        @foreach ($authors as $user)
                            <option wire:key="{{ 'user' . $user->id }}" value="{{ $user->id }}">
                                {{ $user->name }}</option>
                        @endforeach
                    </select>
                    <select wire:model="category_id" class="w-48 rounded-md border border-gray-200 text-sm">
                        <option value="">Filter by category</option>
                        @foreach ($categories as $category)
                            <option wire:key="{{ 'cat' . $category->id }}" value="{{ $category->id }}">
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </section>

        <section class="text-primary mt-8">
            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($courses as $course)
                    <div wire:key="{{ 'course' . $course->id }}"
                        class="flex flex-col rounded-md border bg-white p-4 shadow-md">
                        <a href="{{ route('courses.show', [$course]) }}">
                            <div>
                                @livewire('course-icons', ['icon' => $course->icon, 'class' => 'h-10 w-10 text-gray-600'], key('course' . $course->id))
                                {{-- @if ($course->icon == 'lightning')
                                <x-heroicon-s-lightning-bolt class="h-10 w-10 text-gray-600" />
                            @else
                                <x-heroicon-s-academic-cap class="h-10 w-10 text-gray-600" />
                            @endif --}}
                            </div>
                            <p class="text-secondary mt-1">Course</p>
                            <h3 class="mt-2 text-lg font-bold">
                                {{ $course->title }}
                            </h3>
                            <div class="text-gray-600">{{ Str::limit($course->description, 100) }}</div>
                            <div class="mt-4 flex w-full flex-grow items-end justify-between">
                                <div class="flex gap-3">
                                    <div class="flex items-center gap-1">
                                        <x-heroicon-o-template class="h-4 w-4 text-gray-400" />
                                        <span class="text-sm">{{ $course->modules()->count() }} modules</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <x-heroicon-o-clock class="h-4 w-4 text-gray-400" />
                                        <span
                                            class="text-sm">{{ Carbon\Carbon::parse($course->estimated_time)->format('H:i') }}
                                            minutes</span>
                                    </div>
                                </div>
                                <x-dropdown>
                                    <x-slot name="button">
                                        <button>
                                            <x-heroicon-s-dots-vertical class="h-4 w-4 text-gray-400" />
                                        </button>
                                    </x-slot>
                                    <div>
                                        <a href="{{ route('courses.show', $course->id) }}"
                                            class="text-primary group flex items-center px-4 py-2 text-sm"
                                            role="menuitem" tabindex="-1">
                                            <x-heroicon-s-play
                                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                            Play
                                        </a>
                                        @if (Auth::user()->isAdmin())
                                            <a href="{{ route('courses.edit', $course->id) }}"
                                                class="text-primary group flex items-center px-4 py-2 text-sm"
                                                role="menuitem" tabindex="-1">
                                                <x-heroicon-s-pencil
                                                    class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                Edit Details
                                            </a>
                                            @if ($course->trashed())
                                                <button wire:click="restoreCourse({{ $course->id }})"
                                                    class="text-primary group flex items-center px-4 py-2 text-sm"
                                                    role="menuitem" tabindex="-1">
                                                    <x-heroicon-s-trash
                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                    Restore
                                                </button>
                                            @else
                                                <button wire:click="$set('deletingID', {{ $course->id }})"
                                                    type="button"
                                                    class="text-primary group flex items-center px-4 py-2 text-sm"
                                                    role="menuitem" tabindex="-1">
                                                    <x-heroicon-s-trash
                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                    Delete
                                                </button>
                                            @endif
                                        @endif
                                        @if (
                                            !$course->trashed() &&
                                                $course->status == \App\Enums\CourseStatus::Published &&
                                                (Auth::user()->isAdmin() || Auth::user()->isManager()))
                                            <div>
                                                <a x-data
                                                    x-on:click.prevent="$dispatch('openmodal-assign-course-{{ $course->id }}'); "
                                                    href="#"
                                                    class="text-primary group flex items-center px-4 py-2 text-sm"
                                                    role="menuitem" tabindex="-1">
                                                    <x-heroicon-s-duplicate
                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                    Assign
                                                </a>

                                                <x-modal-default ref="assign-course-{{ $course->id }}">
                                                    <div>
                                                        @livewire('courses.assign-course', ['courseId' => $course->id], key('modal' . $course->id))
                                                    </div>
                                                </x-modal-default>
                                            </div>
                                        @endif
                                    </div>
                                </x-dropdown>
                            </div>
                        </a>
                    </div>
                @endforeach
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

                        <x-danger-button class="ml-3" wire:click="deleteCourse()" wire:loading.attr="disabled">
                            {{ __('Delete') }}
                        </x-danger-button>
                    </x-slot>
                </x-confirmation-modal>
            </div>
        </section>
    </div>
</div>

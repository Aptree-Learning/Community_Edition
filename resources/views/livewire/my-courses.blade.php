<div>
    <div class="mt-10 flex gap-5 px-4 lg:px-16">
        <div class="mb-4 flex w-1/4 flex-row rounded-lg border bg-white p-6 pl-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-10">
                <x-heroicon-s-academic-cap class="flex-shrink-0 w-6 h-6 text-gray-500"/>
            </div>
            <div class="ml-5 flex flex-col justify-center">
                <span class="text-2xl font-extrabold text-gray-700">{{ $graph_students }}</span>
                <span class="text-sm font-normal text-gray-700">Students</span>
            </div>
        </div>
        <div class="mb-4 flex w-1/4 flex-row rounded-lg border bg-white p-6 pl-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-secondary-10">
                <img src="{{ asset('img/vector.svg') }}" class="h-6 w-6" />
            </div>
            <div class="ml-5 flex flex-col justify-center">
                <span class="text-2xl font-extrabold text-gray-700">{{ $graph_published_courses }}</span>
                <span class="text-sm font-normal text-gray-700">Courses</span>
            </div>
        </div>
        <div class="mb-4 flex w-1/4 flex-row rounded-lg border bg-white p-6 pl-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-10">
                <img src="{{ asset('img/bag.svg') }}" class="h-6 w-6" />
            </div>
            <div class="ml-5 flex flex-col justify-center">
                <span class="text-2xl font-extrabold text-gray-700">{{ $graph_learning_paths }}</span>
                <span class="text-sm font-normal text-gray-700">Learning Paths</span>
            </div>
        </div>
        <div class="mb-4 flex w-1/4 flex-row rounded-lg border bg-white p-6 pl-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-secondary-10">
                <img src="{{ asset('img/vector.svg') }}" class="h-6 w-6" />
            </div>
            <div class="ml-5 flex flex-col justify-center">
                <span class="text-2xl font-extrabold text-gray-700">{{ $graph_draft_courses }}</span>
                <span class="text-sm font-normal text-gray-700">Course Drafts</span>
            </div>
        </div>
    </div>
    <div class="px-4 lg:px-16 flex flex-row gap-5 pb-8">
        <div class="w-2/3 bg-white pt-8 pb-3 px-8">
            <span class="text-2xl font-extrabold text-gray-700">Student Activity</span>
            <canvas id="myChart"></canvas>
        </div>
        <div class="w-1/3 bg-white pt-8 px-8 pb-4">
            <span class="text-2xl font-extrabold text-gray-700">Course Progress</span>
            <canvas id="progressChart"></canvas>
        </div>
    </div>
    <div class="flex gap-10">
        <div>
            <header class="py-6 pl-4 lg:pl-16">
                <h1 class="text-primary text-xl font-bold leading-7 sm:leading-9 lg:text-3xl">Your
                    {{ Str::plural(settings('team')) }}
                </h1>
                <h3 class="text-primary text-md leading-7 sm:leading-9 lg:text-lg">
                    {{ Str::plural(settings('team')) }} that you are responsible for managing
                </h3>
            </header>
            <div class="bg-gray-100 pb-12 pl-4 lg:pl-16">
                <section>

                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        {{-- <div class="sm:hidden">
                            <label for="tabs" class="sr-only">Select a tab</label>
                            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                            <select id="tabs" name="tabs" wire:model="course_filter"
                                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                <option>Applied</option>

                                <option>Phone Screening</option>

                                <option selected>Interview</option>

                                <option>Offer</option>

                                <option>Disqualified</option>
                            </select>
                        </div> --}}
                        <div class="hidden sm:block">
                            {{-- <div>
                                <nav class="-mb-px flex space-x-4" aria-label="Tabs">

                                    <a href="?"
                                        class="@if ($course_filter == '') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                        aria-current="page">
                                        View All
                                        <span
                                            class="@if ($course_filter == '') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['total'] }}</span>
                                    </a>

                                    @if (Auth::user()->isAdmin())
                                        <a href="?course_filter=draft"
                                            class="@if ($course_filter == 'draft') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                            aria-current="page">
                                            Drafts
                                            <span
                                                class="@if ($course_filter == 'draft') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['draft'] }}</span>
                                        </a>

                                        <a href="?course_filter=published"
                                            class="@if ($course_filter == 'published') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                            aria-current="page">
                                            Published
                                            <span
                                                class="@if ($course_filter == 'published') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['published'] }}</span>
                                        </a>

                                        <a href="?course_filter=deleted"
                                            class="@if ($course_filter == 'deleted') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                            aria-current="page">
                                            Deleted
                                            <span
                                                class="@if ($course_filter == 'deleted') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['deleted'] }}</span>
                                        </a>
                                    @endif
                                </nav>
                            </div> --}}
                        </div>
                        <div class="hidden gap-2 lg:flex">
                            {{-- <div class="relative max-w-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-s-filter class="h-4 w-4 text-gray-500" />
                                </div>
                                <input datepicker datepicker-autohide type="text" wire:model="team_filter_date"
                                    class="block w-full cursor-pointer rounded-lg border border-gray-200 bg-white p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Filter by Date">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <x-heroicon-s-chevron-down class="h-6 w-6 text-gray-500" />
                                </div>
                            </div> --}}
                            {{-- <div class="relative max-w-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-s-filter class="h-4 w-4 text-gray-500"/>
                                </div>
                                <select wire:model="category_id" class="pl-10 rounded-md w-48 border border-gray-200 text-sm !text-gray-900">
                                    <option value="">Filter by category</option>
                                    @foreach ($categories as $category)
                                        <option wire:key="{{ 'cat' . $category->id }}" value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="relative max-w-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-s-filter class="h-4 w-4 text-gray-500" />
                                </div>
                                <select wire:model="team_sort"
                                    class="w-52 rounded-md border border-gray-200 pl-10 text-sm !text-gray-900">
                                    <option value="asc">Sort by Ascending</option>
                                    <option value="desc">Sort by Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </section>

                <section class="text-primary mt-8">
                    {{ $this->table }}
                </section>
            </div>
        </div>

        <div>
            <header class="py-6 pr-4 lg:pr-16">
                <h1 class="text-primary text-xl font-bold leading-7 sm:leading-9 lg:text-3xl">Your Content</h1>
                <h3 class="text-primary text-md leading-7 sm:leading-9 lg:text-lg">
                    Content in the library that you are the author or co-author of
                </h3>
            </header>
            <div class="bg-gray-100 pb-12 pr-4 lg:pr-16">
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
                                        class="@if ($course_filter == '') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                        aria-current="page">
                                        View All
                                        <span
                                            class="@if ($course_filter == '') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['total'] }}</span>
                                    </a>

                                    @if (Auth::user()->isAdmin())
                                        <a href="?course_filter=draft"
                                            class="@if ($course_filter == 'draft') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                            aria-current="page">
                                            Drafts
                                            <span
                                                class="@if ($course_filter == 'draft') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['draft'] }}</span>
                                        </a>

                                        <a href="?course_filter=published"
                                            class="@if ($course_filter == 'published') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                            aria-current="page">
                                            Published
                                            <span
                                                class="@if ($course_filter == 'published') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['published'] }}</span>
                                        </a>

                                        <a href="?course_filter=deleted"
                                            class="@if ($course_filter == 'deleted') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                                            aria-current="page">
                                            Deleted
                                            <span
                                                class="@if ($course_filter == 'deleted') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $counts['deleted'] }}</span>
                                        </a>
                                    @endif
                                </nav>
                            </div>
                        </div>
                        <div class="hidden gap-2 lg:flex">
                            {{-- <div class="relative max-w-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-s-filter class="h-4 w-4 text-gray-500" />
                                </div>
                                <input datepicker datepicker-autohide type="text" wire:model="course_filter_date"
                                    class="block w-full cursor-pointer rounded-lg border border-gray-200 bg-white p-2.5 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Filter by Date">
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                    <x-heroicon-s-chevron-down class="h-6 w-6 text-gray-500" />
                                </div>
                            </div> --}}
                            {{-- <div class="relative max-w-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-s-filter class="h-4 w-4 text-gray-500"/>
                                </div>
                                <select wire:model="category_id" class="pl-10 rounded-md w-48 border border-gray-200 text-sm !text-gray-900">
                                    <option value="">Filter by category</option>
                                    @foreach ($categories as $category)
                                        <option wire:key="{{ 'cat' . $category->id }}" value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="relative max-w-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-s-filter class="h-4 w-4 text-gray-500" />
                                </div>
                                <select wire:model="course_sort"
                                    class="w-52 rounded-md border border-gray-200 pl-10 text-sm !text-gray-900">
                                    <option value="asc">Sort by Ascending</option>
                                    <option value="desc">Sort by Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </section>

                <section class="text-primary mt-8">
                    <div class="grid gap-6 lg:grid-cols-3">
                        @foreach ($courses as $course)
                            <div wire:key="{{ 'course' . $course->id }}"
                                class="relative flex flex-col rounded-md border bg-white p-4 shadow-md">
                                <a href="{{ route('courses.show', [$course]) }}">
                                    @if ($course->status == \App\Enums\CourseStatus::Published)
                                        <div class="absolute right-2 top-3">
                                            <div class="mb-4 flex items-center rounded-lg border border-green-300 bg-[#EEF8F4] px-4 py-2 text-sm text-[#696F8C]"
                                                role="alert">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="mr-2 h-6 w-6 text-[#52BD94]">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>
                                                    Published
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
                                <x-secondary-button wire:click="$set('deletingID', null)"
                                    wire:loading.attr="disabled">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ml-3" wire:click="deleteCourse()"
                                    wire:loading.attr="disabled">
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </x-slot>
                        </x-confirmation-modal>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            const ctx = document.getElementById('myChart');
            console.log(window.innerWidth * 0.75 + 'px');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {{ Js::from($graph_login_labels) }},
                    datasets: [{
                        label: 'Active Students',
                        data: {{ Js::from($graph_logins) }},
                        fill: false,
                        borderColor: "{{ settings('text_primary') }}",
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            const ctx1 = document.getElementById('progressChart');
            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'New', 'In Progress'],
                    datasets: [{
                        data: {{ Js::from($graph_progress) }},
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    cutout: '70%',
                    backgroundColor: [
                        "{{ settings('text_primary') }}",
                        "{{ settings('text_secondary') }}",
                        '#FF8F6B'
                    ],
                    // hoverOffset: 4,
                    animation: true
                }
            });
        });
    </script>
</div>

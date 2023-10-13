@extends('layouts.app')

@section('content')
    <div>
        <header class="flex justify-between bg-white py-6 pl-4 lg:pl-16">
            <div>
                <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">Welcome Back, {{ Auth()->user()->name }}</h1>
            </div>
        </header>

        <div>
            <div class="pl-16 flex justify-between border-b border-gray-200 py-3">
                <div>
                    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
                        <a href="?force=true"
                            class="@if ($filter == '') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                            aria-current="page">
                            View All
                            <span class="@if ($filter == '') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['all'] }}</span>
                        </a>

                        <a href="?filter=new&force=true"
                            class="@if ($filter == 'new') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                            aria-current="page">
                            New Assignments
                            <span class="@if ($filter == 'new') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['new'] }}</span>
                        </a>

                        <a href="?filter=progress&force=true"
                            class="@if ($filter == 'progress') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                            aria-current="page">
                            In Progress
                            <span class="@if ($filter == 'progress') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['progress'] }}</span>
                        </a>

                        <a href="?filter=completed&force=true"
                            class="@if ($filter == 'completed') text-indigo-600  @else text-gray-500 @endif flex whitespace-nowrap px-1 py-2 text-sm font-medium"
                            aria-current="page">
                            Completed
                            <span class="@if ($filter == 'completed') text-indigo-600 bg-indigo-100 @else text-gray-900 bg-gray-200 @endif ml-1 hidden rounded-full px-2.5 py-0.5 text-xs font-medium md:inline-block">{{ $count['completed'] }}</span>
                        </a>
                    </nav>
                </div>
            </div>
            <div class="space-y-8 bg-gray-100 px-8 py-12 pl-4 lg:pl-16">
                @if (count($enrollments) && $filter == '')
                    <section>
                        <div class="border-gray-300">
                            <h3 class="text-primary text-lg font-bold lg:text-xl">Courses You're Taking</h3>
                        </div>
                        <div class="mt-4 grid gap-6 lg:grid-cols-3">
                            @foreach ($enrollments as $enrollment)
                                <div class="rounded-md bg-white shadow-sm">
                                    <div class="h-52 w-full rounded-t-md border bg-[url('http://marketplace.test/img/default.svg')] bg-cover bg-center"
                                        style="background-image: url({{ $enrollment->course?->image_url ?? asset('img/question.jpg') }})">
                                        <div
                                            class="flex h-full w-full items-center justify-center rounded-t-md bg-gray-500/40 backdrop-blur-lg">
                                            <img src="{{ $enrollment->course?->image_url ?? asset('img/question.jpg') }}"
                                                class="h-40 w-40 rounded-md bg-white p-4">
                                        </div>
                                    </div>
                                    <div class="items-center justify-between p-4 lg:flex lg:p-6">
                                        <div>
                                            <h3 class="text-primary text-xl font-bold">{{ $enrollment->course->title }}
                                            </h3>
                                            <div class="mt-3 gap-3 md:flex">
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-template class="h-4 w-4 text-gray-400" />
                                                    <span class="text-sm">{{ $enrollment->course->modules()->count() }}
                                                        modules</span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-clock class="h-4 w-4 text-gray-400" />
                                                    <span
                                                        class="text-sm">{{ Carbon\Carbon::parse($enrollment->course->estimated_time)->format('H:i') }}
                                                        minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 md:mt-0">
                                            <a href="{{ route('courses.show', $enrollment->course->id) }}"
                                                class="btn-primary">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (count($courses))
                    <section>
                        <div class="border-gray-300">
                            <h3 class="text-primary text-lg font-bold lg:text-xl">Learning Courses</h3>
                        </div>
                        <div class="mt-4 grid gap-6 lg:grid-cols-3">
                            @foreach ($courses as $course)
                                <div class="rounded-md bg-white shadow-sm">
                                    <div class="h-52 w-full rounded-t-md border bg-[url('http://marketplace.test/img/default.svg')] bg-cover bg-center"
                                        style="background-image: url({{ $course?->image_url ?? asset('img/question.jpg') }})">
                                        <div
                                            class="flex h-full w-full items-center justify-center rounded-t-md bg-gray-500/40 backdrop-blur-lg">
                                            <img src="{{ $course?->image_url ?? asset('img/question.jpg') }}"
                                                class="h-40 w-40 rounded-md bg-white p-4">
                                        </div>
                                    </div>
                                    <div class="items-center justify-between p-4 lg:flex lg:p-6">
                                        <div>
                                            <h3 class="text-primary text-xl font-bold">{{ $course->title }}
                                            </h3>
                                            <div class="mt-3 gap-3 md:flex">
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-template class="h-4 w-4 text-gray-400" />
                                                    <span class="text-sm">{{ $course->modules()->count() }}
                                                        modules</span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-clock class="h-4 w-4 text-gray-400" />
                                                    <span
                                                        class="text-sm">{{ Carbon\Carbon::parse($course->estimated_time)->format('H:i') }}
                                                        minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 md:mt-0">
                                            <a href="{{ route('courses.show', $course->id) }}"
                                                class="btn-primary">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (count($pathways))
                    <section>
                        <div class="border-gray-300">
                            <h3 class="text-primary text-lg font-bold lg:text-xl">Learning Paths</h3>
                        </div>
                        <div class="mt-4 grid gap-6 lg:grid-cols-3">
                            @foreach ($pathways as $pathway)
                                <div class="rounded-md bg-white shadow-sm">
                                    <div class="h-52 w-full rounded-t-md border bg-[url('http://marketplace.test/img/default.svg')] bg-cover bg-center"
                                        style="background-image: url({{ asset('img/question.jpg') }})">
                                        <div
                                            class="flex h-full w-full items-center justify-center rounded-t-md bg-gray-500/40 backdrop-blur-lg">
                                            <img src="{{ asset('img/question.jpg') }}"
                                                class="h-40 w-40 rounded-md bg-white p-4">
                                        </div>
                                    </div>
                                    <div class="items-center justify-between p-4 lg:flex lg:p-6">
                                        <div>
                                            <h3 class="text-primary text-xl font-bold">{{ $pathway->title }}
                                            </h3>
                                            <div class="mt-3 gap-3 md:flex">
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-template class="h-4 w-4 text-gray-400" />
                                                    <span class="text-sm">{{ $pathway->count() }}scourses</span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <x-heroicon-o-clock class="h-4 w-4 text-gray-400" />
                                                    <span
                                                        class="text-sm">{{ Carbon\Carbon::parse($pathway->estimated_time)->format('H:i') }}
                                                        minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 md:mt-0">
                                            <a href="{{ route('pathway.show', $pathway->id) }}"
                                                class="btn-primary">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (settings('full_access'))
                    <section class="mt-8">
                        <div class="flex justify-between border-b-2 border-gray-300 pb-6">
                            <h3 class="text-primary text-xl font-bold">Library</h3>
                            <a href="{{ url('courses') }}" class="text-primary inline-flex items-center">More
                                <x-heroicon-s-chevron-right class="h-4 w-4" />
                            </a>
                        </div>
                        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($libraries as $availableCourse)
                                <div class="flex flex-col rounded-md border bg-white p-4 shadow-md">
                                    <div>
                                        @livewire('course-icons', ['icon' => $availableCourse->icon, 'class' => 'w-10 h-10 text-gray-600'])
                                    </div>
                                    <p class="text-secondary mt-1">Course</p>
                                    <h3 class="mt-2 text-lg font-bold">
                                        <a href="{{ route('courses.show', [$availableCourse]) }}">
                                            {{ $availableCourse->title }}
                                        </a>
                                    </h3>
                                    <div class="text-gray-600">{{ Str::limit($availableCourse->description, 100) }}</div>
                                    <div class="mt-4 flex w-full flex-grow items-end justify-between">
                                        <div class="flex gap-3">
                                            <div class="flex items-center gap-1">
                                                <x-heroicon-o-template class="h-4 w-4 flex-shrink-0 text-gray-400" />
                                                <span class="text-sm">{{ $availableCourse->modules()->count() }}
                                                    modules</span>
                                            </div>
                                            <div class="hidden items-center gap-1 md:flex">
                                                <x-heroicon-o-clock class="h-4 w-4 text-gray-400" />
                                                <span
                                                    class="text-sm">{{ Carbon\Carbon::parse($availableCourse->estimated_time)->format('H:i') }}
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
                                                <a href="{{ route('courses.show', $availableCourse->id) }}"
                                                    class="text-primary group flex items-center px-4 py-2 text-sm"
                                                    role="menuitem" tabindex="-1" id="menu-item-0">
                                                    <x-heroicon-s-play
                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                                    Play
                                                </a>
                                            </div>
                                        </x-dropdown>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </div>

    </div>
@endsection



<div>
    <header class="flex justify-between px-8 py-6">
        <h1 class="text-3xl font-bold leading-7 text-primary sm:leading-9">Template Library</h1>
    </header>
    <div class="px-8 py-12 bg-gray-100">
        <section>

            <div class="pb-6 border-b-2 border-gray-300">
                <h3 class="text-xl font-bold text-primary">Pathways</h3>
            </div>

            <div class="grid grid-cols-2 gap-6 mt-8">

                @foreach($pathways as $pathway)
                <div class="p-6 bg-white border rounded-md">
                    <div>
                        <x-heroicon-s-template class="w-10 h-10 text-gray-400"/>
                    </div>
                    <h3 class="mt-2 text-lg font-bold text-primary">{{ $pathway->title }}</h3>
                    <div class="mt-2 text-gray-600">
                        {{ $pathway->description }}
                    </div>
                    <div class="flex justify-between mt-8">
                        <div class="flex gap-3">
                            <div class="flex items-center gap-1">
                                <x-heroicon-s-template class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">0/{{ $pathway->courses_count }} Courses</span>
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
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
                                        tabindex="-1" id="menu-item-0">
                                        <x-heroicon-s-duplicate  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                        Assign
                                    </a>
                                </div>
                            </x-dropdown>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </section>

        <section class="mt-8">
            <div class="flex justify-between pb-6 border-b-2 border-gray-300">
                <h3 class="text-xl font-bold text-primary">Courses Library</h3>
            </div>
            <div class="grid grid-cols-2 gap-6 mt-8 lg:grid-cols-3">
                @foreach($courses as $course)
                <div class="flex flex-col p-4 bg-white border rounded-md shadow-md">
                    <div>
                        @livewire('course-icons', ['icon' => $course->icon, 'class' => 'w-10 h-10 text-gray-600'])
                    </div>
                    <p class="mt-1 text-secondary">Course</p>
                    <h3 class="mt-2 text-lg font-bold">{{ $course->title }}</h3>
                    <div class="text-gray-600">{{ Str::limit($course->description, 100) }}</div>
                    <div class="flex items-end justify-between flex-grow w-full mt-4">
                        <div class="flex gap-3">
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-template class="flex-shrink-0 w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ $course->modules()->count() }} modules</span>
                            </div>
                            <div class="items-center hidden gap-1 md:flex">
                                <x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ Carbon\Carbon::parse($course->estimated_time)->format('H:i') }} minutes</span>
                            </div>
                        </div>
                        <x-dropdown>
                            <x-slot name="button">
                                <button>
                                    <x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400"/>
                                </button>
                            </x-slot>
                            <div>
                                <a href="{{ route('courses.show', $course->id) }}" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
                                    tabindex="-1" id="menu-item-0">
                                    <x-heroicon-s-play  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
                                    Play
                                </a>
                            </div>
                        </x-dropdown>
                    </div>
                </div>
                @endforeach	
            </div>
        </section>
    </div>
</div>


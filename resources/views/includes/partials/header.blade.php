<header class="bg-white px-6 py-4 md:px-16 md:py-8">
    <div class="flex items-center justify-between">
        <section>
            <livewire:search-result>
        </section>

        <section>

            <div class="flex items-center justify-end gap-6">


                <a href="{{ route('dashboard') }}" class="text-primary hidden text-sm md:block">
                    My Courses
                </a>

                <x-dropdown>
                    <x-slot name="button">
                        <button type="button" class="">
                            <x-heroicon-s-bell class="text-primary mt-1 h-5 w-5" />
                        </button>
                    </x-slot>
                    <div class="w-96 p-8">
                        <h3 class="text-primary font-bold">Notifications</h3>

                        <p class="mt-4 text-sm font-normal text-gray-600">You have no new notifications.</p>
                    </div>
                </x-dropdown>


                <x-dropdown>
                    <x-slot name="button">
                        <button type="button"
                            class="text-primary g-5 flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-indigo-200 text-xs transition duration-200 ease-in-out hover:bg-indigo-300">
                            <img src="{!! auth()->user()->profile_photo_url !!}" class="rounded-full">
                        </button>
                    </x-slot>
                    <div class="w-64">
                        <section>

                            <!-- Profile -->
                            <x-dropdown-link href="{{ route('profile.show') }}" class="flex items-center">
                                <x-heroicon-s-user class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                        </section>
                        <section>
                            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                <!-- Profile -->
                                <x-dropdown-link href="{{ route('media.index') }}" class="flex items-center">
                                    <x-heroicon-s-video-camera class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                                    {{ __('Media Library') }}
                                </x-dropdown-link>
                            @endif

                        </section>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-primary group flex w-full items-center px-4 py-2 text-sm hover:bg-gray-200">
                                <x-heroicon-s-logout class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" />
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </x-dropdown>

            </div>
        </section>
    </div>
</header>

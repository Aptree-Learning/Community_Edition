<div x-data="{
        isMobile: false,
        expand: false,
        grow(){
            if(!this.isMobile){
                this.expand = true;
            }
        },
        shrink(){
            this.expand = false;
        },
        checkMobileScreen(){
            this.isMobile = window.innerWidth <= 1024;
        }
     }"
    x-on:mouseenter="grow()"
    x-on:mouseleave="shrink()"
    x-init="checkMobileScreen()"
    x-on:resize.window="checkMobileScreen()"
    :class="expand ? 'w-64' : 'w-14'"
    class="block sticky min-h-screen transition-all duration-300 ease-in-out bg-white border-r md:overflow-hidden ">
    <div class="flex flex-col flex-grow min-h-screen py-5 overflow-y-auto">
        <div class="flex justify-start pl-3">
            <div class="flex items-center bg-transparent rounded-md">
                <button x-on:click="$store.sidebarExpanded.toggle()" type="button">
                    <img class="flex-shrink-0 w-auto h-8" src="{{ site_logo() }}" alt="{{ settings('name') }}">
                </button>
            </div>
        </div>

        <nav class="flex flex-col flex-1 mt-5 overflow-y-auto divide-y divide-gray-300" aria-label="Sidebar">
            <div class="flex-1 space-y-1">

                <x-sidebar-item label="Dashboard" link="{{ url('dashboard') }}?force=true" :active="request()->is('dashboard*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-home class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Grades" link="{{ route('reports.individual') }}" :active="request()->is('reports/individual') ">
                    <x-slot name="icon">
                        <svg class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                            <path d="M219.03 0v464.314h-56.515c-31.196 0-56.515 25.299-56.515 56.47 0 31.172 25.319 56.47 56.515 56.47h56.514v338.824h-56.514c-31.196 0-56.515 25.3-56.515 56.471 0 31.172 25.319 56.47 56.515 56.47h56.514v338.824h-56.514c-31.196 0-56.515 25.299-56.515 56.47 0 31.172 25.319 56.471 56.515 56.471h56.514V1920h1582.412V0H219.03Zm960.578 338.824v112.94H671.373v677.648h677.647V734.118h112.94v508.235H558.432v-903.53h621.177Zm207.326 75.817 79.85 79.85-432.452 432.451-224.866-224.979 79.85-79.85 145.016 145.13 352.602-352.602Z" fill-rule="evenodd"/>
                        </svg>
                    </x-slot>
                </x-sidebar-item>
                
            </div>

            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
            <div class="flex-1 space-y-1 pt-6">
                <x-sidebar-item label="Overview" link="{{ route('overview') }}" :active="request()->is('overview*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-document-text class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Course Library" link="{{ route('courses.index') }}" :active="request()->is('courses*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-academic-cap class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Pathways" link="{{ route('pathway.index') }}" :active="request()->is('pathway*') ">
                    <x-slot name="icon">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zM6 12a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V12zm2.25 0a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM6 15a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V15zm2.25 0a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zM6 18a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V18zm2.25 0a.75.75 0 01.75-.75h3.75a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                          </svg>

                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="{{ Str::plural(settings('team')) }}" link="{{ route('teams.index') }}" :active="request()->is('my-teams*') ">
                    <x-slot name="icon">
                        <x-heroicon-s-user-group class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

                <x-sidebar-item label="Reports" link="{{ route('reports.index') }}" :active="request()->is('reports*') && (!request()->is('reports/individual') || (request()->is('reports/individual') && Route::input('id'))) ">
                    <x-slot name="icon">
                        <x-heroicon-s-book-open class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                    </x-slot>
                </x-sidebar-item>

            </div>
            @endif


            <div class="flex flex-shrink-0 pt-6 pb-5 mt-6">
                <div class="flex-shrink-0 w-full space-y-1">

                    @if (auth()->user()->hasRole('admin'))
                        <x-sidebar-item label="Settings" link="{{ route('settings') }}" :active="request()->is('settings*') ">
                            <x-slot name="icon">
                                <x-heroicon-s-cog class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                            </x-slot>
                        </x-sidebar-item>

                        
                        <x-sidebar-item label="Users" link="{{ route('users.index') }}" :active="request()->is('users*') ">
                            <x-slot name="icon">
                                <x-heroicon-s-users class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                            </x-slot>
                        </x-sidebar-item>

                        {{-- <x-sidebar-item label="Media Library" link="{{ route('media.index') }}" :active="request()->is('media*') ">
                            <x-slot name="icon">
                                <x-heroicon-s-video-camera class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                            </x-slot>
                        </x-sidebar-item> --}}


                    @endif

                    @if (null)
                        <a href="{{ route('invitations.index') }}"
                            class="flex items-center px-2 py-2 text-sm text-gray-500 rounded-md group hover:bg-gray-100">
                            <svg class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                            </svg>

                            <span class="hidden md:block" x-show="expand" x-transition>Invitations </span>

                            <span
                                class="flex items-center justify-center w-5 h-5 ml-4 text-xs text-white bg-red-500 rounded-full">2</span>
                        </a>
                    @endif

                    <x-sidebar-item label="Support" link="https://aptreelearning.com" :active="request()->is('support*') ">
                        <x-slot name="icon">
                            <x-heroicon-s-chat-alt-2 class="flex-shrink-0 w-6 h-6 ml-1 mr-4 text-gray-500"/>
                        </x-slot>
                    </x-sidebar-item>

                </div>
            </div>
        </nav>
    </div>
</div>

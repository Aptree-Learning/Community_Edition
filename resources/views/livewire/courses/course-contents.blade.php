<div class="bg-gray-100">
    <header class="flex justify-between px-4 py-6 bg-white lg:px-16">
        <h1 class="text-xl font-bold leading-7 lg:text-3xl text-primary sm:leading-9">Add New Course</h1>
    </header>
    
    <div class="px-4 lg:px-16">
    
        <x-modal-lg ref="module-create">
            <div class="pt-4">
                @livewire('courses.create-module', ['id' => $course->id])
            </div>
        </x-modal-lg>
    
    
        <x-modal-lg ref="module-edit">
            <div class="pt-4">
                @livewire('courses.edit-module')
            </div>
        </x-modal>
    
    
        <div class="py-8 bg-gray-100 text-primary">
            <nav class="flex items-center space-x-4" aria-label="Tabs">
                <a href="{{ route('courses.edit', $course->id) }}" class="flex items-center">
                    <span class=" px-0.5 py-0.5 text-sm font-normal rounded-sm bg-green-500/70">
                        <x-heroicon-s-check class="w-4 h-4 text-white"/>
                    </span>
                    <span class="ml-2 font-normal text-gray-500 hover:text-primary">Overview</span>
                </a>
    
                <div>
                    <span class="px-1.5 py-0.5 text-white rounded-md bg-darkgreen text-xs font-bold">2</span>
                    <span class="ml-2 font-semibold text-primary">Content</span>
                </div>
            </nav>


        <div x-data="{ module: @entangle('module_id'), width: window.innerWidth, isMobile: false }" 
            x-on:resize.window="width = window.innerWidth; isMobile = width <= 640"
            x-init="isMobile = width <= 640"
            class="mt-8">
            
            <div class="block md:hidden"
                :class="module ? 'visible' : 'invisible'">
                <button type="button"  x-on:click.prevent="module = null" class="inline-flex btn-primary" >
                    <x-heroicon-s-chevron-left class="w-5 h-5 mr-2 text-white"/>
                    Back
                </button>
            </div>

  

            <section class="mt-8">
                <div class="grid gap-6 md:grid-cols-5 lg:grid-cols-6">
                    <div x-show="!module || !isMobile" class="md:col-span-2 lg:col-span-2">
                        <div class="bg-white rounded-lg">
                            <!-- List of Modules -->
                            <div x-data="{ module_id: @entangle('module_id') }" class="relative z-20 px-6 py-6">

                                @if(count($modules))
                                <section class="relative">

                                    <div class="absolute border-r-2 border-gray-300 -z-1 top-5 bottom-5 left-1/2"></div>
                                    
                                    <div wire:sortable 
                                    wire:end.stop="reorderTable($event.target.sortable.toArray())" 
                                    class="relative space-y-5">
                                    @foreach($modules as $module)
                                    <div
                                        wire:sortable.item="{{ $module->id }}"
                                        wire:sortable.handle
                                        wire:key="lg-module-{{ $module->id  . '_' . time() }}"
                                        {{-- wire:click="selectModule({{ $module->id }})" --}}
                                        onclick="window.location.href = '{{ route('courses.contents', $course->id) }}?module_id={{ $module->id }}'"
                                        :class="module_id == {{ $module->id }} ? 'border-2 border-secondary bg-orange-50' : ''"
                                        class="px-2 py-2 bg-white border rounded-md cursor-pointer hover:bg-gray-50">
                                        <div 
                                            class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <x-heroicon-o-menu class="w-6 h-6 mr-2 text-gray-900" />
                                                <p>{{ $module->title }}</p>
                                            </div>
                                            <div>
                                                <button type="button"
                                                    wire:click.prevent.stop="editModule(`{{ $module->id }}`)"
                                                    aria-title="Edit Module">
                                                    <x-heroicon-o-pencil class="w-6 h-6 text-gray-500 hover:text-gray-900" />
                                                </button>
                                                <button type="button" 
                                                    x-data
                                                    x-on:click.prevent.stop="if(confirm('Confirm Delete?')){ $wire.deleteModule('{{ $module->id }}') }"
                                                    aria-title="Delete Module">
                                                    <x-heroicon-o-trash class="w-6 h-6 text-gray-500 hover:text-gray-900" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                </section>

                                <div class="flex flex-col mt-10 space-y-4">
                                    <button x-data x-on:click="$dispatch('openmodal-module-create')" 
                                    type="button" class="px-6 py-2 duration-300 ease-in-out bg-white border-2 rounded-md text-primary border-darkgreen hover:bg-darkgreen hover:text-white">
                                        <span>Add New Module</span>
                                    </button>
                                    <a href="{{ route('courses.show', $course->id) }}" class="block w-full text-center btn-primary">
                                        <span>Save & Exit</span>
                                    </a>
                                </div>
                                @else
                                <div class="bg-gray-100">
                                    <button x-data x-on:click="$dispatch('openmodal-module-create')" type="button"
                                        class="relative block w-full p-12 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                        </svg>
                                        <span class="block mt-2 text-sm font-medium text-gray-900">Add New Module</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div x-show="module || !isMobile" class="md:col-span-3 lg:col-span-4">

                        <!-- Select Module and it's Contents -->
                        @if ($module_id)
                            <div class="p-4 bg-white border rounded-md">
                                <header class="flex justify-between p-4">
                                    <h2 class="text-xl font-bold text-primary">{{ $selected_module->title }}</h2>
                                    <div class="flex items-center gap-3">

                                        <div class="px-3">
                                            <x-loading/> 
                                        </div>
                                        <button type="button" class="flex items-center text-xs btn-primary" wire:click="$refresh"><x-heroicon-s-refresh class="w-4 h-4 mr-2"/>  Refresh</button>
                                    </div>
                                </header>
                                <div wire:sortable 
                                     wire:end.stop="reorderModuleItems($event.target.sortable.toArray())"  
                                    class="p-4">
                                    @foreach($selected_module->items()->ordered()->get() as $card)
                                    <div 
                                        wire:sortable.item="{{ $card->id }}"
                                        wire:key="lg-card-{{ $card->id  . '_' . time() }}"
                                        class="px-4 py-2 mb-4 bg-white border-2 border-gray-300 rounded-md shadow-sm cursor-pointer">
                                        <div class="flex items-center justify-between gap-4">
                                            <div class="flex items-center col-span-3">
                                                <div wire:sortable.handle class="mr-2 text-gray-500 hover:text-primary">
                                                    <x-heroicon-o-menu class="w-6 h-6 mr-2 " />
                                                </div>
                                                <div>
                                                    <p class="text-orange-500">{{ $card->type->key }}</p>
                                                    <p>{{ $card->title }}</p>
                                                </div>
                                            </div>
                                           
                                            <div class="flex gap-2">
                                                <a href="{{ route('courses.module-preview', $card->id) }}"
                                                    target="_blank">
                                                    <x-heroicon-o-eye class="w-6 h-6 text-gray-600"/>
                                                </a>
                                                <button x-data
                                                    x-on:click="if(confirm('Continue delete?')){ $wire.deleteCard('{{ $card->id }}') }"
                                                    type="button" >
                                                    <x-heroicon-o-trash class="w-6 h-6 text-gray-600"/>
                                                </button>
                                                <button type="button" wire:click="editCard('{{ $card->id }}')">
                                                    <x-heroicon-o-pencil class="w-6 h-6 text-gray-600"/>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @include('livewire.courses.partials.add_card')
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-100">
                                <button type="button"
                                    class="relative block w-full p-12 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                    </svg>
                                    <span class="block mt-2 text-sm font-medium text-gray-900">Select Module First</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>

  
            
        </div>
    </div>
    
</div>
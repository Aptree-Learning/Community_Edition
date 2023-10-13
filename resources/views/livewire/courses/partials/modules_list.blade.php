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
                wire:key="{{ $key }}-module-{{ $module->id  . '_' . time() }}"
                {{-- wire:click="selectModule({{ $module->id }})" --}}
                onclick="window.location.href = '{{ route('courses.contents', $course->id) }}?module_id={{ $module->id }}'"
                x-on:click="module = '{{ $module->title }}'"
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
                            wire:click="editModule(`{{ $module->id }}`)"
                            aria-title="Edit Module">
                            <x-heroicon-o-pencil class="w-6 h-6 text-gray-500 hover:text-gray-900" />
                        </button>
                        <button type="button" 
                            x-data
                            x-on:click="if(confirm('Confirm Delete?')){ $wire.deleteModule('{{ $module->id }}') }"
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
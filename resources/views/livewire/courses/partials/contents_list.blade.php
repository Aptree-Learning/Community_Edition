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
            wire:key="{{ $key }}-card-{{ $card->id  . '_' . time() }}"
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
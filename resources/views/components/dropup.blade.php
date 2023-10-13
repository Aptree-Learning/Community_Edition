<div>
    <div class="flex-shrink-0 block group">
        <div class="flex items-center">
            <div @click.away="open = false" class="relative"
                x-data="{ 
                        open: false,
                        hide(){
                            this.open = false;
                        },
                        show(){
                            this.open = true;
                        }
                    }">
                <div class="relative">
                    <div x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute bottom-0 right-0 z-30 mt-2 -mr-1 origin-top-right rounded-md shadow-lg">
                        {{ $slot }}
                    </div>
                </div>
                <div>
                    {{ $button }}
                </div>
            </div>

        </div>
    </div>
</div>
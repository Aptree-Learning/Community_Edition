<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    @php
        $icons = ['abacus', 'atom', 'backpack', 'blackboard', 'book', 'certificate', 'chat', 'education', 'exam', 'flask', 'glasses', 'graduation', 'homeschooling', 'homework', 'laptop', 'microscope', 'mobile', 'notebook', 'pen', 'school', 'search', 'study', 'teacher', 'telescope', 'tools'];
    @endphp
    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}').defer,
        isOpen: false,
        setState($state) {
            this.state = $state;
            this.isOpen = false;
        }
    }" x-on:click.away="isOpen = false" class="relative">
        <div class="relative h-10 rounded-md border border-gray-300 bg-white px-2 pt-2">
            <div class="flex justify-center">
                <div class="-ml-5">
                    @foreach ($icons as $index=>$icon)
                        <div wire:key="icon-{{ $index }}" x-show="state == '{{ $icon }}'">
                            @livewire('course-icons', ['icon' => $icon, 'class' => 'h-6 w-6 text-gray-600'], key('course-icon'.$index))
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="absolute right-2 top-2">
                <button type="button" class="rounded-md bg-gray-100 px-1" x-on:click="isOpen = !isOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="h-5 w-5 text-gray-500">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div x-cloak x-show="isOpen"
            class="absolute left-0 right-0 z-10 h-60 w-64 rounded-md border border-gray-300 bg-white shadow-sm">
            <div class="grid grid-cols-5 gap-6 p-3">
                @foreach ($icons as $index => $icon)
                    <button wire:key="iconf-{{ $index }}" type="button" x-on:click="setState('{{ $icon }}')">
                        @livewire('course-icons', ['icon' => $icon, 'class' => 'w-6 h-6 text-gray-500 hover:text-primary'], key('course-iconf'.$index))
                    </button>
                @endforeach
                {{-- <button type="button" x-on:click="setState('education')">
                    <x-heroicon-s-academic-cap class="hover:text-primary h-6 w-6 text-gray-500" />
                </button> --}}
            </div>
        </div>
    </div>
</x-dynamic-component>

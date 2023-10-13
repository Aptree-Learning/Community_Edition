<div x-data="{showSearchResult: @entangle('showResult')}">

    <div x-on:click.away="showSearchResult = false">

        <div class="relative hidden md:w-96 md:block">
            <input type="search" wire:model.debounce.2000ms="search"
                class="pl-4 border-gray-300 rounded-md w-96" placeholder="Search">
        </div>
        <x-heroicon-s-search class="w-5 h-5 text-gray-500 md:hidden"/>

        <div x-show="showSearchResult" class="relative">
            <ul x-cloak class=" origin-top-right absolute left-0 mt-0 -mr-1 w-full rounded-md shadow-lg overflow-hidden bg-white divide-y divide-gray-200 ring-1 ring-black ring-opacity-5 focus:outline-none sm:left-auto sm:right-0" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-0">
            <!--
                Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                Highlighted: "text-white bg-purple-500", Not Highlighted: "text-gray-900"
            -->
            @forelse ($this->records() as $result)
            <li class="flex items-center text-gray-900 cursor-default select-none relative p-4 text-sm" id="listbox-option-0" role="option">
                <svg class="h-6 w-6 flex-none text-gray-400"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                </svg>

                <div class="space-y-1">
                    <a href="{{ route('courses.show', [$result]) }}">
                        <span class="ml-3 truncate text-base">{{ $result->title }}</span>
                        <span class="ml-3 truncate text-xs text-gray-500">{{ $result->modules_count }} modules / {{ $result->category->name ?? 'Uncategorized' }}</span>
                    </a>
                </div>
            </li>
            @empty

            @endforelse


            <!-- More items... -->
            </ul>
        </div>

    </div>

</div>

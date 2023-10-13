<div class="bg-gray-100">
    <header class="flex justify-between px-16 py-6 bg-white">
        <h1 class="text-3xl font-bold leading-7 text-primary sm:leading-9">Add New Pathway</h1>
    </header>
    
    <div class="px-16">
    
        <div class="py-8 bg-gray-100 text-primary">
            <nav class="flex items-center space-x-4" aria-label="Tabs">
                <a href="{{ route('pathway.builder', ['id' => $pathway->id]) }}" class="flex items-center">
                    <span class=" px-0.5 py-0.5 text-sm font-normal rounded-sm bg-green-500/70">
                        <x-heroicon-s-check class="w-4 h-4 text-white"/>
                    </span>
                    <span class="ml-2 font-normal text-gray-500 hover:text-primary">Overview</span>
                </a>
    
                <div>
                    <span class="px-1.5 py-0.5 text-white rounded-md bg-darkgreen text-xs font-bold">2</span>
                    <span class="ml-2 font-semibold text-primary">Select  Courses</span>
                </div>
            </nav>
            <section class="mt-8">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th width="25%" scope="col"
                                    class="px-6 py-3.5 text-left text-sm font-normal text-gray-600">Course</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-normal text-gray-600">
                                    Title</th>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($this->courses as $course)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        <input type="checkbox" wire:model="assign_courses" value="{{ $course->id }}">
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-gray-900">{{ $course->title }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" wire:click="$set('confirmModal', true)" class="mt-3 btn-primary btn-sm">
                        Save
                    </button>
                </div>

                <x-confirmation-modal wire:model="confirmModal">
                    <x-slot name="title">
                        {{ __('Assign Course') }}
                    </x-slot>
            
                    <x-slot name="content">
                        {{ __('Are you sure you would like to assign selected courses?') }}
                    </x-slot>
            
                    <x-slot name="footer">
                        <x-secondary-button wire:click="$toggle('confirmModal')" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-secondary-button>
            
                        <x-danger-button class="ml-3" wire:click="assignCourse" wire:loading.attr="disabled">
                            {{ __('OK') }}
                        </x-danger-button>
                    </x-slot>
                </x-confirmation-modal>
            </section>
        </div>
    </div>
    
</div>
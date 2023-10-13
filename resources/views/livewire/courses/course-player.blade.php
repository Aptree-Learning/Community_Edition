<div class="min-h-screen py-4 bg-gray-100 h-100">

    <button type="button" 
        wire:click="$set('exitFlag', true)"        
        class="fixed z-50 p-2 text-gray-900 duration-300 ease-in-out bg-gray-300 rounded-full top-3 right-10 hover:bg-red-500 hover:text-white">
        <x-heroicon-s-x class="w-4 h-4 "/>
    </button>

    <div class="px-8 pb-32 mx-auto max-w-7xl">
        <section class="flex mt-8 divide-x-2 lg:mt-10 justify-evenly">
            <div class="w-full h-2 bg-orange-400 rounded-l-md "></div>
            @foreach($contents as $index => $contentItem)
                @if($start)
                    @if($content_index >= $index)
                    <div class="w-full h-2 bg-orange-400"></div>
                    @else
                    <div class="w-full h-2 bg-gray-300"></div>
                    @endif
                @else
                <div class="w-full h-2 bg-gray-300"></div>
                @endif
            @endforeach

            @if($end)
            <div class="w-full h-2 bg-orange-400 rounded-r-md"></div>
            @else
            <div class="w-full h-2 bg-gray-300 rounded-r-md"></div>
            @endif
        </section>
        @if($end)
        <div class="max-w-sm mx-auto mt-24">
            <section class="flex flex-col items-center justify-center">
                <div>
                    <x-heroicon-s-puzzle class="w-16 h-16 text-gray-300"/>
                </div>
                <p class="mt-4 font-bold text-orange-500">{{ $course->title }}</p>
    
                <h1 class="mt-4 text-3xl font-bold text-primary">{{ $module->title }}</h1>
                <p class="px-2 mt-4 text-sm text-center">
                    Congrats! You have completed the module.
                </p>

                <div class="w-full p-6 px-12 mt-8 bg-white border rounded-md">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center">
                            <x-heroicon-s-check-circle class="w-4 h-4 mr-1 text-green-700"/>
                            <span class="text-sm">Completed</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $items_completed }} Exercises</p>
                        <div class="flex items-center">
                            <x-heroicon-s-x-circle class="w-4 h-4 mr-1 text-red-700"/>
                            <span class="text-sm">Missed</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $items_missed }} Answers</p>
                    </div>
                </div>
            </section>
        </div>
        @else
            @if($episode)
            <div class="mt-16">
                <div>
                    @if ($content['type'] == \App\Enums\ModuleItemType::Content)
                        <section class="max-w-4xl px-4 mx-auto">
                            @if ($content['layout'] == \App\Enums\ContentLayout::LeftImageRightText)
                                <div class="grid items-center grid-cols-2 gap-6">
                                    <div>{!! $content['content'] !!}</div>
                                    <div class="p-4 bg-gray-300 rounded-lg shadow-sm border-md">
                                        <img src="{{ $content['image_url'] }}" class="h-auto w-96" alt="">
                                        @if ($content['image_author'])
                                            {!! $content['image_author'] !!}
                                        @endif
                                    </div>
                                </div>
                            @elseif($content['layout'] == \App\Enums\ContentLayout::LeftTextRightImage)
                                <div class="grid items-center grid-cols-2 gap-6">
                                    <div>{!! $content['content'] !!}</div>
                                    <div class="p-4 bg-gray-300 rounded-lg shadow-sm border-md">
                                        <img src="{{ $content['image_url'] }}" class="h-auto w-96" alt="">
                                        @if ($content['image_author'])
                                            {!! $content['image_author'] !!}
                                        @endif
                                    </div>
                                </div>
                            @elseif($content['layout'] == \App\Enums\ContentLayout::TextOnly)
                                <div class="flex justify-center">
                                    <div>{!! $content['content'] !!}</div>
                                </div>
                            @elseif($content['layout'] == \App\Enums\ContentLayout::ImageOnly)
                                <div class="flex justify-center">
                                    <div class="p-4 bg-gray-300 rounded-lg shadow-sm border-md">
                                        <img src="{{ $content['image_url'] }}" class="h-auto w-96" alt="">
                                        @if ($content['image_author'])
                                            {!! $content['image_author'] !!}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </section>
                    @elseif($content['type'] == \App\Enums\ModuleItemType::Video)
                        <section class="max-w-4xl px-4 mx-auto">
                            <div class="flex justify-center">
                                <iframe src="{{ $content['video_embed_url'] }}" height="400" width="700" title="Video Preview"
                                    allow="fullscreen"></iframe>
                            </div>
                            <div class="flex flex-col items-center justify-center mt-4">
                                <h2 class="text-lg font-bold">{{ $content['title'] }}</h2>
                                <div>{!! $content['content'] !!}</div>
                            </div>
                        </section>
                    @elseif($content['type'] == \App\Enums\ModuleItemType::Question)
                        <section class="max-w-3xl px-4 mx-auto">
                            <div class="items-center">
                                @if (!empty( $content['question']) )
                                <div>
                                    <h2 class="font-bold text-gray-900">{{ $content['question']['title'] }}</h2>
                                    <div class="mt-8 space-y-4">
                                        @foreach ($content['question']['random_answers'] as $option)
                                        <div> 
                                            @if ($selected_answer)
                                            <div class="space-y-4">
                                                @if ($selected_answer == $option['id'])
                                                    @if ($option['is_correct'])
                                                        <div class="flex justify-between w-full p-4 border border-gray-300 bg-emerald-100">
                                                            <p>{{ $option['answer'] }}</p>
                                                            <div>
                                                                <x-heroicon-s-check-circle
                                                                    class="w-6 h-6 text-primary" />
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="flex justify-between w-full p-4 bg-red-100 border border-gray-300">
                                                            <p>{{ $option['answer'] }}</p>
                                                            <div>
                                                                <x-heroicon-s-x-circle
                                                                    class="w-6 h-6 text-red-600" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if ($option['is_correct'])
                                                        <div class="flex justify-between w-full p-4 border border-gray-300 bg-emerald-100">
                                                            <p>{{ $option['answer'] }}</p>
                                                            <div>
                                                                <x-heroicon-s-check-circle
                                                                    class="w-6 h-6 text-primary" />
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="flex justify-between w-full p-4 bg-white border border-gray-300">
                                                            <p>{{ $option['answer'] }}</p>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                            @else
                                            <button type="button" wire:click="selectAnswer(`{{ $option['id'] }}`)"
                                                class="flex w-full p-4 text-left bg-white border border-gray-300">
                                                <p>{{ $option['answer'] }}</p>
                                            </button>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
        
                                <section class="col-span-2 mt-8">
                                    @if($selected_answer && $content['question']['display_explanation'])
                                    <div class="bg-white border border-gray-300 p-4 rounded">
                                        <div class="flex">
                                            <x-heroicon-s-light-bulb class="flex-shrink-0 text-yellow-500 w-7 h-7"/>
                                            <div class="pl-5">
                                                <h3 class="font-bold">Explanation</h3>
                                                <p class="mt-2">{{ $content['question']['explanation'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </section>
                                
                                @endif
                            </div>
                        </section>
                    @endif
                </div>
            </div>
            @else
            <div class="max-w-sm mx-auto mt-24">
                <section class="flex flex-col items-center justify-center">
                    <div>
                        <x-heroicon-s-puzzle class="w-16 h-16 text-gray-300"/>
                    </div>
                    <p class="mt-4 font-bold text-orange-500">{{ $course->title }}</p>
        
                    <h1 class="mt-4 text-3xl font-bold text-primary">{{ $module->title }}</h1>
        
                    <p class="px-2 mt-4 text-sm text-center">Remember to do your best with each question. Points are awarded for first time correct answers!</p>

                    <div class="w-full p-6 mt-8 bg-white border rounded-md">
                        <div class="grid grid-cols-2 divide-x">
                            <div class="flex items-center justify-end gap-1 pr-4">
                                <x-heroicon-o-template class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">{{ $module->items()->count() }} Exercises</span>
                            </div>
                            <div class="flex items-center gap-1 pl-4">
                                <x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
                                <span class="text-sm">3 minutes</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            @endif
        @endif
    </div>
    <footer class="fixed bottom-0 left-0 right-0 z-20 py-6 bg-white border-t">
        @if($end)
        <div class="max-w-4xl px-6 mx-auto">
            @if($next_module)
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-primary">{{ $module->title }}</h3>
                <div>
                    <button wire:click="nextModule" type="button" class="btn-primary">Proceed to Next Module</button>
                </div>
            </div>
            @else
            <div class="flex items-center justify-center">
                <div>
                    <button wire:click="close" type="button" class="btn-primary">Close</button>
                </div>
            </div>
            @endif
        </div>
        @else
        @if($episode)
            <div class="max-w-4xl px-6 mx-auto">
                @if($content['type'] == \App\Enums\ModuleItemType::Question )
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-primary">Question</h3>
                    <div>
                        @if($selected_answer)
                        <button wire:click="submitNext" type="button" class="btn-primary">Next</button>
                        @endif
                    </div>
                </div>
                @else
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-primary">{{ $module->title }}</h3>
                    <div>
                        <button wire:click="submitNext" type="button" class="btn-primary">Next</button>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="max-w-4xl px-6 mx-auto">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-primary">Course Overview</h3>
                    <div>
                        <button wire:click="start" type="button" class="btn-primary">Start</button>
                        @if($skippable)
                        <button type="button" wire:click="skipContinue" class="px-4 underline hover:text-primary">Pick where you left off?</button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        @endif
    </footer>
    <x-confirmation-modal wire:model="exitFlag">
        <x-slot name="title">
            {{ __('Are you sure you want to exit from this lesson?') }}
        </x-slot>

        <x-slot name="content">
            {{ __('This will redirect you the course page.') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('exitFlag', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="exit()" wire:loading.attr="disabled">
                {{ __('Yes') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
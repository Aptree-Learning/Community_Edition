@push('head-scripts')
    <script src="https://unpkg.com/@api.video/player-sdk" defer></script>
@endpush

<div class="min-h-screen py-4 bg-gray-200 h-100">
    <div class="px-8 mx-auto max-w-7xl">
        <div class="p-2 text-white bg-red-500 border rounded-md">
            <h4 class="text-center">Preview Mode</h4>
        </div>

        <div class="mt-8">
            @if ($module->type->value == \App\Enums\ModuleItemType::Content)
                <section class="max-w-4xl px-4 mx-auto">
                    @if ($module->layout == \App\Enums\ContentLayout::LeftImageRightText)
                        <div class="grid items-center grid-cols-2 gap-6">
                            <div>{!! $module->content !!}</div>
                            <div class="p-4 bg-gray-300 rounded-lg shadow-sm border-md">
                                <img src="{{ $module->getImage() }}" class="h-auto w-96" alt="">
                                @if ($module->image_author)
                                    {!! $module->image_author !!}
                                @endif
                            </div>
                        </div>
                    @elseif($module->layout == \App\Enums\ContentLayout::LeftTextRightImage)
                        <div class="grid items-center grid-cols-2 gap-6">
                            <div>{!! $module->content !!}</div>
                            <div class="p-4 bg-gray-300 rounded-lg shadow-sm border-md">
                                <img src="{{ $module->getImage() }}" class="h-auto w-96" alt="">
                                @if ($module->image_author)
                                    {!! $module->image_author !!}
                                @endif
                            </div>
                        </div>
                    @elseif($module->layout == \App\Enums\ContentLayout::TextOnly)
                        <div class="flex justify-center">
                            <div>{!! $module->content !!}</div>
                        </div>
                    @elseif($module->layout == \App\Enums\ContentLayout::ImageOnly)
                        <div class="flex justify-center">
                            <div class="p-4 bg-gray-300 rounded-lg shadow-sm border-md">
                                <img src="{{ $module->getImage() }}" class="h-auto w-96" alt="">
                                @if ($module->image_author)
                                    {!! $module->image_author !!}
                                @endif
                            </div>
                        </div>
                    @endif
                </section>
            @elseif($module->type->value == \App\Enums\ModuleItemType::Video)
                <section class="max-w-4xl px-4 mx-auto">
                    <div class="flex justify-center">
                        <iframe src="{{ $module->video_embed_url }}" height="400" width="700" title="Video Preview"
                            allow="fullscreen"></iframe>
                    </div>
                    <div class="flex flex-col items-center justify-center mt-4">
                        <h2 class="text-lg font-bold">{{ $module->title }}</h2>
                        <div>{!! $module->content !!}</div>
                    </div>
                </section>
            @elseif($module->type->value == \App\Enums\ModuleItemType::Question)
                <section class="max-w-3xl px-4 mx-auto">
                    <div class="items-center gap-8">
                        @if ($module->question)
                        <div>
                            <h2 class="font-bold text-gray-900">{{ $module->question->title }}</h2>
                            <div class="mt-8 space-y-4">
                                @foreach ($answers as $option)
                                <div> 
                                    @if ($selected_answer)
                                    <div class="space-y-4">
                                        @if ($selected_answer == $option->id)
                                            @if ($option->is_correct)
                                                <div class="flex justify-between w-full p-4 border border-gray-300 bg-emerald-100">
                                                    <p>{{ $option->answer }}</p>
                                                    <div>
                                                        <x-heroicon-s-check-circle
                                                            class="w-6 h-6 text-primary" />
                                                    </div>
                                                </div>
                                                @else
                                                <div class="flex justify-between w-full p-4 bg-red-100 border border-gray-300">
                                                    <p>{{ $option->answer }}</p>
                                                    <div>
                                                        <x-heroicon-s-x-circle
                                                            class="w-6 h-6 text-red-600" />
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            @if ($option->is_correct)
                                                <div class="flex justify-between w-full p-4 border border-gray-300 bg-emerald-100">
                                                    <p>{{ $option->answer }}</p>
                                                    <div>
                                                        <x-heroicon-s-check-circle
                                                            class="w-6 h-6 text-primary" />
                                                    </div>
                                                </div>
                                                @else
                                                <div class="flex justify-between w-full p-4 bg-white border border-gray-300">
                                                    <p>{{ $option->answer }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    @else
                                    <button type="button" wire:click="selectAnswer(`{{ $option->id }}`)"
                                        class="flex justify-between w-full p-4 bg-white border border-gray-300">
                                        <p>{{ $option->answer }}</p>
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <section class="col-span-2">
                            @if($selected_answer && $module->question->display_explanation)
                            <div class="p-4 border-4 border-gray-300 border-dashed rounded-md ">
                                <div class="flex">
                                    <x-heroicon-s-light-bulb class="text-yellow-500 w-7 h-7"/>
                                    <div class="pl-5">
                                        <h3 class="font-bold">Explanation</h3>
                                        <p class="mt-2">{{ $module->question?->explanation }}</p>
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
</div>

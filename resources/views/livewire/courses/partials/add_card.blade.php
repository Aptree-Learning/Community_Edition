<div class="p-2 px-3 border-2 rounded-md border-emerald-700">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <x-heroicon-s-plus class="w-5 h-5" />
            <p class="text-sm">Add a New Card</p>
        </div>
        <div class="flex gap-1">

            <!-- Modals -->
            <x-modal-xl ref="content" backdrop="true">
                <x-slot name="title">
                    Content Editor
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.content-editor')
                </div>
            </x-modal-xl>
            <x-modal ref="upload">
                <x-slot name="title">
                    Upload Document
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.upload-document', ['moduleId' => $module_id])
                </div>
            </x-modal>

            <x-modal-xl ref="video">
                <x-slot name="title">
                    Add Video
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.video-editor', ['moduleId' => $module_id])
                </div>
            </x-modal-xl>

            <x-modal-xl ref="record">
                <x-slot name="title">
                    Record Video
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.video-recorder', ['moduleId' => $module_id])
                </div>
            </x-modal-xl>

            <x-modal-xl ref="question">
                <x-slot name="title">
                    Questions and Answers
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.question-editor', ['moduleId' => $module_id])
                </div>
            </x-modal-xl>

            <x-modal-lg ref="aiquestion">
                <x-slot name="title">
                    AI Question
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.ai-question-generator', ['moduleId' => $module_id])
                </div>
            </x-modal-lg>

            <x-modal-xl ref="unsplash">
                <x-slot name="title">
                    Search for images
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.unsplash')
                </div>
            </x-modal-xl>

            <x-modal-xl ref="aigen">
                <x-slot name="title">
                    Generate with AI
                </x-slot>
                <div class="pt-4">
                    @livewire('courses.genai')
                </div>
            </x-modal-xl>
            
            <!-- Modals -->

            <x-dropup>
                <x-slot name="button">
                    <button @click="open = !open"
                        class="w-10 h-10 px-2 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                        <span class="font-bold group text-primary">A</span>
                    </button>
                </x-slot>
                <div class="relative px-3 py-3 bg-gray-300 rounded-md shadow-xs">
                    <div class="flex flex-col space-y-1">
                        <button type="button"
                            x-on:click="hide()"
                            wire:click="createContent('image-text')"
                            class="p-2 bg-white border rounded-md hover:bg-emerald-50">
                            <div class="flex">
                                <x-heroicon-s-photograph class="w-4 h-4" />
                                <x-heroicon-s-menu-alt-2 class="w-4 h-4" />
                            </div>
                        </button>
                        <button type="button"
                            x-on:click="hide()"
                            wire:click="createContent('text-image')"
                            class="p-2 bg-white border rounded-md hover:bg-emerald-50">
                            <div class="flex">
                                <x-heroicon-s-menu-alt-2 class="w-4 h-4" />
                                <x-heroicon-s-photograph class="w-4 h-4" />
                            </div>
                        </button>
                        <button type="button"
                            x-on:click="hide()"
                            wire:click="createContent('text')"
                            class="flex justify-center p-2 text-center bg-white border rounded-md hover:bg-emerald-50">
                            <div class="flex">
                                <x-heroicon-s-menu-alt-2 class="w-4 h-4" />
                            </div>
                        </button>
                        <button type="button"
                            x-on:click="hide()"
                            wire:click="createContent('image')"
                            class="flex justify-center p-2 text-center bg-white border rounded-md hover:bg-emerald-50">
                            <div class="flex">
                                <x-heroicon-s-photograph class="w-4 h-4" />
                            </div>
                        </button>
                    </div>
                </div>
            </x-dropup>

            <x-dropup>
                <x-slot name="button">
                    <button @click="open = !open"
                        class="w-10 h-10 px-2 py-2 bg-gray-200 rounded-md text-primary hover:bg-gray-300">
                        <x-heroicon-s-video-camera />
                    </button>
                </x-slot>
                <div class="relative w-32 px-3 py-3 bg-gray-300 rounded-md shadow-xs">
                    <div class="flex flex-col space-y-1">
                        <button type="button"
                            x-on:click="$dispatch('openmodal-video'); hide()"
                            class="p-2 text-sm bg-white border rounded-md hover:bg-emerald-50">
                            <span>Add Video</span>
                        </button>
                        <button type="button"
                            x-on:click="$dispatch('openmodal-record'); hide()"
                            class="p-2 text-sm bg-white border rounded-md hover:bg-emerald-50">
                            <span>Record a Video</span>
                        </button>
                    </div>
                </div>

            </x-dropup>

            <x-dropup>
                <x-slot name="button">
                    <button @click="open = !open"
                        class="w-10 h-10 px-2 py-2 bg-gray-200 rounded-md text-primary hover:bg-gray-300">
                        <x-heroicon-o-document-text />
                    </button>
                </x-slot>
                <div class="relative w-32 px-3 py-3 bg-gray-300 rounded-md shadow-xs">
                    <div class="flex flex-col space-y-1">
                        <button type="button"
                            x-on:click="$dispatch('openmodal-upload')"
                            class="p-2 text-sm bg-white border rounded-md hover:bg-emerald-50">
                            <span>Upload</span>
                        </button>
                    </div>
                </div>
            </x-dropup>

            <x-dropup>
                <x-slot name="button">
                    <button @click="open = !open"
                        class="w-10 h-10 px-2 py-2 bg-gray-200 rounded-md text-primary hover:bg-gray-300">
                        <x-heroicon-s-question-mark-circle />
                    </button>
                </x-slot>
                <div class="relative w-32 px-3 py-3 bg-gray-300 rounded-md shadow-xs">
                    <div class="flex flex-col space-y-1">
                        <button type="button"
                            x-on:click="hide()"
                            wire:click="createQuestion(`{{ \App\Enums\QuestionType::MultipleChoice }}`)"
                            class="p-2 text-xs bg-white border rounded-md hover:bg-emerald-50">
                            <span>Multiple Choice</span>
                        </button>
                        <button type="button"
                            x-on:click="hide()"
                            wire:click="createAiQuestion"
                            class="p-2 text-xs bg-white border rounded-md hover:bg-emerald-50">
                            <span>AI Question Generator</span>
                        </button>
                        <button type="button"
                            wire:click="createQuestion(`{{ \App\Enums\QuestionType::TrueFalse }}`)"
                            class="p-2 text-xs bg-white border rounded-md hover:bg-emerald-50">
                            <span>Yes / No</span>
                        </button>
                        {{-- <button type="button"
                            wire:click="createQuestion(`{{ \App\Enums\QuestionType::LikertScale }}`)"
                            class="p-2 text-xs bg-white border rounded-md hover:bg-emerald-50">
                            <span>Likert Scale</span>
                        </button> --}}
                    </div>
                </div>
            </x-dropup>
        </div>
    </div>
</div>
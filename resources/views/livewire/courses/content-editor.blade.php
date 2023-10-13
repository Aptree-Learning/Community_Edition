<form action="" wire:submit.prevent="submit">
    <style>
        trix-editor {
            overflow: auto
        }
    </style>
    {{ $this->form }}
    @unless ($layout == \App\Enums\ContentLayout::TextOnly)
    <button type="button" wire:click="showUnsplashModal" class="mb-2 w-1/4 btn-primary btn-sm mt-3 break-all @if ($unsplash) !p-0 @endif">
        @if ($unsplash) <img class="object-cover" src="{{ $unsplash }}" />
        {!! $unsplashName !!}
        @else +unsplash
        @endif
    </button>
    @endif
    @unless ($layout == \App\Enums\ContentLayout::ImageOnly)
    <button type="button" wire:click="showAiGenModal" class="mb-2 w-1/4 btn-primary btn-sm mt-3 break-all">
        Generate with AI
    </button>
    @endif
    <div class="flex items-center justify-between pt-4 mt-8 border-t">
        <p class="text-xl font-bold text-primary">Add Content</p>
        <div class="flex gap-2">
            <button type="button" class="btn-light" x-on:click="$dispatch('closeparentmodal')">Cancel</button>
            <button type="submit" class="btn-primary btn-sm">Save</button>
        </div>
    </div>

    <x-confirmation-modal wire:model="confirmRemoveUnsplash">
        <x-slot name="title">
            {{ __('Remove Unsplash') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove unsplash image?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmRemoveUnsplash')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="removeUnsplash" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

</form>
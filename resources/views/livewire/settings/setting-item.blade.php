<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-6 gap-6 settings-page">
            <div class="col-span-2">
                <h3 class="font-bold text-primary">{{ formatString($setting->key) }}</h3>
                <div class="text-sm text-primary">{!! $setting->description !!}</div>
            </div>
            <div class="col-span-3">
                {{ $this->form }}
            </div>
            <div class="self-center">
                <button type="submit" class="btn-primary btn-sm">Save</button>
            </div>
        </div>
    </form>

    <x-confirmation-modal wire:model="saveFlag">
        <x-slot name="title">
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to update this settings?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('saveFlag', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="update()" wire:loading.attr="disabled">
                {{ __('Yes, Apply changes') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>

<form action="" wire:submit.prevent="submit">
    {{ $this->form }}

    <div class="py-4 pt-8 mt-12 border-t">
        <div class="flex justify-between">
            <h1 class="text-lg font-bold text-primary">Create Module</h1>
            <div>
                <div class="flex gap-3">
                    <button  type="button" class="btn-light" x-on:click="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
    </div>
    
</form>
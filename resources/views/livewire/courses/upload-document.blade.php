<form action="" wire:submit.prevent="submit">
    {{ $this->form }}

    <div class="flex items-center justify-between pt-4 mt-8 border-t">
        <p class="text-xl font-bold text-primary">Add File</p>
        <div class="flex gap-2">
            <button type="button" class="btn-default">Cancel</button>
            @if($action == \App\Enums\ActionType::Update)
            <button type="submit" class="btn-warning">Update</button>
            @else
            <button type="submit" class="btn-primary">Save</button>
            @endif
        </div>
    </div>
</form>
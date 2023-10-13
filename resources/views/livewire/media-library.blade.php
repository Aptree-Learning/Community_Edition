<div>
    <header class="flex justify-between bg-white px-8 py-4">
        <div class="mx-8">
            <div class="block">
                <button type="button" onclick="window.location.href = '{{ url()->previous() }}'"
                    class="btn-primary mb-6 flex items-center justify-center !py-2 !px-4">
                    <x-heroicon-s-arrow-left class="mr-2 h-5 w-5 text-white" />
                    Back
                </button>
            </div>
            <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">Media Library</h1>
            <p class="mb-8 py-2 text-primary opacity-70">
                Any videos you have uploaded or recorded will be stored here if you delete them from the course builder.
                If you wish to re-ember them in a course, copy and paste the link to embed it in your new course card.
            </p>
        </div>
    </header>

    <div>
        <div class="space-y-8 bg-gray-100 px-8 py-12">
            <div class="mx-8 mt-10 sm:mt-0">
                <div class="mt-10 sm:mt-5">
                    <div class="space-y-6">
                        {{ $this->table }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

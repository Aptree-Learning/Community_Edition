@section('header')
    <header class="flex justify-between px-8 py-6">
        <h1 class="text-3xl font-bold leading-7 text-primary sm:leading-9">Add New Course</h1>
    </header>
@endsection

<div>
    <div class="px-8 py-12 bg-gray-100">
        <nav class="flex items-center space-x-4" aria-label="Tabs">
            <div>
                <span class="px-1.5 py-0.5 text-white rounded-md bg-darkgreen text-sm font-bold">1</span>
                <span class="ml-2 font-semibold text-primary">Overview</span>
            </div>

            <div>
                <span class="px-1.5 py-0.5 text-primary rounded-sm bg-gray-300 text-sm font-normal">2</span>
                <span class="ml-2 font-normal text-gray-500">Content</span>
            </div>
        </nav>
        <section class="mt-8">
            <form action="" wire:submit.prevent="submit">
                {{ $this->form }}

                <div class="mt-8">
                    <button type="submit" class="btn-primary">Save & Continue</button>
                </div>
            </form>

            {{ $this->modal }}

        </section>
    </div>
</div>

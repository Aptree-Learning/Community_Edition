<div>
    <header class="flex justify-between bg-white px-8 py-4">
        <div class="mx-8">
            <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">Individual Reports</h1>
        </div>
    </header>

    <div class="px-4 lg:px-16">
        <nav class="flex space-x-4 py-4" aria-label="Tabs">
            <a href="{{ route('reports.index') }}" class="px-3 py-2 text-sm font-medium text-gray-500 rounded-md hover:text-primary">{{ Str::plural(settings('team')) }}</a>
            <a href="javascript: void()" class="px-3 py-2 text-sm font-medium  rounded-md bg-darkgreen/10 text-primary">Individuals</a>
        </nav>
    </div>

    <div class="bg-gray-100 px-4 py-12 lg:px-16">
        {{ $this->table }}
    </div>
</div>

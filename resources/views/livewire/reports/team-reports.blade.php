<div>
    <header class="flex justify-between bg-white px-8 py-4">
        <div class="mx-8">
            <div class="block">
                <button type="button" onclick="window.location.href = '{{ route('reports.index') }}'"
                    class="btn-primary mb-6 flex items-center justify-center !py-2 !px-4">
                    <x-heroicon-s-arrow-left class="mr-2 h-5 w-5 text-white" />
                    Back
                </button>
            </div>
            <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">{{ $team->name }}</h1>
        </div>
    </header>

    <div class="bg-gray-100 px-4 py-12 lg:px-16">
        <table class="bg-white w-full text-start divide-y table-auto">
            <thead>
                <tr class="bg-gray-500/5">
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Title</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Date Assigned</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Date Finished</span>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y whitespace-nowrap">
                @if (count($assignments))
                    @foreach($assignments as $eachAssignment)
                        @if (is_a($eachAssignment->assignmentable, \App\Models\Course::class))
                        <tr class="transition hover:bg-gray-50">
                            <td>
                                <a href="{{ route('reports.assignment', $eachAssignment->id) }}" class="block w-full text-start">
                                    <div class="px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                            <span>{{ $eachAssignment->assignmentable->title }}</span>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Course</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('reports.assignment', $eachAssignment->id) }}" class="block w-full text-start">
                                    <div class="px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                            <span>{{ $eachAssignment->created_at }}</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('reports.assignment', $eachAssignment->id) }}" class="block w-full text-start">
                                    <div class="px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                            <span>{{ $eachAssignment->completed_at ?: "Not yet" }}</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach

                    @foreach($assignments as $eachAssignment)
                        @if (is_a($eachAssignment->assignmentable, \App\Models\Pathway::class))
                        <tr class="transition hover:bg-gray-50">
                            <td>
                                <div>
                                    <a href="{{ route('reports.assignment', $eachAssignment->id) }}" class="block w-full text-start">
                                        <div class="px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                <span>{{ $eachAssignment->assignmentable->title }}</span>
                                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Pathway</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('reports.assignment', $eachAssignment->id) }}" class="block w-full text-start">
                                        <div class="px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                <span>{{ $eachAssignment->created_at }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('reports.assignment', $eachAssignment->id) }}" class="block w-full text-start">
                                    <div class="px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                            <span>{{ $eachAssignment->completed_at ?: "Not yet" }}</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                @else
                    <tr class="transition hover:bg-gray-50">
                        <td colspan="2">
                            <div class="px-4 py-3">No data found</div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

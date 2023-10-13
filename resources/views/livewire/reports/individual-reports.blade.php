<div>
    <header class="flex justify-between bg-white px-8 py-4">
        <div class="mx-8">
            <h1 class="text-primary my-2 text-4xl font-bold leading-7 sm:leading-9">{{ $user->name }} Grades</h1>
        </div>
    </header>

    <div class="bg-gray-100 px-4 py-6 lg:px-16">
        <h1 class="text-primary text-2xl py-4 font-bold leading-7 sm:leading-9 mb-5">Pathways</h1>
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
                            <span>Date Started</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Date Completed</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Grade</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Passing</span>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y whitespace-nowrap">
                @if ($pathways->count())
                    @foreach($pathways as $eachPathway)
                    <tr class="transition hover:bg-gray-50">
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachPathway->title }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachPathway->created_at ?: "Not yet" }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachPathway->completed_at ?: "Not yet" }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ isset($eachPathway->score) ? $eachPathway->score : "N/A" }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachPathway->passing ? "Yes" : "No" }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr class="transition hover:bg-gray-50">
                        <td colspan="5">
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>You are not enrolled in any pathways</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <h1 class="text-primary text-2xl py-4 font-bold leading-7 sm:leading-9 my-5">Courses</h1>
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
                            <span>Date Started</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Date Completed</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Grades</span>
                        </button>
                    </th>
                    <th class="p-0">
                        <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 cursor-default">
                            <span>Pass</span>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y whitespace-nowrap">
                @if($courses->count())
                    @foreach($courses as $eachCourse)
                    <tr class="transition hover:bg-gray-50">
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachCourse->title }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ isset($enrollments[$eachCourse->id]) ? $enrollments[$eachCourse->id]['created_at'] : "Not yet"  }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachCourse['completed_at'] ?: "Not yet"  }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachCourse->score ?: "N/A"  }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>{{ $eachCourse->passing?"Yes" : "No" }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr class="transition hover:bg-gray-50">
                        <td colspan="5">
                            <div class="px-4 py-3">
                                <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                    <span>You are not enrolled in any courses</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

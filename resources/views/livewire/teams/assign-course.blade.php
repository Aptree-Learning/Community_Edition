<div x-data="{ tab: 'course' }" >
    <h4 class="text-lg font-bold text-primary">Assign Course</h4>

    <div class="mt-8">
        <div>
            <nav class="flex space-x-4" aria-label="Tabs">

                <a href="#" class="px-3 py-2 text-sm font-medium " :class="tab == 'course' ? 'rounded-md bg-darkgreen/10 text-primary' : 'text-gray-500 rounded-md hover:text-primary'"
                    aria-current="page" @click.prevent="tab='course';">Courses</a>

                <a href="#" @click.prevent="tab='pathway'" class="px-3 py-2 text-sm font-medium "
                    :class="tab == 'pathway' ? 'rounded-md bg-darkgreen/10 text-primary' : 'text-gray-500 rounded-md hover:text-primary'">Pathways</a>
            </nav>
        </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flow-root mt-8">
            <div class="-mx-4 -my-2 overflow-x-auto border rounded-md sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-300" x-show="tab=='course'">
                        <thead class="bg-gray-50">
                            <tr>
                                <th width="25%" scope="col"
                                    class="px-6 py-3.5 text-left text-sm font-normal text-gray-600">
                                    Course</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-normal text-gray-600">
                                    Name</th>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($courses as $course)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        <input type="checkbox" wire:model="assign_courses" value="{{ $course->id }}">
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-gray-900">{{ $course->title }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="min-w-full divide-y divide-gray-300" x-show="tab=='pathway'">
                        <thead class="bg-gray-50">
                            <tr>
                                <th width="25%" scope="col"
                                    class="px-6 py-3.5 text-left text-sm font-normal text-gray-600">
                                    {{ settings('team') }}</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-normal text-gray-600">
                                    Name</th>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pathways as $pathway)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                        <input type="checkbox" wire:model="assign_pathways" value="{{ $pathway->id }}">
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-gray-900">{{ $pathway->title }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-8">
        <button x-data type="button" class="btn-light" x-on:click="closeModal()">Cancel</button>
        <button type="button" x-on:click="tab=='course' ? $wire.assignCoursse() : $wire.assignPathway()" class="btn-primary btn-sm">
            Save
        </button>
    </div>


</div>

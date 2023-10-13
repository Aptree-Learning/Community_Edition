<div>
    <div class="px-16 py-12 bg-gray-100">

        <div class="mt-8">
			<div class="flex gap-5">
				<section class="w-3/4">
					<div class="grid h-full grid-cols-3 gap-6 p-8 bg-white border shadow-lg">
						<div class="col-span-2 pr-4 rounded-md ">
							<div class="inline-block p-4 bg-gray-100 rounded-md">
								<x-heroicon-s-template class="w-10 h-10 text-gray-600"/>
							</div>
			
							<h1 class="mt-8 text-3xl font-bold text-primary">{{ $pathway->title }}</h1>
							<div class="mt-4 font-light text-gray-600">{!! $pathway->description !!}</div>
							<div class="flex gap-6 mt-8">
								<div class="flex items-center gap-1">
									<x-heroicon-o-template class="w-4 h-4 text-gray-400"/>
									<span class="text-sm text-primary">{{ $pathway->courses()->count() }} courses</span>
								</div>
								<div class="flex items-center gap-1">
									<x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
									<span class="text-sm text-primary">{{ $pathway->estimated_time }} minutes</span>
								</div>
								@if($pathway->offer_certificate)
								<div class="flex items-center gap-1">
									<x-heroicon-o-clipboard-check class="w-4 h-4 text-gray-400"/>
									<span class="text-sm text-primary">Certificate of Completion</span>
								</div>
								@endif
							</div>
						</div>
					</div>
				</section>
				<section class="w-1/4">
					<div class="border rounded-lg bg-white mb-4 p-6 pl-10 flex flex-row">
						<div class="bg-primary-10 w-16 h-16 rounded-full flex justify-center items-center">
							<x-heroicon-s-academic-cap class="flex-shrink-0 w-6 h-6 text-gray-500"/>
						</div>
						<div class="flex flex-col justify-center ml-5">
							<span class="text-2xl font-extrabold text-gray-700">{{ $this->graph_students_enrolled }}</span>
							<span class="text-sm font-normal text-gray-700">Students Enrolled</span>
						</div>
					</div>
					<div class="border rounded-lg bg-white mb-4 p-6 pl-10 flex flex-row">
						<div class="bg-secondary-10 w-16 h-16 rounded-full flex justify-center items-center">
							<img src="{{ asset('img/vector.svg') }}" class="h-6 w-6" />
						</div>
						<div class="flex flex-col justify-center ml-5">
							<span class="text-2xl font-extrabold text-gray-700">{{ $graph_courses }}</span>
							<span class="text-sm font-normal text-gray-700">Courses</span>
						</div>
					</div>
					<div class="border rounded-lg bg-white p-6 pl-10 flex flex-row">
						<div class="bg-primary-10 w-16 h-16 rounded-full flex justify-center items-center">
							<img src="{{ asset('img/bag.svg') }}" class="h-6 w-6" />
						</div>
						<div class="flex flex-col justify-center ml-5">
							<span class="text-2xl font-extrabold text-gray-700">{{ $graph_completed }}</span>
							<span class="text-sm font-normal text-gray-700">Complete</span>
						</div>
					</div>
				</section>
			</div>

            <section class="mt-8">
				<div class="flex justify-between pb-6 border-b-2 border-gray-300">
					<h3 class="text-xl font-bold text-primary">Courses You Will Take</h3>
				</div>
				<div class="grid grid-cols-2 gap-6 mt-8 lg:grid-cols-3">
					@foreach($pathway->courses as $availableCourse)
					<div class="flex flex-col p-4 bg-white border rounded-md shadow-md">
						<div>
                            @livewire('course-icons', ['icon' => $availableCourse->icon, 'class' => 'w-10 h-10 text-gray-600'])
						</div>
						<p class="mt-1 text-secondary">Course</p>
						<h3 class="mt-2 text-lg font-bold">{{ $availableCourse->title }}</h3>
						<div class="text-gray-600">{{ Str::limit($availableCourse->description, 100) }}</div>
						<div class="flex items-end justify-between flex-grow w-full mt-4">
							<div class="flex gap-3">
								<div class="flex items-center gap-1">
									<x-heroicon-o-template class="flex-shrink-0 w-4 h-4 text-gray-400"/>
									<span class="text-sm">{{ $availableCourse->modules()->count() }} modules</span>
								</div>
								<div class="items-center hidden gap-1 md:flex">
									<x-heroicon-o-clock class="w-4 h-4 text-gray-400"/>
									<span class="text-sm">{{ $availableCourse->estimated_time }} minutes</span>
								</div>
							</div>
							<x-dropdown>
								<x-slot name="button">
									<button>
										<x-heroicon-s-dots-vertical class="w-4 h-4 text-gray-400"/>
									</button>
								</x-slot>
								<div>
									<a href="{{ route('courses.show', $availableCourse->id) }}" class="flex items-center px-4 py-2 text-sm text-primary group" role="menuitem"
										tabindex="-1" id="menu-item-0">
										<x-heroicon-s-play  class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500"/>
										Play
									</a>
								</div>
							</x-dropdown>
						</div>
					</div>
					@endforeach	
				</div>
			</section>
        </div>
        
    </div>
</div>

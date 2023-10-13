<div class="flex flex-row gap-5">
    <div class="w-3/4 bg-white pt-8 px-8 pb-3">
        <span class="text-2xl font-extrabold text-gray-700">Group</span>
        <div style="height: 400px; width: 100%;">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="w-1/4 px-8 pb-4">
        <div class="mb-4 flex flex-row rounded-lg border bg-white p-6 pl-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-10">
                <x-heroicon-s-academic-cap class="flex-shrink-0 w-6 h-6 text-gray-500"/>
            </div>
            <div class="ml-5 flex flex-col justify-center">
                <span class="text-2xl font-extrabold text-gray-700">{{ $students }}</span>
                <span class="text-sm font-normal text-gray-700">Students</span>
            </div>
        </div>
        <div class="border rounded-lg bg-white mb-4 p-6 pl-10 flex flex-row">
            <div class="bg-secondary-10 w-16 h-16 rounded-full flex justify-center items-center">
                <img src="{{ asset('img/vector.svg') }}" class="h-6 w-6" />
            </div>
            <div class="flex flex-col justify-center ml-5">
                <span class="text-2xl font-extrabold text-gray-700">{{ $courses }}</span>
                <span class="text-sm font-normal text-gray-700">Courses</span>
            </div>
        </div>
        <div class="mb-4 flex flex-row rounded-lg border bg-white p-6 pl-10">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-10">
                <img src="{{ asset('img/bag.svg') }}" class="h-6 w-6" />
            </div>
            <div class="ml-5 flex flex-col justify-center">
                <span class="text-2xl font-extrabold text-gray-700">{{ $pathways }}</span>
                <span class="text-sm font-normal text-gray-700">Learning Paths</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            const ctx = document.getElementById('myChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {{ Js::from($graph_login_labels) }},
                    datasets: [{
                        label: 'Active Students',
                        data: {{ Js::from($graph_logins) }},
                        fill: false,
                        borderColor: "{{ settings('text_primary') }}"
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
        });
    </script>
</div>
<div class="flex gap-4 items-center mb-4">
    <!-- Search and Actions -->
    <div class="flex items-center gap-4 mr-auto">
        <div class="relative">
            <i data-feather="search" class="absolute left-2 top-2 text-gray-500"></i>
            <input
                type="text"
                placeholder="Search"
                class="pl-10 pr-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
            />
        </div>
        <button class="p-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"><i data-feather="filter" class="mr-2"></i>Filters</button>
    </div>

    <button class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"><i data-feather="plus" class="mr-2"></i> Create</button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6 text-gray-600 dark:text-gray-300">
    <!-- Pie Chart -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800 relative">
        <h3 class="mb-2 text-md font-medium absolute left-5 bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 bottom-2">Overall Status</h3>
        <div>
            <canvas id="status-pie-chart" class="h-40"></canvas>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800 relative">
    <h3 class="mb-2 text-md font-medium absolute left-5 bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 bottom-2">Issues Per Assignee</h3>
        <div class="pb-12">
            <canvas id="assignee-bar-chart" class="h-40"></canvas>
        </div>
    </div>
    {{--
    <!-- Average Response Time -->
    <div class="p-4 bg-white dark:bg-gray-800">
        <h3 class="mb-2 text-sm font-medium">Average Response Time</h3>
        <p class="text-2xl font-bold text-gray-800">26.4 days</p>
    </div>
    --}}
    <!-- Total Overdue Items -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800">
        <h3 class="mb-2 text-lg font-medium">Total Overdue Snag List Items</h3>
        <p class="text-4xl font-bold">5</p>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse border dark:border-gray-800">
        <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
            <tr>
                <th class="px-4 py-2 font-light">#</th>
                <th class="px-4 py-2 font-light">Title</th>
                <th class="px-4 py-2 font-light">Status</th>
                <th class="px-4 py-2 font-light">Assignee Company</th>
                <th class="px-4 py-2 font-light">Priority</th>
                <th class="px-4 py-2 font-light">Date Notified</th>
                <th class="px-4 py-2 font-light">Date Resolved</th>
                <th class="px-4 py-2 font-light">Due Date</th>
                <th class="px-4 py-2 font-light">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach(range(0,3) as $k)
            <tr class="border-b dark:border-gray-800">
                <td class="px-4 py-2">1</td>
                <td class="px-4 py-2">Damaged plastered walls</td>
                <td class="px-4 py-2">Closed</td>
                <td class="px-4 py-2">Trunk Flooring</td>
                <td class="px-4 py-2">
                    <!-- High Priority -->
                    <div class="inline-flex items-center p-1 gap-1 bg-red-500/25 rounded-full">
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    </div>
                </td>
                <td class="px-4 py-2">16/10/2024</td>
                <td class="px-4 py-2">31/10/2024</td>
                <td class="px-4 py-2">15/11/2024</td>
                <td class="px-4 py-2 flex gap-4">
                    <button class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                        <i data-feather="file-text" class="w-5 h-5"></i>
                    </button>
                    <button class="text-gray-500 dark:text-gray-400 hover:text-gray-300">
                        <i data-feather="edit" class="w-5 h-5"></i>
                    </button>
                </td>
            </tr>
            <tr class="border-b dark:border-gray-800">
                <td class="px-4 py-2">2</td>
                <td class="px-4 py-2">Wall Finish Incorrect</td>
                <td class="px-4 py-2">Work Required</td>
                <td class="px-4 py-2">GMI - Granite & Marble</td>
                <td class="px-4 py-2">
                    <!-- Medium Priority -->
                    <div class="inline-flex items-center p-1 gap-1 bg-yellow-500/25 rounded-full">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    </div>
                </td>
                <td class="px-4 py-2">16/10/2024</td>
                <td class="px-4 py-2">-</td>
                <td class="px-4 py-2">31/10/2024</td>
                <td class="px-4 py-2 flex gap-4">
                    <button class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                        <i data-feather="file-text" class="w-5 h-5"></i>
                    </button>
                    <button class="text-gray-500 dark:text-gray-400 hover:text-gray-300">
                        <i data-feather="edit" class="w-5 h-5"></i>
                    </button>
                </td>
            </tr>
            <tr class="border-b dark:border-gray-800">
                <td class="px-4 py-2">3</td>
                <td class="px-4 py-2">Cleaning Before Final Handover</td>
                <td class="px-4 py-2">Work Not Accepted</td>
                <td class="px-4 py-2">J. Seamer & Son Limited</td>
                <td class="px-4 py-2">
                    <!-- Low Priority -->
                    <div class="inline-flex items-center p-1 gap-1 bg-gray-500/25 rounded-full">
                        <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                    </div>
                </td>
                <td class="px-4 py-2">31/10/2024</td>
                <td class="px-4 py-2">-</td>
                <td class="px-4 py-2">15/11/2024</td>
                <td class="px-4 py-2 flex gap-4">
                    <button class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                        <i data-feather="file-text" class="w-5 h-5"></i>
                    </button>
                    <button class="text-gray-500 dark:text-gray-400 hover:text-gray-300">
                        <i data-feather="edit" class="w-5 h-5"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function getLabelColor() {
        let isDarkMode = localStorage.getItem('theme') == 'dark' ? true : false;
        
        return isDarkMode ? '#ffffff' : '#000000'; // White for dark mode, Black for light mode
    }
    // Pie Chart
    const pieCtx = document.getElementById('status-pie-chart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Closed', 'Work Not Accepted', 'Work Required'],
            datasets: [
                {
                    data: [1, 1, 10],
                    backgroundColor: ['#7ade45', '#eab308', '#ff5a5a'],
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            borderWidth: 0,
            radius: '80%',
            plugins: {
                legend: {
                    labels: {
                        color: getLabelColor(), // Dynamically set legend label color
                    },
                },
            },
            
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('assignee-bar-chart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['GMI - Granite & Marble', 'J. Seamer & Son', 'Trunk Flooring'],
            datasets: [
                {
                    label: 'Overdue',
                    data: [6, 1, 3],
                    backgroundColor: '#ff5a5a', // Red
                },
                {
                    label: 'Open',
                    data: [4, 2, 5],
                    backgroundColor: '#eab308', // Orange
                },
                {
                    label: 'Closed',
                    data: [1, 3, 2],
                    backgroundColor: '#7ade45', // Green
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Disable aspect ratio for height control
            plugins: {
                legend: {
                    labels: {
                        color: getLabelColor(), // Dynamically set legend label color
                    },
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: getLabelColor(), // Dynamically set x-axis label color
                    },
                },
                y: {
                    ticks: {
                        color: getLabelColor(), // Dynamically set y-axis label color
                    },
                },
            },
        },
    });
</script>
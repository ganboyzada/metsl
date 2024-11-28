<div class="">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex gap-4 items-center">
            <!-- Date Interval Input -->
            <div class="relative">
                <label for="date-interval" class="sr-only">Date Interval</label>
                <input
                    type="date"
                    id="start-date" value="{{ date_format(\Carbon\Carbon::today(), 'd.m.Y') }}"
                    class="border-0 px-3 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
                />
                <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
                <input
                    type="date"
                    id="end-date" value="{{ date_format(\Carbon\Carbon::today(), 'd.m.Y') }}"
                    class="border-0 px-3 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
                />
            </div>

            <!-- Search Bar -->
            <div class="relative">
            <i data-feather="search" stroke-width=2 class="absolute left-2 top-2 text-gray-700 dark:text-gray-300"></i>
            <input
                type="text"
                placeholder="Search"
                class="pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
            />
            </div>
        </div>

        <!-- Plan Meeting Button -->
        <a href="{{ route('projects.meetings.create') }}"
            id="plan-meeting-button"
            class="inline-flex px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"
        >
            <i data-feather="video" class="mr-2"></i>
            Plan a Meeting
        </a>
    </div>

    <!-- Meetings Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th class="px-4 py-2 font-light">Title</th>
                    <th class="px-4 py-2 font-light">Number</th>
                    <th class="px-4 py-2 font-light">Planned Date</th>
                    <th class="px-4 py-2 font-light">Status</th>
                    <th class="px-4 py-2 font-light">Start Time</th>
                    <th class="px-4 py-2 font-light">Participants</th>
                    <th class="px-4 py-2 font-light">Overview</th>
                </tr>
            </thead>
            <tbody id="meetings-table">
                <!-- Example Row -->
                <tr class="border-b dark:border-gray-800">
                    <td class="px-4 py-2"><a href="{{ route('projects.meetings.view') }}">Weekly Review</a></td>
                    <td class="px-4 py-2">001</td>
                    <td class="px-4 py-2">2024-12-01</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-500 text-white">
                            <i data-feather="log-in" stroke-width=2 class="mr-1 w-4 h-4"></i>
                            ONGOING</span>
                    </td>
                    <td class="px-4 py-2">12:30 GMT+4</td>
                    <td class="px-4 py-2">John, Sarah</td>
                    <td class="px-4 py-2">Discussed project milestones and risks.</td>
                </tr>
                <tr class="border-b dark:border-gray-800">
                    <td class="px-4 py-2"><a href="{{ route('projects.meetings.view') }}">Weekly Review</a></td>
                    <td class="px-4 py-2">001</td>
                    <td class="px-4 py-2">2024-12-01</td>
                    <td class="px-4 py-2">
                        <span class="px-3 py-1 rounded-full text-xs bg-blue-500 text-white">PLANNED</span>
                    </td>
                    <td class="px-4 py-2">12:30 GMT+4</td>
                    <td class="px-4 py-2">John, Sarah</td>
                    <td class="px-4 py-2">Discussed project milestones and risks.</td>
                </tr>
                <tr class="border-b dark:border-gray-800">
                    <td class="px-4 py-2"><a href="{{ route('projects.meetings.view') }}">Weekly Review</a></td>
                    <td class="px-4 py-2">001</td>
                    <td class="px-4 py-2">2024-12-01</td>
                    <td class="px-4 py-2">
                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-500 text-black">MISSED</span>
                    </td>
                    <td class="px-4 py-2">12:30 GMT+4</td>
                    <td class="px-4 py-2">John, Sarah</td>
                    <td class="px-4 py-2">Discussed project milestones and risks.</td>
                </tr>
                @foreach(range(0, 5) as $k)
                <tr class="border-b dark:border-gray-800">
                    <td class="px-4 py-2"><a href="{{ route('projects.meetings.view') }}">Weekly Review</a></td>
                    <td class="px-4 py-2">001</td>
                    <td class="px-4 py-2">2024-12-01</td>
                    <td class="px-4 py-2">
                        <span class="inline-flex px-3 py-1 rounded-full text-xs bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-white"><i class="w-4 h-4" stroke-width=2 data-feather="check"></i></span>
                    </td>
                    <td class="px-4 py-2">12:30 GMT+4</td>
                    <td class="px-4 py-2">John, Sarah</td>
                    <td class="px-4 py-2">Discussed project milestones and risks.</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

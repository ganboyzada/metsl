<!-- Filter Section -->
<div class="flex items-center space-x-4 mt-4">
    <span class="text-gray-500 font-medium">Filter by:</span>
    <button class="px-4 py-2 border rounded-lg text-gray-600">Status</button>
    <button class="px-4 py-2 border rounded-lg text-gray-600">Type</button>
    <button class="px-4 py-2 border rounded-lg text-gray-600">Creation date</button>
    <button class="px-4 py-2 border rounded-lg text-gray-600">Assignee</button>
    <button class="px-4 py-2 border rounded-lg text-gray-600">Deadline</button>
</div>

<!-- Project List Section -->
<div class="mt-8 space-y-4">
    <!-- Project Card -->
    <div class="relative bg-gray-100 rounded-lg p-4 flex items-center">
        <div class="absolute top-[-10px] item-tags">
            <span class="bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-semibold">In progress</span>
            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Task</span>
        </div>
        <div class="flex items-center space-x-4">            
            <div class="text-gray-700">
                <p class="font-medium">Name: Site revision</p>
                <p class="text-sm">Creation date: 12.08.2024 | 15:36</p>
            </div>
        </div>
        <div class="flex flex-col items-center ml-auto mr-2">
            <div class="text-sm text-gray-600 mr-2">Assignees</div>
            <div class="flex">
                <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 ml-[-1rem] shadow rounded-full">
                <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 ml-[-1rem] shadow rounded-full">
            </div>
        </div>
        <div class="flex flex-col">
            <span class="text-sm text-gray-600">Deadline</span>
            <span>12.09.2024 | 19:00</span>
        </div>
    </div>
    
            
    <!-- Project Card -->
    <div class="relative bg-gray-100 rounded-lg p-4 flex items-center">
        <div class="absolute top-[-10px] item-tags">
            <span class="bg-green-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Done</span>
            <span class="bg-purple-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Meeting Minutes</span>
        </div>
        <div class="flex items-center space-x-4">            
            <div class="text-gray-700">
                <p class="font-medium">Name: Site revision</p>
                <p class="text-sm">Creation date: 12.08.2024 | 15:36</p>
            </div>
        </div>
        <div class="flex flex-col items-center ml-auto mr-2">
            <div class="text-sm text-gray-600 mr-2">Assignees</div>
            <div class="flex">
                <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 ml-[-1rem] shadow rounded-full">
                <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 ml-[-1rem] shadow rounded-full">
            </div>
        </div>
        <div class="flex flex-col">
            <span class="text-sm text-gray-600">Deadline</span>
            <span>12.09.2024 | 19:00</span>
        </div>
    </div>
</div>

<!-- Create New Button -->
<div class="flex justify-end mt-4">
    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Create new</button>
</div>
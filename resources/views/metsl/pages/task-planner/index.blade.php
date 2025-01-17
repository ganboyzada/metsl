<div class="flex h-screen">
    <!-- Sidebar for Task Groups -->
    <div class="w-1/6 bg-gray-100 dark:bg-gray-800 px-5 py-4 rounded-xl">
        <h2 class="text-lg font-semibold mb-4">Task Groups</h2>
        <ul id="group-list" class="space-y-4">
            <!-- Groups will be dynamically added -->
        </ul>
    </div>

    <!-- Timeline -->
    <div class="flex-1 overflow-x-auto">
        <!-- Timeline Header -->
        <div class="flex items-center justify-between mb-4 px-4">
            <div class="flex items-center space-x-3">
                <button id="prev-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-full ">
                    <i data-feather="arrow-left"></i>
                </button>
                <button id="next-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-full ">
                    <i data-feather="arrow-right"></i>
                </button>
                <span id="current-month" class="text-lg font-semibold text-gray-700 dark:text-gray-200"></span>
            </div>
            <div class="flex items-center space-x-3">
                <button id="add-task-btn" class="inline-flex gap-2 font-semibold py-2 px-4 bg-blue-200 text-blue-800 hover:bg-blue-500 hover:text-white dark:bg-blue-800 dark:hover:bg-blue-600 dark:text-blue-200 rounded-full">
                    <i data-feather="plus"></i> Add Task
                </button>   

                <button id="zoom-in-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-full">
                    <i data-feather="zoom-in"></i>
                </button>
                <button id="zoom-out-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-full">
                    <i data-feather="zoom-out"></i>
                </button>
            </div>
        </div>

        <!-- Days Header -->
        <div id="days-header" class="grid text-center border-b border-gray-300 dark:border-gray-700" style="grid-template-columns: repeat(var(--visible-days), 1fr);">
            <!-- Days will be dynamically added -->
        </div>

        <!-- Timeline Rows -->
        <div id="timeline-rows" class="relative">
            <!-- Rows and tasks will be dynamically added -->
        </div>
    </div>
</div>

<!-- Modal for Task Details -->
<div id="task-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-1/3">
        <h3 class="text-lg font-semibold mb-4">Task Details</h3>
        <div class="space-y-2">
            <p><strong>Title:</strong> <span id="task-title"></span></p>
            <p><strong>Description:</strong> <span id="task-description"></span></p>
            <p><strong>Assignees:</strong> <span id="task-assignees"></span></p>
            <p><strong>Start:</strong> <span id="task-start"></span></p>
            <p><strong>Deadline:</strong> <span id="task-end"></span></p>
        </div>
        <button id="close-modal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Close
        </button>
    </div>
</div>

<div id="add-task-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg p-6 w-1/3">
        <h3 class="text-lg font-semibold mb-4">Add New Task</h3>
        <form id="add-task-form" class="space-y-4">
            <div>
                <label for="task-subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                <input type="text" id="task-subject" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label for="task-explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Explanation</label>
                <textarea id="task-explanation" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 space-x-4">
                <div>
                    <label for="task-start-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                    <input type="date" id="task-start-date" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="task-deadline-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deadline Date</label>
                    <input type="date" id="task-deadline-date" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                <div class="flex space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="task-priority" value="high" class="form-radio text-red-500">
                        <span>High</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="task-priority" value="medium" class="form-radio text-yellow-500">
                        <span>Medium</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="task-priority" value="low" class="form-radio text-green-500">
                        <span>Low</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="task-attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment</label>
                <input type="file" id="task-attachment" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label for="task-assignees" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assignees</label>
                <select id="task-assignees" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white" multiple></select>
            </div>
            <div class="flex justify-end">
                <button type="button" id="cancel-add-task" class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-400">Cancel</button>
                <button type="submit" class="ml-3 px-4 py-2 bg-blue-500 text-white hover:bg-blue-600">Add Task</button>
            </div>
        </form>
    </div>
</div>


<script>
    const groups = [
        { id: 1, name: "Communications", color: "bg-pink-400" },
        { id: 2, name: "Marketing", color: "bg-yellow-400" },
        { id: 3, name: "Design", color: "bg-orange-400" },
        { id: 4, name: "Administrative", color: "bg-purple-400" },
    ];

    const tasks = [
        { id: 1, title: "Complete presentation", groupId: 1, start: 0, duration: 2, assignees: ["Alice"], priority: "high", attachments: true },
        { id: 2, title: "Marketing Analysis", groupId: 2, start: 1, duration: 3, assignees: ["Bob", "Charlie"], priority: "medium", attachments: false },
        { id: 3, title: "UI Design", groupId: 3, start: -2, duration: 4, assignees: ["David"], priority: "low", attachments: true },
    ];

    let currentDayOffset = 0;
    let visibleDays = 14; // Default number of visible days

    // Generate dynamic days based on offset
    function generateDays(offset) {
        const days = [];
        const today = new Date();
        today.setDate(today.getDate() + offset);

        for (let i = 0; i < visibleDays; i++) {
            const day = new Date(today);
            day.setDate(today.getDate() + i);
            days.push(day);
        }

        return days;
    }

    // Render Task Groups
    function renderGroups() {
        const groupElements = groups.map(
            (group) =>
                `<li class="flex items-center space-x-2">
                    <span class="w-6 h-6 ${group.color} block rounded-lg"></span>
                    <span>${group.name}</span>
                </li>`
        ).join('');
        $("#group-list").html(groupElements);
    }

    // Render Days Header
    function renderDays() {
        const days = generateDays(currentDayOffset);
        const dayElements = days.map(
            (day) =>
                `<div class="p-2 border-r border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 striped-background">
                    <div class="text-xs mb-2">${day.toLocaleDateString("en-US", { weekday: "short" })}</div><span class='border border-gray-300 rounded-full px-2 py-1'>${day.getDate()}</span>
                </div>`
        );
        $("#days-header")
            .css("grid-template-columns", `repeat(${visibleDays}, 1fr)`)
            .html(dayElements.join(""));

        // Update Current Month Display
        const firstDay = days[0];
        const monthName = firstDay.toLocaleDateString("en-US", { month: "long" });
        $("#current-month").text(monthName);
    }

    // Render Groups and Tasks
    function renderTimeline() {
        const rows = groups.map((group) => {
            const groupTasks = tasks.filter((task) => task.groupId === group.id);
            const taskElements = groupTasks.map(
                (task) =>
                    `<div 
                        class="absolute h-full ${group.color} text-white text-sm px-2 py-1"
                        style="left: ${((task.start - currentDayOffset) * (100 / visibleDays))}%; width: ${(task.duration * (100 / visibleDays))}%"
                        data-task-id="${task.id}">
                        <div class="flex justify-between items-center">
                            <span>${task.title}</span>
                            <input type="checkbox" class="w-4 h-4">
                        </div>
                        <div class="flex items-center ps-3 mt-2">
                          <div class="flex items-center me-auto">
                              ${task.assignees.map(name => `<img src="https://placehold.co/20" alt="${name}" class="w-6 h-6 rounded-full border-2 border-white -ml-2">`).join('')}
                          </div>
                          <div class="text-xs me-2 bg-gray-100 text-gray-800 rounded-full px-2 py-1">${task.duration} days left</div>
                          <div class="text-xs rounded-full px-2 py-1 font-bold bg-gray-100 ${task.priority === 'high' ? 'text-red-500' : task.priority === 'medium' ? 'text-yellow-500' : 'text-green-500'}">
                              ${task.priority}
                          </div>
                        </div>
                    </div>`
            );
            return `
                <div class="relative h-16 border-t border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 striped-background">
                    ${taskElements.join("")}
                </div>`;
        });
        $("#timeline-rows").html(rows.join(""));
    }

    // Scroll Navigation
    function scrollTimeline(direction) {
        currentDayOffset += direction;
        renderDays();
        renderTimeline();
    }

    // Zoom Functions
    function zoomTimeline(inOut) {
        if (inOut === 'in' && visibleDays > 3) {
            visibleDays -= 1;
        } else if (inOut === 'out' && visibleDays < 14) {
            visibleDays += 1;
        }
        renderDays();
        renderTimeline();
    }

    // Initialize
    $(document).ready(function () {
        renderGroups();
        renderDays();
        renderTimeline();

        // Scroll one day at a time
        $("#prev-btn").click(() => scrollTimeline(-1));
        $("#next-btn").click(() => scrollTimeline(1));

        // Zoom in/out
        $("#zoom-in-btn").click(() => zoomTimeline('in'));
        $("#zoom-out-btn").click(() => zoomTimeline('out'));

        // Open Task Modal
        $("#timeline-rows").on("click", "[data-task-id]", function () {
            const taskId = $(this).data("task-id");
            const task = tasks.find((t) => t.id === taskId);

            $("#task-title").text(task.title);
            $("#task-description").text("Description goes here...");
            $("#task-assignees").text(task.assignees.join(", "));
            $("#task-start").text(`Day ${task.start}`);
            $("#task-end").text(`Day ${task.start + task.duration}`);

            $("#task-modal").removeClass("hidden");
        });

        // Close Task Modal
        $("#close-modal").click(() => $("#task-modal").addClass("hidden"));

        $('#add-task-btn').click(function () {
            $('#add-task-modal').removeClass('hidden');
        });

        $('#cancel-add-task').click(function () {
            $('#add-task-modal').addClass('hidden');
        });

        $('#add-task-form').submit(function (e) {
            e.preventDefault();
            // Add form submission logic here
            $('#add-task-modal').addClass('hidden');
        });
    });
</script>

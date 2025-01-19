<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex flex-col lg:flex-row h-screen">
    <!-- Sidebar for Task Groups -->
    <div class="mb-4 lg:mb-0 lg:w-1/6 bg-gray-100 dark:bg-gray-800 px-5 py-4 rounded-xl">
        <div class="flex items-center pb-7">
            <h2 class="text-md font-semibold me-auto">Task Groups</h2>
            <button id="add-group-btn" class="ms-2 px-3 py-1 rounded-full text-sm inline-flex border border-gray-600 dark:bg-gray-700 whitespace-nowrap">
                <i class="w-5 h-5 mr-2" data-feather="folder-plus"></i>
                Create
            </button>
        </div>
        
        <ul id="group-list" class="space-y-4">
            <!-- Groups will be dynamically added -->
        </ul>
    </div>

    <!-- Timeline -->
    <div class="flex-1 overflow-x-auto">
        <!-- Timeline Header -->
        <div class="flex items-center justify-between mb-4 px-4">
            <div class="flex items-center space-x-2">
                <button id="prev-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-full ">
                    <i data-feather="arrow-left"></i>
                </button>
                <button id="next-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-full ">
                    <i data-feather="arrow-right"></i>
                </button>
                <span id="current-month" class="text-lg font-semibold text-gray-700 dark:text-gray-200"></span>
            </div>
            <div class="flex items-center">
                <button id="add-task-btn" class="mr-3 inline-flex gap-2 font-semibold py-2 px-4 bg-blue-200 text-blue-800 hover:bg-blue-500 hover:text-white dark:bg-blue-800 dark:hover:bg-blue-600 dark:text-blue-200 rounded-full">
                    <i data-feather="plus"></i> Add Task
                </button>   

                <button id="zoom-in-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-s-full">
                    <i data-feather="zoom-in"></i>
                </button>
                <button id="zoom-reset-btn" class="mx-1 py-2 px-2 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200">
                    <i data-feather="minimize-2"></i>
                </button>
                <button id="zoom-out-btn" class="py-2 px-4 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-gray-200 rounded-e-full">
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
        <div>
            <span id="delete_butn"></span>
        </div>
        <button id="close-modal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Close
        </button>
    </div>
</div>

<div id="add-task-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg p-6 w-1/3">
        <h3 class="text-lg font-semibold mb-4">Add New Task</h3>
        <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>

        <form id="add-task-form" class="space-y-4"  method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="task-subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                <input required type="text" name="subject" id="task-subject" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label for="task-explanation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Explanation</label>
                <textarea  name="description" id="task-explanation" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 space-x-4">
                <div>
                    <label for="task-start-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                    <input required type="date" name="start_date" id="task-start-date" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="task-deadline-date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deadline Date</label>
                    <input required type="date" name="end_date" id="task-deadline-date" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                <div class="flex space-x-4">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="priority" value="high" class="form-radio text-red-500" checked>
                        <span>High</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="priority" value="medium" class="form-radio text-yellow-500">
                        <span>Medium</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="priority" value="low" class="form-radio text-green-500">
                        <span>Low</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="group" class="block text-sm font-medium text-gray-700 dark:text-gray-300">group</label>
                <select required name="group_id" id="group" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">

                </select>
            </div>
            <div>
                <label for="task-attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment</label>
                <input type="file" name="file" id="task-attachment" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                
                <label for="assignees" class="block text-sm mb-2 font-medium dark:text-gray-200">Assignees</label>
                <select required id="assignees" name="assignees[]" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
                </select>
            </div>
            <div class="flex justify-end">
                <button type="button" id="cancel-add-task" class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-400">Cancel</button>
                <button type="submit" id="add-task" class="ml-3 px-4 py-2 bg-blue-500 text-white hover:bg-blue-600">Add Task</button>
            </div>
        </form>
    </div>
</div>


<div id="add-group-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 shadow-lg p-6 w-1/3">
        <h3 class="text-lg font-semibold mb-4">Add New group</h3>
        <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>

        <form id="add-group-form" class="space-y-4"  method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" required name="name" id="name" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
            </div>
         
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                    <input required type="color" name="color" id="color" class="w-full px-3 py-2 border border-gray-300 dark:bg-gray-700 dark:text-white">
                </div>
               
            
   
            <div class="flex justify-end">
                <button type="button" id="cancel-add-group" class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-400">Cancel</button>
                <button type="submit"  id="add-group" class="ml-3 px-4 py-2 bg-blue-500 text-white hover:bg-blue-600">Add group</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
		assignees_obj = populateChoices2('assignees', [], true);		
    }); 
    $(".projectButton").on('click',function(event) {
		
		if(localStorage.getItem("project_tool") == 'task_planner'){

			get_groups();
            get_tasks();
		}
	});
    $("#add-group-form").on("submit", function(event) {
        const form = document.getElementById("add-group-form");
        const formData = new FormData(form); 

            $('.error').hide();
            $('.success').hide();
            $('.err-msg').hide();
            $(".error").html("");
            $(".success").html("");
            event.preventDefault();  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('projects.groups.store') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#add-group").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                        $('#add-group-modal').addClass('hidden');
                        $("#add-group").prop('disabled', false);                        
                        $("#add-group-form")[0].reset();						
						window.scrollTo(0,0);
                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
					
						setInterval(function() {
							location.reload();
							}, 3000);


                    }
                    else if(data.error){
                        $("#add-group").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                            var el = $(document).find('[name="'+key + '"]');
                            if(el.length == 0){
                                el = $(document).find('[id="'+key + '"]');
                            }
                            el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            
                        });

                        $("#add-group").prop('disabled', false);


                }
            });
    
      });
        
    
      $("#add-task-form").on("submit", function(event) {
        const form = document.getElementById("add-task-form");
        
        const formData = new FormData(form); 
        formData.append('description',tinyMCE.get('task-explanation').getContent());

            $('.error').hide();
            $('.success').hide();
            $('.err-msg').hide();
            $(".error").html("");
            $(".success").html("");
            event.preventDefault();  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('projects.tasks.store') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#add-task").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                        $('#add-task-modal').addClass('hidden');
                        $("#add-task").prop('disabled', false);                        
                        $("#add-task-form")[0].reset();						
						window.scrollTo(0,0);
                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
					
						setInterval(function() {
							location.reload();
							}, 1000);


                    }
                    else if(data.error){
                        $("#add-task").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                            var el = $(document).find('[name="'+key + '"]');
                            if(el.length == 0){
                                el = $(document).find('[id="'+key + '"]');
                                if(el.length == 0){
                                    el = $(document).find('[name="'+key+ '[]"]');

                                }
                            }
                            el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            
                        });

                        $("#add-task").prop('disabled', false);


                }
            });
    
      });
        
    
        
    let groups = [

    ];
    let tasks = [

];

    get_groups();
    async function get_groups() {
        groups = [];
		let url =`/project/groups/all`;
		//alert(url);
		
		let fetchRes = await fetch(url);
        const res = await fetchRes.json();
		const all_groups = res.groups;
        const assignees = res.assignees.users.map(function(item) {
			  return {'value' : item.id , 'label' : item.name};
		});
        assignees_obj.clearStore();
        assignees_obj.setChoices(assignees);

        let html = ``;
        for (let i = 0; i < all_groups.length; i++) {
            groups.push({ id: all_groups[i].id, name: all_groups[i].name, color: all_groups[i].color });
            html+= `<option value="${all_groups[i].id}">${all_groups[i].name}</option>`;
        }
        $('[name="group_id"]').html(html);
        renderGroups();
        renderDays();
        renderTimeline();
       
        console.log(all_groups);
    }

    get_tasks();
    async function get_tasks() { 
        tasks = [];
		let url =`/project/tasks/all`;
		//alert(url);
		
		let fetchRes = await fetch(url);
        const all_tasks  = await fetchRes.json();

        for (let i = 0; i < all_tasks.length; i++) {
            tasks.push(all_tasks[i]);
        }
        renderGroups();
        renderDays();
        renderTimeline();
       
        console.log(tasks);
    }
/*
    const tasks = [
        { id: 1, title: "Complete presentation", groupId: 1, start: 0, duration: 2, assignees: ["Alice"], priority: "high", attachments: true },
        { id: 2, title: "Marketing Analysis", groupId: 2, start: 1, duration: 3, assignees: ["Bob", "Charlie"], priority: "medium", attachments: false },
        { id: 3, title: "UI Design", groupId: 3, start: -2, duration: 4, assignees: ["David"], priority: "low", attachments: true },
    ];
*/
    let currentDayOffset = 0;
    let dayCursor = normalizeToMidnight(new Date());
    const visibleDaysReset = 14;
    let visibleDays = visibleDaysReset; // Default number of visible days

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
                `<li class="flex items-center gap-2">
                    <span class="w-6 h-6 ${group.color} block rounded-lg" style="background-color: ${group.color}"></span>
                    <span>${group.name}</span>

                    <button onclick="delete_group(${group.id})" class="ms-auto text-red-500 dark:text-red-400 hover:text-red-300">
                        <i data-feather="x" class="w-5 h-5"></i>
                    </button>

                </li>`
        ).join('');
        $("#group-list").html(groupElements);
        feather.replace();
    }
    async function delete_group(id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`/project/groups/destroy/${id}`;	
        if(window.confirm('This will result in all tasks under this group being deleted permanently. Are you sure?')){
            let fetchRes = await fetch(url);
            if(fetchRes.status != 200){
                $('.error').show();
                $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

            }else{
                console.log(fetchRes);
                groups = groups.filter((group) => group.id != id);
                tasks = tasks.filter((task) => task.groupId != id);
                renderGroups();
                renderDays();
                renderTimeline();
                $('.success').show();
                $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
            }
        }
    }

    // Render Days Header
    function renderDays() {
        const days = generateDays(currentDayOffset);
        const dayElements = days.map(
            (day) =>
                `<div class="p-2 border-r border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 striped-background">
                    <div class="text-xs mb-2">${day.toLocaleDateString("en-US", { weekday: "short" })}</div><span class='border border-gray-300 dark:border-gray-600 rounded-full px-2 py-1'>${day.getDate()}</span>
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

    async function delete_task(id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`/project/tasks/destroy/${id}`;		
		let fetchRes = await fetch(url);
        if(fetchRes.status != 200){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

        }else{
            console.log(fetchRes);
            $("#task-modal").addClass("hidden");
            tasks = tasks.filter((task) => task.id != id);
            renderGroups();
            renderDays();
            renderTimeline();
            $('.success').show();
            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
        }
    }

    function normalizeToMidnight(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    // Render Groups and Tasks
    function renderTimeline() {
        const rows = groups.map((group) => {
            const groupTasks = tasks.filter((task) => task.groupId === group.id);

             // Array to track rows for tasks in this group
            const groupRows = [];

            groupTasks.forEach((task) => {
                // Check for available rows to place the task
                let placed = false;
                for (let row of groupRows) {
                    // Check if the task overlaps with any task in the current row
                    const overlap = row.some(
                        (t) =>
                            task.start < t.start + t.duration &&
                            task.start + task.duration > t.start
                    );
                    if (!overlap) {
                        row.push(task);
                        placed = true;
                        break;
                    }
                }

                // If no row can accommodate the task, create a new row
                if (!placed) {
                    groupRows.push([task]);
                }
            });

            const rowElements = groupRows.map((rowTasks) => {
                const taskElements = rowTasks.map(
                (task) =>
                    `<div 
                        class="absolute h-full ${group.color} completed text-white text-sm px-2 py-1"
                        style="left: ${((Math.floor((normalizeToMidnight(new Date(task.start)) - dayCursor) / (1000 * 60 * 60 * 24))) * (100 / visibleDays))}%; width: ${(task.duration * (100 / visibleDays))}% ;background-color: ${group.color}"
                        data-task-id="${task.id}">
                        <div class="flex justify-between items-center">
                            <span>${task.title}</span>
                            <input type="checkbox" class="w-4 h-4">
                        </div>
                        <div class="flex items-center ps-3 mt-2">
                          <div class="flex items-center me-auto">
                              ${task.assignees.map(name => `<img src="https://placehold.co/20" alt="${name}" class="min-w-6 w-6 h-6 rounded-full border-2 border-white -ml-2">`).join('')}
                          </div>
                          <div class="text-xs me-2 bg-gray-800 text-gray-200 rounded-full px-2 py-1"><b>${task.duration}</b> d</div>
                          <div class="text-xs rounded-full px-2 py-1 border font-bold bg-gray-100 ${task.priority === 'high' ? 'bg-red-500 border-red-300' : task.priority === 'medium' ? 'bg-yellow-500 border-yellow-300 text-yellow-800' : 'bg-green-300 border-green-200 text-green-800'}">
                            <i class="w-4 h-4" data-feather="${task.priority ==='high' ? 'alert-triangle' : task.priority === 'medium' ? 'alert-circle' : 'info'}"></i>  
                          </div>
                        </div>
                    </div>`
                    );
                    return `
                        <div class="relative h-24 border-t border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 striped-background">
                            ${taskElements.join("")}
                        </div>`;
                    });
                return rowElements.join("");
            });
        $("#timeline-rows").html(rows.join(""));
        feather.replace();
    }

    // Scroll Navigation
    function scrollTimeline(direction) {
        currentDayOffset += direction;
        dayCursor.setDate(dayCursor.getDate() + direction);
        dayCursor = normalizeToMidnight(dayCursor);
        renderDays();
        renderTimeline();
    }

    // Zoom Functions
    function zoomTimeline(inOut) {
        if (inOut === 'in' && visibleDays > 3) {
            visibleDays -= 1;
        } else if (inOut === 'out' && visibleDays < 31) {
            visibleDays += 1;
        } else{
            visibleDays = visibleDaysReset;
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
        $("#zoom-reset-btn").click(() => zoomTimeline('reset'));

        // Open Task Modal
        $("#timeline-rows").on("click", "[data-task-id]", function () {
            const taskId = $(this).data("task-id");
            const task = tasks.find((t) => t.id === taskId);

            $("#task-title").text(task.title);
            $("#task-description").text(task.description);
            $("#task-assignees").text(task.assignees.join(", "));
            $("#task-start").text(`Day ${task.start}`);
            $("#task-end").text(`Day ${task.end}`);

            $('#delete_butn').html(`                    <button onclick="delete_task(${task.id})" class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-delete w-5 h-5"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path><line x1="18" y1="9" x2="12" y2="15"></line><line x1="12" y1="9" x2="18" y2="15"></line></svg>
                    </button>`);

            $("#task-modal").removeClass("hidden");
        });
9/
        // Close Task Modal
        $("#close-modal").click(() => $("#task-modal").addClass("hidden"));

        $('#add-task-btn').click(function () {
            $('#add-task-modal').removeClass('hidden');
        });

        $('#cancel-add-task').click(function () {
            $('#add-task-modal').addClass('hidden');
        });

        $('#add-group-btn').click(function () {
            $('#add-group-modal').removeClass('hidden');
        });

        $('#cancel-add-group').click(function () {
            $('#add-group-modal').addClass('hidden');
        });

 
    });
</script>

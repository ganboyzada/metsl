
<div class="has-dropdown w-1/2 sm:w-auto relative inline-block text-left z-50">
    <!-- Dropdown Toggle Button -->
    <button class="dropdown-toggle w-full flex items-center px-2 py-1 rounded-lg bg-gray-200 dark:bg-gray-800">
        <span class="flex flex-col items-start text-xs mr-2 font-medium me-auto">Tools <b class="current-selected">Meeting Minutes</b></span>
        <i class="ms-auto" data-feather="chevron-down"></i>
    </button>

    <!-- Dropdown Menu -->
    <div class="dropdown absolute left-0 mt-2 w-max bg-gray-800 rounded-lg overflow-hidden text-gray-200 shadow-lg hidden">
        <div data-tabs="project-tools" class="grid grid-cols-1 tab-links bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-lg text-left">
            <button data-tab="activities" class="py-3 px-4" onclick="set_in_local_storage('activities');">
                <i data-feather="activity" class="mr-2"></i> Activities
            </button>
            <button data-tab="correspondence" class="py-3 px-4" onclick="set_in_local_storage('correspondence'); get_correspondences()">
                <i data-feather="repeat" class="mr-2"></i> Correspondence
            </button>
            <button data-tab="documents" class="py-3 px-4 "  onclick="set_in_local_storage('documents'); get_documents()">
                <i data-feather="file-text" class="mr-2"></i> Documents
            </button>
            <button data-tab="meetings" class=" py-3 px-4"  onclick="set_in_local_storage('meeting_planing'); get_meeting_planing()">
                <i data-feather="calendar" class="mr-2"></i> Meeting Minutes
            </button>
            <button data-tab="stakeholders" class="py-3 px-4" onclick="set_in_local_storage('stakeholders'); get_stakeholders()">
                <i data-feather="users" class="mr-2"></i> Stakeholders
            </button>
            <button data-tab="punch-list" class="py-3 px-4"   onclick="set_in_local_storage('punch_list'); get_punch_list()">
                <i data-feather="list" class="mr-2"></i> Punch List
            </button>
            <button data-tab="task-planner" class="py-3 px-4"   onclick="set_in_local_storage('task_planner'); get_tasks()">
                <i data-feather="check-circle" class="mr-2"></i> Last Planner
            </button>
            {{--
            <button data-tab="images" class="py-3 px-4">
                <i data-feather="image" class="mr-2"></i> Project Images
            </button>
            <button data-tab="documents" class="py-3 px-4">
                <i data-feather="type" class="mr-2"></i>  Official Documents
            </button>
            --}}
        </div>
    </div>
</div>
<script>
//localStorage.setItem("project_tool", 'meeting_planing');
//alert(localStorage.getItem("project_tool"));
async  function set_in_local_storage(tool){
  localStorage.setItem("project_tool", tool);
    preload(1000);
  //if(localStorage.getItem("project_tool") == 'documents'){
   // get_reviewers();
	//get_documents();
  //}


}
</script>
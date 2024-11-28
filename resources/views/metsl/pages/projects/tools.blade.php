
<div class="has-dropdown relative inline-block text-left z-10">
    <!-- Dropdown Toggle Button -->
    <button class="dropdown-toggle flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-800">
        <span id="selected-project" class="flex flex-col items-start text-xs mr-2 font-medium">Tools <b class="current-selected">Meeting Minutes</b></span>
        <i data-feather="chevron-down"></i>
    </button>

    <!-- Dropdown Menu -->
    <div class="dropdown absolute left-0 mt-2 w-max bg-gray-800 text-gray-200 shadow-lg hidden">
        <div data-tabs="project-tools" class="grid grid-cols-1 tab-links bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-lg text-left">
            <button data-tab="correspondence" class="py-3 px-4">
                <i data-feather="repeat" class="mr-2"></i> Correspondence
            </button>
            <button data-tab="documents" class="py-3 px-4">
                <i data-feather="file-text" class="mr-2"></i> Documents
            </button>
            <button data-tab="meetings" class="active py-3 px-4">
                <i data-feather="calendar" class="mr-2"></i> Meeting Minutes
            </button>
            <button data-tab="users" class="py-3 px-4">
                <i data-feather="users" class="mr-2"></i> Stakeholders
            </button>
            <button data-tab="punch-list" class="py-3 px-4">
                <i data-feather="list" class="mr-2"></i> Punch List
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
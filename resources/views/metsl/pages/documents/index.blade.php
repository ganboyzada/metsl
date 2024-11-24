<!-- Top Toolbar -->
<div class="flex flex-wrap items-center justify-between mb-6">
    <!-- Add Document Button -->
    <button data-modal="uploader-modal" class="modal-toggler bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 flex items-center transition duration-200">
        <i data-feather="plus-circle" stroke-width="2" class="w-5 h-5 mr-2"></i> Add Document
    </button>

    <!-- Order By and Filter -->
    <div class="flex items-center gap-4">
        <div class="flex items-center">
            <label for="order-by" class="text-sm font-medium dark:text-gray-400 mr-2">Order by:</label>
            <select id="order-by" class="px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                <option>Name</option>
                <option>Initial Upload Date</option>
                <option>Size</option>
                <option>Last Revision Date</option>
            </select>
            <select id="order-direction" class="ml-2 px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                <option>Descending</option>
                <option>Ascending</option>
            </select>
        </div>

        <!-- Filter By You -->
        <div class="flex items-center">
            <label for="filter-by" class="text-sm font-medium dark:text-gray-400 mr-2">Filter:</label>
            <select id="filter-by" class="px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                <option>All</option>
                <option>By You</option>
            </select>
        </div>
    </div>
</div>

<!-- File Manager Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
    <!-- Example File Tiles -->
    <div class="relative p-4 bg-gray-100 dark:bg-gray-800  shadow-md group transition transform hover:scale-105">
        <!-- File Name -->
        <h3 class="text-sm font-medium dark:text-gray-400 mb-2 truncate">Drawing1.pdf</h3>
        <!-- Latest Revision Date -->
        <span class="absolute top-4 right-4 text-xs font-semibold text-blue-500 dark:text-blue-300">
            2 days ago
        </span>
        <!-- File Icon -->
        <div class="flex justify-center items-center mb-4">
            <i data-feather="file-text" class="w-12 h-12 dark:text-gray-200"></i>
        </div>
        <!-- Revision Count -->
        <span class="absolute bottom-2 right-2 flex items-center text-xs font-semibold bg-blue-900 text-white rounded-full px-2 py-1">
            <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>3
        </span>
        <!-- View Revisions Button -->
        <button data-modal="revisions-modal"
            class="absolute modal-toggler bottom-2 left-2 bg-blue-500 text-white px-3 py-1 text-xs  hidden group-hover:block transition duration-200"
            aria-label="View Revisions"
        >
            View Revisions
        </button>
    </div>

    <!-- Repeat for other files -->
    <div class="relative p-4 bg-gray-100 dark:bg-gray-800  shadow-md group transition transform hover:scale-105">
        <h3 class="text-sm font-medium dark:text-gray-400 mb-2 truncate">Drawing2.docx</h3>
        <span class="absolute top-4 right-4 text-xs font-semibold text-blue-500 dark:text-blue-300">
            Yesterday
        </span>
        <div class="flex justify-center items-center mb-4">
            <i data-feather="file-text" class="w-12 h-12 dark:text-gray-200"></i>
        </div>
        <span class="absolute bottom-2 right-2 flex items-center text-xs font-semibold bg-blue-900 text-white rounded-full px-2 py-1">
            <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>2
        </span>
        <button data-modal="revisions-modal"
            class="absolute modal-toggler bottom-2 left-2 bg-blue-500 text-white px-3 py-1 text-xs  hidden group-hover:block transition duration-200"
            aria-label="View Revisions"
        >
            View Revisions
        </button>
    </div>
    <div class="relative p-4 bg-gray-100 dark:bg-gray-800  shadow-md group transition transform hover:scale-105">
        <h3 class="text-sm font-medium dark:text-gray-400 mb-2 truncate">Drawing2.png</h3>
        <span class="absolute top-4 right-4 text-xs font-semibold text-blue-500 dark:text-blue-300">
            2024-11-15
        </span>
        <div class="flex justify-center items-center mb-4">
            <i data-feather="image" class="w-12 h-12 dark:text-gray-200"></i>
        </div>
        <span class="absolute bottom-2 right-2 flex items-center text-xs font-semibold bg-blue-900 text-white rounded-full px-2 py-1">
            <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>2
        </span>
        <button data-modal="revisions-modal"
            class="absolute modal-toggler bottom-2 left-2 bg-blue-500 text-white px-3 py-1 text-xs  hidden group-hover:block transition duration-200"
            aria-label="View Revisions"
        >
            View Revisions
        </button>
    </div>
</div>
@include('metsl.pages.documents.revisions')
@include('metsl.pages.documents.uploader')
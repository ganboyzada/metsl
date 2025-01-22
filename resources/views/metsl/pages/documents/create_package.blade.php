<!-- Uploader Modal -->
<div id="package-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200">Create a Document Package</h2>
            <button data-modal="package-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="upload-form"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>

            <!-- Title -->
            <div class="mb-4">
                    <label for="title" class="block text-sm font-medium dark:text-gray-200 mb-1">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter title"
                    />
            </div>

            <!-- Reviewers -->
            <div class="mb-4">
                <label for="assignees" class="block text-sm font-medium dark:text-gray-200 mb-1">Accessible by</label>
                <select id="assignees" name="assignees[]" multiple class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                </select>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="flex gap-x-2 bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 transition"
            >   <i data-feather="upload"></i>
                Upload
            </button>
        </form>
    </div>
</div>

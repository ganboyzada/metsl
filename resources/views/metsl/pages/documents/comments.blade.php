<!-- Revisions Modal -->
<div id="comments-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="comments-title" class="text-xl font-semibold dark:text-gray-200">
               Comments
            </h2>
            <button data-modal="comments-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
		<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
		<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
        <!-- comments Table -->
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Title</th>
                    <th class="py-2 px-4">Uploaded By</th>
                </tr>
            </thead>
            <tbody id="comments-list">
                <!-- Example Row -->

                <!-- Comment Box -->

            </tbody>
		
        </table>
    </div>
</div>

<!-- Trigger Script -->



<!-- Revisions Modal -->
<div id="revisions-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="revisions-title" class="text-xl font-semibold dark:text-gray-200">
                Revisions for DD/BCC/LV2/ELC/053/R2
            </h2>
            <button data-modal="revisions-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Revisions Table -->
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Title</th>
                    <th class="py-2 px-4">Uploaded By</th>
                    <th class="py-2 px-4">Upload Date</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody id="revisions-list">
                <!-- Example Row -->
                @foreach(range(1, 10) as $rev)
                <tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="py-2 px-4">{{ $rev }}</td>
                    <td class="py-2 px-4">Revision Title</td>
                    <td class="py-2 px-4">John Doe</td>
                    <td class="py-2 px-4">2024-11-{{ $rev }}</td>
                    <td class="py-2 px-4">Pending</td>
                    <td class="py-2 px-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button class="text-blue-500 hover:text-blue-700">
                            <i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
                        </button>
                        <button class="text-yellow-500 hover:text-yellow-700 comment-button">
                            <i data-feather="message-circle" stroke-width="2" class="w-5 h-5"></i>
                        </button>
                        <button class="text-green-500 hover:text-green-700">
                            <i data-feather="check" stroke-width="2" class="w-5 h-5"></i>
                        </button>
                        <button class="text-red-500 hover:text-red-700">
                            <i data-feather="x-circle" stroke-width="2" class="w-5 h-5"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                <!-- Comment Box -->
                <tr class="comment-box hidden">
                    <td colspan="6" class="py-2 px-4 bg-gray-50 dark:bg-gray-700">
                        <textarea class="w-full border  p-2 dark:bg-gray-800 dark:text-gray-200" placeholder="Write your comment..."></textarea>
                        <button class="bg-blue-500 text-white px-4 py-2 mt-2  hover:bg-blue-600">
                            Send
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Trigger Script -->
<script>
    const commentButtons = document.querySelectorAll('.comment-button');
    const commentBoxes = document.querySelectorAll('.comment-box');

    // Handle comment button click
    commentButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            commentBoxes[index].classList.toggle('hidden');
        });
    });
</script>

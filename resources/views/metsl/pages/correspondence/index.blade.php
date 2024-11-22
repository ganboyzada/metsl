
<div class="dark:bg-gray-900 dark:text-gray-200">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Correspondence</h2>
        <!-- Create Button with Dropdown -->
        <div class="has-dropdown relative">
            <button
                class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none"
            >
                <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                Create
            </button>
            <!-- Dropdown Menu -->
            <div
                class="dropdown absolute right-0 mt-2 w-32 bg-gray-800 text-gray-200 rounded-md shadow-lg hidden"
            >
                <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="info"></i>RFI</a>
                <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="copy"></i>RFV</a>
                <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="refresh-cw"></i>RFC</a>
            </div>
        </div>
    </div>

    <!-- Correspondence Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse dark:bg-gray-800 border dark:border-gray-700">
            <thead class="bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Number</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Subject</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Last Activity</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Assignees</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Created By</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Issued On</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Due Date</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
    </div>
</div>

<script>
    // Sample data for demonstration
    const correspondenceData = Array.from({ length: 100 }).map((_, i) => ({
        number: `CR${i + 1}`,
        subject: `Subject of Correspondence ${i + 1}`,
        lastActivity: `2024-0${Math.ceil(Math.random() * 9)}-${Math.ceil(Math.random() * 28)
            .toString()
            .padStart(2, '0')}`,
        assignees: ['John Doe', 'Jane Smith', 'Alice Johnson'][Math.floor(Math.random() * 3)],
        createdBy: ['Project Manager', 'Contractor'][Math.floor(Math.random() * 2)],
        issuedOn: `2024-0${Math.ceil(Math.random() * 9)}-${Math.ceil(Math.random() * 28)
            .toString()
            .padStart(2, '0')}`,
        dueDate: `2024-1${Math.ceil(Math.random() * 2)}-${Math.ceil(Math.random() * 28)
            .toString()
            .padStart(2, '0')}`,
        status: ['DRAFT', 'ISSUED', 'OPEN', 'CLOSED'][Math.floor(Math.random() * 4)],
    }));

    const tableBody = document.getElementById('table-body');
    let loadedRows = 0;

    // Lazy load rows
    function loadRows() {
        const rowsToLoad = 20;
        const fragment = document.createDocumentFragment();
        for (let i = loadedRows; i < Math.min(loadedRows + rowsToLoad, correspondenceData.length); i++) {
            const row = correspondenceData[i];
            const tr = document.createElement('tr');
            tr.classList.add('hover:shadow-lg','hover:bg-gray-100','hover:dark:bg-gray-700');

            tr.innerHTML = `
                <td class="px-6 py-3">${row.number}</td>
                <td class="px-6 py-3"><a class="underline" href="{{ route('projects.correspondence.view') }}">${row.subject}</a></td>
                <td class="px-6 py-3">${row.lastActivity}</td>
                <td class="px-6 py-3">${row.assignees}</td>
                <td class="px-6 py-3">${row.createdBy}</td>
                <td class="px-6 py-3">${row.issuedOn}</td>
                <td class="px-6 py-3">${row.dueDate}</td>
                <td class="px-6 py-3">
                    <span class="px-3 py-1 rounded-full text-xs ${
                        row.status === 'OPEN'
                            ? 'bg-blue-500 text-white'
                            : row.status === 'CLOSED'
                            ? 'bg-green-500 text-white'
                            : row.status === 'DRAFT'
                            ? 'bg-gray-300 text-black'
                            : 'bg-yellow-500 text-black'
                    }">${row.status}</span>
                </td>
            `;
            fragment.appendChild(tr);
        }
        tableBody.appendChild(fragment);
        loadedRows += rowsToLoad;
    }

    // Detect scroll for lazy loading
    window.addEventListener('scroll', () => {
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        if (scrollTop + clientHeight >= scrollHeight - 50) {
            loadRows();
        }
    });

    // Initial load
    loadRows();

    // Dropdown toggle logic
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }
</script>
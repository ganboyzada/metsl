
<div>
    <!-- Page Header -->
    <div class="flex items-center gap-4 mb-4">
        <div class="flex items-center gap-4 mr-auto">
            <div class="relative">
                <i data-feather="search" class="absolute left-2 top-2 text-gray-500"></i>
                <input
                    type="text"
                    placeholder="Search"
                    class="pl-10 pr-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                />
            </div>
            <button class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200">Add Filter</button>
        </div>
        <!-- Create Button with Dropdown -->
        <div class="has-dropdown relative">
            <button
                class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 focus:outline-none"
            >
                <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                Create
            </button>
            <!-- Dropdown Menu -->
            <div
                class="dropdown absolute right-0 mt-2 w-32 bg-gray-800 text-gray-200  shadow-lg hidden"
            >
                <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="info"></i>RFI</a>
                <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="copy"></i>RFV</a>
                <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="refresh-cw"></i>RFC</a>
            </div>
        </div>
    </div>

    <!-- Correspondence Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th class="px-6 py-3 font-light">Number</th>
                    <th class="px-6 py-3 font-light">Subject</th>
                    <th class="px-6 py-3 font-light">Last Activity</th>
                    <th class="px-6 py-3 font-light">Assignees</th>
                    <th class="px-6 py-3 font-light">Created By</th>
                    <th class="px-6 py-3 font-light">Issued On</th>
                    <th class="px-6 py-3 font-light">Due Date</th>
                    <th class="px-6 py-3 font-light">Status</th>
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
            tr.classList.add('border-b','dark:border-gray-800','hover:shadow-lg','hover:bg-gray-100','hover:dark:bg-gray-700');

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
</script>
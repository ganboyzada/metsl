@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 dark:text-gray-200 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-6">Create Correspondence</h2>

    <!-- Form -->
    <form id="correspondence-form" class="space-y-6">
        <!-- Grid Layout for Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Number -->
            <div>
                <label for="correspondence-number" class="block text-sm font-medium mb-1">Number</label>
                <input
                    id="correspondence-number"
                    type="text"
                    placeholder="RFI-001"
                    class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                />
            </div>

            <!-- Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium mb-1">Subject</label>
                <input
                    id="subject"
                    type="text"
                    placeholder="Enter subject"
                    class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                />
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium mb-1">Status</label>
                <select
                    id="status"
                    class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
                    <option value="Draft">Draft</option>
                    <option value="Issued">Issued</option>
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>

            <!-- Programme Impact -->
            <div>
                <label for="programme-impact" class="block text-sm font-medium mb-1">Programme Impact</label>
                <select
                    id="programme-impact"
                    class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="TBD">TBD</option>
                    <option value="N/A">N/A</option>
                </select>
            </div>

            <!-- Cost Impact -->
            <div>
                <label for="cost-impact" class="block text-sm font-medium mb-1">Cost Impact</label>
                <select
                    id="cost-impact"
                    class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="TBD">TBD</option>
                    <option value="N/A">N/A</option>
                </select>
            </div>

            <!-- Assignees -->
            <div class="relative">
                <label for="assignees" class="block text-sm font-medium mb-1">Assignees</label>
                <select id="assignees" multiple class="w-full"></select>
            </div>

            <!-- Distribution Members -->
            <div class="relative">
                <label for="distribution" class="block text-sm font-medium mb-1">Distribution Members</label>
                <select id="distribution" multiple class="w-full"></select>
            </div>

            <!-- Received From -->
            <div class="relative">
                <label for="received-from" class="block text-sm font-medium mb-1">Received From</label>
                <select id="received-from" class="w-full"></select>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="description" class="block mb-1">Description</label>
                <textarea
                    id="description"
                    placeholder="Enter correspondence description"
                    class="w-full px-4 py-2 border rounded-md dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                ></textarea>
            </div>
            <div>
                <label class="block mb-1">Attachments (PDF only)</label>
                <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-lg dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF only (max. 5MB)</p>
                    </div>
                    <input id="file-upload" type="file" class="hidden" accept=".pdf" multiple>
                </div>
                <ul id="file-list" class="mt-4 space-y-2">
                    <!-- Uploaded files will appear here -->
                </ul>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Create Correspondence</button>
        </div>
    </form>
</div>

<script>


    // Example data
    const assignees = [
        { value: '1', label: 'John Doe (ACT Orders)' },
        { value: '2', label: 'Jane Smith (ACT Developments)' },
        { value: '3', label: 'Michael Brown (MB Architects)' },
        { value: '4', label: 'Alice Johnson (ACT Orders)' },
    ];

    // Feather Icons Initialization
    document.addEventListener('DOMContentLoaded', () => {
        // Populate Assignees, Distribution Members, and Received From
        populateChoices('assignees', assignees, true);
        populateChoices('distribution', assignees, true);
        populateChoices('received-from', assignees);

        feather.replace();
    });

    // Attachments logic
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-upload');
    const fileList = document.getElementById('file-list');

    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', event => {
        event.preventDefault();
        dropZone.classList.add('bg-gray-700');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('bg-gray-700'));
    dropZone.addEventListener('drop', event => {
        event.preventDefault();
        dropZone.classList.remove('bg-gray-700');
        handleFiles(event.dataTransfer.files);
    });
    fileInput.addEventListener('change', () => handleFiles(fileInput.files));

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type !== 'application/pdf') {
                alert('Only PDF files are allowed.');
                return;
            }
            const li = document.createElement('li');
            li.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            li.classList.add('text-gray-400', 'text-sm');
            fileList.appendChild(li);
        });
    }
</script>

@endsection

@extends('metsl.layouts.master')

@section('title', 'Punch List - Create')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Add a Punch Item</h1>
    <form id="snag-item-form" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Title (Required) -->
            <div>
                <label for="title" class="block text-sm mb-2 font-medium dark:text-gray-200">Title <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="title"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter title"
                    required
                />
            </div>

            <!-- Number (#) (Required) -->
            <div>
                <label for="number" class="block text-sm mb-2 font-medium dark:text-gray-200">Number (#) <span class="text-red-500">*</span></label>
                <input
                    type="number"
                    id="number"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter number"
                    required
                />
            </div>

            <!-- Responsible Member (Single Selector) (Required) -->
            <div>
                <label for="responsible-member" class="block text-sm mb-2 font-medium dark:text-gray-200">Responsible Member <span class="text-red-500">*</span></label>
                <select id="responsible-member" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200" required>
                    <option value="">Select a member</option>
                    <option value="member1">Member 1</option>
                    <option value="member2">Member 2</option>
                    <option value="member3">Member 3</option>
                </select>
            </div>

            <!-- Distribution Members (Multiple Selector) -->
            <div>
                <label for="distribution-members" class="block text-sm mb-2 font-medium dark:text-gray-200">Distribution Members</label>
                <select id="distribution-members" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
                    <option value="member1">Member 1</option>
                    <option value="member2">Member 2</option>
                    <option value="member3">Member 3</option>
                    <option value="member4">Member 4</option>
                </select>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm mb-2 font-medium dark:text-gray-200">Location</label>
                <input
                    type="text"
                    id="location"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter location"
                />
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm mb-2 font-medium dark:text-gray-200">Priority</label>
                <select id="priority" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <!-- Cost Impact -->
            <div>
                <label for="cost-impact" class="block text-sm mb-2 font-medium dark:text-gray-200">Cost Impact</label>
                <select id="cost-impact" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                    <option value="tbd">TBD</option>
                    <option value="na">N/A</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm mb-2 dark:text-gray-200">Description</label>
                <textarea
                    id="description"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    rows="4"
                    placeholder="Enter description"
                ></textarea>
            </div>

            <!-- Attachments (Dropzone) -->
            <div>
                <label class="block mb-2 text-sm">Attachments (PDF, JPG, JPEG, PNG)</label>
                <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG (max. 10MB)</p>
                    </div>
                    <input id="file-upload" type="file" class="hidden" multiple>
                </div>
                <ul id="file-list" class="mt-4 space-y-2">
                    <!-- Uploaded files will appear here -->
                </ul>
            </div>
        
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"
        >
            Submit Punch Item
        </button>
    </form>
</div>
<script>
    const cc_list = [
        { value: '1', label: 'John Doe (ACT Orders)' },
        { value: '2', label: 'Jane Smith (ACT Developments)' },
        { value: '3', label: 'Michael Brown (MB Architects)' },
        { value: '4', label: 'Alice Johnson (ACT Orders)' },
    ];

    // Feather Icons Initialization
    document.addEventListener('DOMContentLoaded', () => {
        // Populate Assignees, Distribution Members, and Received From
    
        populateChoices('distribution-members', cc_list, true);
    });
</script>
@endsection
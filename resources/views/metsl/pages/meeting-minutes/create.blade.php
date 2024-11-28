@extends('metsl.layouts.master')

@section('title', 'Plan a Meeting')

@section('content')
<div>
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Meeting Planner</h1>

    <!-- Meeting Planner Form -->
    <form id="meeting-planner-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Meeting # -->
        <div class="col-span-1">
            <label for="meeting-number" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting #</label>
            <input
                type="text"
                id="meeting-number"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter meeting number"
                required
            />
        </div>

        <!-- Meeting Name -->
        <div class="col-span-1">
            <label for="meeting-name" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Name</label>
            <input
                type="text"
                id="meeting-name"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter meeting name"
                required
            />
        </div>

        <!-- Conference Link -->
        <div class="col-span-1">
            <label for="conference-link" class="block text-sm mb-2 font-medium dark:text-gray-200">Conference Link</label>
            <input
                type="url"
                id="conference-link"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter link (e.g., Zoom, Teams)"
            />
        </div>

        <!-- Meeting Location -->
        <div class="col-span-1">
            <label for="meeting-location" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Location</label>
            <input
                type="text"
                id="meeting-location"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter location"
            />
        </div>

        <!-- Planned Date -->
        <div class="col-span-1">
            <label for="planned-date" class="block text-sm mb-2 font-medium dark:text-gray-200">Planned Date</label>
            <input
                type="date"
                id="planned-date"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                required
            />
        </div>

        <!-- Start Time -->
        <div class="col-span-1">
            <label for="start-time" class="block text-sm mb-2 font-medium dark:text-gray-200">Start Time</label>
            <input
                type="time"
                id="start-time"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                required
            />
        </div>

        <!-- Duration -->
        <div class="col-span-1">
            <label for="duration" class="block text-sm mb-2 font-medium dark:text-gray-200">Duration</label>
            <select id="duration" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
                <option value="5">5 minutes</option>
                <option value="15">15 minutes</option>
                <option value="30">30 minutes</option>
                <option value="45">45 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1.5 hours</option>
                <option value="120">2 hours</option>
            </select>
        </div>

        <!-- Time Zone -->
        <div class="col-span-1">
            <label for="time-zone" class="block text-sm mb-2 font-medium dark:text-gray-200">Time Zone</label>
            <select id="time-zone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
                <option value="GMT-12">GMT-12</option>
                <option value="GMT-11">GMT-11</option>
                <option value="GMT-10">GMT-10</option>
                <option value="GMT-9">GMT-9</option>
                <option value="GMT-8">GMT-8</option>
                <option value="GMT-7">GMT-7</option>
                <option value="GMT-6">GMT-6</option>
                <option value="GMT-5">GMT-5</option>
                <option value="GMT-4">GMT-4</option>
                <option value="GMT-3">GMT-3</option>
                <option value="GMT-2">GMT-2</option>
                <option value="GMT-1">GMT-1</option>
                <option value="GMT">GMT</option>
                <option value="GMT+1">GMT+1</option>
                <option value="GMT+2">GMT+2</option>
                <option value="GMT+3">GMT+3</option>
                <option value="GMT+4">GMT+4</option>
                <option value="GMT+5">GMT+5</option>
                <option value="GMT+6">GMT+6</option>
                <option value="GMT+7">GMT+7</option>
                <option value="GMT+8">GMT+8</option>
                <option value="GMT+9">GMT+9</option>
                <option value="GMT+10">GMT+10</option>
                <option value="GMT+11">GMT+11</option>
                <option value="GMT+12">GMT+12</option>
            </select>
        </div>

        <!-- Participants -->
        <div>
            <label for="participants" class="block text-sm mb-2 font-medium dark:text-gray-200">Participants</label>
            <select id="participants" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
            </select>
        </div>

        <!-- Meeting Purpose -->
        <div class="col-span-3">
            <label for="meeting-purpose" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Purpose</label>
            <textarea
                id="meeting-purpose"
                class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                rows="3"
                placeholder="Enter the purpose of the meeting"
            ></textarea>
        </div>

        <!-- Attachments -->
        <div class="col-span-3">
            <label for="attachments" class="block text-sm mb-2 font-medium dark:text-gray-200">Attachments</label>
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

        <!-- Submit Button -->
        <div class="col-span-3 flex justify-end">
            <button
                type="submit"
                class="px-6 py-2 bg-blue-500 text-white hover:bg-blue-600"
            >
                Plan Meeting
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>
    let participants = [
        {'value': '1', 'label': 'John Doe'},
        {'value': '2', 'label': 'Blake John'},
        {'value': '3', 'label': 'Dwayne Hunstman'},
        {'value': '4', 'label': 'Harvey Ramsay'},
        {'value': '5', 'label': 'Brook Chesterville'}
    ];

    document.addEventListener('DOMContentLoaded', () => {
        populateChoices('participants', participants, true);     
    }); 
</script>
@endpush
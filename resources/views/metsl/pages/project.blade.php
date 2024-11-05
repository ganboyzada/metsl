@extends('metsl.layouts.master')

@section('title', 'Project Detail')

@section('header')
    <a href="{{ route('company.detail', 1) }}" class="flex items-center text-gray-600 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg font-medium">
    <i class="fas fa-arrow-left mr-2 text-gray-500"></i> Back to Company
</a>
@endsection

@section('content')
    <div class="flex space-x-6">
        <!-- Left Sidebar with Company Info -->
        <div class="w-1/3 bg-white shadow p-6 rounded-lg">
            <h2 class="text-2xl font-semibold">APEX</h2>
            <p class="mt-2 text-gray-600">Short description of a project is shown here. This is a text which will be added during creation of the project.</p>

            <!-- Project Categories -->
            <!-- Tabs -->
        <div class="mt-6 space-y-4">
            <button onclick="openTab('images')" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-left flex items-center">
                <i class="fas fa-image mr-2 text-gray-500"></i> Images (56)
            </button>
            <button onclick="openTab('documents')" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-left flex items-center">
                <i class="fas fa-file-alt mr-2 text-gray-500"></i> Official Documents (5)
            </button>
            <button onclick="openTab('projects')" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-left flex items-center">
                <i class="fas fa-tasks mr-2 text-gray-500"></i> Projects Ongoing (5)
            </button>
            <button onclick="openTab('approval')" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-left flex items-center">
                <i class="fas fa-check-circle mr-2 text-gray-500"></i> Documents on Approve (1)
            </button>
            <button onclick="openTab('users')" class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-left flex items-center">
                <i class="fas fa-users mr-2 text-gray-500"></i> Company Users (5)
            </button>
        </div>
        </div>

        <!-- Right Section with Project List and Search -->
        <div class="flex-1 ml-6 p-6 bg-white shadow rounded-lg">

            <!-- Header with Tabs -->
            <div class="flex border-b border-gray-200">
                <button class="text-red-600 border-b-2 border-red-600 px-4 py-2">Issues</button>
                <button class="px-4 py-2 text-gray-600 hover:text-gray-800">Documents</button>
                <button class="px-4 py-2 text-gray-600 hover:text-gray-800">Meeting minutes</button>
                <button class="px-4 py-2 text-gray-600 hover:text-gray-800">Reports</button>
            </div>

            <!-- Filter Section -->
            <div class="flex items-center space-x-4 mt-4">
                <span class="text-gray-500 font-medium">Filter by:</span>
                <button class="px-4 py-2 border rounded-lg text-gray-600">Status</button>
                <button class="px-4 py-2 border rounded-lg text-gray-600">Type</button>
                <button class="px-4 py-2 border rounded-lg text-gray-600">Creation date</button>
                <button class="px-4 py-2 border rounded-lg text-gray-600">Assignee</button>
                <button class="px-4 py-2 border rounded-lg text-gray-600">Deadline</button>
            </div>

            <!-- Project List Section -->
            <div class="mt-4 space-y-4">
                <!-- Project Card -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-semibold">In progress</span>
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Task</span>
                        <div class="text-gray-700">
                            <p class="font-medium">Name: Site revision</p>
                            <p class="text-sm">Creation date: 12.08.2024 | 15:36</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-600">Assignee:</span>
                        <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 rounded-full border-2 border-white">
                        <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 rounded-full border-2 border-white">
                        <span class="text-sm text-gray-600">Deadline: 12.09.2024 | 19:00</span>
                    </div>
                </div>

                <!-- Another Project Card -->
                <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Done</span>
                        <span class="bg-purple-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Meeting Minutes</span>
                        <div class="text-gray-700">
                            <p class="font-medium">Name: Site revision</p>
                            <p class="text-sm">Creation date: 12.08.2024 | 15:36</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-600">Assignee:</span>
                        <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 rounded-full border-2 border-white">
                        <img src="https://via.placeholder.com/32" alt="Assignee" class="w-8 h-8 rounded-full border-2 border-white">
                        <span class="text-sm text-gray-600">Deadline: 12.09.2024 | 19:00</span>
                    </div>
                </div>
            </div>

            <!-- Create New Button -->
            <div class="flex justify-end mt-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Create new</button>
            </div>
        </div>
    </div>

    <script>
        function openTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.getElementById(tabId).classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            openTab('images');
        });
    </script>
@endsection
@extends('metsl.layouts.master')

@section('title', 'Company Detail')

@section('header')
    <a href="{{ route('companies') }}" class="flex items-center text-gray-600 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg font-medium">
    <i class="fas fa-arrow-left mr-2 text-gray-500"></i> Back to Companies
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

            <!-- Tab Content: Images -->
            <div id="images" class="tab-content hidden">
                <h3 class="text-lg font-semibold flex items-center"><i class="fas fa-image mr-2"></i> Images</h3>
                <p class="text-gray-600 mt-2">Here is the content for Images.</p>
            </div>

            <!-- Tab Content: Official Documents -->
            <div id="documents" class="tab-content hidden">
                <h3 class="text-lg font-semibold flex items-center"><i class="fas fa-file-alt mr-2"></i> Official Documents</h3>
                <p class="text-gray-600 mt-2">Here is the content for Official Documents.</p>
            </div>

            <!-- Tab Content: Projects Ongoing -->
            <div id="projects" class="tab-content hidden">
                <div class="flex items-center justify-between mb-4">
                    <!-- Search Box -->
                    <div class="relative flex items-center">
                        <input 
                            type="text" 
                            id="searchBar" 
                            placeholder="Search by name" 
                            class="border border-gray-300 rounded-lg p-2 pl-10 text-sm w-64 focus:outline-none focus:ring focus:border-blue-300 appearance-none"
                            style="background: none;" 
                        />
                        <!-- Font Awesome Search Icon -->
                        <i class="fas fa-search absolute left-3 text-gray-500"></i>
                    </div>
                </div>

                <!-- Project Cards -->
                <div class="space-y-4">
                <a href="{{ route('project', ['id' => 1]) }}" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex items-center justify-between shadow-sm">
                    <span class="text-gray-800 font-medium">Project name: Indoor corridors repair</span>
                    <span class="bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-semibold">Ongoing</span>
                </a>

                <a href="{{ route('project', ['id' => 2]) }}" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex items-center justify-between shadow-sm">
                    <span class="text-gray-800 font-medium">Project name: Indoor corridors repair</span>
                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Cancelled</span>
                </a>

                <a href="{{ route('project', ['id' => 3]) }}" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex items-center justify-between shadow-sm">
                    <span class="text-gray-800 font-medium">Project name: Indoor corridors repair</span>
                    <span class="bg-yellow-400 text-white px-2 py-1 rounded-full text-sm font-semibold">Ongoing</span>
                </a>

                <a href="{{ route('project', ['id' => 4]) }}" class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-4 flex items-center justify-between shadow-sm">
                    <span class="text-gray-800 font-medium">Project name: Indoor corridors repair</span>
                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-sm font-semibold">Done</span>
                </a>
                </div>
            </div>

            <!-- Tab Content: Documents on Approve -->
            <div id="approval" class="tab-content hidden">
                <h3 class="text-lg font-semibold flex items-center"><i class="fas fa-check-circle mr-2"></i> Documents on Approve</h3>
                <p class="text-gray-600 mt-2">Here is the content for Documents on Approve.</p>
            </div>

            <!-- Tab Content: Company Users -->
            <div id="users" class="tab-content hidden">
                <h3 class="text-lg font-semibold flex items-center"><i class="fas fa-users mr-2"></i> Company Users</h3>
                <p class="text-gray-600 mt-2">Here is the content for Company Users.</p>
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
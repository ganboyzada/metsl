<div class="bg-gray-900 text-gray-200 rounded-lg shadow-md">
    <!-- Project Overview -->
    <h2 class="text-2xl font-semibold mb-6 flex items-center">
        <i data-feather="info" class="w-6 h-6 mr-2 text-blue-500"></i>
        Project Overview
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <p class="text-sm text-gray-400">Project Name</p>
            <p class="text-lg font-medium" id="projectNameReview">New Building Construction</p>
        </div>
        <div>
            <p class="text-sm text-gray-400">Project Timeline</p>
            <p class="text-lg font-medium" id="startEndDateLbl">01/01/2024 - 12/31/2024</p>
        </div>
        <div class="md:col-span-2">
            <p class="text-sm text-gray-400">Project Description</p>
            <p class="text-lg font-medium" id="ProjectDescription">
                This project involves the construction of a multi-story commercial building with
                advanced features and facilities.
            </p>
        </div>
    </div>

    <!-- Stakeholder Section -->
    <h2 class="text-2xl font-semibold mb-6 flex items-center">
        <i data-feather="users" class="w-6 h-6 mr-2 text-green-500"></i>
        Project Team
    </h2>
    <div  id="Stakeholders" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        <!-- Stakeholder Card -->
        <div class="p-4 border  bg-gray-800 border-gray-700">
            <div class="flex items-center mb-4">
                <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                <div>
                    <p class="text-sm font-medium">John Doe</p>
                    <p class="text-xs text-gray-400">Client</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 mb-1">Role</p>
            <p class="text-sm font-medium mb-2">Project Initiator</p>
            <p class="text-xs text-gray-400 mb-1">Permissions</p>
            <ul class="list-disc pl-5 text-xs text-gray-300">
                <li>Can view progress reports</li>
                <li>Can request updates</li>
            </ul>
        </div>

        <!-- Repeat for Other Stakeholders -->
        <div class="p-4 border  bg-gray-800 border-gray-700">
            <div class="flex items-center mb-4">
                <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                <div>
                    <p class="text-sm font-medium">Sarah Smith</p>
                    <p class="text-xs text-gray-400">Project Manager</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 mb-1">Role</p>
            <p class="text-sm font-medium mb-2">Team Leader</p>
            <p class="text-xs text-gray-400 mb-1">Permissions</p>
            <ul class="list-disc pl-5 text-xs text-gray-300">
                <li>Can assign tasks</li>
                <li>Can approve designs</li>
                <li>Can communicate with contractors</li>
            </ul>
        </div>

        <!-- Add more Stakeholder Cards as needed -->
    </div>

    <!-- Documents Section -->
    <h2 class="text-2xl font-semibold mb-6 flex items-center">
        <i data-feather="file-text" class="w-6 h-6 mr-2 text-orange-500"></i>
        Project Documents
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8" id="docs">
        @if (isset($files) && $files->count() > 0)
            @foreach ($files as $file)
            <div class="p-4 border  bg-gray-800 border-gray-700 flex items-center justify-between">

                <div>
                    <p class="text-lg font-medium">{{$file->name}}</p>
                    <p class="text-sm text-gray-400">( {{ $file->size != NULL ? round($file->size/1024 , 2) : 0  }} kb )</p>
                </div>
                <a  href="{{ asset('storage/project'.$project->id.'/'.$file->name)  }}" target="__blank" class="text-blue-400 hover:underline flex items-center">
                    <i data-feather="download" class="w-5 h-5 mr-1"></i> Download
                </a>
            </div>                
            @endforeach
            
        @endif


    </div>
</div>
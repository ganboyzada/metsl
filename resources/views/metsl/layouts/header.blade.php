<header class="fixed z-50 w-[100vw] h-[7rem] md:h-[4rem] left-0 top-0 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-200 shadow px-3 px-md-6 py-2">
    <div class="flex justify-between items-start md:items-center">
        <div class="relative flex flex-col md:flex-row md:items-center gap-3">
            <a href="/" class="block relative md:mt-[-6px] w-24">
                <img src="{{ asset('images/logo.png') }}" class="dark:hidden" alt="">
                <img src="{{ asset('images/logo-light.png') }}" class="hidden dark:block" alt="">
            </a>

            <div class="toolbox flex flex-nowrap items-center gap-2 absolute md:static left-0 top-[140%] w-[90vw] md:w-auto">
                <div class="w-1/2 sm:w-auto has-dropdown relative inline-block text-left z-2">
                    <!-- Dropdown Toggle Button -->
                    <button  onclick="toggleProjectsDropdown()" class="dropdown-toggle w-full flex items-center px-2 py-1 rounded-lg bg-gray-200 dark:bg-gray-800">
                        <span id="selected-project" class="flex flex-col items-start text-xs mr-2 font-medium me-auto">Project<b id="project-variable">{{  session('projectName')  }}</b></span>
                        <i class="ms-auto" data-feather="chevron-down"></i>
                    </button>
                    @php
                        $projects_ids = \App\Models\ProjectUser::where('user_id', auth()->user()->id)->pluck('project_id')->toArray();
                    @endphp

                    <input type="hidden" id="selected_project_id" value="{{ session('projectID') }}"/>
                    <input type="hidden" id="selected_project_name" value="{{ session('projectName') }}"/>
                    <!-- Dropdown Menu -->
                    <div  id="projects-dropdown-toggle" class="hidden absolute  left-0 rounded-lg mt-2 min-w-full w-[130%] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-lg">
                        <ul class="py-2">
                            @php
                                if(checkIfUserHasThisPermission(Session::get('projectID') ,'view_all_projects')){
                                    $all_projects = \App\Models\Project::all();
                                }else{
                                    $all_projects =\App\Models\Project::whereHas('stakholders', function ($query) {
                                    $query->where(function ($q) {
                                        $q->where('user_id', auth()->user()->id);
                                    });
                                    })->get();
                                }
                            @endphp
                            <!-- List of Projects (Replace these with dynamic content) -->
                            @if($all_projects->count() > 0) 
                                @foreach($all_projects as $project)
                                    @if (in_array($project->id, $projects_ids) || auth()->user()->is_admin)
                                    <li>
                                        <button onclick="selectProject('{{ $project->name }}' , '{{ $project->id }}')" class="block text-xs w-full text-left px-4 py-2 hover:bg-black/10 projectButton">{{ $project->name }}</button>
                                    </li>                                       
                                    @endif

                                @endforeach
                            @endif

                            <li class="px-3 pt-2">
                                <a href="{{ route('projects') }}" class="text-xs inline-flex w-full px-3 rounded-lg py-1 bg-gray-600 hover:bg-blue-700 text-white font-medium">
                                    My Projects
                                </a>
                            </li>

                            <!-- Add more projects as needed -->
                        </ul>
                    </div>
                </div>
                @include('metsl.pages.projects.tools')
                <h1 class="hidden lg:inline text-lg ps-5 font-medium current-selected"></h1>
            </div>

            @yield('header')
        </div>
        
        <!-- Add user info or notifications here if needed -->

        <!-- Right side icons -->
        <div class="flex items-center space-x-6">
            <!-- Language Switcher -->
            {{--
            <button onclick="toggleModal('user-circle-modal', 'open');" id="people-button">
                <i data-feather="users" class="w-6 h-6"></i>
            </button>

            <button>
                <i data-feather="globe"></i>
            </button>
                --}}
            <!-- Full Screen Toggle -->
            <button onclick="toggleFullScreen()">
            <i data-feather="maximize"></i>
            </button>

            

            <!-- Notifications with Badge -->
            <div class="relative hidden">
                <button onclick="toggleNotifications()">
                    <i data-feather="bell"></i>
                    <!-- Notification count badge -->
                    <span class="absolute bottom-4 left-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">3</span>
                </button>
                <!-- Notification Popup -->
                <div id="notificationPopup" class="hidden absolute right-0 mt-2 w-64 bg-white shadow-lg  p-4 z-10">
                    <p class="font-semibold mb-2">Notifications</p>
                    <div class="space-y-2">
                        <p class="text-gray-600 text-sm">Notification 1</p>
                        <p class="text-gray-600 text-sm">Notification 2</p>
                        <p class="text-gray-600 text-sm">Notification 3</p>
                    </div>
                </div>
            </div>

            <!-- User Profile and Dropdown -->
            <div class="has-dropdown w-1/2 sm:w-auto relative inline-block text-left z-50">
                <button onclick="toggleUserDropdown()"  class="dropdown-toggle w-full flex items-center px-2 py-1 rounded-lg bg-gray-200 dark:bg-gray-800">
                    <!-- User Image -->
                    <img src="{{ auth()->user()->profile_photo_path }}" alt="User" class="min-w-7 md:min-w-9 w-7 md:w-9 h-7 md:h-9 md:mr-2 rounded-full">
                    <!-- User Name -->
                    <div class="text-xs flex-col items-start hidden md:flex">
                        <span>Welcome,</span>
                        <span class="font-bold">{{ auth()->user()->name }}</span>
                    </div>   
                </button>
                <!-- User Dropdown Menu -->
                <div id="userDropdown" class="hidden absolute  right-0 mt-2 w-max bg-gray-800 rounded-lg  text-gray-200 shadow-lg">
                    <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 hover:bg-gray-100/25"><i data-feather="user" class="mr-3"></i>Profile</a>
                    @if(checkIfUserHasThisPermission(Session::get('projectID') ,'modify_presets') 
                    //|| checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects')
                    )
                    <a href="{{ route('roles') }}" class="flex items-center px-4 py-2 hover:bg-gray-200/25">
                        <i data-feather="git-pull-request" class="mr-3"></i>
                        Manage Roles
                        <i data-feather="lock" class="ml-auto w-4 h-4 text-blue-400"></i>
                    </a>
					@endif
					@if(checkIfUserHasThisPermission(Session::get('projectID') ,'modify_companies')
                    // || checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects')
                    )
                    <a href="{{ route('work_packages') }}" class="flex items-center px-4 py-2 hover:bg-gray-200/25">
                        <i data-feather="list" class="mr-3"></i>
                        Work Packages
                        <i data-feather="lock" class="ml-auto w-4 h-4 text-blue-400"></i>
                    </a>
                    <a href="{{ route('companies') }}" class="flex items-center px-4 py-2 hover:bg-gray-200/25">
                        <i data-feather="list" class="mr-3"></i>
                        Companies
                        <i data-feather="lock" class="ml-auto w-4 h-4 text-blue-400"></i>
                    </a>
                    @endif
                    <!-- Dark/Light Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="flex w-full items-center px-4 py-2 hover:bg-gray-100/25">
                        <i data-feather="moon" class="mr-3"></i>Toggle Theme
                    </button>
                    {{--
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100/25"><i data-feather="settings" class="mr-3"></i>Settings</a>
                    --}}
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="flex w-full items-center px-4 py-2 hover:bg-gray-100/25">
                            <i data-feather="log-out" class="mr-3"></i> Sign Out
                        </button>
                    </form>

                </div>
            </div>
        </div>
    <script>
        // Full Screen Toggle Function
        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        // Add this in a <script> tag or a separate JS file
        function toggleDarkMode() {
            const htmlElement = document.documentElement;
            const isDarkMode = htmlElement.classList.toggle('dark');
            
            // Save the user preference in localStorage
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        }

        // Notifications Toggle Function
        function toggleNotifications() {
            const popup = document.getElementById('notificationPopup');
            popup.classList.toggle('hidden');
        }

        // User Dropdown Toggle Function
        function toggleUserDropdown() {
           
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleToolsDropdown() {
          //  alert('hi');
            const dropdown = document.getElementById('toolsDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleProjectsDropdown(){
            // alert('ok');
            const dropdown = document.getElementById('projects-dropdown-toggle');
            dropdown.classList.toggle('hidden');            
        }

        // Close notifications popup when clicking outside
        document.addEventListener('click', function(event) {
            //alert('ok');
            //document.getElementById('toolsDropdown').classList.toggle('hidden');
            const toolPopup = document.getElementById('toolsDropdown');
            const toolButton = event.target.closest('button[onclick="toggleToolsDropdown()"]');

            const projectPopup = document.getElementById('projects-dropdown-toggle');
            const projectButton = event.target.closest('button[onclick="toggleProjectsDropdown()"]');

            const notificationPopup = document.getElementById('notificationPopup');
            const notificationButton = event.target.closest('button[onclick="toggleNotifications()"]');
            const userDropdown = document.getElementById('userDropdown');
            const userButton = event.target.closest('button[onclick="toggleUserDropdown()"]');
            
            if (!notificationButton && !notificationPopup.contains(event.target)) {
                notificationPopup.classList.add('hidden');
            }
            
  

            if (!toolButton && !toolPopup.contains(event.target)) {
                toolPopup.classList.add('hidden');
            }

            if (!projectButton && !projectPopup.contains(event.target)) {
                projectPopup.classList.add('hidden');
            }

            if (!userButton && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });

 
     function selectProject(projectName , projectId) {

            // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

            // let fetchRes = await fetch(url);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('projects.store_id_session') }}",
                type: "POST",
                data: { projectID: projectId ,  projectName:projectName,_token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function(data) {
                    if(data.success){
                        //console.log(data);
                        const selectedProjectElement = document.getElementById("project-variable");
                        selectedProjectElement.textContent = projectName; // Update the displayed project name
                        const dropdown = document.getElementById('projects-dropdown-toggle');
                        dropdown.classList.toggle('active');
                        $('[name="project_id"]').val(projectId);
                        $('#selected_project_id').val(projectId);
                        $('#selected_project_name').val(projectName);
                       location.reload();
                    }


                }
            });
            //alert('ok2');

            //alert(projectId);
 
            //toggleDropdown(); // Close the dropdown after selection
    }
		
 	
		
    </script>
    </div>
</header>
<header class="fixed z-10 w-[100vw] h-[7rem] md:h-[4rem] left-0 top-0 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-200 shadow px-6 py-2">
    <div class="flex justify-between items-start md:items-center">
        <div class="relative flex flex-col md:flex-row md:items-center gap-3">
            <a href="/" class="block relative md:mt-[-6px] w-24">
                <img src="{{ asset('images/logo-dark.png') }}" class="dark:hidden" alt="">
                <img src="{{ asset('images/logo-light.png') }}" class="hidden dark:block" alt="">
            </a>

            <div class="toolbox flex flex-nowrap gap-2 absolute md:static left-0 top-[140%] w-[90vw] md:w-auto">
                <div class="w-2/5 sm:w-auto has-dropdown relative inline-block text-left z-2">
                    <!-- Dropdown Toggle Button -->
                    <button class="dropdown-toggle w-full flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-800">
                        <span id="selected-project" class="flex flex-col items-start text-xs mr-2 font-medium me-auto">Project<b id="project-variable">{{  session('projectName')  }}</b></span>
                        <i data-feather="chevron-down"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div  id="dropdown-toggle" class="dropdown absolute left-0 mt-2 min-w-full w-[130%] bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-lg hidden">
                        <ul class="py-2">
                            <!-- List of Projects (Replace these with dynamic content) -->
                            @if($projects->count() > 0) 
                                @foreach($projects as $project)

                                    <li>
                                        <button onclick="selectProject('{{ $project->name }}' , '{{ $project->id }}')" class="block text-xs w-full text-left px-4 py-2 hover:bg-black/10 projectButton">{{ $project->name }}</button>
                                    </li>
                                @endforeach
                            @endif

                            <li class="px-3 pt-2">
                            <a href="{{ route('projects') }}" class="text-xs inline-flex w-full px-3 py-1 bg-gray-600 hover:bg-blue-700 text-white font-medium">
                                All Projects
                            </a>
                            </li>
                            <li class="px-3 pt-2">
                            <a href="{{ route('projects.create') }}" class="text-xs inline-flex items-center w-full px-3 py-1 bg-blue-900 hover:bg-blue-700 text-white">
                                <i data-feather="plus" class="mr-1"></i> New Project
                            </a>
                            </li>
                            <!-- Add more projects as needed -->
                        </ul>
                    </div>
                </div>
                @include('metsl.pages.projects.tools')
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
            <div class="relative">
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
            <div class="relative">
                <button onclick="toggleUserDropdown()" class="rounded-full flex items-center pl-1 py-1 pr-1 md:pr-2 lg:pr-4 bg-gray-200 dark:bg-gray-800">
                    <!-- User Image -->
                    <img src="https://placehold.co/32" alt="User" class="min-w-7 md:min-w-9 w-7 md:w-9 h-7 md:h-9 md:mr-2 rounded-full">
                    <!-- User Name -->
                    <div class="text-xs flex-col items-start hidden md:flex">
                        <span>Welcome,</span>
                        <span class="font-bold">{{ auth()->user()->name }}</span>
                    </div>   
                </button>
                <!-- User Dropdown Menu -->
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-lg  py-2 z-10">
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100/25"><i data-feather="user" class="mr-3"></i>Profile</a>
                    <a href="{{ route('roles') }}" class="flex items-center px-4 py-2 hover:bg-gray-100/25"><i data-feather="git-pull-request" class="mr-3"></i>Role Management</a>
                    <!-- Dark/Light Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="flex w-full items-center px-4 py-2 hover:bg-gray-100/25">
                        <i data-feather="moon" class="mr-3"></i>Toggle Theme
                    </button>
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100/25"><i data-feather="settings" class="mr-3"></i>Settings</a>

                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="text-left text-gray-700 dark:text-gray-300 hover:bg-red-900/25 hover:text-red-400 px-4 py-2 w-full">
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

        // Close notifications popup when clicking outside
        document.addEventListener('click', function(event) {
            const notificationPopup = document.getElementById('notificationPopup');
            const notificationButton = event.target.closest('button[onclick="toggleNotifications()"]');
            const userDropdown = document.getElementById('userDropdown');
            const userButton = event.target.closest('button[onclick="toggleUserDropdown()"]');
            
            if (!notificationButton && !notificationPopup.contains(event.target)) {
                notificationPopup.classList.add('hidden');
            }
            
            if (!userButton && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });

 
        function selectProject(projectName , projectId) {
            const selectedProjectElement = document.getElementById("project-variable");
            selectedProjectElement.textContent = projectName; // Update the displayed project name
            const dropdown = document.getElementById('dropdown-toggle');
            dropdown.classList.toggle('hidden');
			$('[name="project_id"]').val(projectId);
            //alert(projectId);
            $.ajax({
                url: "{{ route('projects.store_id_session') }}",
                data: { projectID: projectId ,  projectName:projectName}
            });  
            //toggleDropdown(); // Close the dropdown after selection
        }
		
 	
		
    </script>
    </div>
</header>
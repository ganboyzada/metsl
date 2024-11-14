<header class="bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-200 shadow px-6 py-4">
    <div class="flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="relative mt-[-6px]">
                <img src="{{ asset('images/logo-dark.png') }}" class="h-8 dark:hidden" alt="">
                <img src="{{ asset('images/logo-light.png') }}" class="h-8 hidden dark:block" alt="">
            </div>

            <div class="relative inline-block text-left z-10">
                <!-- Dropdown Toggle Button -->
                <button onclick="toggleDropdown()" class="flex items-center px-4 py-2 bg-gray-200 dark:bg-white/5 rounded-md">
                    <span id="selected-project" class="mr-2 font-medium">Project: Bridgex Construction</span>
                    <i class="fas fa-chevron-down"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdown" class="absolute left-0 mt-2 w-full bg-gray-800 text-gray-200 rounded-md shadow-lg hidden">
                    <ul class="py-2">
                        <!-- List of Projects (Replace these with dynamic content) -->
                        <li>
                            <button onclick="selectProject('Project A')" class="block w-full text-left px-4 py-2 hover:bg-black/10">Project A</button>
                        </li>
                        <li>
                            <button onclick="selectProject('Project B')" class="block w-full text-left px-4 py-2 hover:bg-black/10">Project B</button>
                        </li>
                        <li>
                            <button onclick="selectProject('Project C')" class="block w-full text-left px-4 py-2 hover:bg-black/10">Project C</button>
                        </li>

                        <li class="px-3 pt-2">
                        <a href="{{ route('projects.create') }}" class="inline-flex w-full text-center px-4 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium">
                            <i data-feather="plus" class="inline-block mr-1"></i> Create New Project
                        </a>
                        </li>
                        <!-- Add more projects as needed -->
                    </ul>
                    
                    <!-- Create New Project Button -->
                    
                </div>

                
            </div>

            @yield('header')
        </div>
        
        <!-- Add user info or notifications here if needed -->

        <!-- Right side icons -->
    <div class="flex items-center space-x-6">
        <!-- Language Switcher -->
        <button>
        <i data-feather="globe"></i>
        </button>

        <!-- Full Screen Toggle -->
        <button onclick="toggleFullScreen()">
        <i data-feather="maximize"></i>
        </button>

        <!-- Dark/Light Mode Toggle -->
        <button onclick="toggleDarkMode()">
        <i data-feather="moon"></i>
        </button>

        <!-- Notifications with Badge -->
        <div class="relative">
            <button onclick="toggleNotifications()">
                <i data-feather="bell"></i>
                <!-- Notification count badge -->
                <span class="absolute bottom-4 left-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">3</span>
            </button>
            <!-- Notification Popup -->
            <div id="notificationPopup" class="hidden absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg p-4 z-10">
                <p class="font-semibold mb-2">Notifications</p>
                <div class="space-y-2">
                    <p class="text-gray-600 text-sm">Notification 1</p>
                    <p class="text-gray-600 text-sm">Notification 2</p>
                    <p class="text-gray-600 text-sm">Notification 3</p>
                </div>
            </div>
        </div>

        <!-- User Profile and Dropdown -->
        <div class="relative pl-5">
            <button onclick="toggleUserDropdown()" class="flex items-center space-x-2">
                <!-- User Image -->
                <img src="https://via.placeholder.com/32" alt="User" class="w-9 h-9 rounded-full">
                <!-- User Name -->
                <div class="flex flex-col items-start">
                    <span class="text-sm">Welcome,</span>
                    <span class="">{{ auth()->user()->name }}</span>
                </div>
                
                
            </button>
            <!-- User Dropdown Menu -->
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-lg rounded-lg py-2 z-10">
                <a href="#" class="block px-4 py-2 hover:bg-gray-100/25"><i data-feather="user" class="mr-3"></i>Profile</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100/25"><i data-feather="settings" class="mr-3"></i>Settings</a>
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

        // Check user preference on page load
        document.addEventListener('DOMContentLoaded', () => {
            const userPreference = localStorage.getItem('theme');
            
            if (userPreference === 'dark' || (!userPreference && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });

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

        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("hidden"); // Toggle the visibility of the dropdown
        }

        function selectProject(projectName) {
            const selectedProjectElement = document.getElementById("selected-project");
            selectedProjectElement.textContent = projectName; // Update the displayed project name
            toggleDropdown(); // Close the dropdown after selection
        }
    </script>
    </div>
</header>
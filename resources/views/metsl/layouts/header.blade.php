<header class="bg-white dark:bg-slate:800 shadow p-4">
    <div class="flex justify-between">
        <h1 class="text-xl font-bold">@yield('header')</h1>
        <!-- Add user info or notifications here if needed -->

        <!-- Right side icons -->
    <div class="flex items-center space-x-4">
        <!-- Language Switcher -->
        <button class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-globe fa-lg"></i>
        </button>

        <!-- Full Screen Toggle -->
        <button onclick="toggleFullScreen()" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-expand fa-lg"></i>
        </button>

        <!-- Dark/Light Mode Toggle -->
        <button onclick="toggleDarkMode()" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-moon fa-lg"></i>
        </button>

        <!-- Notifications with Badge -->
        <div class="relative">
            <button onclick="toggleNotifications()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bell fa-lg"></i>
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
        <div class="relative">
            <button onclick="toggleUserDropdown()" class="flex items-center space-x-2 text-gray-500 hover:text-gray-700">
                <!-- User Image -->
                <img src="https://via.placeholder.com/32" alt="User" class="w-8 h-8 rounded-full">
                <!-- User Name -->
                <span class="font-semibold">John Doe</span>
            </button>
            <!-- User Dropdown Menu -->
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2 z-10">
                <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Settings</a>
                <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100">Sign Out</a>
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
    </script>
    </div>
</header>
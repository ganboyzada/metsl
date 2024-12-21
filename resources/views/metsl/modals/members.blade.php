<div id="user-circle-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800  p-6 w-full max-w-2xl relative">
        <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Your Circle</h3>
        
        <!-- User List -->
        <ul id="user-list" class="space-y-4">
            <!-- Users will be dynamically added here -->
        </ul>

        <!-- Add User Button -->
        <div class="mt-6 text-right">
            <button id="add-user-button" class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                <i data-feather="user-plus" class="w-5 h-5"></i>
                <span>Add User</span>
            </button>
        </div>

        <!-- Close Modal -->
        <button onclick="toggleModal('user-circle-modal', 'close');" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100" onclick="closeUserCircleModal()">
            <i data-feather="x" class="w-5 h-5"></i>
        </button>
    </div>
</div>
<script>
    // Sample user data for the circle
let userCircle = [
    { id: 1, name: "Alice Johnson", email: "alice@example.com" },
    { id: 2, name: "Bob Smith", email: "bob@example.com" },
];

// Render the User List
function renderUserList() {
    const userList = document.getElementById('user-list');
    userList.innerHTML = ''; // Clear existing list

    userCircle.forEach(user => {
        const li = document.createElement('li');
       // li.classList.add('flex', 'items-center', 'space-x-4', 'p-4', 'border', '', 'bg-gray-100', 'dark:bg-gray-700');

        const avatar = document.createElement('div');
        avatar.classList.add('w-10', 'h-10', 'rounded-full', 'bg-blue-500', 'flex', 'items-center', 'justify-center', 'text-white', 'font-semibold');
        avatar.textContent = user.name[0]; // Initial of the user's name

        const details = document.createElement('div');
        details.classList.add('flex-1');
        details.innerHTML = `
            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">${user.name}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">${user.email}</p>
        `;

        li.appendChild(avatar);
        li.appendChild(details);
        userList.appendChild(li);
    });
}

renderUserList();

// Add New User Button
document.getElementById('add-user-button').addEventListener('click', () => {
    openCreateUserModal(); // Use the modal created earlier for adding users
});

</script>
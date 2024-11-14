@extends('metsl.layouts.master')

@section('title', 'Project Creation Wizard')

@section('header')
    <a href="{{ route('projects.find', 1) }}" class="flex items-center text-gray-600 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg font-medium">
    <i class="fas fa-arrow-left mr-2 text-gray-500"></i> Back to Project
</a>
@endsection

@section('content')
<div class="container mx-auto p-6 bg-white dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-md">
    <!-- Progress Indicator -->
    <div class="flex justify-between mb-6">
    <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">1. Project Basics</div>
            <div id="progress-step-1" class="progress-step active h-2 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">2. Stakeholder Selection</div>
            <div id="progress-step-2" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">3. Role Assignment</div>
            <div id="progress-step-3" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">4. Workflow Setup</div>
            <div id="progress-step-4" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">5. Review & Submit</div>
            <div id="progress-step-5" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
    </div>

    <!-- Step 1: Project Basics -->
    <form id="projectWizard" method="POST" action="{{-- route('project.store') --}}">
        @csrf

        <div id="step1" class="wizard-step">
            <h2 class="text-2xl font-semibold mb-4">Project Basics</h2>
            <div class="mb-4">
                <label for="projectName" class="block font-medium text-gray-700 dark:text-gray-200">Project Name</label>
                <input type="text" name="projectName" id="projectName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block font-medium text-gray-700 dark:text-gray-200">Project Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200"></textarea>
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 mr-2">
                    <label for="startDate" class="block font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                    <input type="date" name="startDate" id="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200" required>
                </div>
                <div class="w-1/2 ml-2">
                    <label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">End Date</label>
                    <input type="date" name="endDate" id="endDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200">
                </div>
            </div>
            <button type="button" onclick="showStep(2)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Step 2: Stakeholder Selection -->
        <div id="step2" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Stakeholder Selection</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Clients Section -->
                <div id="clientSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Client</h3>
                    <div id="clientList">
                        <!-- Client selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('client')" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded mt-2">
                        <i data-feather="plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Project Manager Section -->
                <div id="projectManagerSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Project Manager</h3>
                    <div id="projectManagerList">
                        <!-- Project Manager selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('projectManager')" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded mt-2">
                        <i data-feather="plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Design Team Section -->
                <div id="designTeamSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Design Team</h3>
                    <div id="designTeamList">
                        <!-- Design Team selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('designTeam')" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded mt-2">
                        <i data-feather="plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Contractors Section -->
                <div id="contractorSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Contractors</h3>
                    <div id="contractorList">
                        <!-- Contractor selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('contractor')" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded mt-2">
                        <i data-feather="plus" class="mr-2"></i> Add User
                    </button>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <button type="button" onclick="showStep(1)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(3)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Overlay Modal for Creating New User -->
        <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Create New User</h3>
                <form id="createUserForm">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Name</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Surname</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Mobile Phone</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Office Phone</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Email (Login Credential)</label>
                        <input type="email" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Specialty</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="button" onclick="closeCreateUserModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create User</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Step 3: Role Assignment -->
        <div id="step3" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Role Assignment</h2>
            <p class="mb-2 text-gray-700 dark:text-gray-200">Assign specific roles to the stakeholders selected in the previous step.</p>

            <!-- Stakeholder Grid -->
            <div id="stakeholderGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Stakeholder cards will be generated here -->
            </div>

            <!-- Navigation Buttons -->
            <button type="button" onclick="showStep(2)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(4)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Role Assignment Modal -->
        <div id="roleAssignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200" id="modalStakeholderName">Assign Role to Stakeholder</h3>

                <!-- Role Assignment Form -->
                <form id="roleAssignmentForm" onsubmit="saveRoleAssignment(event)">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Custom Role Name</label>
                        <input type="text" id="customRoleName" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" placeholder="Enter custom role name (optional)" disabled>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Select Preset Role</label>
                        <select id="presetRoleSelect" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" onchange="applyPresetRole()">
                            <option value="">Choose a preset role...</option>
                            <option value="viewer">Viewer</option>
                            <option value="editor">Editor</option>
                            <option value="approver">Approver</option>
                            <!-- Add more roles as needed -->
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Custom Permissions</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="view" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2" onchange="handleCustomPermissions()"> View
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="edit" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2" onchange="handleCustomPermissions()"> Edit
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="delete" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2" onchange="handleCustomPermissions()"> Delete
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="approve" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2" onchange="handleCustomPermissions()"> Approve
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" onclick="closeRoleAssignmentModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Step 4: Additional Settings -->
        <div id="step4" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Workflow Setup</h2>
            <!-- Optional fields like milestones, budget, notes -->
            <button type="button" onclick="showStep(3)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(5)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Step 5: Review & Submit -->
        <div id="step5" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Review & Submit</h2>
            <p class="text-gray-700 dark:text-gray-200">Review all your information before submitting.</p>
            <!-- Display summary of project details -->
            <button type="button" onclick="showStep(4)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Submit Project</button>
        </div>
    </form>
</div>

@endsection

@push('js')

<!-- JavaScript for Wizard Step Navigation -->
<script>
    function showStep(step) {
        document.querySelectorAll('.wizard-step').forEach(stepDiv => stepDiv.classList.add('hidden'));
        document.getElementById(`step${step}`).classList.remove('hidden');

        // Update progress bar
        const progressSteps = document.querySelectorAll('.progress-step');
        progressSteps.forEach((el, index) => {
            if(index+1 <= step){
                el.classList.add('active');
            }
            else{
                el.classList.remove('active');
            }
            
        });
    }

    function removeStakeholder(element) {
        element.parentElement.remove();
    }

    // Toggle visibility of Create User Modal
    function openCreateUserModal() {
        document.getElementById("createUserModal").classList.remove("hidden");
    }

    function closeCreateUserModal() {
        document.getElementById("createUserModal").classList.add("hidden");
    }

    // Add a new stakeholder to the respective section
    function addStakeholder(type) {
        const listElement = document.getElementById(`${type}List`);
        const newStakeholder = document.createElement("div");
        newStakeholder.classList.add("flex", "items-center", "mb-2");

        newStakeholder.innerHTML = `
            <select name="${type}[]" class="block w-96 px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200 mr-2">
                <option value="" disabled selected>Select ${type.charAt(0).toUpperCase() + type.slice(1)}</option>
                <option value="user1">User 1</option>
                <option value="user2">User 2</option>
            </select>
            <button type="button" onclick="openCreateUserModal()" class="p-2 rounded-md bg-orange-600 inline-flex text-white">
                <i data-feather="user-plus"></i>
            </button>
        `;

        listElement.appendChild(newStakeholder);
        feather.replace({ 'stroke-width': 1 });
    }


// Sample stakeholder data; replace with actual data as needed
const stakeholders = [
    { id: 1, name: "John Doe", role: "", permissions: [] },
    { id: 2, name: "Sarah Smith", role: "", permissions: [] }
];

// Function to render stakeholder grid
function renderStakeholderGrid() {
    const grid = document.getElementById("stakeholderGrid");
    grid.innerHTML = ""; // Clear existing content

    stakeholders.forEach(stakeholder => {
        // Create stakeholder card
        const card = document.createElement("div");
        card.classList.add("bg-gray-100", "dark:bg-gray-700", "rounded-lg", "p-4", "shadow-md", "cursor-pointer");
        card.onclick = () => openRoleAssignmentModal(stakeholder);

        // Stakeholder info
        const name = document.createElement("h4");
        name.classList.add("text-lg", "font-semibold", "text-gray-800", "dark:text-gray-200");
        name.textContent = stakeholder.name;

        const role = document.createElement("p");
        role.classList.add("text-sm", "text-gray-600", "dark:text-gray-400");
        role.textContent = stakeholder.role || "No role assigned";

        const permissions = document.createElement("p");
        permissions.classList.add("text-sm", "text-gray-600", "dark:text-gray-400");
        permissions.textContent = stakeholder.permissions.length ? `Permissions: ${stakeholder.permissions.join(", ")}` : "No permissions assigned";

        // Append elements to card
        card.appendChild(name);
        card.appendChild(role);
        card.appendChild(permissions);

        // Append card to grid
        grid.appendChild(card);
    });
}

// Role presets with associated permissions
const rolePresets = {
    viewer: ["view"],
    editor: ["view", "edit"],
    approver: ["view", "edit", "approve"]
};

// Open modal for role assignment
let currentStakeholder = null;

function openRoleAssignmentModal(stakeholder) {
    currentStakeholder = stakeholder;
    document.getElementById("modalStakeholderName").textContent = `Assign Role to ${stakeholder.name}`;
    document.getElementById("customRoleName").value = stakeholder.role || "";
    document.getElementById("presetRoleSelect").value = ""; // Clear preset selection
    document.getElementById("customRoleName").disabled = true; // Initially disable custom role input

    // Reset permissions based on existing role
    document.querySelectorAll("#roleAssignmentForm input[type='checkbox']").forEach(checkbox => {
        checkbox.checked = stakeholder.permissions.includes(checkbox.value);
    });

    document.getElementById("roleAssignmentModal").classList.remove("hidden");
}

// Apply the selected preset role and its permissions
function applyPresetRole() {
    const selectedRole = document.getElementById("presetRoleSelect").value;
    const permissions = rolePresets[selectedRole] || [];

    // Check the appropriate permissions and disable custom role input
    document.querySelectorAll("#roleAssignmentForm input[type='checkbox']").forEach(checkbox => {
        checkbox.checked = permissions.includes(checkbox.value);
    });
    document.getElementById("customRoleName").value = selectedRole ? capitalize(selectedRole) : "";
    document.getElementById("customRoleName").disabled = true;
}

// Detect changes in custom permissions and enforce custom role input
function handleCustomPermissions() {
    // Clear preset selection and enable custom role input
    document.getElementById("presetRoleSelect").value = "";
    document.getElementById("customRoleName").value = ""; // Clear custom role name field
    document.getElementById("customRoleName").disabled = false;
}

// Save the role and permissions for the stakeholder
function saveRoleAssignment(event) {
    event.preventDefault();

    const role = document.getElementById("customRoleName").value || document.getElementById("presetRoleSelect").value;
    const permissions = Array.from(document.querySelectorAll("#roleAssignmentForm input[type='checkbox']:checked")).map(checkbox => checkbox.value);

    if (currentStakeholder) {
        // Save custom role and permissions to the stakeholder
        currentStakeholder.role = role || "Custom Role";
        currentStakeholder.permissions = permissions;
    }

    closeRoleAssignmentModal();
    renderStakeholderGrid(); // Update the grid display
}

// Helper functions
function closeRoleAssignmentModal() {
    document.getElementById("roleAssignmentModal").classList.add("hidden");
}

function capitalize(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

// Initialize the grid on page load
document.addEventListener("DOMContentLoaded", renderStakeholderGrid);
</script>

@endpush

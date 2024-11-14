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

            <!-- Role Assignment Fields -->
            <div id="roleAssignmentFields" class="space-y-4">
                <!-- Placeholder for dynamic role assignment fields -->
                <!-- Example format:
                <div class="mb-4">
                    <label class="block font-medium text-gray-700 dark:text-gray-200">[Stakeholder Name]</label>
                    <select class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200">
                        <option value="">Select Role</option>
                        <option value="role1">Role 1</option>
                        <option value="role2">Role 2</option>
                        <option value="role3">Role 3</option>
                    </select>
                </div>
                -->
            </div>

            <!-- Button to open role creation modal -->
            <button type="button" onclick="openRoleCreationModal()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded flex items-center">
                <i data-feather="plus" class="mr-2"></i> Add New Role
            </button>

            <!-- Navigation Buttons -->
            <button type="button" onclick="showStep(2)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(4)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Overlay Modal for Creating New Role -->
        <div id="createRoleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Create New Role</h3>
                
                <!-- Role Creation Form -->
                <form id="createRoleForm" onsubmit="createNewRole(event)">
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Role Name</label>
                        <input type="text" id="roleName" class="w-full px-4 py-2 border rounded-md dark:bg-gray-700 dark:text-gray-200" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Permissions</label>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Replace these options with your actual permissions -->
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="view" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2"> View
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="edit" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2"> Edit
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="delete" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2"> Delete
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" value="approve" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2"> Approve
                            </label>
                            <!-- Add more permissions as needed -->
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="button" onclick="closeRoleCreationModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Role</button>
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


    const roles = [
    { name: "Viewer", permissions: ["view"] },
    { name: "Editor", permissions: ["view", "edit"] },
    { name: "Manager", permissions: ["view", "edit", "approve"] }
];

const stakeholders = [
    { id: 1, name: "Client: John Doe" },
    { id: 2, name: "Project Manager: Sarah Smith" }
];

// Open and close role creation modal
function openRoleCreationModal() {
    document.getElementById("createRoleModal").classList.remove("hidden");
}

function closeRoleCreationModal() {
    document.getElementById("createRoleModal").classList.add("hidden");
}

// Create a new role and add it to the dropdown
function createNewRole(event) {
    event.preventDefault(); // Prevent form submission

    const roleName = document.getElementById("roleName").value;
    const selectedPermissions = Array.from(document.querySelectorAll("#createRoleForm input[type='checkbox']:checked"))
        .map(checkbox => checkbox.value);

    // Create new role object and add to roles array
    const newRole = { name: roleName, permissions: selectedPermissions };
    roles.push(newRole);

    // Close modal
    closeRoleCreationModal();

    // Update dropdowns with the new role
    updateRoleDropdowns(newRole);
}

// Function to dynamically populate role dropdowns for each stakeholder
function generateRoleAssignmentFields() {
    const roleAssignmentFields = document.getElementById("roleAssignmentFields");

    stakeholders.forEach(stakeholder => {
        const stakeholderDiv = document.createElement("div");
        stakeholderDiv.classList.add("mb-4");

        const label = document.createElement("label");
        label.classList.add("block", "font-medium", "text-gray-700", "dark:text-gray-200");
        label.textContent = stakeholder.name;

        const select = document.createElement("select");
        select.classList.add("w-full", "px-4", "py-2", "border", "rounded-md", "dark:bg-gray-700", "dark:text-gray-200");
        select.name = `role_${stakeholder.id}`;

        // Add default option
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = "Select Role";
        select.appendChild(defaultOption);

        // Populate predefined roles
        roles.forEach(role => {
            const option = document.createElement("option");
            option.value = role.name;
            option.textContent = role.name;
            select.appendChild(option);
        });

        stakeholderDiv.appendChild(label);
        stakeholderDiv.appendChild(select);
        roleAssignmentFields.appendChild(stakeholderDiv);
    });
}

// Function to add new role to existing dropdowns
function updateRoleDropdowns(newRole) {
    const selects = document.querySelectorAll("#roleAssignmentFields select");
    selects.forEach(select => {
        const option = document.createElement("option");
        option.value = newRole.name;
        option.textContent = newRole.name;
        select.appendChild(option);
    });
}

// Call this when displaying the role assignment step
document.addEventListener("DOMContentLoaded", function() {
    generateRoleAssignmentFields();
});
</script>

@endpush

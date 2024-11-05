@extends('metsl.layouts.master')

@section('title', 'Project Creation Wizard')

@section('header')
    <a href="{{ route('company.detail', 1) }}" class="flex items-center text-gray-600 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg font-medium">
    <i class="fas fa-arrow-left mr-2 text-gray-500"></i> Back to Company
</a>
@endsection

@section('content')
<div class="container mx-auto p-6 bg-white dark:bg-gray-900 rounded-lg shadow-md">
    <!-- Progress Indicator -->
    <div class="flex justify-between mb-6">
    <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">1. Project Basics</div>
            <div id="progress-step-1" class="h-2 bg-blue-500 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">2. Stakeholder Selection</div>
            <div id="progress-step-2" class="h-2 bg-gray-300 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">3. Role Assignment</div>
            <div id="progress-step-3" class="h-2 bg-gray-300 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">4. Additional Settings</div>
            <div id="progress-step-4" class="h-2 bg-gray-300 rounded-full mt-2"></div>
        </div>
        <div class="w-1/5 text-center">
            <div class="text-sm font-semibold">5. Review & Submit</div>
            <div id="progress-step-5" class="h-2 bg-gray-300 rounded-full mt-2"></div>
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
                    <button type="button" onclick="addStakeholder('client')" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Add Client</button>
                </div>

                <!-- Project Manager Section -->
                <div id="projectManagerSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Project Manager</h3>
                    <div id="projectManagerList">
                        <!-- Project Manager selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('projectManager')" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Add Project Manager</button>
                </div>

                <!-- Design Team Section -->
                <div id="designTeamSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Design Team</h3>
                    <div id="designTeamList">
                        <!-- Design Team selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('designTeam')" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Add Design Team Member</button>
                </div>

                <!-- Contractors Section -->
                <div id="contractorSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Contractor</h3>
                    <div id="contractorList">
                        <!-- Contractor selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('contractor')" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Add Contractor</button>
                </div>
            </div>
            

            <!-- Navigation Buttons -->
            <button type="button" onclick="showStep(1)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(3)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Step 3: Role Assignment -->
        <div id="step3" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Role Assignment</h2>
            <p class="mb-2 text-gray-700 dark:text-gray-200">Assign specific roles to the stakeholders selected in the previous step.</p>
            <!-- Role Assignment Fields -->
            <button type="button" onclick="showStep(2)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(4)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Step 4: Additional Settings -->
        <div id="step4" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Additional Settings</h2>
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

<!-- JavaScript for Wizard Step Navigation -->
<script>
    function showStep(step) {
        document.querySelectorAll('.wizard-step').forEach(stepDiv => stepDiv.classList.add('hidden'));
        document.getElementById(`step${step}`).classList.remove('hidden');

        // Update progress bar
        const progressSteps = document.querySelectorAll('.progress-step');
        progressSteps.forEach((el, index) => {
            el.classList.toggle('bg-blue-500', index < step);
            el.classList.toggle('bg-gray-300', index >= step);
        });
    }

    document.addEventListener('DOMContentLoaded', () => showStep(1));
</script>

<!-- JavaScript for Wizard Step Navigation -->
<script>
    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(stepDiv => stepDiv.classList.add('hidden'));
        // Show the current step
        document.getElementById(`step${step}`).classList.remove('hidden');

        // Update progress indicator
        for (let i = 1; i <= 5; i++) {
            const progressStep = document.getElementById(`progress-step-${i}`);
            if (i <= step) {
                progressStep.classList.remove('bg-gray-300');
                progressStep.classList.add('bg-blue-500');
            } else {
                progressStep.classList.remove('bg-blue-500');
                progressStep.classList.add('bg-gray-300');
            }
        }
    }

    // Initialize with the first step
    document.addEventListener('DOMContentLoaded', () => showStep(1));
</script>

<script>
    function addStakeholder(type) {
        const listElement = document.getElementById(`${type}List`);
        const newStakeholder = document.createElement('div');
        newStakeholder.classList.add('flex', 'items-center', 'mb-2');
        newStakeholder.innerHTML = `
            <select name="${type}[]" class="block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 mr-2">
                <option value="" disabled selected>Select ${type.charAt(0).toUpperCase() + type.slice(1)}</option>
                <!-- Example options, replace with dynamic data -->
                <option value="${type}1">${type.charAt(0).toUpperCase() + type.slice(1)} 1</option>
                <option value="${type}2">${type.charAt(0).toUpperCase() + type.slice(1)} 2</option>
            </select>
            <button type="button" onclick="removeStakeholder(this)" class="text-red-500 hover:text-red-700 ml-2">
                <i class="fas fa-trash-alt"></i>
            </button>
        `;
        listElement.appendChild(newStakeholder);
    }

    function removeStakeholder(element) {
        element.parentElement.remove();
    }
</script>
@endsection

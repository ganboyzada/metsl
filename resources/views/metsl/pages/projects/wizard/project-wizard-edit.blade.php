@extends('metsl.layouts.master')

@section('title', 'Project Creation Wizard')

@section('header')
    <a href="{{ route('projects.find', 1) }}" class="flex items-center text-gray-600 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 px-4 py-2  font-medium">
    <i class="fas fa-arrow-left mr-2 text-gray-500"></i> Back to Project
</a>
@endsection

@section('content')
<style>
        .search-container {
      position: relative;
      width: 300px;
    }

    #email {
      width: 100%;
      padding: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .search-results {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      border: 1px solid #ccc;
      border-top: none;
      background: white;
      z-index: 1000;
      max-height: 200px;
      overflow-y: auto;
      display: none;
    }

    .search-results div {
      padding: 8px;
      cursor: pointer;
      color:rgb(17 24 39 / 1);
    }

    .search-results div:hover {
      background-color: #f0f0f0;
    }
</style>
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
@if(session()->has('success'))
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
    {{ session()->get('success') }}
</div>
@endif 
<div class="container mx-auto p-6 bg-white dark:bg-gray-900 dark:text-gray-100  shadow-md">
    <!-- Progress Indicator -->
    <div class="grid grid-cols-4 justify-between mb-6">
    <div class="text-center">
            <div class="text-sm font-semibold">1. Project Basics</div>
            <div id="progress-step-1" class="progress-step active h-2 rounded-full mt-2"></div>
        </div>
        <div class="text-center">
            <div class="text-sm font-semibold">2. Project Team Selection</div>
            <div id="progress-step-2" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
        <div class="text-center">
            <div class="text-sm font-semibold">3. Role Assignment</div>
            <div id="progress-step-3" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
        {{--<div class="text-center">
            <div class="text-sm font-semibold">4. Workflow Setup</div>
            <div id="progress-step-4" class="progress-step h-2 rounded-full mt-2"></div>
        </div>--}}
        <div class="text-center">
            <div class="text-sm font-semibold">4. Review & Submit</div>
            <div id="progress-step-4" class="progress-step h-2 rounded-full mt-2"></div>
        </div>
    </div>

    <!-- Step 1: Project Basics -->
	@if(checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects') || auth()->user()->id == $project->created_by)

    <form id="projectWizard" method="POST" enctype="multipart/form-data">
        @csrf
	@endif	
        <input type="hidden" name="id" value="{{ $project->id }}"/>

        <div id="step1" class="wizard-step">
            <h2 class="text-2xl font-semibold mb-4">Project Basics</h2>
            <div class="gap-6 grid md:grid-cols-2 lg:grid-cols-3">
                <div>
                    <div class="mb-4">
                        <label for="projectName" class="block font-medium text-gray-700 dark:text-gray-200">Project Name</label>
                        <input type="text" name="name" id="projectName" class="mt-1 block w-full  shadow-sm dark:bg-gray-800 dark:text-gray-200" value="{{$project->name}}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block font-medium text-gray-700 dark:text-gray-200">Project Description</label>
                        <textarea name="description"  id="description" class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200">{{ $project->description }}</textarea>
                    </div>
                </div>
                
                <div>
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="startDate" class="block font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                            <input type="date" name="start_date" id="startDate" value="{{$project->start_date}}" class="mt-1 block w-full  shadow-sm dark:bg-gray-800 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">End Date</label>
                            <input type="date"  name="end_date" id="endDate" value="{{$project->end_date}}" class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200">
                        </div>
                    </div>
                
                    <div class="flex flex-col w-full">
                        <label for="startDate" class="block mb-2 font-medium text-gray-700 dark:text-gray-200">Project Official Documents</label>
                        <!-- Drag-and-Drop Zone -->
                        <label for="file-upload" id="drop-zone" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed  cursor-pointer bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i data-feather="upload" class="w-10 h-10 text-gray-500 dark:text-gray-400"></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG, GIF (max. 5MB)</p>
                            </div>
                            <input id="file-upload" name="docs[]" accept="image/*" type="file" class="hidden" multiple  onchange="loadFiles(event)">
                        </label>

                        <!-- File List -->
                        <ul id="file-list" class="mt-4 text-sm text-gray-600 dark:text-gray-300">

                            @if ($project->files->count()  > 0)
                            <ul  class="mt-4 space-y-2">
                                @foreach ( $project->files as $file )
                                    <li class="flex justify-between"><a href="{{ asset('storage/project'.$project->id.'/'.$file->name)  }}" target="_blank">{{ $file->name  }}   ( {{ $file->size != NULL ? round($file->size/1024 , 2) : 0  }} kb )</a>
                                        <a href="{{ route('projects.destroy-file',[$file->id]) }}" class="text-red-500 dark:text-red-400 hover:text-red-300">
                                            <i data-feather="delete" class="w-5 h-5"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>   
                            @endif
                        </ul>
                    </div>
                    
                </div>
                <div>

                    <div class="grid lg:grid-cols-1  md:grid-cols-1 gap-4">
                        <div class="mb-4">
                            <label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">status</label>
                            <select name="status" id="status"class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200">
                                @php
                                $status_list = \App\Enums\ProjectStatusEnum::cases();
                                @endphp
                                @foreach ($status_list as $status)
                                    <option value="{{$status->value}}"{{ $project->status->value == $status->value ? 'selected' : '' }}>{{$status->name }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="mb-4">
                            <label for="startDate" class="block font-medium text-gray-700 dark:text-gray-200">logo</label>
                            <input type="file" name="logo" id="logo" class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200" >
                            <img src="{{ $project->logo  }}" class="w-32 h-32 object-cover mt-2"/>
                        </div>

                    </div>
                </div>
                
            </div>
        
            <button type="button" onclick="showStep(2); sendValueToReviewTab();" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

        <!-- Step 2: Stakeholder Selection -->
        <div id="step2" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Project Team Selection</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <!-- Clients Section -->
                <div id="clientSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Client</h3>
                    <div id="clientList">
                        @if ($project->clients->count() > 0)
                            @php $i = 0; @endphp
                            @foreach ($project->clients as $selected_user)
                            <div class="flex items-center mb-2 client{{$i}}">
                            <select onchange="add_others_data_to_selected_user(this ,'client',{{ $i }})" name="client[]" id="client.{{ $i }}" index="{{ $i }}" class="block w-96 px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200 mr-2">
                               <option value="" disabled>select client</option>
                                @foreach ($users as $user)
                                @if ($selected_user->id == $user->id)
                                    <option value="{{ $user->id }}" uuid="{{ $user->id }}" image="{{ $user->profile_photo_path }}"
                                     company="{{ $selected_user->pivot->company_id }}" specialty="{{ $selected_user->pivot->specialty }}"
                                      office_phone="{{ $selected_user->pivot->office_phone }}"
                                     
                                     name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                     {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}" uuid="{{ $user->id }}" image="{{ $user->profile_photo_path }}"
                                     
                                     name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                     {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>     
                                    
                                @endif
                                
                                @endforeach
                               
                            </select>
                            <button type="button" onclick="openCreateUserModal('client' , '{{ $i }}')" class="p-2 rounded-md bg-orange-600 inline-flex text-white">
                
                                <i data-feather="user-plus"></i>
                            </button>
                            </div>
                            @php $i++; @endphp
                                
                            @endforeach
                            
                        @endif
                        <!-- Client selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('client')" class="flex items-center bg-gray-200 dark:bg-gray-600 dark:text-white px-3 py-1 rounded-full mt-2">
                        <i data-feather="user-plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Project Manager Section -->
                <div id="projectManagerSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Project Manager</h3>
                    <div id="projectManagerList">
                        @if ($project->projectMangers->count() > 0)
                            @php $i = 0; @endphp
                            @foreach ($project->projectMangers as $selected_user)
                                <div class="flex items-center mb-2 projectManager{{$i}}">
                                <select onchange="add_others_data_to_selected_user(this ,'projectManager',{{ $i }})" name="projectManager[]" id="projectManager.{{ $i }}" index="{{ $i }}" class="block w-96 px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200 mr-2">
                                <option value="" disabled>select projectManager</option>
                                    @foreach ($users as $user)
                                @if ($selected_user->id == $user->id)
                                    <option value="{{ $user->id }}" uuid="{{ $user->id }}" image="{{ $user->profile_photo_path }}"
                                     company="{{ $selected_user->pivot->company_id }}" specialty="{{ $selected_user->pivot->specialty }}"
                                      office_phone="{{ $selected_user->pivot->office_phone }}"
                                     
                                     name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                     {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}" uuid="{{ $user->id }}" image="{{ $user->profile_photo_path }}"
                                     
                                     name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                     {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>     
                                    
                                @endif
                                
                                @endforeach
                                
                                </select>
                                <button type="button" onclick="openCreateUserModal('projectManager' , '{{ $i }}')" class="p-2 rounded-md bg-orange-600 inline-flex text-white">
                    
                                    <i data-feather="user-plus"></i>
                                </button>
                                </div>
                            @php $i++; @endphp
                                
                            @endforeach
                        
                        @endif
                        <!-- Project Manager selection template will be inserted here -->
                    </div>
                    <button type="button" onclick="addStakeholder('projectManager')" class="flex items-center bg-gray-200 dark:bg-gray-600 dark:text-white px-3 py-1 rounded-full mt-2">
                        <i data-feather="user-plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Design Team Section -->
                <div id="designTeamSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Design Team</h3>
                    <div id="designTeamList">
                        <!-- Design Team selection template will be inserted here -->
                        @if ($project->designTeams->count() > 0)
                            @php $i = 0; @endphp
                            @foreach ($project->designTeams as $selected_user)
                            <div class="flex items-center mb-2 designTeam{{$i}}">
                                <select onchange="add_others_data_to_selected_user(this ,'designTeam',{{ $i  }})" name="designTeam[]" id="designTeam.{{ $i }}" index="{{ $i }}" class="block w-96 px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200 mr-2">
                                    <option value="" disabled>select designTeam</option>
                                    @foreach ($users as $user)
                                    @if ($selected_user->id == $user->id)
                                        <option value="{{ $user->id }}" uuid="{{ $user->id }}" image="{{ $user->profile_photo_path }}"
                                        company="{{ $selected_user->pivot->company_id }}" specialty="{{ $selected_user->pivot->specialty }}"
                                        office_phone="{{ $selected_user->pivot->office_phone }}"
                                        
                                        name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                        {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>
                                    @else
                                    <option value="{{ $user->id }}" uuid="{{ $user->id }}" image="{{ $user->profile_photo_path }}"
                                        
                                        name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                        {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>     
                                        
                                    @endif
                                    
                                    @endforeach
                                
                                </select>
                                <button type="button" onclick="openCreateUserModal('designTeam' , '{{ $i }}')" class="p-2 rounded-md bg-orange-600 inline-flex text-white">
                    
                                    <i data-feather="user-plus"></i>
                                </button>
                            </div>
                            @php $i++; @endphp
                                
                            @endforeach
                    
                        @endif
                    </div>
                    <button type="button" onclick="addStakeholder('designTeam')" class="flex items-center bg-gray-200 dark:bg-gray-600 dark:text-white px-3 py-1 rounded-full mt-2">
                        <i data-feather="user-plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Contractors Section -->
                <div id="contractorSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Contractors</h3>
                    <div id="contractorList">
                        <!-- Contractor selection template will be inserted here -->
                        @if ($project->contractors->count() > 0)
                        @php $i = 0; @endphp
                        
                        @foreach ($project->contractors as $selected_user)
                        <div class="flex items-center mb-2 contractor{{$i}}">
                            <select onchange="add_others_data_to_selected_user(this ,'contractor',{{ $i }})" name="contractor[]" id="contractor.{{ $i }}" index="{{ $i }}" class="block w-96 px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200 mr-2">
                                <option value="" disabled>select contractor</option>
                                @foreach ($users as $user)
                                @if ($selected_user->id == $user->id)
                                    <option value="{{ $user->id }}" uuid="{{ $user->id }}"  image="{{ $user->profile_photo_path }}"
                                     company="{{ $selected_user->pivot->company_id }}" specialty="{{ $selected_user->pivot->specialty }}"
                                      office_phone="{{ $selected_user->pivot->office_phone }}"
                                     
                                     name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                     {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>
                                @else
                                <option value="{{ $user->id }}" uuid="{{ $user->id }}"  image="{{ $user->profile_photo_path }}"
                                     
                                     name="{{ $user->name }}" email="{{ $user->email }}" phone="{{ $user->mobile_phone }}"
                                     {{ $selected_user->id == $user->id ? 'selected' : '' }}   >{{ $user->name }}</option>     
                                    
                                @endif
                                
                                @endforeach
                            
                            </select>
                            <button type="button" onclick="openCreateUserModal('contractor' , '{{ $i }}')" class="p-2 rounded-md bg-orange-600 inline-flex text-white">
                
                                <i data-feather="user-plus"></i>
                            </button>
                        </div>    
                        @php $i++; @endphp
                            
                        @endforeach
                
                    @endif
                    </div>
                    <button type="button" onclick="addStakeholder('contractor')" class="flex items-center bg-gray-200 dark:bg-gray-600 dark:text-white px-3 py-1 rounded-full mt-2">
                        <i data-feather="user-plus" class="mr-2"></i> Add User
                    </button>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <button type="button" onclick="showStep(1)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(3)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>

       
        <!-- Step 3: Role Assignment -->
        <div id="step3" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Role Assignment</h2>
            <p class="mb-2 text-gray-700 dark:text-gray-200">Assign specific roles to the Project Team selected in the previous step.</p>

            <!-- Stakeholder Grid -->
            <div id="stakeholderGrid" class="stakeholder-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Stakeholder cards will be generated here -->
            </div>

            <!-- Navigation Buttons -->
            <button type="button" onclick="showStep(2)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(4)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>

        </div>

      
        {{--
        <!-- Step 4: Additional Settings -->
        <div id="step4" class="wizard-step hidden">
            <h2 class="text-2xl font-semibold mb-4">Workflow Setup</h2>
            <!-- Optional fields like milestones, budget, notes -->
            <button type="button" onclick="showStep(3)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="button" onclick="showStep(5)" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
        </div>
        --}}

        <!-- Step 5: Review & Submit -->
        <div id="step4" class="wizard-step hidden">
        
            @include('metsl.pages.projects.wizard.review_step',['files'=>$project->files])

            <!-- Display summary of project details -->
            <button type="button" onclick="showStep(3)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            @if(checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects') || auth()->user()->id == $project->created_by)

			<button type="submit"id="submit_project_form" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Submit Project</button>
			@endif
		</div>
	@if(checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects') || auth()->user()->id == $project->created_by)

    </form>
	@endif
       <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 p-6 w-full max-w-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200" id="model_user_title">Create New User</h3>
                    <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    
    
                    <form id="createUserForm"   enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="user_type" name="user_type">
                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="user_index" name="user_index">
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">image</label>
                            <input   accept="image/*" id="profile_image" type="file" name="image" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" >
                        </div>                    
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="company_id" class="block text-sm mb-4 font-medium dark:text-gray-200">Company (Optional)</label>
                                <select name="company_id" id="user_company" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" id="company_id">
                                    <option value="" selected>None</option>
                                @foreach(\App\Models\Company::where('active', true)->get() as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                                </select>
                            </div>


                            <div class="search-container md:col-span-2">
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Email (Login Credential)</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                                <div id="results" class="search-results"></div>
                            </div>


                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Name</label>
                                <input type="text" id="first_name" name="first_name" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Surname</label>
                                <input type="text" id="last_name" name="last_name" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Mobile Phone</label>
                                <input type="text" id="phone" name="mobile_phone" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Office Phone</label>
                                <input type="text" name="office_phone" id="office_phone" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 dark:text-gray-200 mb-1">Specialty</label>
                                <input type="text" name="specialty" id="specialty" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="closeCreateUserModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                            <button type="submit" id="submitBtn" class="bg-blue-500 text-white px-4 py-2">Please Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
    
    
            
            <!-- Role Assignment Modal -->
            <div id="roleAssignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 p-6 w-full max-w-lg max-h-[90vh] overflow-y-scroll">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200" id="modalStakeholderName">Assign Role to Project Team</h3>
    
                    <!-- Role Assignment Form -->
                    <form id="roleAssignmentForm" onsubmit="saveRoleAssignment(event)">
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Job title</label>
                            <input type="text" id="job_title" name="job_title" class="w-full px-4 py-2 border dark:bg-gray-700 dark:text-gray-200" placeholder="e.g, Electrical Engineer">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Custom Role Name</label>
                            <input type="text" id="customRoleName" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" placeholder="Enter custom role name (optional)" disabled>
                        </div>
    
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Select Preset Role</label>
                            <select id="presetRoleSelect" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" onchange="applyPresetRole()">
                                <option value="">Choose a preset role...</option>
                                @if($roles->count() > 0)
                                    @foreach($roles as $role)                               
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>                                                      
                                    @endforeach
                                @endif
    
                                <!-- Add more roles as needed -->
                            </select>
                        </div>
    
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-3">Custom Permissions</label>
                            <div class="grid grid-cols-2 gap-6">
                                @if($permissions->count() > 0)
                                @foreach($permissions as $permission)  
                                <div class="checkbox-wrapper-47"> 
                                    <input type="checkbox" id="p-{{ $permission->id }}" value="{{  $permission->name }}" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2" 
                                    onchange="handleCustomPermissions()">
                                    <label class="text-sm" for="p-{{ $permission->id }}">
                                         {{ ucwords(str_replace("_"," ",$permission->name)) }}
                                    </label>          
                                </div>                                              
                                @endforeach
                                @endif
                            </div>
                        </div>
    
                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="closeRoleAssignmentModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                             @if(checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects') || auth()->user()->id == $project->created_by)
							<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
							@endif
                        </div>
                    </form>
                </div>
            </div>
</div>

@endsection

@push('js')


<!-- JavaScript for Wizard Step Navigation -->
<script>
        const searchInput  = document.getElementById("email");
    const resultsDiv = document.getElementById("results");
    const firstNameInput = document.getElementById("first_name");
    const lastNameInput = document.getElementById("last_name");
    const phoneInput = document.getElementById("phone");
    const user_id = document.getElementById("user_id");

 let debounceTimer;

    searchInput.addEventListener("input", function () {
      const query = this.value.trim();
      clearTimeout(debounceTimer);

      if (!query) {
        resultsDiv.style.display = "none";
        return;
      }

      debounceTimer = setTimeout(() => {
        fetch(`/project/users/search-users?search=${encodeURIComponent(query)}`)
          .then(res => res.json())
          .then(data => {
            resultsDiv.innerHTML = "";
            if (!data.length) {
              resultsDiv.style.display = "none";
              return;
            }

            data.forEach(user => {
              const div = document.createElement("div");
              div.textContent = `${user.email} (${user.name})`;

              div.addEventListener("click", () => {

                  let filtered_contractor_stakeholders = contractor_stakeholders.filter(function (ele) {
                        return ele.id == user.id;
                    });
                    let filtered_designTeam_stakeholders = designTeam_stakeholders.filter(function (ele) {
                        return ele.id == user.id;
                    });
                    let filtered_projectManager_stakeholders = projectManager_stakeholders.filter(function (ele) {
                        return ele.id == user.id;
                    });
                    let filtered_client_stakeholders = client_stakeholders.filter(function (ele) {
                        return ele.id == user.id;
                    });

                if(filtered_contractor_stakeholders.length > 0 || filtered_designTeam_stakeholders.length > 0 || filtered_projectManager_stakeholders.length > 0 || filtered_client_stakeholders.length > 0){
                    alert('this user has already been added');
                    firstNameInput.value = '';
                    lastNameInput.value = '';
                    phoneInput.value = '';
                    searchInput.value = '';
                    user_id.value = '';
                    resultsDiv.style.display = "none";
                  //  document.getElementById("profile_image").src = "{{ asset('images/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.webp') }}";
                    return false;
                }else{
                    const nameParts = user.name.trim().split("_");
                    const firstName = nameParts[0];
                    const lastName = nameParts.slice(1).join(" "); // Join rest as last name

                    // Fill fields
                    firstNameInput.value = firstName;
                    lastNameInput.value = lastName;
                    phoneInput.value = user.mobile_phone;
                    searchInput.value = user.email;
                    user_id.value = user.id;
                  //  document.getElementById("profile_image").src = user.profile_photo_path;

                    resultsDiv.style.display = "none";
                }

                // Split full name

              });

              resultsDiv.appendChild(div);
            });

            resultsDiv.style.display = "block";
          })
          .catch(err => {
            console.error("Search error:", err);
            resultsDiv.innerHTML = "<div>Error loading results</div>";
            resultsDiv.style.display = "block";
          });
      }, 300); // debounce
    });

    document.addEventListener("click", (e) => {
      if (!document.querySelector(".search-container").contains(e.target)) {
        resultsDiv.style.display = "none";
      }
    });




    function loadFiles(event) {
	    var html = '';
	    if(event.target.files.length > 0){
		    for(var i =0; i < event.target.files.length; i++){
			    var img = URL.createObjectURL(event.target.files[i]);
                html+=`        <div class="p-4 border  bg-gray-800 border-gray-700 flex items-center justify-between">
                    <div>
                        <p class="text-lg font-medium">${event.target.files[i].name}</p>
                        <p class="text-sm text-gray-400">${(event.target.files[i].size / 1024).toFixed(2) } KB</p>
                    </div>
                    <a href="${img}" target="__blank" class="text-blue-400 hover:underline flex items-center">
                        <i data-feather="download" class="w-5 h-5 mr-1"></i> Download
                    </a>
                </div>`;
            }
        }
        $('#docs').prepend(html);

    }
    function sendValueToReviewTab(){
        $('#projectNameReview').html($("[name='name']").val());
        $('#startEndDateLbl').html($("[name='start_date']").val()+' / '+$("[name='end_date']").val());
        $('#ProjectDescription').html(tinyMCE.get('description').getContent());
    }


   $("#projectWizard").on("submit", function(event) {
        const form = document.getElementById("projectWizard");
        const formData = new FormData(form); 
		formData.append('description',tinyMCE.get('description').getContent());

        const all_stakholders = [...contractor_stakeholders,...client_stakeholders ,...designTeam_stakeholders ,...projectManager_stakeholders];
		//console.log(all_stakholders);
        formData.append('all_stakholders' , JSON.stringify(all_stakholders));


       // console.log(formData);
    //alert(document.getElementById('contractor.0').value);
            $('.error').hide();
            $('.success').hide();
            $('.err-msg').hide();
            $(".error").html("");
            $(".success").html("");
            event.preventDefault();  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('projects.update') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submit_project_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $("#submit_project_form").prop('disabled', false);
                        
                        $("#projectWizard")[0].reset();
						
						window.scrollTo(0,0);
                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						$('#file-list').html('');
						$('#stakeholderGrid').html('');
						$('#projectManagerList').html('');
						$('#contractorList').html('');
						$('#designTeamList').html('');
						$('#clientList').html('');
                        $('#projectNameReview').html();
                        $('#startEndDateLbl').html();
                        $('#ProjectDescription').html();
                        $('#Stakeholders').html();
                        $('#docs').html();
						setInterval(function() {
							location.reload();
							}, 3000);


                    }
                    else if(data.error){
                        $("#submit_project_form").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
                            var el = $(document).find('[name="'+key + '"]');
                            if(el.length == 0){
                                el = $(document).find('[id="'+key + '"]');
                            }
                            el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            
                        });

                        $("#submit_project_form").prop('disabled', false);


                }
            });
    
      });
        
    
  
    
        
    $("#createUserForm").on("submit", function(event) {
        event.preventDefault();
        $('.err-msg').hide();
        $(".error").html("");
        $(".error").hide();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('projects.users.store') }}",
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $("#submitBtn").prop('disabled', true);
            },
            success: function(data) {
                if (data.success) {
                    //  
                    $("#submitBtn").prop('disabled', false); 
                    const type = $('#user_type').val();
                    const index = $('#user_index').val();
                    const company = $('#user_company').val();
               //#ccc     alert(data.data.id);
                    if(document.getElementById('user_id').value == '' || document.getElementById('user_id').value == null ){
                       // alert(data.data.id+'**************');
                        //alert(`${type}.${index}`);
                      
                        const select = document.getElementById(`${type}.${index}`);
                        const opt = document.createElement('option');
                        opt.value = data.data.id;
                        opt.uuid = data.data.id;
                        opt.name = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;
                        opt.email = document.getElementById('email').value;
                        opt.phone = document.getElementById('phone').value;
                        opt.specialty = document.getElementById('specialty').value;
                        opt.company = document.getElementById('user_company').value;
                        opt.office_phone = document.getElementById('office_phone').value;
                        opt.image = data.data.profile_photo_path;

                        opt.setAttribute("image",data.data.profile_photo_path);

                        opt.setAttribute("uuid",data.data.id);
                        opt.setAttribute("name",document.getElementById('first_name').value+'_'+document.getElementById('last_name').value);
                        opt.setAttribute("email",document.getElementById('email').value);
                        opt.setAttribute("phone",document.getElementById('phone').value);

                        opt.setAttribute("specialty",document.getElementById('specialty').value);
                        opt.setAttribute("company",document.getElementById('user_company').value);
                        opt.setAttribute("office_phone",document.getElementById('office_phone').value);

                        opt.innerHTML = data.data.name;

                        
                        select.appendChild(opt);

                          document.getElementById(`${type}.${index}`).value = data.data.id;
                       // $(`#${type}.${index}`).val(data.data.id);
                        
                    }else{
                      //  alert(index);
                        document.getElementById(`${type}.${index}`).value = data.data.id;
                       // alert(document.getElementById(`${type}.${index}`).selectedIndex);
                        const select = document.getElementById(`${type}.${index}`).options[document.getElementById(`${type}.${index}`).selectedIndex];
                        console.log(select);
                        
                        select.name = document.getElementById('first_name').value+'_'+document.getElementById('last_name').value;
                        select.email = document.getElementById('email').value;
                        select.phone = document.getElementById('phone').value;
                        select.specialty = document.getElementById('specialty').value;
                        select.company = document.getElementById('user_company').value;
                        select.office_phone = document.getElementById('office_phone').value;
                        select.image = data.data.profile_photo_path;

                        select.setAttribute("image",data.data.profile_photo_path);

                        select.setAttribute("uuid",data.data.id);
                        select.setAttribute("name",document.getElementById('first_name').value+'_'+document.getElementById('last_name').value);
                        select.setAttribute("email",document.getElementById('email').value);
                        select.setAttribute("phone",document.getElementById('phone').value);

                        select.setAttribute("specialty",document.getElementById('specialty').value);
                        select.setAttribute("company",document.getElementById('user_company').value);
                        select.setAttribute("office_phone",document.getElementById('office_phone').value);


                        console.log(select);
                    }

                    map_user_type(type);
                   // $("#createUserForm")[0].reset(); 
                    document.getElementById("createUserModal").classList.add("hidden");

                
                }
            },
            error: function (err) {
                $.each(err.responseJSON.errors, function(key, value) {
                    $('.error').show();
                    $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
                        var el = $(document).find('[name="'+key + '"]');
                        el.after($('<span class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</span>'));
                        
                    });

                    $("#submitBtn").prop('disabled', false);
                    $(".error").show();
                    $(".error").html("<div class='text-white-500  px-2 py-1 text-sm font-semibold'>Some Error Occurred!</div>")

            }
        });
    });
       


    let designTeam_stakeholders =  {!! json_encode($project->design_teams_permissions) !!};
    let projectManager_stakeholders =  {!! json_encode($project->project_managers_permissions) !!};
    let client_stakeholders =  {!! json_encode($project->clients_permissions) !!};
    let  contractor_stakeholders = {!! json_encode($project->contractors_permissions) !!};




    	
    function add_others_data_to_selected_user(select , type , length){


        
        const selectedOption = select.options[select.selectedIndex];

        let filtered_contractor_stakeholders = contractor_stakeholders.filter(function (ele) {
            return ele.id == selectedOption.getAttribute('uuid');
        });
        let filtered_designTeam_stakeholders = designTeam_stakeholders.filter(function (ele) {
            return ele.id == selectedOption.getAttribute('uuid');
        });
        let filtered_projectManager_stakeholders = projectManager_stakeholders.filter(function (ele) {
            return ele.id == selectedOption.getAttribute('uuid');
        });
        let filtered_client_stakeholders = client_stakeholders.filter(function (ele) {
            return ele.id == selectedOption.getAttribute('uuid');
        });

        console.log(contractor_stakeholders);

        if(filtered_contractor_stakeholders.length > 0 || filtered_designTeam_stakeholders.length > 0 || filtered_projectManager_stakeholders.length > 0 || filtered_client_stakeholders.length > 0){
            select.value = '';
            alert('this user has already been added');
            return false;
        }else{
            openCreateUserModal(type , length);
            const nameParts = selectedOption.getAttribute('name').trim().split("_");
            const firstName = nameParts[0];
            const lastName = nameParts.slice(1).join(" "); // Join rest as last name
            $('#model_user_title').html('User '+selectedOption.getAttribute('name'));
            document.getElementById("email").value = selectedOption.getAttribute('email');
            document.getElementById("user_id").value = selectedOption.getAttribute('uuid');
            document.getElementById("first_name").value = firstName;
            document.getElementById("last_name").value = lastName;
            document.getElementById("phone").value = (selectedOption.getAttribute('phone') == 'null')?'':selectedOption.getAttribute('phone');
            //document.getElementById("profile_image").src = selectedOption.getAttribute('image');
        }



    }
    
    //console.log(contractor_stakeholders);
    //console.log(designTeam_stakeholders);
    //console.log(projectManager_stakeholders);

function map_user_type(type){
		
		// alert(e.getAttribute('index'));
		
		// stakeholders.push({'id':parseInt(e.options[e.selectedIndex].getAttribute('uuid')) , 'name':e.options[e.selectedIndex].text,  'role': "", 'permissions': [] , 'type':type});
		// stakeholders.push({'id':parseInt(e.options[e.selectedIndex].getAttribute('uuid')) , 'name':e.options[e.selectedIndex].text,  'role': "asd", 'permissions': [] , 'type':type});


        if(type == 'client'){
            // client_stakeholders = [];
            $("select[name='"+type+"[]']").map(function (idx, ele) {
                if($(ele).val() != '' && $.isNumeric($(ele).val())){
 					if (typeof client_stakeholders[idx] !== 'undefined') {
						client_stakeholders[idx].id = parseInt($(ele).find(":selected").attr('uuid'));
						client_stakeholders[idx].name = $(ele).find(":selected").text();
                        client_stakeholders[idx].company = $(ele).find(":selected").attr('company');
                         client_stakeholders[idx].specialty = $(ele).find(":selected").attr('specialty');
                         client_stakeholders[idx].office_phone = $(ele).find(":selected").attr('office_phone');
						
					}else{
						
						client_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(),
                        'specialty':$(ele).find(":selected").attr('specialty'),'office_phone':$(ele).find(":selected").attr('office_phone'),
                         'company':$(ele).find(":selected").attr('company'),  'role': "" , 'job_title': "", 'permissions': [] , 'type':type});
					}                   

                }
            
            }).get();           
        }else if(type == 'contractor'){
            $("select[name='"+type+"[]']").map(function (idx, ele) {
                               // alert($(ele).find(":selected").attr('specialty'));

                if($(ele).val() != '' && $.isNumeric($(ele).val())){
					if (typeof contractor_stakeholders[idx] !== 'undefined') {
						contractor_stakeholders[idx].id = parseInt($(ele).find(":selected").attr('uuid'));
						contractor_stakeholders[idx].name = $(ele).find(":selected").text();
                        contractor_stakeholders[idx].company = $(ele).find(":selected").attr('company');
                        contractor_stakeholders[idx].specialty = $(ele).find(":selected").attr('specialty');
                        contractor_stakeholders[idx].office_phone = $(ele).find(":selected").attr('office_phone');
						
					}else{
						
						contractor_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(), 
                        'specialty':$(ele).find(":selected").attr('specialty'),'office_phone':$(ele).find(":selected").attr('office_phone'),
                        'company':$(ele).find(":selected").attr('company'), 'role': "", 'job_title': "",'permissions': [] , 'type':type});
					}
                }
            
            }).get();    
			
        }else if(type == 'designTeam'){
            // designTeam_stakeholders = [];
            $("select[name='"+type+"[]']").map(function (idx, ele) {
				if($(ele).val() != '' && $.isNumeric($(ele).val())){
					if (typeof designTeam_stakeholders[idx] !== 'undefined') {
						designTeam_stakeholders[idx].id = parseInt($(ele).find(":selected").attr('uuid'));
						designTeam_stakeholders[idx].name = $(ele).find(":selected").text();
						designTeam_stakeholders[idx].company = $(ele).find(":selected").attr('company');
                        designTeam_stakeholders[idx].specialty = $(ele).find(":selected").attr('specialty');
                         designTeam_stakeholders[idx].office_phone = $(ele).find(":selected").attr('office_phone');
					}else{
						
						designTeam_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(), 
                        'specialty':$(ele).find(":selected").attr('specialty'),'office_phone':$(ele).find(":selected").attr('office_phone'),
                        'company':$(ele).find(":selected").attr('company'), 'role': "", 'job_title': "",'permissions': [] , 'type':type});
					}

                }
            
            }).get(); 
        }else{
            // projectManager_stakeholders = [];
            $("select[name='"+type+"[]']").map(function (idx, ele) {
                if($(ele).val() != '' && $.isNumeric($(ele).val())){
					if (typeof projectManager_stakeholders[idx] !== 'undefined') {
						projectManager_stakeholders[idx].id = parseInt($(ele).find(":selected").attr('uuid'));
						projectManager_stakeholders[idx].name = $(ele).find(":selected").text();
						projectManager_stakeholders[idx].company = $(ele).find(":selected").attr('company');
                        projectManager_stakeholders[idx].specialty = $(ele).find(":selected").attr('specialty');
                         projectManager_stakeholders[idx].office_phone = $(ele).find(":selected").attr('office_phone');
					}else{
						
						projectManager_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(), 
                        'specialty':$(ele).find(":selected").attr('specialty'),'office_phone':$(ele).find(":selected").attr('office_phone'),
                        'company':$(ele).find(":selected").attr('company'), 'role': "", 'job_title': "", 'permissions': [] , 'type':type});
					}					

                }
            
            }).get(); 
        }
			console.log(designTeam_stakeholders);
        console.log(projectManager_stakeholders);
        console.log(contractor_stakeholders);
        console.log(client_stakeholders);
		renderStakeholderGrid();
    }
    
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
    let model_type =  '';
    let model_index = '';
    // Toggle visibility of Create User Modal
    function openCreateUserModal(type , length) {
        $('#model_user_title').html('Create New User ');
        document.getElementById("email").value = '';
        document.getElementById("user_id").value = '';
        document.getElementById("first_name").value = '';
        document.getElementById("last_name").value = '';
        document.getElementById("phone").value = '';
        document.getElementById("specialty").value = '';
        document.getElementById("office_phone").value = '';
        document.getElementById("user_company").value = '';
        //document.getElementById("profile_image").src = "{{ asset('images/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.webp') }}";

        model_type = type;
        model_index = length;
        $('#user_type').val(type);
        $('#user_index').val(length);
        document.getElementById("createUserModal").classList.remove("hidden");
    }

    function closeCreateUserModal() {
        $('#user_type').val('');
        $('#user_index').val('');
        //alert(`${model_type}.${model_index}`);
        let option  = document.getElementById(`${model_type}.${model_index}`).options[document.getElementById(`${model_type}.${model_index}`).selectedIndex];
        let specialty = option.getAttribute('specialty');
        let company = option.getAttribute('company');
        let office_phone = option.getAttribute('office_phone');
        console.log(specialty+'///////////');
        if(specialty == null || company == null || office_phone == null){
            document.getElementById(`${model_type}.${model_index}`).value = '';
        }
        
        document.getElementById("createUserModal").classList.add("hidden");
    }
    // Add a new stakeholder to the respective section
    function addStakeholder(type) {
    
        const companies = {!! json_encode($companies) !!}
        //console.log(contractors);
        const users = {!! json_encode($users) !!};

        var client_html = ``;
        for (let x in users) {
            if(users[x].is_admin == 0){
                client_html+=`<option value="${users[x].id}"  image="${users[x].profile_photo_path}" name="${users[x].name}" email="${users[x].email}" phone="${users[x].mobile_phone}"   uuid="${users[x].id}">${users[x].name}</option>`;           


            }
        }

        var contractor_html = ``;
        for (let x in users) {
            if(users[x].is_admin == 0){
                contractor_html+=`<option value="${users[x].id}"  image="${users[x].profile_photo_path}" name="${users[x].name}" email="${users[x].email}" phone="${users[x].mobile_phone}"   uuid="${users[x].id}">${users[x].name}</option>`;           
            }
        }

        var designTeam_html = ``;
        for (let x in users) {
            if(users[x].is_admin == 0){
                designTeam_html+=`<option value="${users[x].id}"  image="${users[x].profile_photo_path}" name="${users[x].name}" email="${users[x].email}" phone="${users[x].mobile_phone}"   uuid="${users[x].id}">${users[x].name}</option>`;           
        
            }   
        }

        var projectManager_html = ``;
        for (let x in users) {
            if(users[x].is_admin == 0){
                projectManager_html+=`<option value="${users[x].id}"  image="${users[x].profile_photo_path}" name="${users[x].name}" email="${users[x].email}" phone="${users[x].mobile_phone}"   uuid="${users[x].id}">${users[x].name}</option>`;           
        
            }
        }


        const listElement = document.getElementById(`${type}List`);
        const newStakeholder = document.createElement("div");
        //(document.getElementById(type+"List").childElementCount);
        const length = document.getElementById(type+"List").childElementCount;
       if(document.getElementById(type+"List").childElementCount == 0){
            newStakeholder.index = `0`;
           // var length = 0;
        }else{
            console.log(document.getElementById(type+"List").lastElementChild.index);
            //var length = parseInt(document.getElementById(type+"List").lastElementChild.index) + 1;
                newStakeholder.index = length;
        }

       // alert(length);

        newStakeholder.classList.add("flex", "items-center", "mb-2",`${type}${length}`);
        //const length = document.getElementById(type+"List").childElementCount;
        var html = `
            <select onchange="add_others_data_to_selected_user(this, '${type}', ${length});" name="${type}[]"  id="${type}.${length}" index="${length}" class="block w-96 px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200 mr-2">
                <option value="" disabled selected>Select ${type.charAt(0).toUpperCase() + type.slice(1)}</option>`;
                if(type == 'client'){
                    html+=client_html;
                }else if(type == 'contractor'){
                    html+=contractor_html;
                }else if(type == 'designTeam'){
                    html+=designTeam_html;
                }else if(type == 'projectManager'){
                    html+=projectManager_html;
                }
                html+=`
               
            </select>
            <button type="button" onclick="openCreateUserModal('${type}' , ${length})" class="p-2 bg-orange-600 inline-flex text-white">

                <i data-feather="user-plus"></i>
            </button>
        `;
        newStakeholder.innerHTML = html;

        listElement.appendChild(newStakeholder);
        feather.replace({ 'stroke-width': 1 });

    }


// Sample stakeholder data; replace with actual data as needed
const stakeholders = [

];

function stakeholderCard(users, title, grid){
    if(users.length > 0){
        users.forEach(stakeholder => {

            // Create stakeholder card
            const card = document.createElement("div");
            card.classList.add("stakeholder-card", "bg-gray-800", "rounded-xl", "p-4", "shadow-md", "cursor-pointer");
            card.onclick = () => openRoleAssignmentModal(stakeholder);

            const stakeholderGroup = document.createElement("div");
            stakeholderGroup.classList.add("mb-3", "text-sm", "text-blue-500"); 
            stakeholderGroup.textContent = title;

            // Stakeholder info
            const name = document.createElement("h4");
            name.classList.add("text-md", "mb-3", "font-semibold", "text-gray-200");
            name.textContent = stakeholder.name;

            const role = document.createElement("p");
            role.classList.add("stakeholder-role", "text-md", "text-gray-400");
            role.textContent = stakeholder.role || "No role assigned";

            const permissions = document.createElement("div");
            permissions.classList.add("permissions", "flex", "flex-wrap", "gap-2", "text-sm", "text-white");
            
            if(stakeholder.permissions.length){
                stakeholder.permissions.forEach(permission => {
                    $(permissions).append(`
                        <span class="px-2 py-1 rounded-full bg-blue-900">${permission.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())}</span>
                    `);
                });
            } else{
                permissions.textContent = "No permissions assigned";
            }

            // Append elements to card
            card.appendChild(stakeholderGroup);

            if(stakeholder.company != ''){
                $(name).append(`
                    <span class="ml-2 px-3 py-1 border border-orange-500 text-xs rounded-full text-orange-300">
                        ${stakeholder.company}
                    </span>
                `);
            }

            card.appendChild(name);
            card.appendChild(role);
            card.appendChild(permissions);

            // Append card to grid
            grid.appendChild(card);

            
            let stakholder_review = `<div class="p-4 border  bg-gray-800 border-gray-700">
                <div class="flex items-center mb-4">
                    <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-6 h-6 mr-2 text-gray-500"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <div>
                        <p class="text-sm font-medium">${stakeholder.name}</p>
                        <p class="text-xs text-gray-400">${stakeholder.job_title}</p>
                        <p class="text-xs text-gray-400">Client</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-1">Role</p>
                <p class="text-sm font-medium mb-2">${stakeholder.role || "No role assigned"}</p>
                <p class="text-xs text-gray-400 mb-1">Permissions</p>
                <ul class="list-disc pl-5 text-xs text-gray-300">`;
                    stakeholder.permissions.forEach(function(permission){
                        stakholder_review+= `<li>${permission}</li>`;

                    });
                    stakholder_review+= !stakeholder.permissions.length ?  `No permissions assigned` : '';
                stakholder_review+= `</ul>
            </div>`;

           $('#Stakeholders').append(stakholder_review);


        });

        $(grid).append(`
                <div class="separator sm:col-span-2 md:col-span-3 lg:col-span-4  h-[1px] my-4 bg-gray-200 dark:bg-gray-800"></div>
            
            `);
    }
}

// Function to render stakeholder grid
function renderStakeholderGrid() {
    const grid = document.getElementById("stakeholderGrid");
    $('#Stakeholders').html('');
    grid.innerHTML = ""; // Clear existing content
  
    stakeholderCard(client_stakeholders, 'Client', grid);
    stakeholderCard(contractor_stakeholders, 'Contractor Employee', grid);
    stakeholderCard(designTeam_stakeholders, 'Design Team Member', grid);
    stakeholderCard(projectManager_stakeholders, 'Project Manager', grid);

    /*
    stakeholders.forEach(stakeholder => {
        const card = document.createElement("div");
        card.classList.add("bg-gray-100", "dark:bg-gray-700", "", "p-4", "shadow-md", "cursor-pointer");
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
    */
}

// Role presets with associated permissions
/*const rolePresets = {
    viewer: ["view"],
    editor: ["view", "edit"],
    approver: ["view", "edit", "approve"]
};*/

const rolePresets = {!! json_encode($role_permission_arr) !!};
// Open modal for role assignment
let currentStakeholder = null;

function openRoleAssignmentModal(stakeholder) {
    currentStakeholder = stakeholder;
    document.getElementById("modalStakeholderName").textContent = `Assign Role to ${stakeholder.name}`;
    document.getElementById("customRoleName").value = stakeholder.role || "";
    document.getElementById("job_title").value = stakeholder.job_title || "";
    document.getElementById("presetRoleSelect").value = stakeholder.role; // Clear preset selection
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
    const job_title = document.getElementById("job_title").value
    if (currentStakeholder) {
        // Save custom role and permissions to the stakeholder
        currentStakeholder.role = role || "Custom Role";
        currentStakeholder.permissions = permissions;
        currentStakeholder.job_title = job_title;
    }
    //console.log(contractor_stakeholders);
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

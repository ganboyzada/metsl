@extends('metsl.layouts.master')

@section('title', 'Project Creation Wizard')

@section('header')
    <a href="{{ route('projects.find', 1) }}" class="flex items-center text-gray-600 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 px-4 py-2  font-medium">
    <i class="fas fa-arrow-left mr-2 text-gray-500"></i> Back to Project
</a>
@endsection

@section('content')
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>

<div class="container mx-auto p-6 bg-white dark:bg-gray-900 dark:text-gray-100  shadow-md">
    <!-- Progress Indicator -->
    <div class="grid grid-cols-4 justify-between mb-6">
    <div class="text-center">
            <div class="text-sm font-semibold">1. Project Basics</div>
            <div id="progress-step-1" class="progress-step active h-2 rounded-full mt-2"></div>
        </div>
        <div class="text-center">
            <div class="text-sm font-semibold">2. Stakeholder Selection</div>
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
    <form id="projectWizard" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="step1" class="wizard-step">
            <h2 class="text-2xl font-semibold mb-4">Project Basics</h2>
            <div class="gap-6 grid md:grid-cols-2 lg:grid-cols-3">
                <div>
                    <div class="mb-4">
                        <label for="projectName" class="block font-medium text-gray-700 dark:text-gray-200">Project Name</label>
                        <input type="text" name="name" id="projectName" class="mt-1 block w-full  shadow-sm dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block font-medium text-gray-700 dark:text-gray-200">Project Description</label>
                        <textarea name="description"  id="description" class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200"></textarea>
                    </div>
                </div>
                
                <div>
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="startDate" class="block font-medium text-gray-700 dark:text-gray-200">Start Date</label>
                            <input type="date" name="start_date" id="startDate" class="mt-1 block w-full  shadow-sm dark:bg-gray-800 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">End Date</label>
                            <input type="date"  name="end_date" id="endDate" class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200">
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
                        <ul id="file-list" class="mt-4 text-sm text-gray-600 dark:text-gray-300"></ul>
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
                                    <option value="{{$status->value}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="mb-4">
                            <label for="startDate" class="block font-medium text-gray-700 dark:text-gray-200">logo</label>
                            <input type="file" name="logo" id="logo" class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200" >
                        </div>

                    </div>
                </div>
                
            </div>
        
            <button type="button" onclick="showStep(2); sendValueToReviewTab();" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next</button>
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
                    <button type="button" onclick="addStakeholder('client')" class="flex items-center bg-gray-200 dark:bg-gray-600 dark:text-white px-3 py-1 rounded-full mt-2">
                        <i data-feather="user-plus" class="mr-2"></i> Add User
                    </button>
                </div>

                <!-- Project Manager Section -->
                <div id="projectManagerSection" class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Project Manager</h3>
                    <div id="projectManagerList">
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
            <p class="mb-2 text-gray-700 dark:text-gray-200">Assign specific roles to the stakeholders selected in the previous step.</p>

            <!-- Stakeholder Grid -->
            <div id="stakeholderGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
        
            @include('metsl.pages.projects.wizard.review_step')

            <!-- Display summary of project details -->
            <button type="button" onclick="showStep(3)" class="bg-gray-500 text-white px-4 py-2 rounded mt-4 mr-2">Back</button>
            <button type="submit"id="submit_project_form" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Submit Project</button>
        </div>
    </form>
            <!-- Overlay Modal for Creating New User -->
            <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800  p-6 w-full max-w-md">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Create New User</h3>
                    <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    
    
                    <form id="createUserForm"   enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="user_type" name="user_type">
                        <input type="hidden" id="user_index" name="user_index">
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">image</label>
                            <input type="file" name="image" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" >
                        </div>                    
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Name</label>
                            <input type="text" name="first_name" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Surname</label>
                            <input type="text" name="last_name" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Mobile Phone</label>
                            <input type="text" name="mobile_phone" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Office Phone</label>
                            <input type="text" name="office_phone" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Email (Login Credential)</label>
                            <input type="email" name="email" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Specialty</label>
                            <input type="text" name="specialty" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                        </div>
                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="closeCreateUserModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                            <button type="submit" id="submitBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
    
    
            
            <!-- Role Assignment Modal -->
            <div id="roleAssignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800  p-6 w-full max-w-lg">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200" id="modalStakeholderName">Assign Role to Stakeholder</h3>
    
                    <!-- Role Assignment Form -->
                    <form id="roleAssignmentForm" onsubmit="saveRoleAssignment(event)">
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
                            <label class="block text-gray-700 dark:text-gray-200 mb-1">Custom Permissions</label>
                            <div class="grid grid-cols-2 gap-2">
                                @if($permissions->count() > 0)
                                @foreach($permissions as $permission)   
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" value="{{  $permission->name }}" class="form-checkbox text-blue-600 dark:text-blue-300 mr-2" 
                                        onchange="handleCustomPermissions()"> {{  $permission->name }}
                                    </label>                                                        
                                @endforeach
                                @endif
    
    
                            
                            </div>
                        </div>
    
                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="closeRoleAssignmentModal()" class="text-gray-600 dark:text-gray-300 mr-3">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
</div>

@endsection

@push('js')


<!-- JavaScript for Wizard Step Navigation -->
<script>
    function loadFiles(event) {
	    var html = '';
	    if(event.target.files.length > 0){
		    for(var i =0; i < event.target.files.length; i++){
			    var img = URL.createObjectURL(event.target.files[i]);
                html+=`        <div class="p-4 border  bg-gray-800 border-gray-700 flex items-center justify-between">
                    <div>
                        <p class="text-lg font-medium">${event.target.files[i].name}</p>
                        <p class="text-sm text-gray-400">${(event.target.files[i].size /1024 / 1024).toFixed(2) } MB</p>
                    </div>
                    <a href="${img}" target="__blank" class="text-blue-400 hover:underline flex items-center">
                        <i data-feather="download" class="w-5 h-5 mr-1"></i> Download
                    </a>
                </div>`;
            }
        }
        $('#docs').html(html);

    }
    function sendValueToReviewTab(){
        $('#projectNameReview').html($("[name='name']").val());
        $('#startEndDateLbl').html($("[name='start_date']").val()+' / '+$("[name='end_date']").val());
        $('#ProjectDescription').html(tinyMCE.get('description').getContent());
    }


   $("#projectWizard").on("submit", function(event) {
        const form = document.getElementById("projectWizard");
        const formData = new FormData(form); 
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
                url: "{{ route('projects.store') }}",
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
        $('.err-msg').hide();
        $(".error").html("");
        $(".error").hide();
        event.preventDefault();  
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

                    const select = document.getElementById(`${type}.${index}`);
                    const opt = document.createElement('option');
                    opt.value = data.data.id;
                    opt.uuid = data.user.id;
                    opt.setAttribute("uuid",data.user.id);
                    opt.innerHTML = data.data.user_name;
                    select.appendChild(opt);
                    document.getElementById(`${type}.${index}`).value = data.data.id;
                    

                    map_user_type(type);
                    $("#createUserForm")[0].reset(); 
                    document.getElementById("createUserModal").classList.add("hidden");

                
                }
            },
            error: function (err) {
                $.each(err.responseJSON.errors, function(key, value) {
                        var el = $(document).find('[name="'+key + '"]');
                        el.after($('<span class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</span>'));
                        
                    });

                    $("#submitBtn").prop('disabled', false);
                    $(".error").show();
                    $(".error").html("<div class='text-white-500  px-2 py-1 text-sm font-semibold'>Some Error Occurred!</div>")

            }
        });
    });
        
    var client_stakeholders = [];
    var contractor_stakeholders = [];
    var designTeam_stakeholders = [];
    var projectManager_stakeholders = [];
	
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
						
					}else{
						
						client_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(),  'role': "", 'permissions': [] , 'type':type});
					}                   

                }
            
            }).get();           
        }else if(type == 'contractor'){
            $("select[name='"+type+"[]']").map(function (idx, ele) {
                if($(ele).val() != '' && $.isNumeric($(ele).val())){
					if (typeof contractor_stakeholders[idx] !== 'undefined') {
						contractor_stakeholders[idx].id = parseInt($(ele).find(":selected").attr('uuid'));
						contractor_stakeholders[idx].name = $(ele).find(":selected").text();
						
					}else{
						
						contractor_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(),  'role': "", 'permissions': [] , 'type':type});
					}
                }
            
            }).get();    
			console.log(contractor_stakeholders);
        }else if(type == 'designTeam'){
            // designTeam_stakeholders = [];
            $("select[name='"+type+"[]']").map(function (idx, ele) {
				if($(ele).val() != '' && $.isNumeric($(ele).val())){
					if (typeof designTeam_stakeholders[idx] !== 'undefined') {
						designTeam_stakeholders[idx].id = parseInt($(ele).find(":selected").attr('uuid'));
						designTeam_stakeholders[idx].name = $(ele).find(":selected").text();
						
					}else{
						
						designTeam_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(),  'role': "", 'permissions': [] , 'type':type});
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
						
					}else{
						
						projectManager_stakeholders.push({'id':parseInt($(ele).find(":selected").attr('uuid')) , 'name':$(ele).find(":selected").text(),  'role': "", 'permissions': [] , 'type':type});
					}					

                }
            
            }).get(); 
        }
		
		
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
    function openCreateUserModal(type , length) {
        $('#user_type').val(type);
        $('#user_index').val(length);
        document.getElementById("createUserModal").classList.remove("hidden");
    }

    function closeCreateUserModal() {
        $('#user_type').val('');
        $('#user_index').val('');
        document.getElementById("createUserModal").classList.add("hidden");
    }

    // Add a new stakeholder to the respective section
    function addStakeholder(type) {
        const clients = {!! json_encode($clients) !!};
        const contractors = {!! json_encode($contractors) !!};
        const design_teams = {!! json_encode($design_teams) !!};
        const project_managers = {!! json_encode($project_managers) !!};
        //console.log(contractors);
        var client_html = ``;
        for (let x in clients) {
            client_html+=`<option value="${clients[x].id}"  uuid="${clients[x].user.id}">${clients[x].user_name}</option>`;           
        }

        var contractor_html = ``;
        for (let x in contractors) {
            contractor_html+=`<option value="${contractors[x].id}"  uuid="${contractors[x].user.id}">${contractors[x].user_name}</option>`;
        
        }

        var designTeam_html = ``;
        for (let x in design_teams) {
            designTeam_html+=`<option value="${design_teams[x].id}"  uuid="${design_teams[x].user.id}">${design_teams[x].user_name}</option>`;
        }   
        

        var projectManager_html = ``;
        for (let x in project_managers) {
            projectManager_html+=`<option value="${project_managers[x].id}"  uuid="${project_managers[x].user.id}">${project_managers[x].user_name}</option>`;
        }

        const listElement = document.getElementById(`${type}List`);
        const newStakeholder = document.createElement("div");
        newStakeholder.classList.add("flex", "items-center", "mb-2");
        const length = document.getElementById(type+"List").childElementCount;
        var html = `
            <select onchange="map_user_type('${type}')" name="${type}[]" id="${type}.${length}" index="${length}" class="block w-96 px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200 mr-2">
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
            <button type="button" onclick="openCreateUserModal('${type}' , ${length})" class="p-2 rounded-md bg-orange-600 inline-flex text-white">

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

// Function to render stakeholder grid
function renderStakeholderGrid() {
    const grid = document.getElementById("stakeholderGrid");
    $('#Stakeholders').html('');
    grid.innerHTML = ""; // Clear existing content
    if(client_stakeholders.length > 0){
        client_stakeholders.forEach(stakeholder => {
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

            
            let stakholder_review = `<div class="p-4 border  bg-gray-800 border-gray-700">
                <div class="flex items-center mb-4">
                    <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-6 h-6 mr-2 text-gray-500"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <div>
                        <p class="text-sm font-medium">${stakeholder.name}</p>
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
    }
 
    if(contractor_stakeholders.length > 0){
        contractor_stakeholders.forEach(stakeholder => {
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


            let stakholder_review = `<div class="p-4 border  bg-gray-800 border-gray-700">
                <div class="flex items-center mb-4">
                    <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-6 h-6 mr-2 text-gray-500"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>

                    <div>
                        <p class="text-sm font-medium">${stakeholder.name}</p>
                        <p class="text-xs text-gray-400">Contractor</p>
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
    }    

    if(designTeam_stakeholders.length > 0){
        designTeam_stakeholders.forEach(stakeholder => {
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
            let stakholder_review = `<div class="p-4 border  bg-gray-800 border-gray-700">
                <div class="flex items-center mb-4">
                    <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-6 h-6 mr-2 text-gray-500"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>

                    <div>
                        <p class="text-sm font-medium">${stakeholder.name}</p>
                        <p class="text-xs text-gray-400">Design Team</p>
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
    }
 
    if(projectManager_stakeholders.length > 0){
        projectManager_stakeholders.forEach(stakeholder => {
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

            let stakholder_review = `<div class="p-4 border  bg-gray-800 border-gray-700">
                <div class="flex items-center mb-4">
                    <i data-feather="user" class="w-6 h-6 mr-2 text-gray-500"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user w-6 h-6 mr-2 text-gray-500"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>        
                    <div>
                        <p class="text-sm font-medium">${stakeholder.name}</p>
                        <p class="text-xs text-gray-400">Project Manager</p>
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
    }  

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

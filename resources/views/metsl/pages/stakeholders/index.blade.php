<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    <div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <div class="relative flex items-center">
            <input type="text" id="searchStakeholders" placeholder="Search by name..." 
                class="pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-700 dark:text-gray-200" />
            <i data-feather="search" class="absolute left-2 top-2"></i>
        </div>

    </div>

    <div id="stakeholdersGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <!-- Company Cards -->
      
	</div>

    <div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800  p-6 w-full max-w-md">
            <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-200">Edit User</h3>
            <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>


            <form id="createUserForm"   enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_type" name="user_type">
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" id="project_user_id" name="project_user_id">

                <input type="hidden" id="user_index" name="user_index">
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-200 mb-1">Image</label>
                    <input   accept="image/*" type="file" name="image" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" >
                </div>  
                <img src="" id="user_image" class="w-32 h-32 object-cover mt-2"/>   
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
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Name</label>
                        <input type="text" name="first_name" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Surname</label>
                        <input type="text" name="last_name" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                    </div>

                    @if (auth()->user()->is_admin)
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200">
                    </div>                        
                    @endif
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
                        <label class="block text-gray-700 dark:text-gray-200 mb-1">Field of specialty</label>
                        <input type="text" name="specialty" class="w-full px-4 py-2 border  dark:bg-gray-700 dark:text-gray-200" required>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="button" data-modal="createUserModal" class="modal-toggler text-gray-600 dark:text-gray-300 mr-5">Cancel</button>
                    <button type="submit" id="submitBtn" class="bg-blue-500 text-white px-4 py-2">Update User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Filtering -->
    <script>
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
            url: "{{ route('projects.stakeholders.update') }}",
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
                  
                    $("#createUserForm")[0].reset(); 
                    document.getElementById("createUserModal").classList.add("hidden");
                    get_stakeholders();
					$('.success').show();
					$('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Updated Successfully</div>');

                
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
        
   

        function openCreateUserModal(i,project_user_id) {
            let currentStakeholder = allStakeholder[i];
            //console.log(currentStakeholder);
           // $('#user_type').val(currentStakeholder.userable_type);
            $('#user_type').val('');
            $('[name="company_id"]').val(currentStakeholder.projects[0].pivot.company_id);

            const nameParts = currentStakeholder.name.trim().split("_");
            const firstName = nameParts[0];
            const lastName = nameParts.slice(1).join(" "); // Join rest as last name

            $('[name="first_name"]').val(firstName);
            $('[name="project_user_id"]').val(project_user_id);
            $('[name="last_name"]').val(lastName);
            $('[name="mobile_phone"]').val(currentStakeholder.mobile_phone);
            $('[name="office_phone"]').val(currentStakeholder.projects[0].pivot.office_phone);
            $('[name="email"]').val(currentStakeholder.email);
            $('[name="specialty"]').val(currentStakeholder.projects[0].pivot.specialty);
            $('[name="user_id"]').val(currentStakeholder.id);
            $('#user_image').attr('src',currentStakeholder.profile_photo_path);
            document.getElementById("createUserModal").classList.remove("hidden");
        }


    async function set_projectID_stakeholders(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        get_stakeholders();		

    }

	// $(".projectButton").on('click',function(event) {
		
	// 	if(localStorage.getItem("project_tool") == 'stakeholders'){

	// 		set_projectID_stakeholders();
	// 	}
	// });
	$("#searchStakeholders").on('input',function(event) {
		get_stakeholders();
	});
    let allStakeholder = {};
	get_stakeholders();
	async function get_stakeholders(){
        if(localStorage.getItem("project_tool") == 'stakeholders'){
		const search = $('#searchStakeholders').val();		
		let url =`/project/stakeholders/all?search=${search}`;
		
		let fetchRes = await fetch(url);
		const all_stakeholders = await fetchRes.json();
	
			let html =``;
			if(all_stakeholders.length > 0){
                allStakeholder = all_stakeholders;
				for(let i=0;i<all_stakeholders.length;i++){
					let url = "{{ route('projects.stakeholders.edit', [':id']) }}".replace(':id', all_stakeholders[i].id);
                    let url_delete = "{{ route('projects.stakeholders.destroy', [':id']) }}".replace(':id', all_stakeholders[i].id);
					html+=`	<div class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex gap-3 rounded-lg">
						<a href="#"><img src="${all_stakeholders[i].profile_photo_path}" alt="user_photo" class="h-10 min-w-10"></a>
						<div>
                            <a onclick="openCreateUserModal('${i}',, ${all_stakeholders[i].project_user_id})" href="#"><h3 class="text-lg font-semibold">${all_stakeholders[i].name} </h3></a>
                            <p class="text-sm text-gray-600 dark:text-gray-300">${all_stakeholders[i].company_name}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">${all_stakeholders[i].email}</p>
                             <p class="text-sm text-gray-600 dark:text-gray-300">${all_stakeholders[i].mobile_phone != null ? all_stakeholders[i].mobile_phone : '' }</p>
                              <p class="text-sm text-gray-600 dark:text-gray-300">${all_stakeholders[i].all_roles[0].pivot.job_title}</p>
                               <p class="text-sm text-gray-600 dark:text-gray-300">${all_stakeholders[i].mobile_phone}</p>
                        
                            <div class="mt-4 flex items-center gap-2">
                                <a onclick="openCreateUserModal('${i}' , ${all_stakeholders[i].project_user_id})" href="#" class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                                    <i data-feather="eye" class="w-5 h-5"></i>
                                </a>
                                <a onclick="deleteUser(${all_stakeholders[i].id})" href="#" class="text-red-500 dark:text-red-400 hover:text-red-300">
                                    <i data-feather="trash" class="w-5 h-5"></i>
                                </a>
                            </div>        
                        </div>
						                    
					</div>`;
				}
				
			}
            	
			$('#stakeholdersGrid').html(html);
            feather.replace();	
			
        }
	}

   
    async function deleteUser(id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`/project/stakeholders/destroy/${id}`;		
		let fetchRes = await fetch(url);
        if(fetchRes.status != 200){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

        }else{
            get_stakeholders();
            $('.success').show();
            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
        }


    }



    </script>

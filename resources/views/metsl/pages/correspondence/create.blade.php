@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>

<div class="dark:text-gray-200">
    <h2 class="text-2xl font-semibold mb-6">
           @if (isset($reply_correspondence->id) && $reply_correspondence_id != NULL)
                    Reply
                @else
                    Create Correspondence
                @endif

    </h2>

    <!-- Form -->
    <form id="correspondence-form" class="space-y-6"  method="POST" enctype="multipart/form-data">
	    @csrf
		<input type="hidden" name="project_id" value="{{ \Session::get('projectID') }}"/>
		<input type="hidden" value="{{$type ?? ''}}" name="type"/>
		<input type="hidden" value="{{$reply_correspondence_id ?? ''}}" name="reply_correspondence_id"/>
		<input type="hidden" value="{{$reply_child_correspondence_id ?? ''}}" name="reply_child_correspondence_id"/>
		
        <!-- Grid Layout for Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Number -->
            <div>
                <label for="correspondence-number" class="block text-sm font-medium mb-1">Number</label>
                <input
                    id="correspondence-number"
                    type="text"
					name="number"
                    readonly required
                    placeholder="RFI-001"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                />
            </div>

            <!-- Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium mb-1">Subject</label>
                <input required
                    id="subject"
					name="subject"
                    type="text"
                    placeholder="Enter subject"
                    value="{{ $reply_correspondence->subject??'' }}"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                />
            </div>

            <!-- Status -->
            <div style="display: none">
                <label for="status" class="block text-sm font-medium mb-1">Status</label>
                <select 
                    id="status" name="status"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
					@php
					$status_list = \App\Enums\CorrespondenceStatusEnum::cases();
                    $i = 0;
					@endphp

					@foreach ($status_list as $status)
                        <option value="{{$status->value}}">{{$status->name}}</option>
                        @php
                            $i++;
                        @endphp
						
					@endforeach
                </select>
            </div>

            <!-- Programme Impact -->
            <div>
                <label for="programme-impact" class="block text-sm font-medium mb-1">Programme Impact</label>
                <select
                    id="programme-impact"
					name="program_impact"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
					@php
					$enums_list = \App\Enums\CorrespondenceProgrammImpactEnum::cases();
					@endphp
					@foreach ($enums_list as $enum)
						<option value="{{$enum->value}}">{{$enum->name}}</option>
					@endforeach

                </select>
            </div>

            <!-- Cost Impact -->
            <div>
                <label for="cost-impact" class="block text-sm font-medium mb-1">Cost Impact</label>
                <select
                    id="cost-impact"
					name="cost_impact"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
					@php
					$enums_list = \App\Enums\CorrespondenceCostImpactEnum::cases();
					@endphp
					@foreach ($enums_list as $enum)
						<option value="{{$enum->value}}">{{$enum->name}}</option>
					@endforeach
                </select>
            </div>

              <div class="md:col-span-1" style="display:{{ isset($reply_correspondence->id)?'none':'' }};">
                    <label for="due_days" class="block text-sm mb-2 font-medium dark:text-gray-200">Due Days</label>
                    <select id="due_days" required name="due_days" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
 
                        <option value="5">5 day</option>
                        <option value="7">7 day</option>
                        <option value="10">10 day</option>
                        <option value="14">14 day</option>
                        <option value="17">17 day</option>
                        <option value="21">21 day</option>
                        <option value="24">24 day</option>
                        <option value="27">27 day</option>
                        <option value="30">30 day</option>

                    </select>
            
                </div>	

            <!-- Assignees -->
            <div class="relative">
                <label for="assignees" class="block text-sm font-medium mb-1">Assignees</label>
                <select  {{ isset($reply_correspondence->id)?'disabled':'' }} id="assignees" name="assignees[]" multiple class="w-full"></select>
            </div>

            <!-- Distribution Members -->
            <div class="relative">
                <label for="distribution" class="block text-sm font-medium mb-1">Distribution Members</label>
                <select  {{ isset($reply_correspondence->id)?'disabled':'' }}  id="distribution" name="distribution[]" multiple class="w-full"></select>
            </div>


            <div class="relative">
                <label for="related_correspondences" class="block text-sm font-medium mb-1">Related Correspondence</label>
                <select id="related_correspondences" multiple name="related_correspondences[]" class="w-full">
                    <option value="">select related correspondence<option>
                

                </select>
            </div>
		
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label for="description" class="block mb-1">Description</label>
                <textarea
                    id="description"
					name="description"
                    placeholder="Enter correspondence description"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                ></textarea>
            </div>
            <div>
                <label class="block mb-1">Attachments (PDF only)</label>
                <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF only (max. 5MB)</p>
                    </div>
                    <input id="file-upload"  name="docs[]"  type="file" name="" class="docs hidden" accept=".pdf" multiple>
                </div>
                <ul id="file-list" class="mt-4 space-y-2">
                    <!-- Uploaded files will appear here -->
                </ul>
            
				
			<div class="relative">
                <label for="linked_documents" class="block text-sm font-medium mb-1">Linked Documents</label>
                <select id="linked_documents" name="linked_documents[]" multiple class="w-full"></select>
            </div>
			
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"  id="submit_correspondence_form" class="px-6 py-2 bg-blue-500 text-white  hover:bg-blue-600">
                @if (isset($reply_correspondence->id) && $reply_correspondence_id != NULL)
                    Reply
                @else
                    Create    
                @endif
                </button>
        </div>
    </form>
</div>

<script>
   // alert(tinyMCE.get('description').getContent());
 $("#correspondence-form").on("submit", function(event) {
        const form = document.getElementById("correspondence-form");
        const formData = new FormData(form); 
		formData.append('description',tinyMCE.get('description').getContent());
    
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
                url: "{{ route('projects.correspondence.store') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submit_correspondence_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $("#submit_correspondence_form").prop('disabled', false);
                        
                        $("#correspondence-form")[0].reset();
						
						window.scrollTo(0,0);
                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						
                        $('#file-list').html();
						setInterval(function() {
                            window.location.href="{{ route('home') }}";
                        }, 3000);	


                    }
                    else if(data.error){
                        $("#submit_correspondence_form").prop('disabled', false);

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
                                el = $(document).find('[name="'+key + '[]"]');
                            }
                            el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            
                        });

                        $("#submit_correspondence_form").prop('disabled', false);


                }
            });
    
      });
	  
    async function set_projectID_users(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        //location.reload();
        get_users();
    }

	// $(".projectButton").on('click',function(event) {

	// 	set_projectID_users();
		
	// });
					

	
        // Populate Assignees, Distribution Members, and Received From
	async  function get_users(){
		const type = $('[name="type"]').val();
		let fetchRes = await fetch(`{{url('project/correspondence/users?type=${type}')}}`);
		const all_users = await fetchRes.json();
        if($('[name="reply_correspondence_id"]').val() != ''){
            var old_type = "{{ $reply_correspondence->number ?? ''}}";
		    $('[name="number"]').val('Replying to '+old_type);

        }else{
            $('[name="number"]').val(all_users.next_number);
          
        }

        let assigned_users_reply =  {!! json_encode($reply_correspondence->assignees??[]) !!};
    
                const assignees = all_users.assigned_users.map(function(item) {
                    return {'value' : item.id , 'label' : item.name, 
                    'selected': assigned_users_reply.some(user => user.id === item.id)};

                
                
                });

        


			assignees_obj.clearStore();
			assignees_obj.setChoices(assignees);
			//populateChoices3('assignees',assignees);

            let distributions_users_reply =  {!! json_encode($reply_correspondence->distributionMembers??[]) !!};
			
			const distribution = all_users.destrbution_users.map(function(item) {
			  return {'value' : item.id , 'label' : item.name,
                'selected': distributions_users_reply.some(user => user.id === item.id)
              };
			});	
			//populateChoices3('distribution', distribution);
			distribution_obj.clearStore();
			distribution_obj.setChoices(distribution);	
            
            let correspondences = {!! json_encode($related_correpondences) !!};
            const allcorrespondences = correspondences.map(function(item) {
			  return {'value' : item.id  , 'label' : item.number+' - '+item.subject};
			});	
			correspondence_obj.clearStore();
			correspondence_obj.setChoices(allcorrespondences);	
			
			// const allusers = all_users.users.map(function(item) {
			  // return {'value' : item.id , 'label' : item.name};
			// });	
			
			
			// received_obj.clearStore();
			// received_obj.setChoices(allusers);
			let files =  {!! json_encode($files) !!};
			const allfiles = files.map(function(item) {
			  return {'value' : item.file_id+'-'+item.revisionid  , 'label' : item.project_document.number};
			});	
			linked_documents.clearStore();
			linked_documents.setChoices(allfiles);				
		
		
	}
			

    document.addEventListener('DOMContentLoaded', () => {
		assignees_obj = populateChoices2('assignees', [], true);		
		distribution_obj = populateChoices2('distribution', [], true);	
        correspondence_obj = populateChoices2('related_correspondences', [], true);	
		linked_documents = populateChoices2('linked_documents', [], false);		
        get_users();
		
    }); 

    // document.addEventListener('DOMContentLoaded', () => {

    // });

    // Attachments logic
    // const dropZone = document.getElementById('drop-zone');
    // const fileInput = document.getElementById('file-upload');
    // const fileList = document.getElementById('file-list');

    // dropZone.addEventListener('click', () => fileInput.click());
    // dropZone.addEventListener('dragover', event => {
        // event.preventDefault();
        // dropZone.classList.add('bg-gray-700');
    // });
    // dropZone.addEventListener('dragleave', () => dropZone.classList.remove('bg-gray-700'));
    // dropZone.addEventListener('drop', event => {
        // event.preventDefault();
        // dropZone.classList.remove('bg-gray-700');
        // handleFiles(event.dataTransfer.files);
    // });
    // fileInput.addEventListener('change', () => handleFiles(fileInput.files));

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type !== 'application/pdf') {
                alert('Only PDF files are allowed.');
                return;
            }
            const li = document.createElement('li');
            li.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            li.classList.add('text-gray-400', 'text-sm');
            fileList.appendChild(li);
        });
    }
</script>

@endsection

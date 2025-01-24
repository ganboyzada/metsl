@extends('metsl.layouts.master')

@section('title', 'Correspondence - Update')

@section('content')
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
@if(session()->has('success'))
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
    {{ session()->get('success') }}
</div>
@endif 
<div class="p-6 bg-white dark:bg-gray-900 dark:text-gray-200  shadow-md">
    <h2 class="text-2xl font-semibold mb-6">Update Correspondence</h2>

    <!-- Form -->
    <form id="correspondence-form" class="space-y-6"  method="POST" enctype="multipart/form-data">
	@csrf
		<input type="hidden" value="{{$correspondece->project_id}}" name="project_id"/>
		<input type="hidden" value="{{$correspondece->type}}" name="type"/>
        <input type="hidden" name="id" value="{{ $correspondece->id }}"/> 

		
        <!-- Grid Layout for Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Number -->
            <div>
                <label for="correspondence-number" class="block text-sm font-medium mb-1">Number</label>
                <input
                    id="correspondence-number" value="{{ $correspondece->number }}"
                    type="text"
					name="number"
                    placeholder="RFI-001"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                />
            </div>

            <!-- Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium mb-1">Subject</label>
                <input
                    id="subject" value="{{ $correspondece->subject }}"
					name="subject"
                    type="text"
                    placeholder="Enter subject"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                />
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium mb-1">Status</label>
                <select
                    id="status" name="status"
                    class="w-full px-4 py-2 border  dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 focus:border-blue-500 focus:outline-none"
                >
					@php
					$status_list = \App\Enums\CorrespondenceStatusEnum::cases();
					@endphp
					@foreach ($status_list as $status)
						<option value="{{$status->value}}"{{ $correspondece->status == $status->value ? 'selected' : '' }}>{{$status->name }}</option>
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
						<option value="{{$enum->value}}" {{ $correspondece->program_impact->value == $enum->value ? 'selected' : '' }}>{{$enum->name}}</option>
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
						<option value="{{$enum->value}}" {{ $correspondece->cost_impact->value == $enum->value ? 'selected' : '' }}>{{$enum->name}}</option>
					@endforeach
                </select>
            </div>

            <!-- Assignees -->
            <div class="relative">
                <label for="assignees" class="block text-sm font-medium mb-1">Assignees</label>
                <select id="assignees" name="assignees[]" multiple class="w-full"></select>
            </div>

            <!-- Distribution Members -->
            <div class="relative">
                <label for="distribution" class="block text-sm font-medium mb-1">Distribution Members</label>
                <select id="distribution" name="distribution[]" multiple class="w-full"></select>
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
                >{{ $correspondece->description }}</textarea>
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
                    @if ($correspondece->files->count()  > 0)
                    <ul id="file-list" class="mt-4 space-y-2">
                        @foreach ( $correspondece->files as $file )
                            <li class="flex justify-between"><a href="{{ asset('storage/project'.$correspondece->project_id.'/correspondence'.$correspondece->id.'/'.$file->file)  }}" target="_blank">{{ $file->file  }}   ( {{ $file->size != NULL ? round($file->size/1024 , 2) : 0  }} kb )</a>
                                <a href={{ route('projects.correspondence.destroy-file',[$file->id]) }} class="text-red-500 dark:text-red-400 hover:text-red-300">
                                    <i data-feather="delete" class="w-5 h-5"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>   
                    @endif
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
            <button type="submit"  id="submit_correspondence_form" class="px-6 py-2 bg-blue-500 text-white  hover:bg-blue-600">Update Correspondence</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
		
		assignees_obj = populateChoices2('assignees', [], true);		
		distribution_obj = populateChoices2('distribution', [], true);	
		linked_documents = populateChoices2('linked_documents', [], false);		
		
    });    
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
                url: "{{ route('projects.correspondence.update') }}",
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
							location.reload();
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
	  


			

	get_users();

    async  function get_users(){
		const type = $('[name="type"]').val();
		let fetchRes = await fetch(`{{url('project/correspondence/users?type=${type}')}}`);
		const all_users = await fetchRes.json();
        let assignees_correspondence ={!! json_encode($correspondece->assignees) !!}  ;
            
        let selected_assignees=assignees_correspondence.map(function(item) {
            return item.id;
        })	;

        const assignees = all_users.assigned_users.map(function(item) {
            return {'value' : item.id , 'label' : item.name ,  'selected': selected_assignees.includes(item.id) ? true : false};
        });

        console.log(assignees);
        // assignees_obj = populateChoices2('assignees', assignees, true);
		assignees_obj.clearStore();
		assignees_obj.setChoices(assignees);		


		let DistributionMembers ={!! json_encode($correspondece->DistributionMembers) !!}  ;
		
		let selected_DistributionMembers=DistributionMembers.map(function(item) {
			return item.id;
		})	;
		const distribution = all_users.destrbution_users.map(function(item) {
		  return {'value' : item.id , 'label' : item.name ,  'selected': selected_DistributionMembers.includes(item.id) ? true : false};
		});	
		distribution_obj.clearStore();
		distribution_obj.setChoices(distribution);	
		
		// let recieved  = `{{ $correspondece->recieved_from }}`;
		// const allusers = all_users.users.map(function(item) {
		  // return {'value' : item.id , 'label' : item.name, 'selected' : recieved == item.id ? true : false};
		// });	

		// received_obj.clearStore();
		// received_obj.setChoices(allusers);
	
		let DocumentFiles ={!! json_encode($correspondece->documentFiles) !!}  ;	
		let selectedDocumentFiles=DocumentFiles.map(function(item) {
			return item.pivot.file_id+'-'+(item.pivot.revision_id == 0 ? null : item.pivot.revision_id);
		})	;
		let files =  {!! json_encode($files) !!};
		const allfiles = files.map(function(item) {
		  return {'value' : item.file_id+'-'+item.revisionid  , 'label' : item.project_document.number,  'selected': selectedDocumentFiles.includes(item.file_id+'-'+item.revisionid) ? true : false};
		});		
			linked_documents.clearStore();
			linked_documents.setChoices(allfiles);	
        feather.replace();
			
    }
	



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
